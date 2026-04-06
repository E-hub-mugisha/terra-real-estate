<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('advertisement_packages', function (Blueprint $table) {
            $table->id();
            $table->string('name');                        // Basic, Standard, Premium
            $table->string('slug')->unique();
            $table->text('description')->nullable();
            $table->integer('duration_days');             // 7, 14, 30
            $table->unsignedBigInteger('price');          // in RWF
            $table->boolean('allows_video')->default(false);
            $table->integer('max_images')->default(3);
            $table->boolean('featured_homepage')->default(false);
            $table->boolean('featured_listings')->default(false);
            $table->boolean('priority_placement')->default(false);
            $table->json('badge_label')->nullable();       // e.g. {"text":"Popular","color":"green"}
            $table->boolean('is_active')->default(true);
            $table->integer('sort_order')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('advertisement_packages');
    }
};