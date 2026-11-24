<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * The platform was reduced to Lands, Houses, Architectural Designs and Agents.
 * This migration removes the tables and columns of every other module from
 * databases that were created before that change. On a fresh install none of
 * these exist, so every step is guarded and becomes a no-op.
 */
return new class extends Migration
{
    private array $tables = [
        'activity_logs', 'advertisement_packages', 'advertisements', 'agent_appointments',
        'agent_commissions', 'agent_levels', 'agent_reviews', 'agent_service', 'agent_stats',
        'announcements', 'blog_categories', 'blog_images', 'blogs', 'buildings',
        'consultant_appointments', 'consultant_bookings', 'consultant_commission_tiers',
        'consultant_commissions', 'consultant_portfolios', 'consultant_reviews',
        'consultant_service', 'consultant_service_category', 'consultant_service_reports',
        'consultant_unavailable_dates', 'consultants', 'floors', 'job_listing_views',
        'job_listings', 'leases', 'listing_commissions', 'listings',
        'maintenance_request_activities', 'maintenance_requests', 'managed_properties',
        'material_categories', 'material_product_images', 'material_products',
        'material_subcategories', 'notification_deliveries', 'notification_preferences',
        'partners', 'professional_service', 'professional_service_category', 'professionals',
        'properties', 'property_expenses', 'property_media', 'property_owners',
        'property_requests', 'rent_invoices', 'rent_payment_allocations', 'rent_payments',
        'service_categories', 'service_requests', 'service_sub_categories', 'services',
        'shops', 'tenant_applications', 'tenants', 'tenders', 'terra_advertisements',
        'terra_job_applications', 'terra_jobs', 'terra_task_documents',
        'terra_task_submissions', 'terra_tasks', 'testimonials', 'units', 'user_notifications',
    ];

    /** Columns on kept tables that belonged to removed modules (services, agent levels). */
    private array $columns = [
        'houses'                => ['service_id'],
        'lands'                 => ['service_id'],
        'architectural_designs' => ['service_id'],
        'agents'                => ['agent_level_id', 'total_referrals', 'total_revenue_generated'],
    ];

    public function up(): void
    {
        foreach ($this->columns as $table => $columns) {
            foreach ($columns as $column) {
                if (! Schema::hasTable($table) || ! Schema::hasColumn($table, $column)) {
                    continue;
                }

                Schema::table($table, function (Blueprint $t) use ($table, $column) {
                    $foreignKeys = collect(Schema::getForeignKeys($table))
                        ->filter(fn ($fk) => $fk['columns'] === [$column]);

                    foreach ($foreignKeys as $fk) {
                        $t->dropForeign($fk['name']);
                    }

                    $t->dropColumn($column);
                });
            }
        }

        Schema::disableForeignKeyConstraints();

        foreach ($this->tables as $table) {
            Schema::dropIfExists($table);
        }

        Schema::enableForeignKeyConstraints();
    }

    public function down(): void
    {
        // Removed modules are not restored. Check out the code from before this
        // change and run its migrations if they are needed again.
    }
};
