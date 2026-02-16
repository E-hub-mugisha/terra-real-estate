<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Land;
use App\Models\User;
use Carbon\Carbon;

class LandSeeder extends Seeder
{
    public function run(): void
    {
        // Prefer agent, fallback to first user
        $user = User::where('role', 'agent')->first() ?? User::first();

        if (!$user) {
            $this->command->warn('No users found. Seed users first.');
            return;
        }

        $lands = [

            [
                'title' => 'Residential Plot in Nyarutarama',
                'description' => 'Prime residential land suitable for high-end villa development.',
                'price' => 120000000, // 120M RWF
                'size_sqm' => 850,
                'zoning' => 'R1',
                'land_use' => 'Residential',
                'province' => 'Kigali City',
                'district' => 'Gasabo',
                'sector' => 'Remera',
                'cell' => 'Nyarutarama',
                'village' => 'Kabeza',
                'upi' => '1/02/03/04/1234',
                'is_title_verified' => true,
                'status' => 'available',
                'is_approved' => true,
                'expires_at' => Carbon::now()->addMonths(6),
            ],

            [
                'title' => 'Commercial Plot in Kicukiro',
                'description' => 'Strategic commercial land near main road.',
                'price' => 95000000,
                'size_sqm' => 600,
                'zoning' => 'Commercial',
                'land_use' => 'Commercial',
                'province' => 'Kigali City',
                'district' => 'Kicukiro',
                'sector' => 'Kagarama',
                'cell' => 'Kagasa',
                'village' => null,
                'upi' => '1/03/05/08/4321',
                'is_title_verified' => true,
                'status' => 'available',
                'is_approved' => true,
                'expires_at' => Carbon::now()->addMonths(4),
            ],

            [
                'title' => 'Agricultural Land in Nyagatare',
                'description' => 'Large farmland ideal for livestock or crop farming.',
                'price' => 35000000,
                'size_sqm' => 5000,
                'zoning' => 'Agricultural',
                'land_use' => 'Farming',
                'province' => 'Eastern Province',
                'district' => 'Nyagatare',
                'sector' => 'Karangazi',
                'cell' => 'Nyamirama',
                'village' => null,
                'upi' => '5/01/02/01/9988',
                'is_title_verified' => false,
                'status' => 'available',
                'is_approved' => true,
                'expires_at' => Carbon::now()->addMonths(8),
            ],

            [
                'title' => 'Industrial Plot in Masoro',
                'description' => 'Industrial zone land suitable for warehouses.',
                'price' => 200000000,
                'size_sqm' => 1500,
                'zoning' => 'Industrial',
                'land_use' => 'Industrial',
                'province' => 'Kigali City',
                'district' => 'Gasabo',
                'sector' => 'Masoro',
                'cell' => 'Rurenge',
                'village' => null,
                'upi' => '1/01/07/03/5555',
                'is_title_verified' => true,
                'status' => 'available',
                'is_approved' => true,
                'expires_at' => Carbon::now()->addMonths(12),
            ],

            [
                'title' => 'Lake View Plot in Rubavu',
                'description' => 'Scenic land near Lake Kivu for resort development.',
                'price' => 140000000,
                'size_sqm' => 1200,
                'zoning' => 'R2',
                'land_use' => 'Mixed-use',
                'province' => 'Western Province',
                'district' => 'Rubavu',
                'sector' => 'Gisenyi',
                'cell' => 'Bugoyi',
                'village' => null,
                'upi' => '4/02/01/06/2211',
                'is_title_verified' => true,
                'status' => 'reserved',
                'is_approved' => true,
                'expires_at' => Carbon::now()->addMonths(5),
            ],

            [
                'title' => 'Residential Plot in Musanze',
                'description' => 'Perfect for family home construction.',
                'price' => 45000000,
                'size_sqm' => 700,
                'zoning' => 'R2',
                'land_use' => 'Residential',
                'province' => 'Northern Province',
                'district' => 'Musanze',
                'sector' => 'Muhoza',
                'cell' => 'Ruhengeri',
                'village' => null,
                'upi' => '2/01/04/02/7788',
                'is_title_verified' => false,
                'status' => 'available',
                'is_approved' => false,
                'expires_at' => Carbon::now()->addMonths(3),
            ],

            [
                'title' => 'Mixed-Use Plot in Huye',
                'description' => 'Ideal for apartments and shops.',
                'price' => 60000000,
                'size_sqm' => 900,
                'zoning' => 'R3',
                'land_use' => 'Mixed-use',
                'province' => 'Southern Province',
                'district' => 'Huye',
                'sector' => 'Ngoma',
                'cell' => 'Matyazo',
                'village' => null,
                'upi' => '3/01/02/03/1199',
                'is_title_verified' => true,
                'status' => 'available',
                'is_approved' => true,
                'expires_at' => Carbon::now()->addMonths(7),
            ],

            [
                'title' => 'Development Land in Rusizi',
                'description' => 'Land suitable for tourism investment.',
                'price' => 75000000,
                'size_sqm' => 1100,
                'zoning' => 'Commercial',
                'land_use' => 'Tourism',
                'province' => 'Western Province',
                'district' => 'Rusizi',
                'sector' => 'Kamembe',
                'cell' => 'Gihundwe',
                'village' => null,
                'upi' => '4/05/02/04/6611',
                'is_title_verified' => false,
                'status' => 'sold',
                'is_approved' => true,
                'expires_at' => Carbon::now()->addMonths(2),
            ],
        ];

        foreach ($lands as $land) {
            Land::create(array_merge($land, [
                'user_id' => $user->id
            ]));
        }
    }
}
