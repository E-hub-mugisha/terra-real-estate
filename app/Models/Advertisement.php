<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;

class Advertisement extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'user_id', 'advertisement_package_id',
        'advertisable_id', 'advertisable_type',
        'title', 'description', 'contact_phone', 'contact_email',
        'location', 'price_amount', 'currency',
        'images', 'video_path',
        'payment_status', 'momo_phone', 'momo_transaction_id',
        'payment_submitted_at', 'payment_confirmed_at', 'payment_confirmed_by',
        'status', 'starts_at', 'expires_at',
        'impressions', 'clicks', 'admin_notes',
    ];

    protected $casts = [
        'images'                 => 'array',
        'payment_submitted_at'   => 'datetime',
        'payment_confirmed_at'   => 'datetime',
        'starts_at'              => 'datetime',
        'expires_at'             => 'datetime',
        'price_amount'           => 'decimal:2',
    ];

    // ─── Relationships ────────────────────────────────────────────────────────

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function package(): BelongsTo
    {
        return $this->belongsTo(AdvertisementPackage::class, 'advertisement_package_id');
    }

    public function advertisable(): MorphTo
    {
        return $this->morphTo();
    }

    public function confirmedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'payment_confirmed_by');
    }

    // ─── Scopes ───────────────────────────────────────────────────────────────

    public function scopeActive($query)
    {
        return $query->where('status', 'active')
                     ->where('starts_at', '<=', now())
                     ->where('expires_at', '>=', now());
    }

    public function scopePendingPayment($query)
    {
        return $query->where('payment_status', 'pending')
                     ->whereNotNull('momo_phone');
    }

    public function scopeForHomepage($query)
    {
        return $query->active()
                     ->whereHas('package', fn ($q) => $q->where('featured_homepage', true));
    }

    public function scopeFeatured($query)
    {
        return $query->active()
                     ->whereHas('package', fn ($q) => $q->where('featured_listings', true));
    }

    // ─── Accessors ────────────────────────────────────────────────────────────

    public function getFirstImageUrlAttribute(): ?string
    {
        $images = $this->images;
        return $images && count($images) > 0
            ? Storage::url($images[0])
            : null;
    }

    public function getVideoUrlAttribute(): ?string
    {
        return $this->video_path ? Storage::url($this->video_path) : null;
    }

    public function getIsExpiredAttribute(): bool
    {
        return $this->expires_at && $this->expires_at->isPast();
    }

    public function getIsActiveAttribute(): bool
    {
        return $this->status === 'active'
            && $this->starts_at?->isPast()
            && $this->expires_at?->isFuture();
    }

    public function getDaysRemainingAttribute(): int
    {
        if (! $this->expires_at || $this->is_expired) return 0;
        return (int) now()->diffInDays($this->expires_at);
    }

    public function getListingTypeAttribute(): string
    {
        if (! $this->advertisable_type) return 'Custom';
        return match (true) {
            str_contains($this->advertisable_type, 'House')                 => 'House',
            str_contains($this->advertisable_type, 'Land')                  => 'Land',
            str_contains($this->advertisable_type, 'Architectural')         => 'Design',
            default                                                          => 'Property',
        };
    }

    // ─── Helpers ──────────────────────────────────────────────────────────────

    /**
     * Activate the advertisement after payment is confirmed.
     */
    public function activate(int $confirmedBy): void
    {
        $this->update([
            'payment_status'        => 'confirmed',
            'payment_confirmed_at'  => now(),
            'payment_confirmed_by'  => $confirmedBy,
            'status'                => 'active',
            'starts_at'             => now(),
            'expires_at'            => now()->addDays($this->package->duration_days),
        ]);
    }

    /**
     * Reject an advertisement (payment not verified or content issue).
     */
    public function reject(string $reason, int $rejectedBy): void
    {
        $this->update([
            'payment_status' => 'rejected',
            'status'         => 'rejected',
            'admin_notes'    => $reason,
        ]);
    }

    /**
     * Increment impression count efficiently.
     */
    public function recordImpression(): void
    {
        $this->increment('impressions');
    }

    public function recordClick(): void
    {
        $this->increment('clicks');
    }
}