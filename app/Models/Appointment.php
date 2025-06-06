<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    use HasFactory;
    protected $fillable = [
        'cottage_number',
        'preferred_date',
        'preferred_time',
        'proposed_time',
        'message',
        'status',
        'user_id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class,'user_id');
    }

}
