<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class ListingPromotion extends Model
{
    protected $fillable = [
        'listable_type',
        'listable_id',
        'user_id',
        'listing_package_id',
        'listing_payment_id',
        'tier',
        'days',
        'starts_at',
        'ends_at',
        'ad_ends_at',
        'spotlight',
        'status',
    ];

    protected $casts = [
        'starts_at' => 'datetime',
        'ends_at' => 'datetime',
        'ad_ends_at' => 'datetime',
        'spotlight' => 'boolean',
    ];

    public function listable(): MorphTo
    {
        return $this->morphTo();
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function package(): BelongsTo
    {
        return $this->belongsTo(ListingPackage::class, 'listing_package_id');
    }

    public function payment(): BelongsTo
    {
        return $this->belongsTo(ListingPayment::class, 'listing_payment_id');
    }

    public function scopeActive(Builder $q): Builder
    {
        return $q->where('status', 'active')->where('starts_at', '<=', now())->where('ends_at', '>', now());
    }

    /** Currently in the homepage ad rotation. */
    public function scopeInAds(Builder $q): Builder
    {
        return $q->active()->whereNotNull('ad_ends_at')->where('ad_ends_at', '>', now());
    }

    public function scopeSpotlight(Builder $q): Builder
    {
        return $q->active()->where('spotlight', true);
    }

    public function daysLeft(): int
    {
        return max(0, (int) ceil(now()->diffInHours($this->ends_at, false) / 24));
    }

    public function adDaysLeft(): int
    {
        return $this->ad_ends_at ? max(0, (int) ceil(now()->diffInHours($this->ad_ends_at, false) / 24)) : 0;
    }
}
