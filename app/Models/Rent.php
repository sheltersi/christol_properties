<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Rent extends Model implements HasMedia
{
    use InteractsWithMedia;

    protected $fillable = [
        'user_id',
        'phone',
        'dob',
        'id_number',
        'current_address',
        'occupants',
        'pets',
        'employer',
        'job_title',
        'employment_start',
        'monthly_income',
        'employer_contact',
        'landlord_name',
        'landlord_contact',
        'rent_amount',
        'reason_leaving',
        'agree'
    ];
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
