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
        Schema::create('user_notifications', function (Blueprint $table) {
            $table->id();

            $table->foreignId('user_id')
                ->constrained('users')
                ->cascadeOnDelete();

            $table->string('event_key', 100);
            $table->string('title', 180);
            $table->text('message');

            $table->string('priority', 20)->default('normal');
            $table->string('related_type')->nullable();
            $table->unsignedBigInteger('related_id')->nullable();

            $table->json('data')->nullable();
            $table->string('action_url', 2048)->nullable();

            // Supports duplicate prevention for scheduled reminders.
            $table->string('dedupe_key', 191)->nullable()->unique();

            $table->timestamp('read_at')->nullable();
            $table->timestamp('expires_at')->nullable();

            $table->timestamps();

            $table->index(['user_id', 'read_at', 'created_at']);
            $table->index(['related_type', 'related_id']);
            $table->index(['event_key', 'created_at']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_notifications');
    }
};
