<?php 

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Disable foreign keys (important)
        Schema::disableForeignKeyConstraints();

        // Drop old table
        Schema::dropIfExists('advertisements');

        // Re-enable
        Schema::enableForeignKeyConstraints();

        // Create new table
        Schema::create('advertisements', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('advertisement_package_id')->constrained('advertisement_packages');

            // Polymorphic
            $table->nullableMorphs('advertisable');

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

    public function down(): void
    {
        Schema::dropIfExists('advertisements');
    }
};