<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('duration_discounts')) {
            return;
        }

        Schema::create('duration_discounts', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('min_days');
            $table->unsignedInteger('max_days')->nullable();
            $table->decimal('discount_pct', 5, 2);
            $table->string('label')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('duration_discounts');
    }
};
