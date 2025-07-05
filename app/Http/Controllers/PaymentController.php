<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\Tenant;
use App\Models\User;
use App\Notifications\PaymentNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class PaymentController extends Controller
{
    //
    public function create()
    {
        $tenant = Auth::user()->tenant;

        return Inertia::render("Payments/Create", [
            'tenant' => $tenant,
            // 'payment' => $payment
        ]);
    }

    // Store a new payment (tenant uploads proof)
    public function store(Request $request)
    {
        $request->validate([
            'month_for'     => 'required|string',
            'amount_paid'   => 'required|numeric',
            'date'  => 'required|date',
            'reference'   => 'required|string',
            'proof'         => 'required|file|mimes:pdf,jpg,jpeg,png|max:2048',
        ]);

        $tenant = Auth::user()->tenant;

        $payment = Payment::create([
            'lease_id'     => $tenant->currentLease?->id,
            'month_for'    => $request->month_for,
            'amount_paid'  => $request->amount_paid,
            // 'status'       => 'pending',
            'date' => $request->date,
            'reference'  => $request->reference,
        ]);

        // Attach proof using Spatie Media
        if ($request->hasFile('proof')) {
            $payment->addMediaFromRequest('proof')
                ->toMediaCollection('proofs');
        }

        $admins = User::where('role', 'admin')->get();

        foreach ($admins as $admin) {
            $admin->notify(new PaymentNotification($tenant));
        }

        return redirect(route('tenant.dashboard'))->with('success', 'Payment submitted successfully!');
    }
}

