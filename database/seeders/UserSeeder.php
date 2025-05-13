<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $password = 'shelo1234';

        User::create([
            'first_name' => 'shelter',
            'last_name' => 'sibanda',
            'email' => 'shelter@gmail.com',
            'email_verified_at' => now(),
            'password' => 'password123',
            'remember_token' => Str::random(10),
        ]);

        User::create([
            'first_name' => 'chris',
            'last_name' => 'ugbaja',
            'role' => 'admin',
            'email' => 'chris@gmail.com',
            'email_verified_at' => now(),
            'password' => 'password123',
            'remember_token' => Str::random(10),
        ]);

        User::create([
            'first_name' => 'fadzai',
            'last_name' => 'bridges',
            'role' => 'tenant',
            'email' => 'fadzai@gmail.com',
            'email_verified_at' => now(),
            'password' => 'password123',
            'remember_token' => Str::random(10),
        ]);

        User::create([
            'first_name' => 'susan',
            'last_name' => 'williams',
            'role' => 'tenant',
            'email' => 'susan@gmail.com',
            'email_verified_at' => now(),
            'password' => 'password123',
            'remember_token' => Str::random(10),
        ]);
    }
}
