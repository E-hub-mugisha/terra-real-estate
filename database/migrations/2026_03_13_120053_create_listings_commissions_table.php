<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('listings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('agent_id')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('listing_package_id')->constrained('listing_packages');

            $table->string('listing_type');
            $table->string('package_tier');
            $table->string('title');
            $table->text('description')->nullable();
            $table->date('start_date');
            $table->date('end_date');
            $table->unsignedInteger('duration_days');
            $table->unsignedBigInteger('base_price_per_day');

            $table->unsignedBigInteger('gross_amount');
            $table->decimal('duration_discount_pct', 5, 2)->default(0);
            $table->unsignedBigInteger('discount_amount')->default(0);
            $table->unsignedBigInteger('net_amount');

            $table->string('status')->default('pending');
            $table->string('payment_status')->default('unpaid');
            $table->timestamp('paid_at')->nullable();
            $table->json('meta')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('listing_commissions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('listing_id')->constrained('listings')->cascadeOnDelete();
            $table->foreignId('agent_id')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('listing_package_id')->constrained('listing_packages');

            $table->string('listing_type');
            $table->string('package_tier');
            $table->unsignedBigInteger('net_listing_amount');

            $table->decimal('agent_commission_pct', 5, 2);
            $table->unsignedBigInteger('agent_commission_amount');
            $table->unsignedBigInteger('terra_share_amount');

            $table->string('agent_level')->nullable();
            $table->decimal('performance_bonus_pct', 5, 2)->default(0);
            $table->unsignedBigInteger('performance_bonus_amount')->default(0);
            $table->unsignedBigInteger('total_agent_payout')->default(0);

            $table->string('status')->default('pending');
            $table->timestamp('confirmed_at')->nullable();
            $table->timestamp('paid_at')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
        });

        Schema::create('consultant_commissions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('consultant_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('client_id')->nullable()->constrained('users')->nullOnDelete();

            $table->string('service_description');
            $table->unsignedBigInteger('service_value');

            $table->foreignId('commission_tier_id')->constrained('consultant_commission_tiers');
            $table->decimal('terra_commission_pct', 5, 2);
            $table->decimal('consultant_payout_pct', 5, 2);
            $table->unsignedBigInteger('terra_commission_amount');
            $table->unsignedBigInteger('consultant_payout_amount');

            $table->string('status')->default('pending');
            $table->timestamp('confirmed_at')->nullable();
            $table->timestamp('paid_at')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
        });

        Schema::create('agent_stats', function (Blueprint $table) {
            $table->id();
            $table->foreignId('agent_id')->unique()->constrained('users')->cascadeOnDelete();
            $table->foreignId('level_id')->constrained('agent_levels');
            $table->unsignedInteger('total_referrals')->default(0);
            $table->unsignedBigInteger('total_revenue_generated')->default(0);
            $table->unsignedBigInteger('total_commissions_earned')->default(0);
            $table->unsignedBigInteger('total_commissions_paid')->default(0);
            $table->unsignedBigInteger('pending_payout')->default(0);
            $table->timestamp('last_level_upgrade_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('agent_stats');
        Schema::dropIfExists('consultant_commissions');
        Schema::dropIfExists('listing_commissions');
        Schema::dropIfExists('listings');
    }
};