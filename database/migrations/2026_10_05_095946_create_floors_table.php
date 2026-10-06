<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('floors', function (Blueprint $table) {
            $table->id();

            $table->foreignId('building_id')
                ->constrained('buildings')
                ->cascadeOnDelete();

            $table->string('name');
            $table->integer('floor_number');

            $table->text('description')->nullable();

            $table->timestamps();

            $table->index('building_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('floors');
    }
};