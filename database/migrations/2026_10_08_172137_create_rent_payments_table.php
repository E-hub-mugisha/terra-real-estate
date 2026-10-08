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
        Schema::create('rent_payments', function (Blueprint $table) {
            $table->id();

            $table->string('payment_number')->unique();

            $table->foreignId('tenant_id')
                ->constrained('tenants')
                ->restrictOnDelete();

            $table->foreignId('lease_id')
                ->constrained('leases')
                ->restrictOnDelete();

            $table->foreignId('unit_id')
                ->constrained('units')
                ->restrictOnDelete();

            /*
             * Payment method is deliberately generic so we can
             * integrate providers later.
             */
            $table->enum('payment_method', [
                'cash',
                'bank_transfer',
                'mobile_money',
                'card',
                'payment_gateway',
                'other'
            ])->default('cash');

            /*
             * MTN Mobile Money
             * Airtel Money
             * Bank of Kigali
             * Equity
             * etc.
             */
            $table->string('provider')->nullable();

            $table->string('transaction_id')->nullable();

            $table->decimal('amount', 15, 2);

            $table->string('currency', 3)->default('RWF');

            $table->date('payment_date');

            $table->enum('status', [
                'pending',
                'confirmed',
                'failed',
                'reversed',
                'cancelled'
            ])->default('pending');

            $table->text('notes')->nullable();

            $table->foreignId('recorded_by')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            $table->timestamps();

            $table->index('tenant_id');
            $table->index('lease_id');
            $table->index('unit_id');
            $table->index('transaction_id');
            $table->index('status');
            $table->index('payment_date');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rent_payments');
    }
};
