<?php

namespace App\Services;

use App\Models\Agent;
use App\Models\AgentCommission;
use App\Models\DurationDiscount;
use App\Models\ListingPackage;
use Illuminate\Database\Eloquent\Model;

class CommissionService
{
    /**
     * Called when a property is LISTED.
     * Calculates listing fee + agent's cut from ListingPackage.
     */
    public function recordListingCommission(
        Agent  $agent,
        Model  $model,
        string $type,          // 'house' | 'land' | 'design' | 'tender'
        int    $listingDays,
        int    $packageId
    ): ?AgentCommission {

        $package = ListingPackage::find($packageId);
        if (!$package) return null;

        // 1. Gross fee before discount
        $gross = $package->price_per_day * $listingDays;

        // 2. Find applicable duration discount
        $discount = DurationDiscount::where('min_days', '<=', $listingDays)
            ->where(fn($q) => $q->whereNull('max_days')
                ->orWhere('max_days', '>=', $listingDays))
            ->orderByDesc('min_days')
            ->first();

        $discountPct = $discount?->discount_pct ?? 0;
        $net         = $gross * (1 - $discountPct / 100);

        // 3. Agent's cut from the listing fee
        $agentPct        = $package->agent_commission_pct;
        $listingCommission = round($net * $agentPct / 100, 2);
        $terraRevenue      = round($net * $package->terra_share_pct / 100, 2);

        // 4. Store calculated values back on the property
        $model->update([
            'listing_fee_total'         => $net,
            'agent_listing_commission'  => $listingCommission,
            'terra_listing_revenue'     => $terraRevenue,
        ]);

        // 5. Create commission record
        return AgentCommission::create([
            'agent_id'                  => $agent->id,
            'commissionable_id'         => $model->id,
            'commissionable_type'       => get_class($model),
            'property_type'             => $type,
            'property_title'            => $model->title ?? $model->name,
            'listing_package_id'        => $package->id,
            'listing_days'              => $listingDays,
            'price_per_day'             => $package->price_per_day,
            'discount_applied_pct'      => $discountPct,
            'listing_fee_gross'         => $gross,
            'listing_fee_net'           => $net,
            'listing_agent_pct'         => $agentPct,
            'listing_commission'        => $listingCommission,
            'agent_level_id'            => $agent->agent_level_id,
            'listing_commission_status' => 'pending',
            'sale_commission_status'    => 'pending',
        ]);
    }

    /**
     * Called when a property is SOLD.
     * Calculates sale commission from AgentLevel.commission_rate.
     */
    public function recordSaleCommission(
        AgentCommission $commission,
        float           $salePrice
    ): AgentCommission {

        $agent = $commission->agent()->with('level')->first();
        $rate  = $agent->getSaleCommissionRate();
        $amount = round($salePrice * $rate / 100, 2);

        $commission->update([
            'sale_price'           => $salePrice,
            'sale_commission_rate' => $rate,
            'sale_commission'      => $amount,
            'sale_commission_status' => 'pending',
        ]);

        // Update agent's revenue total → may trigger level upgrade
        $agent->increment('total_revenue_generated', $salePrice);
        $agent->checkAndUpgradeLevel();

        return $commission->fresh();
    }

    /**
     * Record commission for a consultant service booking.
     * Uses ConsultantCommissionTier sliding scale.
     */
    public function recordConsultantCommission(
        \App\Models\Consultant $consultant,
        float                  $bookingValue
    ): array {

        $tier = \App\Models\ConsultantCommissionTier::where('min_value', '<=', $bookingValue)
            ->where(fn($q) => $q->whereNull('max_value')
                ->orWhere('max_value', '>=', $bookingValue))
            ->orderByDesc('min_value')
            ->first();

        if (!$tier) return ['terra' => 0, 'consultant' => $bookingValue];

        return [
            'terra_amount'      => round($bookingValue * $tier->terra_commission_pct / 100, 2),
            'consultant_amount' => round($bookingValue * $tier->consultant_payout_pct / 100, 2),
            'tier'              => $tier,
        ];
    }
}
