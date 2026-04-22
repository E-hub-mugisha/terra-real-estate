<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class JobListingView extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'job_listing_id',
        'user_id',
        'ip_address',
        'session_id',
        'user_agent',
        'is_unique',
        'is_bot',
        'viewed_at',
    ];

    protected $casts = [
        'is_unique' => 'boolean',
        'is_bot'    => 'boolean',
        'viewed_at' => 'datetime',
    ];

    // ── Relationships ────────────────────────────────────────────────────────

    public function jobListing(): BelongsTo
    {
        return $this->belongsTo(JobListing::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    // ── Scopes ───────────────────────────────────────────────────────────────

    public function scopeReal($query)
    {
        return $query->where('is_bot', false);
    }

    public function scopeUnique($query)
    {
        return $query->where('is_unique', true)->where('is_bot', false);
    }

    public function scopeForPeriod($query, string $from, string $to)
    {
        return $query->whereBetween('viewed_at', [$from, $to]);
    }

    public function scopeToday($query)
    {
        return $query->whereDate('viewed_at', today());
    }

    public function scopeThisWeek($query)
    {
        return $query->where('viewed_at', '>=', now()->startOfWeek());
    }

    public function scopeThisMonth($query)
    {
        return $query->where('viewed_at', '>=', now()->startOfMonth());
    }

    // ── Bot detection ────────────────────────────────────────────────────────

    /**
     * Common crawler / bot keywords.
     * Extend this list as needed.
     */
    public static function detectBot(?string $userAgent): bool
    {
        if (blank($userAgent)) {
            return false;
        }

        $bots = [
            'bot', 'crawl', 'spider', 'slurp', 'search', 'fetch',
            'mediapartners', 'facebookexternalhit', 'Twitterbot',
            'LinkedInBot', 'WhatsApp', 'TelegramBot', 'Googlebot',
            'bingbot', 'DuckDuckBot', 'Baiduspider', 'YandexBot',
            'SemrushBot', 'AhrefsBot', 'MJ12bot', 'Bytespider',
            'HeadlessChrome', 'PhantomJS',
        ];

        foreach ($bots as $bot) {
            if (stripos($userAgent, $bot) !== false) {
                return true;
            }
        }

        return false;
    }
}