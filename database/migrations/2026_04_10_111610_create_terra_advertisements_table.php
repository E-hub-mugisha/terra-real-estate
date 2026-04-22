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
        Schema::create('terra_advertisements', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            // Which listing package the owner chose
            $table->foreignId('listing_package_id')
                ->nullable()
                ->constrained('listing_packages')->nullOnDelete();

            // How many days to list
            $table->integer('listing_days')->default(30);

            // Ad content
            $table->string('title');
            $table->text('description');
            $table->string('contact_phone')->nullable();
            $table->string('contact_email')->nullable();
            $table->string('location')->nullable();
            $table->decimal('price_amount', 15, 2)->nullable();
            $table->string('currency', 10)->default('RWF');

            // Media
            $table->json('images')->nullable();
            $table->string('video_path')->nullable();

            // Payment
            $table->enum('payment_status', ['pending', 'confirmed', 'rejected'])->default('pending');
            $table->string('momo_phone')->nullable();
            $table->string('momo_transaction_id')->nullable();
            $table->timestamp('payment_submitted_at')->nullable();
            $table->timestamp('payment_confirmed_at')->nullable();
            $table->foreignId('payment_confirmed_by')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            // Lifecycle
            $table->enum('status', ['draft', 'pending_review', 'active', 'paused', 'expired', 'rejected'])->default('draft');
            $table->timestamp('starts_at')->nullable();
            $table->timestamp('expires_at')->nullable();
            $table->unsignedInteger('impressions')->default(0);
            $table->unsignedInteger('clicks')->default(0);
            $table->text('admin_notes')->nullable();

            $table->timestamps();
            $table->softDeletes();

            $table->index(['status', 'starts_at', 'expires_at']);
            $table->index('payment_status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('terra_advertisements');
    }
};
