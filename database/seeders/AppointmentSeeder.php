<?php

namespace Database\Seeders;

use App\Models\Appointment;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AppointmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::find(1);

        Appointment::create([
            'user_id' => $user->id,
            'cottage_number' => 8,
            'preferred_time' => fake()->time(),
            'preferred_date' => fake()->date(),
            'status' => 'pending',
            'message' => fake()->sentence()
        ]);

    }
}
