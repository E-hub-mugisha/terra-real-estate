<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('rent_payment_allocations', function (Blueprint $table) {
            $table->id();

            $table->foreignId('rent_payment_id')
                ->constrained('rent_payments')
                ->restrictOnDelete();

            $table->foreignId('rent_invoice_id')
                ->constrained('rent_invoices')
                ->restrictOnDelete();

            $table->decimal('amount', 15, 2);

            $table->foreignId('allocated_by')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            $table->dateTime('allocated_at')->nullable();
            $table->text('notes')->nullable();

            $table->timestamps();

            $table->unique(
                ['rent_payment_id', 'rent_invoice_id'],
                'rent_payment_invoice_unique'
            );

            $table->index(['rent_invoice_id', 'allocated_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('rent_payment_allocations');
    }
};