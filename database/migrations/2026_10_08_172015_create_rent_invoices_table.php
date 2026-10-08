<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('rent_invoices', function (Blueprint $table) {

            $table->id();

            $table->string('invoice_number')->unique();

            $table->foreignId('lease_id')
                ->constrained('leases')
                ->restrictOnDelete();

            $table->foreignId('tenant_id')
                ->constrained('tenants')
                ->restrictOnDelete();

            $table->foreignId('unit_id')
                ->constrained('units')
                ->restrictOnDelete();

            /*
             * rent
             * deposit
             * service_charge
             * other
             */
            $table->enum('invoice_type', [
                'rent',
                'deposit',
                'service_charge',
                'other'
            ])->default('rent');

            $table->string('description');

            /*
             * Example:
             * September 2026 Rent
             */
            $table->date('billing_period_start')->nullable();
            $table->date('billing_period_end')->nullable();

            $table->date('issue_date');
            $table->date('due_date');

            $table->decimal('amount', 15, 2);

            $table->decimal('paid_amount', 15, 2)
                ->default(0);

            $table->decimal('balance', 15, 2)
                ->default(0);

            $table->enum('status', [
                'draft',
                'issued',
                'partially_paid',
                'paid',
                'overdue',
                'cancelled'
            ])->default('draft');

            $table->text('notes')->nullable();

            $table->timestamps();

            $table->index('lease_id');
            $table->index('tenant_id');
            $table->index('unit_id');
            $table->index('invoice_type');
            $table->index('status');
            $table->index('due_date');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('rent_invoices');
    }
};