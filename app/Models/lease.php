<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class lease extends Model
{
    /** @use HasFactory<\Database\Factories\LeaseFactory> */
    use HasFactory;


    public function payments():HasOne
    {
        return $this->hasOne(Payment::class);
    }

     public function tenant():BelongsTo
    {
        return $this->belongsTo(Tenant::class);
    }
}
