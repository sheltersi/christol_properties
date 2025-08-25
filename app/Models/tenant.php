<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Notifications\Notifiable;

class Tenant extends Model
{
    /** @use HasFactory<\Database\Factories\TenantFactory> */
    use HasFactory, Notifiable;

    protected $fillable = [
        'user_id',
        // 'payment_reference',
    ];

    public function leases():HasMany
    {
        return $this->hasMany(Lease::class);
    }
     public function user() {
        return $this->belongsTo(User::class);
    }

    // current lease = the one whose dates cover today (or latest 'active')
    public function currentLease()
    {
        return $this->hasOne(Lease::class)
                    ->where('status', 'active')      // or date logic
                    ->latestOfMany();                // picks the latest row
    }
}
