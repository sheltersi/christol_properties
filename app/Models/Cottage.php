<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Cottage extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia;
   protected $fillable = [
    'number',
    'location',
    'price_per_month',
    'is_available'
   ];
}
