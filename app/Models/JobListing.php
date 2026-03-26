<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class JobListing extends Model
{
    protected $fillable = [
        'company_name',
        'company_email',
        'company_phone',
        'company_logo',
        'company_website',
        'title',
        'slug',
        'description',
        'requirements',
        'benefits',
        'location',
        'job_type',
        'category',
        'salary_min',
        'salary_max',
        'salary_currency',
        'show_salary',
        'application_deadline',
        'application_email',
        'application_url',
        'listing_package_id',
        'days_purchased',
        'total_amount',
        'agent_commission_amount',
        'terra_share_amount',
        'payment_status',
        'payment_reference',
        'payment_method',
        'paid_at',
        'status',
        'published_at',
        'expires_at',
        'rejection_reason',
        'user_id',
    ];

    protected $casts = [
        'salary_min'           => 'integer',
        'salary_max'           => 'integer',
        'total_amount'         => 'integer',
        'agent_commission_amount' => 'integer',
        'terra_share_amount'   => 'integer',
        'days_purchased'       => 'integer',
        'show_salary'          => 'boolean',
        'paid_at'              => 'datetime',
        'published_at'         => 'datetime',
        'expires_at'           => 'datetime',
        'application_deadline' => 'date',
    ];

    // ── Relationships ────────────────────────────────────────────

    public function package()
    {
        return $this->belongsTo(ListingPackage::class, 'listing_package_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // ── Scopes ──────────────────────────────────────────────────

    public function scopeActive(Builder $query): Builder
    {
        return $query->where('status', 'active')
                     ->where('expires_at', '>', now());
    }

    public function scopeExpired(Builder $query): Builder
    {
        return $query->where('status', 'active')
                     ->where('expires_at', '<=', now());
    }

    public function scopePaid(Builder $query): Builder
    {
        return $query->where('payment_status', 'paid');
    }

    // ── Accessors ────────────────────────────────────────────────

    public function getDaysRemainingAttribute(): int
    {
        if (!$this->expires_at) return 0;
        return max(0, (int) now()->diffInDays($this->expires_at, false));
    }

    public function getIsExpiredAttribute(): bool
    {
        return $this->expires_at && $this->expires_at->isPast();
    }

    public function getIsActiveAttribute(): bool
    {
        return $this->status === 'active' && !$this->is_expired;
    }

    public function getSalaryRangeAttribute(): string
    {
        if (!$this->show_salary) return 'Not disclosed';
        if ($this->salary_min && $this->salary_max) {
            return number_format($this->salary_min) . ' – ' . number_format($this->salary_max) . ' ' . $this->salary_currency;
        }
        if ($this->salary_min) {
            return 'From ' . number_format($this->salary_min) . ' ' . $this->salary_currency;
        }
        return 'Negotiable';
    }

    public function getJobTypeLabelAttribute(): string
    {
        return match($this->job_type) {
            'full-time'   => 'Full Time',
            'part-time'   => 'Part Time',
            'contract'    => 'Contract',
            'internship'  => 'Internship',
            'remote'      => 'Remote',
            default       => ucfirst($this->job_type),
        };
    }

    // ── Business Logic ───────────────────────────────────────────

    /**
     * Activate the listing after payment is confirmed.
     */
    public function activate(): void
    {
        $now = Carbon::now();

        $this->update([
            'status'       => 'active',
            'published_at' => $now,
            'expires_at'   => $now->copy()->addDays($this->days_purchased),
            'payment_status' => 'paid',
            'paid_at'      => $now,
        ]);
    }

    /**
     * Mark as expired.
     */
    public function expire(): void
    {
        $this->update(['status' => 'expired']);
    }

    /**
     * Check and auto-expire if past expiry date.
     */
    public function checkExpiry(): void
    {
        if ($this->status === 'active' && $this->expires_at && $this->expires_at->isPast()) {
            $this->expire();
        }
    }

    // ── Slug generation ──────────────────────────────────────────

    public static function generateSlug(string $title): string
    {
        $slug = Str::slug($title);
        $count = static::where('slug', 'like', "{$slug}%")->count();
        return $count ? "{$slug}-{$count}" : $slug;
    }
}