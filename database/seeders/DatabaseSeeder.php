<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // ── System & Auth ──
        $this->call(DepartmentSeeder::class);
        $this->call(UserSeeder::class);
        $this->call(RolesAndPermissionsSeeder::class);

        // ── Reference / Lookup Tables ──
        $this->call(ListingPackageSeeder::class);
        $this->call(DurationDiscountSeeder::class);
        $this->call(FacilitySeeder::class);
        $this->call(DesignCategorySeeder::class);

        // ── Business Entities ──
        $this->call(ClientSeeder::class);
        $this->call(AgentsSeeder::class);

        // ── Property Listings ──
        $this->call(HouseSeeder::class);
        $this->call(HouseImageSeeder::class);
        $this->call(FacilityHouseSeeder::class);
        $this->call(LandSeeder::class);
        $this->call(LandImageSeeder::class);
        $this->call(ArchitecturalDesignSeeder::class);
        $this->call(DesignImageSeeder::class);

        // ── Payments & Orders ──
        $this->call(ListingPaymentSeeder::class);
        $this->call(DesignOrderSeeder::class);

        // ── Marketplace demo: owner / client / partner accounts and activity ──
        $this->call(MarketplaceDemoSeeder::class);
    }
}
