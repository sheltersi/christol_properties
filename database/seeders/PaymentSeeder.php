<?php

namespace Database\Seeders;

use App\Models\Payment;
use Faker\Factory as Faker;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;


class PaymentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();

        Payment::create(
            [
                'lease_id' => 1,
                'month_for' => "April",
                'amount_paid' => 5500,
                'status' => "approved",
                'date' => $faker->date(), // e.g. '2025-04-01'
                'reference'  => strtoupper(Str::random(10)), // e.g. 'QWERTY1234'
            ]
        );
    }
}
