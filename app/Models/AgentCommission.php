<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AgentCommission extends Model
{
    protected $fillable = [
        'agent_id',
        'commissionable_id',
        'commissionable_type',
        'property_type',
        'property_title',
        'listing_package_id',
        'listing_days',
        'price_per_day',
        'discount_applied_pct',
        'listing_fee_gross',
        'listing_fee_net',
        'listing_agent_pct',
        'listing_commission',
        'sale_price',
        'agent_level_id',
        'sale_commission_rate',
        'sale_commission',
        'listing_commission_status',
        'sale_commission_status',
        'listing_commission_paid_at',
        'sale_commission_paid_at',
        'notes',
    ];

    protected $casts = [
        'listing_commission_paid_at' => 'date',
        'sale_commission_paid_at'    => 'date',
    ];

    public function commissionable()
    {
        return $this->morphTo();
    }
    public function agent()
    {
        return $this->belongsTo(Agent::class);
    }
    public function listingPackage()
    {
        return $this->belongsTo(ListingPackage::class);
    }
    public function agentLevel()
    {
        return $this->belongsTo(AgentLevel::class);
    }

    /** Total earned so far (listing + sale if paid) */
    public function getTotalEarnedAttribute(): float
    {
        return (float) $this->listing_commission + (float) $this->sale_commission;
    }
}
