<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\Cottage;
use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;

class AdminDashboardController extends Controller
{
    public function index()
{
    $today = now()->toDateString();

    return Inertia::render('Admin/Dashboard', [
        'stats' => [
            'totalCottages' => Cottage::count(),
            'upcomingAppointments' => Appointment::whereDate('preferred_date', $today)->count(),
            'totalUsers' => User::count(),
            'pendingPayments' => Appointment::where('status', 'pending')->count(),
        ],
        'recentAppointments' => Appointment::with('user')
            ->whereDate('preferred_date', $today)
            ->latest()
            ->take(5)
            ->get(),
        'notifications' => [
            ['id' => 1, 'message' => '2 appointments are unconfirmed.'],
            ['id' => 2, 'message' => '1 maintenance request pending.'],
        ],
    ]);
}
}
