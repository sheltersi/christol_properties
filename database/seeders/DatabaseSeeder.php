<?php

namespace Database\Seeders;

use App\Models\Appointment;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory(20)->create();
        Appointment::factory(20)->create();


        $this->call([UserSeeder::class]);
        $this->call([AppointmentSeeder::class]);
    }
}
