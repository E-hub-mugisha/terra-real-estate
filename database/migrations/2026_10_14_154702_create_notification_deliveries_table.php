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
        Schema::create('notification_deliveries', function (Blueprint $table) {
            $table->id();

            $table->foreignId('user_notification_id')
                ->constrained('user_notifications')
                ->cascadeOnDelete();

            $table->string('channel', 20); // in_app, email, sms, push, whatsapp
            $table->string('status', 20)->default('pending');
            $table->unsignedInteger('attempts')->default(0);

            $table->string('recipient', 320)->nullable();
            $table->string('provider_reference')->nullable();
            $table->text('last_error')->nullable();

            $table->timestamp('queued_at')->nullable();
            $table->timestamp('sent_at')->nullable();
            $table->timestamp('delivered_at')->nullable();
            $table->timestamp('failed_at')->nullable();

            $table->timestamps();

            $table->index(['channel', 'status']);
            $table->index(['user_notification_id', 'channel']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notification_deliveries');
    }
};
