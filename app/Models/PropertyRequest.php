<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class PropertyRequest extends Model
{
    use SoftDeletes;

    protected $fillable = [
        // Step 1
        'full_name',
        'email',
        'phone',
        'nationality',
        'preferred_contact',
        // Step 2
        'request_type',
        'property_type',
        'property_status',
        // Step 3
        'preferred_province',
        'preferred_district',
        'preferred_sector',
        'location_notes',
        // Step 4
        'currency',
        'budget_min',
        'budget_max',
        'timeline',
        'financing_needed',
        // Step 5
        'bedrooms_min',
        'bathrooms_min',
        'land_size_min',
        'land_size_max',
        'amenities',
        'must_have_features',
        'nice_to_have_features',
        // Step 6
        'additional_notes',
        'newsletter_opt_in',
        'how_did_you_hear',
        'urgency',
        // Internal
        'status',
        'reference_number',
        'assigned_agent',
        'admin_notes',
        'reviewed_at',
    ];

    protected $casts = [
        'amenities'            => 'array',
        'must_have_features'   => 'array',
        'nice_to_have_features' => 'array',
        'financing_needed'     => 'boolean',
        'newsletter_opt_in'    => 'boolean',
        'reviewed_at'          => 'datetime',
        'budget_min'           => 'decimal:2',
        'budget_max'           => 'decimal:2',
        'land_size_min'        => 'decimal:2',
        'land_size_max'        => 'decimal:2',
    ];

    /**
     * Boot — auto-generate reference number before creating.
     */
    protected static function boot(): void
    {
        parent::boot();

        static::creating(function (PropertyRequest $model) {
            if (empty($model->reference_number)) {
                $model->reference_number = self::generateReference();
            }
        });
    }

    public static function generateReference(): string
    {
        do {
            $ref = 'TERRA-' . strtoupper(Str::random(3)) . '-' . now()->format('ymd') . '-' . random_int(100, 999);
        } while (self::withTrashed()->where('reference_number', $ref)->exists());

        return $ref;
    }

    /* ── Scopes ───────────────────────────────────────────────── */

    public function scopeNew($query)
    {
        return $query->where('status', 'new');
    }
    public function scopeInReview($query)
    {
        return $query->where('status', 'in_review');
    }
    public function scopeMatched($query)
    {
        return $query->where('status', 'matched');
    }

    /* ── Accessors ────────────────────────────────────────────── */

    public function getFormattedBudgetAttribute(): string
    {
        $symbol = match ($this->currency) {
            'RWF' => 'RWF ',
            'EUR' => '€',
            default => '$',
        };

        $min = $this->budget_min ? $symbol . number_format($this->budget_min) : null;
        $max = $this->budget_max ? $symbol . number_format($this->budget_max) : null;

        if ($min && $max) return "{$min} – {$max}";
        if ($min)        return "From {$min}";
        if ($max)        return "Up to {$max}";
        return 'Not specified';
    }

    public function getUrgencyBadgeColorAttribute(): string
    {
        return match ($this->urgency) {
            'high'   => 'red',
            'medium' => 'yellow',
            default  => 'green',
        };
    }
}
