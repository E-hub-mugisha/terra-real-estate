<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ListingPackage;
use App\Models\DurationDiscount;
use Illuminate\Support\Facades\DB;

class PricingCommissionSeeder extends Seeder
{
    public function run(): void
    {
        $this->seedListingPackages();
        $this->seedDurationDiscounts();

        $this->command->info('✅ Listing packages and duration discounts seeded successfully.');
    }

    // ── 1. Listing Packages ──────────────────────────────────────────────────
    private function seedListingPackages(): void
    {
        $packages = [
            // Land
            ['listing_type' => 'land', 'package_tier' => 'basic',    'price_per_day' => 1000, 'agent_commission_pct' => 20, 'terra_share_pct' => 80],
            ['listing_type' => 'land', 'package_tier' => 'medium',   'price_per_day' => 2000, 'agent_commission_pct' => 20, 'terra_share_pct' => 80],
            ['listing_type' => 'land', 'package_tier' => 'premium', 'price_per_day' => 3500, 'agent_commission_pct' => 20, 'terra_share_pct' => 80],

            // House
            ['listing_type' => 'house', 'package_tier' => 'basic',    'price_per_day' => 1500, 'agent_commission_pct' => 20, 'terra_share_pct' => 80],
            ['listing_type' => 'house', 'package_tier' => 'medium',   'price_per_day' => 3000, 'agent_commission_pct' => 20, 'terra_share_pct' => 80],
            ['listing_type' => 'house', 'package_tier' => 'premium', 'price_per_day' => 4000, 'agent_commission_pct' => 20, 'terra_share_pct' => 80],

            // Design
            ['listing_type' => 'design', 'package_tier' => 'basic',    'price_per_day' => 200, 'agent_commission_pct' => 25, 'terra_share_pct' => 75],
            ['listing_type' => 'design', 'package_tier' => 'medium',   'price_per_day' => 350, 'agent_commission_pct' => 25, 'terra_share_pct' => 75],
            ['listing_type' => 'design', 'package_tier' => 'premium', 'price_per_day' => 500, 'agent_commission_pct' => 25, 'terra_share_pct' => 75],


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

        $this->command->info('  → 9 listing packages seeded.');
    }

    // ── 2. Duration Discounts ────────────────────────────────────────────────
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

}