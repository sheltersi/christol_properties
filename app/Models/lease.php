<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Lease extends Model
{
    /** @use HasFactory<\Database\Factories\LeaseFactory> */
    use HasFactory;

    protected $fillable = [
        'tenant_id',
        'cottage_id',
        'monthly_rent',
        'payment_date',
        'starts_at',
        'end_at',
        'deposit_amount',
        'status',
        'lease_expiry_date'
    ];

    public function payments():HasMany
    {
        return $this->hasMany(Payment::class);
    }

     public function tenant():BelongsTo
    {
        return $this->belongsTo(Tenant::class);
    }

    public function currentPayment()
    {
        return $this->hasOne(Payment::class)
                ->latestOfMany();
    }

     public function cottage():BelongsTo
    {
        return $this->belongsTo(Cottage::class);
    }
}
