<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DurationDiscountSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('duration_discounts')->insert([
            ['id' => 1, 'min_days' => 1,   'max_days' => 14,  'discount_pct' => 0.00,  'label' => 'No Discount (1-14 days)',    'created_at' => now(), 'updated_at' => now()],
            ['id' => 2, 'min_days' => 15,  'max_days' => 30,  'discount_pct' => 5.00,  'label' => '5% Off (15-30 days)',        'created_at' => now(), 'updated_at' => now()],
            ['id' => 3, 'min_days' => 31,  'max_days' => 60,  'discount_pct' => 10.00, 'label' => '10% Off (31-60 days)',       'created_at' => now(), 'updated_at' => now()],
            ['id' => 4, 'min_days' => 61,  'max_days' => 90,  'discount_pct' => 15.00, 'label' => '15% Off (61-90 days)',       'created_at' => now(), 'updated_at' => now()],
            ['id' => 5, 'min_days' => 91,  'max_days' => null, 'discount_pct' => 20.00, 'label' => '20% Off (90+ days)',         'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}