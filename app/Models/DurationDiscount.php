<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DurationDiscount extends Model
{
    protected $fillable = [
        'min_days',
        'max_days',
        'discount_pct',
        'label',
    ];

    protected $casts = [
        'min_days'     => 'integer',
        'max_days'     => 'integer',
        'discount_pct' => 'float',
    ];

    // Human readable range e.g. "31 – 59 days"
    public function getRangeDescriptionAttribute(): string
    {
        if (is_null($this->max_days)) {
            return $this->min_days . '+ days';
        }
        return $this->min_days . ' – ' . $this->max_days . ' days';
    }

    // Calculate discount amount for a given gross amount
    public function calculateDiscount(int $grossAmount): int
    {
        return (int) round($grossAmount * ($this->discount_pct / 100));
    }

    // Calculate net amount after discount
    public function calculateNet(int $grossAmount): int
    {
        return $grossAmount - $this->calculateDiscount($grossAmount);
    }

    // Find the correct discount for a given number of days
    public static function findDiscountForDays(int $days): ?self
    {
        return static::where('min_days', '<=', $days)
            ->where(function ($q) use ($days) {
                $q->whereNull('max_days')
                  ->orWhere('max_days', '>=', $days);
            })
            ->orderByDesc('min_days')
            ->first();
    }
}