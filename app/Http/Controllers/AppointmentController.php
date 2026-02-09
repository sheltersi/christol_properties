<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\User;
use App\Notifications\AppointmentConfirmedNotification;
use App\Notifications\AppointmentRevoked;
use App\Notifications\NewAppointmentRequest;
use App\Notifications\TenantAppointmentBooked;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Inertia\Inertia;

class AppointmentController extends Controller
{
    //
    public function index()
    {
        $user = Auth::user();

        $user_appointments = $user->appointments;

        return Inertia::render('Appointments/Index', [
            'user' => $user,
            'user_appointments' => $user_appointments
        ]);
    }

    public function allAppointments(Request $request)
    {
        $search = $request->input('search');
        $status = $request->query('status');
        $date = $request->query('date');


        $appointments = Appointment::query()
            ->when($status && $status !== 'all', function ($query) use ($status) {
                if ($status === 'today') {
                    $query->whereDate('preferred_date', now()->toDateString());
                } elseif ($status === 'upcoming') {
                    $query->whereDate('preferred_date', '>', now()->toDateString());
                } elseif ($status === 'expired') {
                    $query->whereDate('preferred_date', '<', now()->toDateString());
                } else {
                    $query->where('status', $status);
                }
            })
            ->when($date, function ($query) use ($date) {
                $query->whereDate('preferred_date', $date);
            })
            ->when($search, fn ($query) =>
            $query->whereHas('user', fn ($q) =>
                $q->where('name', 'like', "%$search%")
                  ->orWhere('last_name', 'like', "%$search%")
            )
        )
            ->latest()
            ->paginate(10)
            ->withQueryString();

        $appointments->load('user');


        return Inertia::render('Admin/Appointments/Index', [
            'appointments' => $appointments,
            'filters' => [
                'search' => $search,
                'status' => $status,
                // 'date' => $date,
            ],
        ]);
    }


    public function create()
    {

        return Inertia::render('Dashboard');
    }

    public function store(Request $request)
    {
        $user = Auth::user();

        $validated = $request->validate([
            'preferred_date' => 'required|date',
            'preferred_time' => 'required',
            'message' => 'nullable|string',
            'cottage_number' => 'required',
        ]);

        $appointment = Appointment::create([
            'user_id' => $user->id, // ✅ Set the current user's ID
            'cottage_number' => $validated['cottage_number'],
            'preferred_date' => $validated['preferred_date'],
            'preferred_time' => $validated['preferred_time'],
            'message' => $validated['message'] ?? '',
            'status' => 'pending',
        ]);

        //notify the tenant that appointment has been booked in the email
        $user->notify(new TenantAppointmentBooked($appointment));

        //Notify all admins
        User::where('role', 'admin')->get()->each(function ($admin) use ($appointment) {
            $admin->notify(new NewAppointmentRequest($appointment));
        });

        return redirect()->route('cottages.index');
    }

    public function show(Appointment $appointment)
    {
        // dd($appointment->user->name);
        $appointment->load('user');
        return Inertia::render('Appointments/Show', [
            'appointment' => $appointment,
        ]);
    }

    public function confirm(Appointment $appointment)
    {
        $appointment->update(['status' => 'confirmed']);

        $user = $appointment->user;

        $user->notify(new AppointmentConfirmedNotification($appointment));

        return redirect()->route('all-appointments.index')->with('success', 'Appointment confirmed.');
    }

        public function revoke(Request $request, Appointment $appointment)
    {
        $request->validate(['reason' => 'required|string|max:1000']);

        $appointment->status = 'revoked';
        $appointment->revoked_reason = $request->reason;
        $appointment->save();

        $user = $appointment->user;
        // Send notification to user (example)
        // Mail::to($appointment->user->email)->send(new AppointmentRevoked($appointment));

        $user->notify(new AppointmentRevoked($appointment));

        return redirect()->back()->with('success', 'Appointment revoked and user notified.');
    }

    public function proposeNewTime(Request $request,Appointment $appointment)
    {
        $request->validate([
            'new_time' => 'required|date|after:now',
        ]);

        // You can store this as a "proposed_time" field or log somewhere
        $appointment->proposed_time = $request->new_time;
        $appointment->save();

        return back()->with('success', 'Proposed new time successfully.');
    }

}
