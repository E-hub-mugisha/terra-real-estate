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
        Schema::create('properties', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->string('title');
            $table->text('description');
            $table->enum('type', ['house', 'land']);
            $table->enum('zoning', ['R1', 'R2', 'R3', 'Commercial', 'Industrial'])->nullable();
            $table->decimal('price', 15, 2);
            $table->string('district');
            $table->string('sector');
            $table->string('cell');
            $table->enum('status', ['available', 'reserved', 'sold'])->default('available');
            $table->boolean('is_approved')->default(false);
            $table->timestamp('expires_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('properties');
    }
};
