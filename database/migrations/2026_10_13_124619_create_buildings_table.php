<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('buildings', function (Blueprint $table) {
            $table->id();

            $table->foreignId('managed_property_id')
                ->constrained('managed_properties')
                ->cascadeOnDelete();

            $table->string('name');
            $table->string('building_code')->nullable();
            $table->unsignedInteger('number_of_floors')->default(1);
            $table->text('description')->nullable();
            $table->boolean('is_active')->default(true);

            $table->timestamps();

            $table->unique([
                'managed_property_id',
                'building_code',
            ]);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('buildings');
    }
};