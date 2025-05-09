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
            // 'password' => static::$password ??= Hash::make('password'),
            'remember_token' => Str::random(10),
        ]);
    }
}
