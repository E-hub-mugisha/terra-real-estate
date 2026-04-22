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
        Schema::create('pricing_plans', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // Basic, Premium, Featured
            $table->text('description')->nullable();
            $table->decimal('price_per_day', 10, 2);
            $table->integer('max_images')->nullable();
            $table->boolean('featured')->default(false);
            $table->boolean('priority_listing')->default(false);
            $table->boolean('show_on_homepage')->default(false);
            $table->boolean('active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pricing_plans');
    }
};
