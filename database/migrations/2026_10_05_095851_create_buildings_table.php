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

            $table->foreignId('property_id')
                ->constrained('properties')
                ->cascadeOnDelete();

            $table->string('name');
            $table->string('reference')->nullable();

            $table->text('description')->nullable();

            $table->unsignedInteger('number_of_floors')->default(1);

            $table->string('status')->default('active');

            $table->timestamps();

            $table->index('property_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('buildings');
    }
};