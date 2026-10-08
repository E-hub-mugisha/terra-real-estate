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
        Schema::create('rent_receipts', function (Blueprint $table) {
            $table->id();
            $table->string('receipt_number')->unique();

            $table->foreignId('rent_payment_id')
                ->unique()
                ->constrained('rent_payments')
                ->restrictOnDelete();

            $table->foreignId('tenant_id')
                ->constrained('tenants')
                ->restrictOnDelete();

            $table->foreignId('lease_id')
                ->constrained('leases')
                ->restrictOnDelete();

            $table->foreignId('unit_id')
                ->constrained('units')
                ->restrictOnDelete();

            $table->decimal('amount', 15, 2);

            $table->string('currency', 3)->default('RWF');

            $table->date('receipt_date');

            $table->string('payment_method');

            $table->string('transaction_id')->nullable();

            $table->string('pdf_path')->nullable();

            $table->timestamps();

            $table->index('tenant_id');
            $table->index('lease_id');
            $table->index('unit_id');
            $table->index('receipt_date');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rent_receipts');
    }
};
