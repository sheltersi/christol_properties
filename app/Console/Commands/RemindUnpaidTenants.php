<?php

namespace App\Console\Commands;

use App\Models\Payment;
use App\Models\Tenant;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class RemindUnpaidTenants extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:remind-unpaid-tenants';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function __invoke()
    {
        $month = Carbon::now()->format('F Y');

        // Get all tenants with active leases
        $tenants = Tenant::with('currentLease')->get();

        foreach ($tenants as $tenant) {
            $lease = $tenant->currentLease;

            if (!$lease) {
                Log::warning("Tenant {$tenant->id} has no active lease. Skipping.");
                continue;
            }

            // Check if payment exists for this month
            $hasPaid = Payment::where('lease_id', $lease->id)
                ->where('month_for', $month)
                ->exists();


            $fullAmount = $tenant->currentLease->monthly_rent;

            $completePayment  =  Payment::where('lease_id', $lease->id)
                ->where('amount_paid', $fullAmount)
                ->exists();

            if (!$hasPaid) {

                if (!$completePayment) {
                    //reminder to complete the payment
                    Log::info("Reminder sent to tenant {$tenant->id} for {$month} rent.");
                } else {
                    // Send a reminder (email, SMS, or app notification)
                    Log::info("Reminder sent to tenant {$tenant->id} for {$month} rent.");
                }

                // Example: using mail
                // Mail::to($tenant->email)->send(new RentReminderMail($tenant, $month));
            }
        }

        $this->info("Reminders processed successfully for {$month}.");
    }
}
