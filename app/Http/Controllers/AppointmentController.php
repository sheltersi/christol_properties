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

        return Inertia::render('Appointments/Index',[
            'user' => $user,
            'user_appointments' => $user_appointments
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

}
