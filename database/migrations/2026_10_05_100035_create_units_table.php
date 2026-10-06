<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('units', function (Blueprint $table) {
            $table->id();

            $table->foreignId('floor_id')
                ->constrained('floors')
                ->cascadeOnDelete();

            $table->string('unit_number');
            $table->string('unit_type')->nullable();

            $table->decimal('size', 10, 2)->nullable();

            $table->unsignedInteger('bedrooms')->nullable();
            $table->unsignedInteger('bathrooms')->nullable();

            $table->decimal('rent', 15, 2)->nullable();
            $table->decimal('deposit', 15, 2)->nullable();

            $table->enum('availability', [
                'available',
                'reserved',
                'unavailable',
            ])->default('available');

            $table->enum('occupancy_status', [
                'vacant',
                'occupied',
                'under_maintenance',
            ])->default('vacant');

            $table->string('utility_meter')->nullable();

            $table->text('description')->nullable();

            $table->timestamps();

            $table->index('floor_id');
            $table->index('occupancy_status');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('units');
    }
};