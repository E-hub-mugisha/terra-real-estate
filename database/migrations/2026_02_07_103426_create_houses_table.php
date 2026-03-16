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
        Schema::create('houses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('service_id')->nullable()->constrained('services')->nullOnDelete();
            // Property Details
            $table->string('title');
            $table->string('upi');
            $table->string('type'); // Apartment, Villa, Bungalow, etc
            $table->decimal('price', 15, 2);
            $table->integer('area_sqft');
            $table->enum('status', ['available', 'reserved', 'sold'])->default('available');
            $table->string('condition')->default('for_sale'); // new, good, needs renovation
            $table->integer('bedrooms');
            $table->integer('bathrooms');
            $table->integer('garages')->default(0);
            $table->text('description');

            // Location
            $table->string('province');
            $table->string('district')->nullable();
            $table->string('sector')->nullable();
            $table->string('cell')->nullable();
            $table->string('village')->nullable();

            // Admin control
            $table->boolean('is_approved')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('houses');
    }
};
