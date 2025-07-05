<?php

namespace App\Http\Controllers;

use App\Models\Tenant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class TenantDashboardController extends Controller
{
    public function index()
{
  $tenant = Tenant::with([
        'currentLease.cottage',
        'currentLease.currentPayment',
        'user',
        // 'leases.cottage',     // history, if you ever need it
        // 'leases.payments',
    ])
    ->where('user_id', auth()->id())
    ->firstOrFail();

    // dd($tenant);

    return Inertia::render('Tenant/Dashboard', [
        'tenant' => $tenant,
        // 'cottage' => $tenant->cottage, // assuming relationship
    ]);
}

}
