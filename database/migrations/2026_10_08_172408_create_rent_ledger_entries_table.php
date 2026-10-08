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
        Schema::create('rent_ledger_entries', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tenant_id')
                ->constrained('tenants')
                ->restrictOnDelete();

            $table->foreignId('lease_id')
                ->constrained('leases')
                ->restrictOnDelete();

            $table->foreignId('unit_id')
                ->constrained('units')
                ->restrictOnDelete();

            $table->foreignId('rent_invoice_id')
                ->nullable()
                ->constrained('rent_invoices')
                ->nullOnDelete();

            $table->foreignId('rent_payment_id')
                ->nullable()
                ->constrained('rent_payments')
                ->nullOnDelete();

            /*
             * invoice
             * payment
             * deposit
             * adjustment
             * refund
             */
            $table->enum('entry_type', [
                'invoice',
                'payment',
                'deposit',
                'adjustment',
                'refund'
            ]);

            $table->date('entry_date');

            $table->string('description');

            $table->decimal('debit', 15, 2)
                ->default(0);

            $table->decimal('credit', 15, 2)
                ->default(0);

            $table->decimal('balance', 15, 2)
                ->default(0);

            $table->timestamps();

            $table->index('tenant_id');
            $table->index('lease_id');
            $table->index('unit_id');
            $table->index('entry_date');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rent_ledger_entries');
    }
};
