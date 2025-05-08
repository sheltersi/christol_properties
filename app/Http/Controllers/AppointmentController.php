<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Inertia\Inertia;

class AppointmentController extends Controller
{
    //
    public function index():View
    {

    }

    public function create()
    {

            return Inertia::render('Dashboard');

    }

    public function store(Request $request)
{
    // dd($request);
    $validated = $request->validate([
        'preferred_date' => 'required|date',
        'preferred_time' => 'required',
        'message' => 'nullable|string',
        'cottage_number' => 'required',
    ]);

    Appointment::create([
        'user_id' => auth()->id(), // ✅ Set the current user's ID
        'cottage_number' => $validated['cottage_number'],
        'preferred_date' => $validated['preferred_date'],
        'preferred_time' => $validated['preferred_time'],
        'message' => $validated['message'] ?? '',
        'status' => 'pending',
    ]);
    return redirect()->route('cottages.index');
}

}
