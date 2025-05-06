<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cottage extends Model
{
   protected $fillable = [
    'number',
    'location',
    'price_per_month',
    'is_available'
   ];
}
