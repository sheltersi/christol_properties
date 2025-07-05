<?php

namespace Database\Seeders;

use App\Models\Cottage;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;

class CottageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Cottage::create([
            'user_id'=> 21,
            'number' => 21,
            'location' => '66 1st avenue bramley view',
            'price_per_month' => 5500,
            'status' => 'taken'
        ]);
    }
}
