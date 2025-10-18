<?php

// app/Console/Commands/AllocateOverpayments.php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Tenant;
use App\Models\Payment;
use Carbon\Carbon;

class TestingAllocateOverpayments extends Command
{
    protected $signature = 'payments:allocate-overpayments';
    protected $description = 'Apply overpaid balances to new month rent automatically';

    public function __invoke()
    {
        $tenants = Tenant::with('currentLease')->get();

        foreach ($tenants as $tenant) {
            $lease = $tenant->currentLease;

            if (!$lease) continue;

            $monthly_rent = $lease->monthly_rent;
            $overpaid_balance = Payment::where('lease_id', $lease->id)
                ->sum('overpaid_balance');

            if ($overpaid_balance > 0) {
                if ($overpaid_balance >= $monthly_rent) {
                    // Fully cover rent from overpaid
                    Payment::create([
                        'lease_id' => $lease->id,
                        'month_for' => Carbon::now()->format('F Y'),
                        'amount_paid' => $monthly_rent,
                        'outstanding_balance' => 0,
                        'overpaid_balance' => $overpaid_balance - $monthly_rent,
                        'status' => 'paid',
                        'reference' => 'AUTO_OVERPAYMENT',
                        'date' => now(),
                    ]);

                    $this->info("Tenant {$tenant->id} rent fully covered by overpaid balance.");
                } else {
                    // Partial coverage
                    $outstanding = $monthly_rent - $overpaid_balance;

                    Payment::create([
                        'lease_id' => $lease->id,
                        'month_for' => Carbon::now()->format('F Y'),
                        'amount_paid' => $overpaid_balance,
                        'outstanding_balance' => $outstanding,
                        'overpaid_balance' => 0,
                        'status' => 'partial',
                        'reference' => 'AUTO_OVERPAYMENT_PARTIAL',
                        'date' => now(),
                    ]);

                    $this->info("Tenant {$tenant->id} rent partially covered. Outstanding: {$outstanding}");
                }
            }
        }
    }
}
