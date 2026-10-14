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

            $table->foreignId('managed_property_id')
                ->constrained('managed_properties')
                ->cascadeOnDelete();

            $table->foreignId('building_id')
                ->nullable()
                ->constrained('buildings')
                ->nullOnDelete();

            $table->foreignId('floor_id')
                ->nullable()
                ->constrained('floors')
                ->nullOnDelete();

            $table->string('unit_number');
            $table->string('unit_type')->default('apartment');

            $table->unsignedSmallInteger('bedrooms')->default(0);
            $table->unsignedSmallInteger('bathrooms')->default(0);
            $table->decimal('area_sqm', 10, 2)->nullable();

            $table->decimal('monthly_rent', 15, 2)->default(0);
            $table->decimal('security_deposit', 15, 2)->default(0);
            $table->string('currency', 3)->default('RWF');

            $table->string('status')->default('available');
            // Suggested values: available, occupied, reserved, maintenance

            $table->text('description')->nullable();
            $table->timestamps();

            $table->unique([
                'managed_property_id',
                'unit_number',
            ]);

            $table->index(['managed_property_id', 'status']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('units');
    }
};