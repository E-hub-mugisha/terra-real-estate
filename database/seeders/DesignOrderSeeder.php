<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DesignOrderSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('design_orders')->insert([
            [
                'id'                    => 1,
                'user_id'               => 4,  // Diane
                'architectural_design_id' => 1, // 3-Bedroom Bungalow
                'amount'                => 150000.00,
                'payment_status'        => 'paid',
                'created_at'            => now()->subDays(7),
                'updated_at'            => now(),
            ],
            [
                'id'                    => 2,
                'user_id'               => 2,  // Marie-Claire
                'architectural_design_id' => 2, // 4-Bedroom Double Storey
                'amount'                => 250000.00,
                'payment_status'        => 'paid',
                'created_at'            => now()->subDays(12),
                'updated_at'            => now(),
            ],
            [
                'id'                    => 3,
                'user_id'               => 5,  // Eric
                'architectural_design_id' => 3, // Free Starter House Plan
                'amount'                => 0.00,
                'payment_status'        => 'paid',
                'created_at'            => now()->subDays(3),
                'updated_at'            => now(),
            ],
            [
                'id'                    => 4,
                'user_id'               => 1,  // Jean-Pierre
                'architectural_design_id' => 5, // 6-Unit Apartment Block
                'amount'                => 400000.00,
                'payment_status'        => 'pending',
                'created_at'            => now(),
                'updated_at'            => now(),
            ],
            [
                'id'                    => 5,
                'user_id'               => 4,  // Diane
                'architectural_design_id' => 4, // Commercial Retail Space
                'amount'                => 200000.00,
                'payment_status'        => 'paid',
                'created_at'            => now()->subDays(20),
                'updated_at'            => now(),
            ],
        ]);
    }
}