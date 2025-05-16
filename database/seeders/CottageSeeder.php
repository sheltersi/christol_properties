<?php

namespace Database\Seeders;

use App\Models\Cottage;
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
         // Create 10 cottages
    Cottage::factory(10)->create()->each(function ($cottage) {
        // Use local image files or download from the internet (unsplash.it)
        $imageUrl = 'https://picsum.photos/640/480'; // Random placeholder image
        $imageContents = file_get_contents($imageUrl);
        $filename = 'cottage_' . uniqid() . '.jpg';

        // Store image locally (in storage/app/public/temp)
        Storage::disk('public')->put("temp/{$filename}", $imageContents);

        // Attach to Spatie Media Library
        $cottage->addMedia(storage_path("app/public/temp/{$filename}"))
            ->preservingOriginal()
            ->toMediaCollection('images');

        // Optionally delete the temp file
        Storage::disk('public')->delete("temp/{$filename}");
    });



    }
}
