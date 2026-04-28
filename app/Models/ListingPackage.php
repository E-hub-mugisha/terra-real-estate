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

    public static function listingTypes(): array
    {
        return [
            'land'   => 'Land (Kugurisha Ubutaka)',
            'land_rent'   => 'Land (Gukodesha Ubutaka)',
            'house'  => 'House (Kugurisha Inzu)',
            'house_rent'  => 'House (Gukodesha Inzu)',
            'design'      => 'Architectural Design',
            'tender'      => 'Tender',
            'advertisement' => 'Advertisement',
            'job'         => 'Job',
            'announcement' => 'Announcement'
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

    public function jobListings()
    {
        return $this->hasMany(JobListing::class, 'listing_package_id');
    }

    // ── Scopes ────────────────────────────────────────────────────

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeForJobs($query)
    {
        return $query->where('listing_type', 'job')->where('is_active', true);
    }

    /**
     * Calculate the total cost for a given number of days.
     */
    public function calculateTotal(int $days): array
    {
        $total           = $this->price_per_day * $days;
        $agentCommission = (int) round($total * $this->agent_commission_pct / 100);
        $terraShare      = (int) round($total * $this->terra_share_pct / 100);

        return [
            'days'             => $days,
            'price_per_day'    => $this->price_per_day,
            'total'            => $total,
            'agent_commission' => $agentCommission,
            'terra_share'      => $terraShare,
        ];
    }
}
