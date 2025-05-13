<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\User;
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

        $appointments = Appointment::with('user')
            ->when($search, fn($q) =>
            $q->whereHas('user', fn($q) =>
            // $q->where('first_name', 'like', "%$search%")))
            $q->where('first_name', 'like', "%$search%")
                ->orWhere('last_name', 'like', "%$search%")))
            ->latest()
            ->paginate(10)
            ->withQueryString();

        if ($request->wantsJson()) {
            return response()->json([
                'appointments' => $appointments,
                'filters' => ['search' => $search],
            ]);
        }

        return Inertia::render('Admin/Appointments/Index', [
            'appointments' => $appointments,
            'filters' => ['search' => $search],
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
        return Inertia::render('Appointments/Show', [
            'appointment' => $appointment,
        ]);
    }

    public function confirm(Appointment $appointment)
    {
        $appointment->update(['status' => 'confirmed']);
        return redirect()->route('all-appointments.index')->with('success', 'Appointment confirmed.');
    }
}
