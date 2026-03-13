<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ListingPackage extends Model
{
    protected $fillable = [
        'listing_type',
        'package_tier',
        'price_per_day',
        'agent_commission_pct',
        'terra_share_pct',
        'features',
        'is_active',
    ];

    protected $casts = [
        'price_per_day'        => 'integer',
        'agent_commission_pct' => 'float',
        'terra_share_pct'      => 'float',
        'is_active'            => 'boolean',
        'features'             => 'array',
    ];

    // Listing type options
    public static function listingTypes(): array
    {
        return [
            'land'          => 'Land (Kugurisha Ubutaka)',
            'house'         => 'House (Kugurisha Inzu)',
            'design'        => 'Architectural Design',
            'tender'        => 'Tender',
            'advertisement' => 'Advertisement',
        ];
    }

    // Package tier options
    public static function packageTiers(): array
    {
        return [
            'basic'    => 'Basic',
            'medium'   => 'Medium',
            'standard' => 'Standard',
        ];
    }

    // Human readable type label
    public function getTypeLabelAttribute(): string
    {
        return self::listingTypes()[$this->listing_type] ?? ucfirst($this->listing_type);
    }

    // Human readable tier label
    public function getTierLabelAttribute(): string
    {
        return self::packageTiers()[$this->package_tier] ?? ucfirst($this->package_tier);
    }

    // Formatted price
    public function getFormattedPriceAttribute(): string
    {
        return number_format($this->price_per_day) . ' RWF/day';
    }
}