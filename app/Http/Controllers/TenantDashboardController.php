<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class TenantDashboardController extends Controller
{
    public function index()
{
    $user = Auth::user();
    $tenant = $user;

    return Inertia::render('Tenant/Dashboard', [
        'tenant' => $tenant,
        'cottage' => $tenant->cottage, // assuming relationship
        // 'payments' => [
        //     'last_payment_date' => $tenant->payments()->latest()->first()?->created_at,
        //     'balance_due' => $tenant->balance_due ?? 0,
        // ],
        // 'appointments' => $tenant->appointments()->upcoming()->get(),
        'appointments' => $tenant->appointments()->get(),

        // 'maintenance' => $tenant->maintenanceRequests()->latest()->take(5)->get(),
    ]);
}

}
