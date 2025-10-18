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

        unset($validated_data['proof']);

        $tenant = Auth::user()->tenant;

        $admin = User::where('role', 'admin')->first();
        $amount_paid = $validated_data['amount_paid'];
        $month = $validated_data['month_for'];
        $lease = $tenant->currentLease;
        $monthly_rent = $tenant->currentLease->monthly_rent;
        $validated_data['lease_id'] = $tenant->currentLease?->id;

        // statement to run when user does not have existing lease
        if (!$tenant || !$tenant->currentLease) {
            return back()->withErrors(['Lease' => 'No active lease found for this tenant']);
        }

        // The following logic first check if the user does not have any outstanding balance
        $outstanding_balance = Payment::where('lease_id', $lease->id)
            ->where('outstanding_balance', '>', 0)
            ->sum('outstanding_balance');

        // statement to run if user make payment whilst owing
        if ($outstanding_balance  > 0) {

            if ($amount_paid == $outstanding_balance) {
                $validated_data['outstanding_balance'] = 0.0;
            }
            elseif ($amount_paid > $outstanding_balance) {
                $extra_balance = $amount_paid - $outstanding_balance;
                $validated_data['outstanding_balance'] = 0.0;
                $validated_data['overpaid_balance'] = $extra_balance;
            }
            else {
                $validated_data['outstanding_balance'] = $outstanding_balance - $amount_paid;
            }
        }

        //statement to run if user underpay
        elseif ($amount_paid < $monthly_rent) {
            $balance = $monthly_rent - $amount_paid;
            $validated_data['status'] = 'partial';
            $validated_data['outstanding_balance'] = $balance;
            // $admin->notify(new underPaymentNotification($tenant, $admin, $amount_paid, $overpaid_balance, $month));
        }

        //statement to run when user overpaid
        elseif ($amount_paid > $monthly_rent) {

            $overpaid_balance = $amount_paid - $monthly_rent;

            $validated_data['overpaid_balance'] = $overpaid_balance;

            // update tenant prepared balance
            $tenant->increment('prepaid_balance',$overpaid_balance);

            $admin->notify(new OverPaymentNotification($tenant, $admin, $amount_paid, $overpaid_balance, $month));
        }

        //statement to run if user pays correct rental amount
        elseif ($amount_paid == $monthly_rent) {
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
