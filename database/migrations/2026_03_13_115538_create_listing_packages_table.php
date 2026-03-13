<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('listing_packages', function (Blueprint $table) {
            $table->id();
            $table->string('listing_type');
            $table->string('package_tier');
            $table->unsignedBigInteger('price_per_day');
            $table->decimal('agent_commission_pct', 5, 2);
            $table->decimal('terra_share_pct', 5, 2);
            $table->string('features')->nullable();
            $table->boolean('is_active')->default(true);
            $table->unique(['listing_type', 'package_tier']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('listing_packages');
    }
};
