<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Payment extends Model implements HasMedia
{
    /** @use HasFactory<\Database\Factories\PaymentFactory> */
    use HasFactory, InteractsWithMedia;


    protected $fillable = [
        'lease_id',
        'month_for',
        'amount_paid',
        'status',
        'date',
        'reference',
        'outstanding_balance',
        'over_paid_amount'
    ];

     public function lease():BelongsTo
    {
        return $this->belongsTo(Payment::class);
    }

}
