<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ConsultantCommissionTierSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('consultant_commission_tiers')->insert([
            ['id' => 1, 'min_value' => 0,      'max_value' => 50000,    'terra_commission_pct' => 30.00, 'consultant_payout_pct' => 70.00, 'label' => 'Starter Tier (0-50K RWF)',     'created_at' => now(), 'updated_at' => now()],
            ['id' => 2, 'min_value' => 50001,  'max_value' => 200000,   'terra_commission_pct' => 25.00, 'consultant_payout_pct' => 75.00, 'label' => 'Growth Tier (50K-200K RWF)',   'created_at' => now(), 'updated_at' => now()],
            ['id' => 3, 'min_value' => 200001, 'max_value' => 1000000,  'terra_commission_pct' => 20.00, 'consultant_payout_pct' => 80.00, 'label' => 'Professional Tier (200K-1M RWF)','created_at' => now(), 'updated_at' => now()],
            ['id' => 4, 'min_value' => 1000001,'max_value' => 5000000,  'terra_commission_pct' => 15.00, 'consultant_payout_pct' => 85.00, 'label' => 'Expert Tier (1M-5M RWF)',      'created_at' => now(), 'updated_at' => now()],
            ['id' => 5, 'min_value' => 5000001,'max_value' => null,     'terra_commission_pct' => 10.00, 'consultant_payout_pct' => 90.00, 'label' => 'Elite Tier (5M+ RWF)',         'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}