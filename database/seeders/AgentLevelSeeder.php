<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AgentLevelSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('agent_levels')->insert([
            [
                'id'              => 1,
                'level_name'      => 'bronze',
                'label'           => 'Bronze Agent',
                'badge_emoji'     => '🥉',
                'badge_color'     => '#CD7F32',
                'commission_rate' => 15.00,
                'requirements'    => 'New agent, 0-5 completed transactions',
                'created_at'      => now(),
                'updated_at'      => now(),
            ],
            [
                'id'              => 2,
                'level_name'      => 'silver',
                'label'           => 'Silver Agent',
                'badge_emoji'     => '🥈',
                'badge_color'     => '#C0C0C0',
                'commission_rate' => 20.00,
                'requirements'    => '6-15 completed transactions, minimum 4.0 rating',
                'created_at'      => now(),
                'updated_at'      => now(),
            ],
            [
                'id'              => 3,
                'level_name'      => 'gold',
                'label'           => 'Gold Agent',
                'badge_emoji'     => '🥇',
                'badge_color'     => '#FFD700',
                'commission_rate' => 25.00,
                'requirements'    => '16-30 completed transactions, minimum 4.5 rating',
                'created_at'      => now(),
                'updated_at'      => now(),
            ],
            [
                'id'              => 4,
                'level_name'      => 'platinum',
                'label'           => 'Platinum Agent',
                'badge_emoji'     => '💎',
                'badge_color'     => '#E5E4E2',
                'commission_rate' => 30.00,
                'requirements'    => '31-50 completed transactions, minimum 4.7 rating',
                'created_at'      => now(),
                'updated_at'      => now(),
            ],
            [
                'id'              => 5,
                'level_name'      => 'diamond',
                'label'           => 'Diamond Agent',
                'badge_emoji'     => '👑',
                'badge_color'     => '#B9F2FF',
                'commission_rate' => 35.00,
                'requirements'    => '50+ completed transactions, minimum 4.9 rating, verified by Terra',
                'created_at'      => now(),
                'updated_at'      => now(),
            ],
        ]);
    }
}