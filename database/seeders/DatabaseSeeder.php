<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->command->info('');
        $this->command->info('╔══════════════════════════════════════════════╗');
        $this->command->info('║         Terra Platform — Database Seeder      ║');
        $this->command->info('╚══════════════════════════════════════════════╝');
        $this->command->info('');

        // ─── 1. LOOKUP / REFERENCE DATA ──────────────────────────────────────
        // No foreign key dependencies — seed first.
        $this->call(UserSeeder::class);

        $this->command->info('▶  [1/14] Seeding service categories...');
        $this->call(ServiceCategorySeeder::class);
        $this->call(ServiceSubcategorySeeder::class);
        $this->call(ServiceSeeder::class);
        $this->command->info('▶  [2/14] Seeding facilities...');
        $this->call(FacilitySeeder::class);

        $this->command->info('▶  [3/14] Seeding design categories...');
        $this->call(DesignCategorySeeder::class);

        $this->command->info('▶  [4/14] Seeding pricing plans...');
        $this->call(PricingPlanSeeder::class);

        $this->command->info('▶  [5/14] Seeding announcements...');
        $this->call(AnnouncementSeeder::class);

        // ─── 2. USERS + PEOPLE ───────────────────────────────────────────────
        // Agents, Professionals, and Consultants each auto-create their User.

        $this->command->info('▶  [6/14] Seeding agents (+ their users)...');
        $this->call(AgentsSeeder::class);

        $this->command->info('▶  [7/14] Seeding professionals (+ their users)...');
        $this->call(ProfessionalSeeder::class);

        $this->command->info('▶  [8/14] Seeding consultants (+ their users)...');
        $this->call(ConsultantSeeder::class);

        // ─── 3. CONSULTANT PIVOT ─────────────────────────────────────────────
        // Requires service_categories + consultants to exist.

        $this->command->info('▶  [9/14] Seeding consultant ↔ service category links...');
        $this->call(ConsultantServiceCategorySeeder::class);

        // ─── 4. PROPERTIES ───────────────────────────────────────────────────
        // Houses require users + facilities. Lands require users.

        $this->command->info('▶  [10/14] Seeding houses (with facilities)...');
        $this->call(HouseSeeder::class);

        $this->command->info('▶  [11/14] Seeding land listings...');
        $this->call(LandSeeder::class);

        // ─── 5. DESIGNS & TENDERS ────────────────────────────────────────────
        // Architectural designs require design_categories + users.
        // Tenders require users.
        $this->call(DesignCategorySeeder::class);
        $this->command->info('▶  [12/14] Seeding architectural designs...');
        $this->call(ArchitecturalDesignSeeder::class);

        $this->command->info('▶  [13/14] Seeding tenders...');
        $this->call(TenderSeeder::class);

        // ─── 6. ADVERTISEMENTS ───────────────────────────────────────────────
        // Requires agents + houses + lands to exist.

        $this->command->info('▶  [14/14] Seeding advertisements...');
        $this->call(AdvertisementSeeder::class);

        $this->command->info('▶  [14/14] Seeding blog...');
        $this->call(BlogCategorySeeder::class);
        $this->call(BlogSeeder::class);
        // ─── DONE ─────────────────────────────────────────────────────────────

        $this->command->info('');
        $this->command->info('✅  All seeders completed successfully.');
        $this->command->info('');
        $this->command->table(
            ['#', 'Seeder', 'Status'],
            [
                ['1',  'ServiceCategorySeeder',              '✓ Done'],
                ['2',  'FacilitySeeder',                     '✓ Done'],
                ['3',  'DesignCategorySeeder',               '✓ Done'],
                ['4',  'PricingPlanSeeder',                  '✓ Done'],
                ['5',  'AnnouncementSeeder',                 '✓ Done'],
                ['6',  'AgentSeeder',                        '✓ Done'],
                ['7',  'ProfessionalSeeder',                 '✓ Done'],
                ['8',  'ConsultantSeeder',                   '✓ Done'],
                ['9',  'ConsultantServiceCategorySeeder',    '✓ Done'],
                ['10', 'HouseSeeder',                        '✓ Done'],
                ['11', 'LandSeeder',                         '✓ Done'],
                ['12', 'ArchitecturalDesignSeeder',          '✓ Done'],
                ['13', 'TenderSeeder',                       '✓ Done'],
                ['14', 'AdvertisementSeeder',                '✓ Done'],
            ]
        );
        $this->command->info('');
    }
}
