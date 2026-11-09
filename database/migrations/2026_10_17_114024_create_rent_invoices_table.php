
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

            $table->foreignId('lease_id')
                ->constrained('leases')
                ->restrictOnDelete();

            $table->foreignId('tenant_id')
                ->constrained('tenants')
                ->restrictOnDelete();

            $table->foreignId('unit_id')
                ->constrained('units')
                ->restrictOnDelete();

            $table->string('invoice_number')->unique();

            $table->string('invoice_type')->default('rent');
            // rent, deposit, service_charge, late_fee, other

            $table->string('description')->nullable();

            $table->date('billing_period_start')->nullable();
            $table->date('billing_period_end')->nullable();

            $table->date('issue_date');
            $table->date('due_date');

            $table->decimal('amount', 15, 2);
            $table->decimal('paid_amount', 15, 2)->default(0);
            $table->decimal('balance', 15, 2);

            $table->string('currency', 3)->default('RWF');

            $table->string('status')->default('issued');
            // issued, partially_paid, paid, overdue, cancelled

            $table->text('notes')->nullable();

            $table->timestamps();

            $table->index(['lease_id', 'invoice_type']);
            $table->index(['tenant_id', 'status']);
            $table->index(['unit_id', 'status']);
            $table->index(['due_date', 'status']);
            $table->index([
                'lease_id',
                'billing_period_start',
                'billing_period_end',
            ], 'rent_invoice_billing_period_idx');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('rent_invoices');
    }
};
