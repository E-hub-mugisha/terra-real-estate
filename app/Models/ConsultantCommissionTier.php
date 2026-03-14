<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ConsultantCommissionTier extends Model
{
    protected $fillable = [
        'min_value',
        'max_value',
        'terra_commission_pct',
        'consultant_payout_pct',
        'label',
    ];

    protected $casts = [
        'min_value'             => 'integer',
        'max_value'             => 'integer',
        'terra_commission_pct'  => 'float',
        'consultant_payout_pct' => 'float',
        'created_at' => 'date'
    ];

    // Human readable range e.g. "30,000 – 99,999 RWF"
    public function getRangeDescriptionAttribute(): string
    {
        if (is_null($this->max_value)) {
            return number_format($this->min_value) . ' RWF and above';
        }
        return number_format($this->min_value) . ' – ' . number_format($this->max_value) . ' RWF';
    }

    // Calculate terra cut for a given service value
    public function calculateTerraCut(int $serviceValue): int
    {
        return (int) round($serviceValue * ($this->terra_commission_pct / 100));
    }

    // Calculate consultant payout for a given service value
    public function calculateConsultantPayout(int $serviceValue): int
    {
        return $serviceValue - $this->calculateTerraCut($serviceValue);
    }

    // Find the correct tier for a given service value
    public static function findTierForValue(int $serviceValue): ?self
    {
        return static::where('min_value', '<=', $serviceValue)
            ->where(function ($q) use ($serviceValue) {
                $q->whereNull('max_value')
                  ->orWhere('max_value', '>=', $serviceValue);
            })
            ->orderByDesc('min_value')
            ->first();
    }
}
