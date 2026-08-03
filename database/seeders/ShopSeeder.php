<?php

namespace Database\Seeders;

use App\Models\Shop;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class ShopSeeder extends Seeder
{
    /**
     * Rwandan districts grouped roughly by province, used to give seeded
     * shops realistic-looking locations.
     */
    private array $locations = [
        'Kigali City'  => ['Gasabo', 'Kicukiro', 'Nyarugenge'],
        'Southern'     => ['Huye', 'Muhanga', 'Nyanza', 'Ruhango'],
        'Northern'     => ['Musanze', 'Gicumbi', 'Burera', 'Rulindo'],
        'Eastern'      => ['Rwamagana', 'Kayonza', 'Ngoma', 'Nyagatare'],
        'Western'      => ['Rubavu', 'Karongi', 'Rusizi', 'Nyamasheke'],
    ];

    private array $shopNames = [
        'Kigali Cement Depot',
        'Rwanda Steel & Rebar Supplies',
        'BuildRight Materials',
        'Umuganda Hardware Store',
        'Gasabo Timber & Wood',
        'Prime Roofing Solutions',
        'Nyarugenge Tiles & Flooring',
        'Solid Foundation Materials',
        'Musanze Construction Supplies',
        'Rubavu Steel Works',
        'Kigali Electrical Supplies',
        'Huye Plumbing Center',
        'GreenBuild Paint & Finishes',
        'Rwamagana Doors & Windows',
        'Master Builders Hardware',
        'Nyanza Cement & Concrete',
        'Kicukiro Tools & Equipment',
        'Karongi Timber Merchants',
        'Elite Roofing Rwanda',
        'Capital Hardware & Tools',
    ];

    public function run(): void
    {
        // Ensure there's at least one admin to act as approver for approved shops
        $admin = User::firstOrCreate(
            ['email' => 'admin@terra.rw'],
            [
                'name' => 'Terra Admin',
                'password' => Hash::make('password'),
                'role' => 'admin',
                'email_verified_at' => now(),
            ]
        );

        $statuses = [
            Shop::STATUS_APPROVED,
            Shop::STATUS_APPROVED,
            Shop::STATUS_APPROVED,
            Shop::STATUS_APPROVED,
            Shop::STATUS_PENDING,
            Shop::STATUS_PENDING,
            Shop::STATUS_REJECTED,
            Shop::STATUS_SUSPENDED,
        ];

        foreach ($this->shopNames as $i => $name) {
            $owner = User::firstOrCreate(
                ['email' => Str::slug($name) . '@shops.terra.rw'],
                [
                    'name' => $name . ' Owner',
                    'password' => Hash::make('password'),
                    'role' => 'user',
                    'email_verified_at' => now(),
                ]
            );

            $province = array_rand($this->locations);
            $district = $this->locations[$province][array_rand($this->locations[$province])];

            $status = $statuses[$i % count($statuses)];
            $phone = $this->rwandanPhone();

            $shop = Shop::create([
                'user_id'          => $owner->id,
                'name'             => $name,
                'slug'             => Shop::generateUniqueSlug($name),
                'description'      => "{$name} supplies quality construction materials and equipment across Rwanda, serving contractors, developers, and individual builders.",
                'phone'            => $phone,
                'whatsapp_number'  => $phone,
                'email'            => Str::slug($name) . '@shops.terra.rw',
                'province'         => $province,
                'district'         => $district,
                'sector'           => null,
                'address'          => "{$district} District, {$province} Province",
                'status'           => $status,
                'approved_at'      => $status === Shop::STATUS_APPROVED ? now()->subDays(rand(1, 60)) : null,
                'approved_by'      => $status === Shop::STATUS_APPROVED ? $admin->id : null,
                'rejection_reason' => $status === Shop::STATUS_REJECTED ? 'Incomplete business documentation provided.' : null,
                'is_featured'      => $i < 3, // first 3 shops featured
                'views_count'      => rand(10, 500),
            ]);

            $this->command->info("Created shop: {$shop->name} ({$shop->status})");
        }
    }

    /**
     * Generates a unique-looking Rwandan phone number matching the
     * 078/072/073/079XXXXXXX format validated at the request layer.
     */
    private function rwandanPhone(): string
    {
        $prefixes = ['078', '072', '073', '079'];
        $prefix = $prefixes[array_rand($prefixes)];

        return $prefix . str_pad((string) rand(0, 9999999), 7, '0', STR_PAD_LEFT);
    }
}
