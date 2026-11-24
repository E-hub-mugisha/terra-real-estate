<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Commission extends Model
{
    protected $fillable = [
        'user_id',
        'role',
        'type',
        'listable_type',
        'listable_id',
        'listing_payment_id',
        'base_amount',
        'rate',
        'amount',
        'currency',
        'status',
        'notes',
        'paid_at',
    ];

    protected $casts = [
        'base_amount' => 'decimal:2',
        'rate' => 'decimal:2',
        'amount' => 'decimal:2',
        'paid_at' => 'datetime',
    ];

    public const STATUSES = ['pending', 'approved', 'paid', 'cancelled'];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function listable(): MorphTo
    {
        return $this->morphTo();
    }

    public function payment(): BelongsTo
    {
        return $this->belongsTo(ListingPayment::class, 'listing_payment_id');
    }

    public function typeLabel(): string
    {
        return match ($this->type) {
            'listing_fee' => 'Listing fee share',
            'deal' => 'Deal commission',
            'referral' => 'Referral',
            default => ucfirst($this->type),
        };
    }
}
