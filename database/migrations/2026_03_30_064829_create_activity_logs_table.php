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
        Schema::create('activity_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->string('action');           // e.g. 'created', 'updated', 'deleted'
            $table->string('module');           // e.g. 'Listing', 'Agent', 'Payment'
            $table->text('description');        // human-readable message
            $table->string('subject_type')->nullable(); // morphable model class
            $table->unsignedBigInteger('subject_id')->nullable();
            $table->json('properties')->nullable(); // old/new values if needed
            $table->string('ip_address')->nullable();
            $table->string('user_agent')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('activity_logs');
    }
};
