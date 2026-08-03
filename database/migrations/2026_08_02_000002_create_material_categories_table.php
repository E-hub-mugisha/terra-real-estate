<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('material_categories', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->string('icon')->nullable(); // e.g. an icon key/class for the UI
            $table->unsignedInteger('order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        Schema::create('material_subcategories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('material_category_id')->constrained('material_categories')->cascadeOnDelete();
            $table->string('name');
            $table->string('slug');
            $table->unsignedInteger('order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            $table->unique(['material_category_id', 'slug']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('material_subcategories');
        Schema::dropIfExists('material_categories');
    }
};
