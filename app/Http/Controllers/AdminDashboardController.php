<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\Cottage;
use App\Models\Lease;
use App\Models\Payment;
use App\Models\Tenant;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Inertia\Inertia;

class AdminDashboardController extends Controller
{
    public function index()
    {
        // 1️⃣ Total rent expected (sum of all active leases)
        $rentDue = Lease::where('status', 'active')->sum('monthly_rent');
        $today = now()->toDateString();
        $currentMonth = Carbon::now()->format('Y-m');

        $rentPaid = Payment::whereYear('date', Carbon::now()->year)
            ->whereMonth('date', Carbon::now()->month)
            ->sum('amount_paid');
        // dd($rentPaid);
        $rentLeft = $rentDue - $rentPaid;


        return Inertia::render('Admin/Dashboard', [
            'stats' => [
                'totalCottages' => Cottage::count(),
                'upcomingAppointments' => Appointment::whereDate('preferred_date', $today)->count(),
                'rentPaid' => Payment::whereYear('date', Carbon::now()->year)
                    ->whereMonth('date', Carbon::now()->month)
                    ->sum('amount_paid'),
                'rentLeft' => $rentLeft,
                'rentDue' => $rentDue,
                'totalTenants' => Tenant::count(),
                'totalLeases' => Lease::all(),
                'activeLeases' => Lease::where('status', 'active'),
                'expiredLeases' => Lease::where('status', 'expired'),
                'pendingPayments' => Appointment::where('status', 'pending')->count(),

            ],
            'recentAppointments' => Appointment::with('user')
                ->whereDate('preferred_date', $today)
                ->latest()
                ->take(5)
                ->get(),
            'pendingPayments' => Payment::where('status', 'pending')->get(),
            'partialPayments' => Payment::where('status', 'partial'),
            'tenants' => Tenant::all(),
            'notifications' => [
                ['id' => 1, 'message' => '2 appointments are unconfirmed.'],
                ['id' => 2, 'message' => '1 maintenance request pending.'],
            ],
        ]);
    }
}
