<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('consultant_commission_tiers', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('min_value');
            $table->unsignedBigInteger('max_value')->nullable();
            $table->decimal('terra_commission_pct', 5, 2);
            $table->decimal('consultant_payout_pct', 5, 2);
            $table->string('label')->nullable();
            $table->timestamps();
        });

        Schema::create('duration_discounts', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('min_days');
            $table->unsignedInteger('max_days')->nullable();
            $table->decimal('discount_pct', 5, 2);
            $table->string('label')->nullable();
            $table->timestamps();
        });

        Schema::create('agent_levels', function (Blueprint $table) {
            $table->id();
            $table->string('level_name');
            $table->string('label');
            $table->string('badge_emoji')->nullable();
            $table->string('badge_color');
            $table->decimal('commission_rate', 5, 2);
            $table->text('requirements')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('agent_levels');
        Schema::dropIfExists('duration_discounts');
        Schema::dropIfExists('consultant_commission_tiers');
    }
};