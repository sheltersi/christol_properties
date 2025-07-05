<?php

namespace Database\Seeders;

use App\Models\Lease;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class LeaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Lease::create([
            'tenant_id' => 1,
            'cottage_id' => 1,
            'monthly_rent' => 5500,
            'payment_date' => Carbon::create(2025, 12, 31),
            'lease_expiry_date' => Carbon::create(2025, 12, 31),
            'starts_at' => Carbon::create(2023, 12, 31),
            'end_at' => Carbon::create(2026, 12, 30),
            'deposit_amount' => 5500,
            'status' => 'active',
        ]);
    }
}
