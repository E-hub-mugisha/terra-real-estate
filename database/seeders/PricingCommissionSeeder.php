<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ListingPackage;
use App\Models\ConsultantCommissionTier;
use App\Models\DurationDiscount;
use App\Models\AgentLevel;
use Illuminate\Support\Facades\DB;

class PricingCommissionSeeder extends Seeder
{
    public function run(): void
    {
        $this->seedListingPackages();
        $this->seedConsultantCommissionTiers();
        $this->seedDurationDiscounts();
        $this->seedAgentLevels();

        $this->command->info('✅ All pricing and commission data seeded successfully.');
    }

    // ── 1. Listing Packages ──────────────────────────────────────────────────
    private function seedListingPackages(): void
    {
        $packages = [
            // Land
            ['listing_type' => 'land', 'package_tier' => 'basic',    'price_per_day' => 1000, 'agent_commission_pct' => 20, 'terra_share_pct' => 80],
            ['listing_type' => 'land', 'package_tier' => 'medium',   'price_per_day' => 2000, 'agent_commission_pct' => 20, 'terra_share_pct' => 80],
            ['listing_type' => 'land', 'package_tier' => 'standard', 'price_per_day' => 3500, 'agent_commission_pct' => 20, 'terra_share_pct' => 80],

            // House
            ['listing_type' => 'house', 'package_tier' => 'basic',    'price_per_day' => 1500, 'agent_commission_pct' => 20, 'terra_share_pct' => 80],
            ['listing_type' => 'house', 'package_tier' => 'medium',   'price_per_day' => 3000, 'agent_commission_pct' => 20, 'terra_share_pct' => 80],
            ['listing_type' => 'house', 'package_tier' => 'standard', 'price_per_day' => 4000, 'agent_commission_pct' => 20, 'terra_share_pct' => 80],

            // Design
            ['listing_type' => 'design', 'package_tier' => 'basic',    'price_per_day' => 200, 'agent_commission_pct' => 25, 'terra_share_pct' => 75],
            ['listing_type' => 'design', 'package_tier' => 'medium',   'price_per_day' => 350, 'agent_commission_pct' => 25, 'terra_share_pct' => 75],
            ['listing_type' => 'design', 'package_tier' => 'standard', 'price_per_day' => 500, 'agent_commission_pct' => 25, 'terra_share_pct' => 75],

            // Tender
            ['listing_type' => 'tender', 'package_tier' => 'basic',    'price_per_day' => 1500, 'agent_commission_pct' => 20, 'terra_share_pct' => 80],
            ['listing_type' => 'tender', 'package_tier' => 'medium',   'price_per_day' => 2000, 'agent_commission_pct' => 20, 'terra_share_pct' => 80],
            ['listing_type' => 'tender', 'package_tier' => 'standard', 'price_per_day' => 3000, 'agent_commission_pct' => 20, 'terra_share_pct' => 80],

            // Advertisement
            ['listing_type' => 'advertisement', 'package_tier' => 'basic',    'price_per_day' => 2000, 'agent_commission_pct' => 20, 'terra_share_pct' => 80],
            ['listing_type' => 'advertisement', 'package_tier' => 'medium',   'price_per_day' => 3000, 'agent_commission_pct' => 20, 'terra_share_pct' => 80],
            ['listing_type' => 'advertisement', 'package_tier' => 'standard', 'price_per_day' => 4000, 'agent_commission_pct' => 20, 'terra_share_pct' => 80],
        ];

        foreach ($packages as $package) {
            ListingPackage::updateOrCreate(
                [
                    'listing_type' => $package['listing_type'],
                    'package_tier' => $package['package_tier'],
                ],
                $package
            );
        }

        $this->command->info('  → 15 listing packages seeded.');
    }

    // ── 2. Consultant Commission Tiers ───────────────────────────────────────
    private function seedConsultantCommissionTiers(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        ConsultantCommissionTier::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $tiers = [
            ['label' => 'Under 30,000 RWF',          'min_value' => 0,       'max_value' => 29999,   'terra_commission_pct' => 30, 'consultant_payout_pct' => 70],
            ['label' => '30,000 – 99,999 RWF',        'min_value' => 30000,   'max_value' => 99999,   'terra_commission_pct' => 29, 'consultant_payout_pct' => 71],
            ['label' => '100,000 – 299,999 RWF',      'min_value' => 100000,  'max_value' => 299999,  'terra_commission_pct' => 28, 'consultant_payout_pct' => 72],
            ['label' => '300,000 – 499,999 RWF',      'min_value' => 300000,  'max_value' => 499999,  'terra_commission_pct' => 27, 'consultant_payout_pct' => 73],
            ['label' => '500,000 – 999,999 RWF',      'min_value' => 500000,  'max_value' => 999999,  'terra_commission_pct' => 26, 'consultant_payout_pct' => 74],
            ['label' => '1,000,000 – 4,999,999 RWF',  'min_value' => 1000000, 'max_value' => 4999999, 'terra_commission_pct' => 25, 'consultant_payout_pct' => 75],
            ['label' => '5,000,000 RWF and above',    'min_value' => 5000000, 'max_value' => null,    'terra_commission_pct' => 24, 'consultant_payout_pct' => 76],
        ];

        ConsultantCommissionTier::insert($tiers);

        $this->command->info('  → 7 consultant commission tiers seeded.');
    }

    // ── 3. Duration Discounts ────────────────────────────────────────────────
    private function seedDurationDiscounts(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DurationDiscount::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $discounts = [
            ['label' => '31 – 59 Days', 'min_days' => 31, 'max_days' => 59, 'discount_pct' => 10],
            ['label' => '61 – 89 Days', 'min_days' => 61, 'max_days' => 89, 'discount_pct' => 15],
            ['label' => '90+ Days',     'min_days' => 90, 'max_days' => null, 'discount_pct' => 20],
        ];

        DurationDiscount::insert($discounts);

        $this->command->info('  → 3 duration discounts seeded.');
    }

    // ── 4. Agent Levels ──────────────────────────────────────────────────────
    private function seedAgentLevels(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        AgentLevel::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $levels = [
            [
                'level_name'      => 'bronze',
                'label'           => 'Bronze Agent',
                'badge_emoji'     => '🥉',
                'badge_color'     => '#cd7f32',
                'commission_rate' => 25,
                'requirements'    => 'Entry level. All new agents start here.',
            ],
            [
                'level_name'      => 'silver',
                'label'           => 'Silver Agent',
                'badge_emoji'     => '🥈',
                'badge_color'     => '#a8a9ad',
                'commission_rate' => 30,
                'requirements'    => 'Minimum 10 referrals OR 500,000 RWF in total revenue generated.',
            ],
            [
                'level_name'      => 'gold',
                'label'           => 'Gold Agent',
                'badge_emoji'     => '🥇',
                'badge_color'     => '#ffd700',
                'commission_rate' => 35,
                'requirements'    => 'Minimum 30 referrals OR 2,000,000 RWF in total revenue generated.',
            ],
            [
                'level_name'      => 'elite',
                'label'           => 'Elite Agent',
                'badge_emoji'     => '⭐',
                'badge_color'     => '#1a2d5a',
                'commission_rate' => 40,
                'requirements'    => 'Minimum 75 referrals OR 10,000,000 RWF in total revenue generated.',
            ],
        ];

        AgentLevel::insert($levels);

        $this->command->info('  → 4 agent levels seeded.');
    }
}