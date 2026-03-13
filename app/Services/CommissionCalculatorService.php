<?php

namespace App\Services;

use App\Models\AgentLevel;
use App\Models\AgentStats;
use App\Models\ConsultantCommissionTier;
use App\Models\DurationDiscount;
use App\Models\Listing;
use App\Models\ListingCommission;
use App\Models\ConsultantCommission;
use App\Models\ListingPackage;
use App\Models\ListingsCommission;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class CommissionCalculatorService
{
    // ── 1. Calculate listing pricing ────────────────────────────────────────
    public function calculateListingPricing(
        int $pricePerDay,
        int $durationDays,
        float $agentCommissionPct,
        float $terraSharePct
    ): array {
        // Gross amount
        $grossAmount = $pricePerDay * $durationDays;

        // Duration discount
        $discount    = DurationDiscount::findDiscountForDays($durationDays);
        $discountPct = $discount ? $discount->discount_pct : 0;
        $discountAmt = (int) round($grossAmount * $discountPct / 100);
        $netAmount   = $grossAmount - $discountAmt;

        // Commission split
        $agentCommission = (int) round($netAmount * $agentCommissionPct / 100);
        $terraShare      = $netAmount - $agentCommission;

        return [
            'gross_amount'         => $grossAmount,
            'discount_pct'         => $discountPct,
            'discount_amount'      => $discountAmt,
            'net_amount'           => $netAmount,
            'agent_commission_pct' => $agentCommissionPct,
            'agent_commission'     => $agentCommission,
            'terra_share'          => $terraShare,
        ];
    }

    // ── 2. Get agent performance bonus ───────────────────────────────────────
    public function getAgentPerformanceBonus(int $agentId, int $agentCommissionAmount): array
    {
        $stats = AgentStats::where('agent_id', $agentId)->with('level')->first();

        if (!$stats || !$stats->level) {
            // Default to bronze if no stats yet
            $level      = AgentLevel::where('level_name', 'bronze')->first();
            $bonusPct   = $level ? $level->commission_rate : 25;
            $levelName  = 'bronze';
        } else {
            $bonusPct  = $stats->level->commission_rate;
            $levelName = $stats->level->level_name;
        }

        $bonusAmount = (int) round($agentCommissionAmount * $bonusPct / 100);

        return [
            'level_name'   => $levelName,
            'bonus_pct'    => $bonusPct,
            'bonus_amount' => $bonusAmount,
            'total_payout' => $agentCommissionAmount + $bonusAmount,
        ];
    }

    // ── 3. Create listing commission record ──────────────────────────────────
    public function createListingCommission(Listing $listing): ListingCommission
    {
        $package = $listing->listingPackage;

        // Calculate pricing
        $pricing = $this->calculateListingPricing(
            $listing->base_price_per_day,
            $listing->duration_days,
            $package->agent_commission_pct,
            $package->terra_share_pct
        );

        // Get performance bonus
        $agentId = $listing->agent_id ?? $listing->user_id;
        $bonus   = $this->getAgentPerformanceBonus($agentId, $pricing['agent_commission']);

        return DB::transaction(function () use ($listing, $package, $pricing, $bonus, $agentId) {
            return ListingCommission::create([
                'listing_id'              => $listing->id,
                'agent_id'                => $agentId,
                'listing_package_id'      => $package->id,
                'listing_type'            => $listing->listing_type,
                'package_tier'            => $listing->package_tier,
                'net_listing_amount'      => $pricing['net_amount'],
                'agent_commission_pct'    => $pricing['agent_commission_pct'],
                'agent_commission_amount' => $pricing['agent_commission'],
                'terra_share_amount'      => $pricing['terra_share'],
                'agent_level'             => $bonus['level_name'],
                'performance_bonus_pct'   => $bonus['bonus_pct'],
                'performance_bonus_amount'=> $bonus['bonus_amount'],
                'total_agent_payout'      => $bonus['total_payout'],
                'status'                  => 'pending',
            ]);
        });
    }

    // ── 4. Create consultant commission record ───────────────────────────────
    public function createConsultantCommission(
        int $consultantId,
        int $serviceValue,
        string $serviceDescription,
        ?int $clientId = null
    ): ConsultantCommission {
        $tier = ConsultantCommissionTier::findTierForValue($serviceValue);

        if (!$tier) {
            throw new \RuntimeException('No commission tier found for service value: ' . $serviceValue);
        }

        $terraCut         = $tier->calculateTerraCut($serviceValue);
        $consultantPayout = $tier->calculateConsultantPayout($serviceValue);

        return DB::transaction(function () use ($consultantId, $clientId, $serviceValue, $serviceDescription, $tier, $terraCut, $consultantPayout) {
            return ConsultantCommission::create([
                'consultant_id'           => $consultantId,
                'client_id'               => $clientId,
                'service_description'     => $serviceDescription,
                'service_value'           => $serviceValue,
                'commission_tier_id'      => $tier->id,
                'terra_commission_pct'    => $tier->terra_commission_pct,
                'consultant_payout_pct'   => $tier->consultant_payout_pct,
                'terra_commission_amount' => $terraCut,
                'consultant_payout_amount'=> $consultantPayout,
                'status'                  => 'pending',
            ]);
        });
    }

    // ── 5. Confirm listing commission ────────────────────────────────────────
    public function confirmListingCommission(ListingCommission $commission): ListingCommission
    {
        DB::transaction(function () use ($commission) {
            $commission->update([
                'status'       => 'confirmed',
                'confirmed_at' => now(),
            ]);

            // Update agent stats
            $this->updateAgentStats($commission->agent_id, $commission);
        });

        return $commission->fresh();
    }

    // ── 6. Pay listing commission ────────────────────────────────────────────
    public function payListingCommission(ListingCommission $commission): ListingCommission
    {
        DB::transaction(function () use ($commission) {
            $commission->update([
                'status'  => 'paid',
                'paid_at' => now(),
            ]);

            // Decrement pending payout
            AgentStats::where('agent_id', $commission->agent_id)
                ->decrement('pending_payout', $commission->total_agent_payout);

            AgentStats::where('agent_id', $commission->agent_id)
                ->increment('total_commissions_paid', $commission->total_agent_payout);
        });

        return $commission->fresh();
    }

    // ── 7. Update agent stats & check level upgrade ──────────────────────────
    public function updateAgentStats(int $agentId, ListingCommission $commission): void
    {
        $stats = AgentStats::firstOrCreate(
            ['agent_id' => $agentId],
            [
                'level_id'                 => AgentLevel::where('level_name', 'bronze')->first()?->id ?? 1,
                'total_referrals'          => 0,
                'total_revenue_generated'  => 0,
                'total_commissions_earned' => 0,
                'pending_payout'           => 0,
            ]
        );

        $stats->increment('total_referrals', 1);
        $stats->increment('total_revenue_generated', $commission->net_listing_amount);
        $stats->increment('total_commissions_earned', $commission->total_agent_payout);
        $stats->increment('pending_payout', $commission->total_agent_payout);

        // Check level upgrade
        $this->checkAndUpgradeAgentLevel($stats->fresh());
    }

    // ── 8. Check and upgrade agent level ────────────────────────────────────
    public function checkAndUpgradeAgentLevel(AgentStats $stats): void
    {
        $currentLevel = $stats->level->level_name ?? 'bronze';

        $upgrades = [
            'bronze' => [
                'next'            => 'silver',
                'min_referrals'   => 10,
                'min_revenue'     => 500000,
            ],
            'silver' => [
                'next'            => 'gold',
                'min_referrals'   => 30,
                'min_revenue'     => 2000000,
            ],
            'gold' => [
                'next'            => 'elite',
                'min_referrals'   => 75,
                'min_revenue'     => 10000000,
            ],
        ];

        if (!isset($upgrades[$currentLevel])) {
            return; // Already at elite
        }

        $upgrade = $upgrades[$currentLevel];

        $qualifies = $stats->total_referrals >= $upgrade['min_referrals']
            || $stats->total_revenue_generated >= $upgrade['min_revenue'];

        if ($qualifies) {
            $nextLevel = AgentLevel::where('level_name', $upgrade['next'])->first();

            if ($nextLevel) {
                $stats->update([
                    'level_id'              => $nextLevel->id,
                    'last_level_upgrade_at' => now(),
                ]);
            }
        }
    }

    // ── 9. Quote preview for AJAX ────────────────────────────────────────────
    public function previewQuote(
        string $listingType,
        string $packageTier,
        int $durationDays,
        ?int $agentId = null
    ): array {
        $package = ListingPackage::where('listing_type', $listingType)
            ->where('package_tier', $packageTier)
            ->where('is_active', true)
            ->first();

        if (!$package) {
            return ['error' => 'Package not found.'];
        }

        $pricing = $this->calculateListingPricing(
            $package->price_per_day,
            $durationDays,
            $package->agent_commission_pct,
            $package->terra_share_pct
        );

        $bonus = $agentId
            ? $this->getAgentPerformanceBonus($agentId, $pricing['agent_commission'])
            : ['level_name' => 'bronze', 'bonus_pct' => 25, 'bonus_amount' => 0, 'total_payout' => $pricing['agent_commission']];

        return [
            'package'        => $package->type_label . ' — ' . $package->tier_label,
            'price_per_day'  => $package->price_per_day,
            'duration_days'  => $durationDays,
            'gross_amount'   => $pricing['gross_amount'],
            'discount_pct'   => $pricing['discount_pct'],
            'discount_amount'=> $pricing['discount_amount'],
            'net_amount'     => $pricing['net_amount'],
            'agent_pct'      => $pricing['agent_commission_pct'],
            'agent_commission'=> $pricing['agent_commission'],
            'terra_share'    => $pricing['terra_share'],
            'agent_level'    => $bonus['level_name'],
            'bonus_pct'      => $bonus['bonus_pct'],
            'bonus_amount'   => $bonus['bonus_amount'],
            'total_payout'   => $bonus['total_payout'],
        ];
    }

    // ── 10. Agent dashboard summary ──────────────────────────────────────────
    public function getAgentDashboardSummary(int $agentId): array
    {
        $stats = AgentStats::where('agent_id', $agentId)->with('level')->first();

        $pendingCommissions   = ListingsCommission::where('agent_id', $agentId)->where('status', 'pending')->count();
        $confirmedCommissions = ListingsCommission::where('agent_id', $agentId)->where('status', 'confirmed')->count();
        $paidCommissions      = ListingsCommission::where('agent_id', $agentId)->where('status', 'paid')->count();

        return [
            'stats'                => $stats,
            'level'                => $stats?->level,
            'pending_commissions'  => $pendingCommissions,
            'confirmed_commissions'=> $confirmedCommissions,
            'paid_commissions'     => $paidCommissions,
            'total_referrals'      => $stats?->total_referrals ?? 0,
            'total_revenue'        => $stats?->total_revenue_generated ?? 0,
            'total_earned'         => $stats?->total_commissions_earned ?? 0,
            'pending_payout'       => $stats?->pending_payout ?? 0,
        ];
    }
}