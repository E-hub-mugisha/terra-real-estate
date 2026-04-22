<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class ModelView extends Model
{
    public $timestamps = false;

    protected $table = 'model_views';

    protected $fillable = [
        'viewable_type',
        'viewable_id',
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

    public function viewable(): MorphTo
    {
        return $this->morphTo();
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