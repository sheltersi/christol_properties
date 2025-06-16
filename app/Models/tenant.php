<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class tenant extends Model
{
    /** @use HasFactory<\Database\Factories\TenantFactory> */
    use HasFactory;

    public function lease():HasOne
    {
        return $this->hasOne(Lease::class);
    }
     public function user() {
        return $this->belongsTo(User::class);
    }
}
