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
        Schema::create('professional_service_category', function (Blueprint $table) {
            $table->unsignedBigInteger('professional_id');
        $table->unsignedBigInteger('service_category_id');
        $table->primary(['professional_id', 'service_category_id']);

        $table->foreign('professional_id')->references('id')->on('professionals')->onDelete('cascade');
        $table->foreign('service_category_id')->references('id')->on('service_categories')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('professional_service_category');
    }
};
