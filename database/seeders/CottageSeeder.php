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
            'location' => '66 1st avenue, bramley kew',
            'price_per_month' => 5500,
            'status' => 'taken'
        ]);

         Cottage::create([
            'user_id'=> 23,
            'number' => 20,
            'location' => '66 1st avenue, bramley kew',
            'price_per_month' => 5500,
            'status' => 'taken'
        ]);

         Cottage::create([
            'user_id'=> 24,
            'number' => 12,
            'location' => '4 heelra rd, bramley park, sandton',
            'price_per_month' => 5500,
            'status' => 'taken'
        ]);
    }
}
