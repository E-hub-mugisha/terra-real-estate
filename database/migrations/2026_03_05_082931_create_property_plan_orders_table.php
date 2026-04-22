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
        Schema::create('property_plan_orders', function (Blueprint $table) {
            $table->id();
            // Polymorphic property relation
            $table->morphs('property');
            // creates: property_id + property_type
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('pricing_plan_id')->constrained('pricing_plans')->cascadeOnDelete();

            $table->integer('days');
            $table->decimal('price_per_day', 10, 2);
            $table->decimal('total_price', 10, 2);

            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();

            $table->enum('payment_status', ['pending', 'paid', 'expired'])->default('pending');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('property_plan_orders');
    }
};
