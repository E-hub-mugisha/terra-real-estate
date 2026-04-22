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
        Schema::create('listing_payments', function (Blueprint $table) {
            $table->id();
            // ── Polymorphic relation ──────────────────────────────────────
            // payable_type = "App\Models\Land" | "App\Models\House" | "App\Models\ArchitecturalDesign"
            $table->morphs('payable');          // adds payable_id (unsignedBigInt) + payable_type (string) + index

            // ── Who is paying ─────────────────────────────────────────────
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();

            // ── What they're paying for ───────────────────────────────────
            // e.g. "listing_fee", "reservation", "purchase"
            $table->string('payment_purpose')->default('listing_fee');

            // ── Amount ────────────────────────────────────────────────────
            $table->decimal('amount', 12, 2);
            $table->string('currency', 10)->default('RWF');

            // ── Payment method & gateway ──────────────────────────────────
            $table->string('payment_method')->default('momo');
            // e.g. momo | card | bank_transfer | cash

            $table->string('phone_number')->nullable();      // MoMo phone
            $table->string('gateway_reference')->nullable(); // MoMo/Flutterwave tx ref
            $table->string('transaction_id')->nullable();    // returned by gateway
            $table->text('gateway_response')->nullable();    // raw JSON from gateway

            // ── Internal reference ────────────────────────────────────────
            $table->string('reference')->unique();           // PAY-XXXXXX

            // ── Status ────────────────────────────────────────────────────
            $table->enum('status', ['pending', 'processing', 'completed', 'failed', 'refunded'])
                ->default('pending');

            $table->timestamp('paid_at')->nullable();
            $table->text('failure_reason')->nullable();

            $table->timestamps();
            $table->softDeletes();

            // ── Useful indexes ────────────────────────────────────────────
            $table->index(['status', 'created_at']);
            $table->index('reference');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('listing_payments');
    }
};
