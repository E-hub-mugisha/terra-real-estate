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
        Schema::create('notification_preferences', function (Blueprint $table) {
            $table->id();

            $table->foreignId('user_id')
                ->unique()
                ->constrained('users')
                ->cascadeOnDelete();

            $table->boolean('in_app_enabled')->default(true);
            $table->boolean('email_enabled')->default(true);

            // Future channels remain disabled until configured.
            $table->boolean('sms_enabled')->default(false);
            $table->boolean('push_enabled')->default(false);
            $table->boolean('whatsapp_enabled')->default(false);

            // Optional event-specific overrides, stored as JSON.
            $table->json('event_preferences')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notification_preferences');
    }
};
