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
        $user3 = User::find(3);
        $user4 = User::find(4);

        Appointment::create([
            'user_id' => $user->id,
            'cottage_number' => 8,
            'preferred_time' => fake()->time(),
            'preferred_date' => fake()->date(),
            'status' => 'pending',
            'message' => fake()->sentence()
        ]);

        Appointment::create([
            'user_id' => $user3->id,
            'cottage_number' => 5,
            'preferred_time' => fake()->time(),
            'preferred_date' => fake()->date(),
            'status' => 'pending',
            'message' => fake()->sentence()
        ]);

        Appointment::create([
            'user_id' => $user4->id,
            'cottage_number' => 7,
            'preferred_time' => fake()->time(),
            'preferred_date' => fake()->date(),
            'status' => 'pending',
            'message' => fake()->sentence()
        ]);

    }
}
