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

        // ── Reference / Lookup Tables ──
        $this->call(ServiceCategorySeeder::class);
        $this->call(ServiceSubCategorySeeder::class);
        $this->call(ServiceSeeder::class);
        $this->call(AgentLevelSeeder::class);
        $this->call(ListingPackageSeeder::class);
        $this->call(AdvertisementPackageSeeder::class);
        $this->call(DurationDiscountSeeder::class);
        $this->call(ConsultantCommissionTierSeeder::class);
        $this->call(FacilitySeeder::class);
        $this->call(DesignCategorySeeder::class);
        $this->call(BlogCategorySeeder::class);

        // ── Business Entities ──
        $this->call(ClientSeeder::class);
        $this->call(AgentsSeeder::class);
        $this->call(ConsultantSeeder::class);

        // ── Property Listings ──
        $this->call(HouseSeeder::class);
        $this->call(HouseImageSeeder::class);
        $this->call(FacilityHouseSeeder::class);
        $this->call(LandSeeder::class);
        $this->call(LandImageSeeder::class);
        $this->call(ArchitecturalDesignSeeder::class);
        $this->call(DesignImageSeeder::class);

        // ── Content & Marketing ──
        $this->call(BlogSeeder::class);
        $this->call(BlogImageSeeder::class);
        $this->call(AnnouncementSeeder::class);
        $this->call(AdvertisementSeeder::class);
        $this->call(JobListingSeeder::class);

        // ── Interactions & Reviews ──
        $this->call(AgentReviewSeeder::class);
        $this->call(AgentAppointmentSeeder::class);
        $this->call(ConsultantReviewSeeder::class);
        $this->call(ConsultantAppointmentSeeder::class);
        $this->call(ConsultantBookingSeeder::class);
        $this->call(ConsultantPortfolioSeeder::class);
        $this->call(ConsultantUnavailableDateSeeder::class);

        // ── Commissions & Payments ──
        $this->call(AgentCommissionSeeder::class);
        $this->call(AgentServiceSeeder::class);
        $this->call(ConsultantServiceSeeder::class);
        $this->call(ConsultantServiceReportSeeder::class);
        $this->call(ConsultantCommissionSeeder::class);
        $this->call(ListingSeeder::class);
        $this->call(ListingCommissionSeeder::class);
        $this->call(ListingPaymentSeeder::class);
        $this->call(DesignOrderSeeder::class);

        // ── Analytics & Logs ──
        $this->call(AgentStatSeeder::class);
        $this->call(ActivityLogSeeder::class);
    }
}