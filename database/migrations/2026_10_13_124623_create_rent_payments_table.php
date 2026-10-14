<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('rent_payments', function (Blueprint $table) {
            $table->id();

            $table->foreignId('lease_id')
                ->constrained('leases')
                ->restrictOnDelete();

            $table->foreignId('recorded_by')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            $table->string('receipt_number')->unique();
            $table->string('transaction_reference')->nullable()->unique();

            $table->decimal('amount', 15, 2);
            $table->string('currency', 3)->default('RWF');

            $table->string('payment_method')->nullable();
            // Examples: cash, bank_transfer, mobile_money, card

            $table->date('payment_date');

            $table->date('period_start')->nullable();
            $table->date('period_end')->nullable();

            $table->string('payment_type')->default('rent');
            // Suggested values: rent, security_deposit, late_fee, other

            $table->string('status')->default('completed');
            // Suggested values: pending, completed, failed, refunded

            $table->text('notes')->nullable();

            $table->timestamps();

            $table->index(['lease_id', 'payment_date']);
            $table->index(['status', 'payment_date']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('rent_payments');
    }
};