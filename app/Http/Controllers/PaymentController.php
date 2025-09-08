<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\Tenant;
use App\Models\User;
use App\Notifications\AdminShortPaymentNotification;
use App\Notifications\OverPaymentNotification;
use App\Notifications\PaymentNotification;
use App\Notifications\ShortPaymentNotification;
use App\Notifications\TenantPaymentNotification;
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
        $validated_data = $request->validate([
            'month_for'     => 'required|string',
            'amount_paid'   => 'required|numeric',
            'date'  => 'required|date',
            'reference'   => 'required|string',
            'proof'         => 'required|file|mimes:pdf,jpg,jpeg,png|max:2048',
        ]);

        // to avoid sending the proof to the database
        // since we are using spatie media for storing files
        unset($validated_data['proof']);

        $tenant = Auth::user()->tenant;

        $admin = User::where('role', 'admin')->first();
        $amount_paid = $validated_data['amount_paid'];
        $month = $validated_data['month_for'];
        $lease = $tenant->currentLease;

        // The following logic first check if the user does not have any outstanding balance

        $previous_balance = Payment::where('lease_id', $lease->id)
        ->where('outstanding_balance', '>', 0)
        ->sum('outstanding_balance');

        $remaining_balance = $

        // statement to run when user does not have existing lease
        if(!$tenant || !$tenant->currentLease)
        {
            return back()->withErrors(['Lease'=> 'No active lease found for this tenant']);
        }

        $validated_data['lease_id'] = $tenant->currentLease?->id;

        // statement to run when user underpay
        if($validated_data['amount_paid'] < $tenant->currentLease->monthly_rent)
        {
            $validated_data['status'] = 'partial';
            $remaining_balance = ($tenant->currentLease->monthly_rent ) - ($amount_paid);
            // dd($remaining_balance);
            $validated_data['outstanding_balance'] = $remaining_balance;
            $admin->notify(new AdminShortPaymentNotification($admin,$tenant,$amount_paid, $month, $remaining_balance));
            $tenant->notify(new ShortPaymentNotification($tenant,$amount_paid, $month, $remaining_balance));
        }

        //statement to run when user overpaid
        if($validated_data['amount_paid'] > $tenant->currentLease->monthly_rent)
        {

            $over_paid_amount = $amount_paid - $tenant->currentLease->monthly_rent ;
            $validated_data['status'] = 'pending';
            $validated_data['over_paid_amount'] = $over_paid_amount;
            $admin->notify(new OverPaymentNotification($tenant,$admin, $amount_paid,$over_paid_amount,$month));
        }

         if($validated_data['amount_paid'] == $tenant->currentLease->monthly_rent)
        {
            $validated_data['status'] = 'pending';
            $admin->notify(new PaymentNotification($tenant));
            $tenant->notify(new TenantPaymentNotification($tenant));
        }

        $payment = Payment::create($validated_data);

        // Attach proof using Spatie Media
        if ($request->hasFile('proof')) {
            $payment->addMediaFromRequest('proof')
                ->toMediaCollection('proofs');
        }

        return redirect(route('tenant.dashboard'))->with('success', 'Payment submitted successfully!');
    }
}

