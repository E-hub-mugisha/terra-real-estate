<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Advertisement extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'user_id',
        'listing_package_id',
        'listing_days',
        'advertisable_type',
        'advertisable_id',
        'title',
        'description',
        'contact_phone',
        'contact_email',
        'location',
        'price_amount',
        'currency',
        'images',
        'video_path',
        'payment_status',
        'momo_phone',
        'momo_transaction_id',
        'payment_submitted_at',
        'payment_confirmed_at',
        'payment_confirmed_by',
        'status',
        'starts_at',
        'expires_at',
        'impressions',
        'clicks',
        'admin_notes',
    ];

    protected $casts = [
        'images'               => 'array',
        'price_amount'         => 'decimal:2',
        'payment_submitted_at' => 'datetime',
        'payment_confirmed_at' => 'datetime',
        'starts_at'            => 'datetime',
        'expires_at'           => 'datetime',
    ];

    // ── Relationships ────────────────────────────────────────────

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function listingPackage(): BelongsTo
    {
        return $this->belongsTo(ListingPackage::class);
    }

    public function advertisable(): MorphTo
    {
        return $this->morphTo();
    }

    public function confirmedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'payment_confirmed_by');
    }

    // ── Scopes ───────────────────────────────────────────────────

    public function scopePendingReview($query)
    {
        return $query->where('status', 'pending_review');
    }

    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    public function scopeForUser($query, $userId)
    {
        return $query->where('user_id', $userId);
    }

    // ── Helpers ──────────────────────────────────────────────────

    public function getTotalCostAttribute(): int
    {
        return ($this->listingPackage?->price_per_day ?? 0) * $this->listing_days;
    }

    public function getFormattedTotalAttribute(): string
    {
        return number_format($this->total_cost) . ' RWF';
    }

    public function getStatusBadgeAttribute(): array
    {
        return match ($this->status) {
            'draft'          => ['label' => 'Draft',          'class' => 'badge-secondary'],
            'pending_review' => ['label' => 'Pending Review', 'class' => 'badge-warning'],
            'active'         => ['label' => 'Active',         'class' => 'badge-success'],
            'paused'         => ['label' => 'Paused',         'class' => 'badge-info'],
            'expired'        => ['label' => 'Expired',        'class' => 'badge-dark'],
            'rejected'       => ['label' => 'Rejected',       'class' => 'badge-danger'],
            default          => ['label' => ucfirst($this->status), 'class' => 'badge-secondary'],
        };
    }

    public function getPaymentBadgeAttribute(): array
    {
        return match ($this->payment_status) {
            'pending'   => ['label' => 'Pending',   'class' => 'badge-warning'],
            'confirmed' => ['label' => 'Confirmed', 'class' => 'badge-success'],
            'rejected'  => ['label' => 'Rejected',  'class' => 'badge-danger'],
            default     => ['label' => 'Pending',   'class' => 'badge-warning'],
        };
    }

    public function isExpired(): bool
    {
        return $this->expires_at && $this->expires_at->isPast();
    }

    /**
     * Activate the ad after payment is confirmed.
     */
    public function activate(int $confirmedBy): void
    {
        $now = now();
        $this->update([
            'status'               => 'active',
            'payment_status'       => 'confirmed',
            'payment_confirmed_at' => $now,
            'payment_confirmed_by' => $confirmedBy,
            'starts_at'            => $now,
            'expires_at'           => $now->copy()->addDays($this->listing_days),
        ]);
    }

    /**
     * Reject the ad with an optional admin note.
     */
    public function reject(int $confirmedBy, ?string $note = null): void
    {
        $this->update([
            'status'               => 'rejected',
            'payment_status'       => 'rejected',
            'payment_confirmed_by' => $confirmedBy,
            'admin_notes'          => $note,
        ]);
    }

    /**
     * Returns the route to the linked property's detail page.
     */
    public function getAdvertisableUrlAttribute(): ?string
    {
        if (! $this->advertisable_type || ! $this->advertisable_id) {
            return null;
        }

        return match ($this->advertisable_type) {
            \App\Models\House::class               => route('front.buy.home.details', $this->advertisable_id),
            \App\Models\Land::class                => route('front.buy.land.details', $this->advertisable_id),
            \App\Models\ArchitecturalDesign::class => route('front.buy.design.show', $this->advertisable_id),
            default => null,
        };
    }

    /**
     * Returns a human-readable label for the linked property type.
     */
    public function getAdvertisableTypeLabelAttribute(): ?string
    {
        if (! $this->advertisable_type) return null;

        return match ($this->advertisable_type) {
            \App\Models\House::class               => 'House',
            \App\Models\Land::class                => 'Land',
            \App\Models\ArchitecturalDesign::class => 'Architectural Design',
            default => class_basename($this->advertisable_type),
        };
    }
}
