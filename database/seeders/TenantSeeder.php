<?php

namespace Database\Seeders;

use App\Models\Tenant;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TenantSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user21 = User::find(21);

        Tenant::create([
            'user_id' => $user21->id,
            'payment_reference' => '78645'
        ]);

          Tenant::create([
            'user_id' => User::find(23)->id,
            'payment_reference' => '78678'
        ]);

         Tenant::create([
            'user_id' => User::find(24)->id,
            'payment_reference' => '67849'
        ]);
    }
}
