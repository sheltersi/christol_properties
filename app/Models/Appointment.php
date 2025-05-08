<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    //
    protected $fillable = [
        'cottage_number',
        'preferred_date',
        'preferred_time',
        'message',
        'status',
        'user_id'
    ];

    public function user()
    {
        return $this->hasOne(Appointment::class);
    }

}
