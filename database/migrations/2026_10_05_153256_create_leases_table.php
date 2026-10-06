<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('leases', function (Blueprint $table) {
            $table->id();

            $table->string('lease_number')->unique();

            $table->foreignId('tenant_id')
                ->constrained('tenants')
                ->restrictOnDelete();

            $table->foreignId('unit_id')
                ->constrained('units')
                ->restrictOnDelete();

            $table->foreignId('tenant_application_id')
                ->nullable()
                ->constrained('tenant_applications')
                ->nullOnDelete();

            // Contract dates
            $table->date('start_date');
            $table->date('end_date');

            // Financial terms
            $table->decimal('monthly_rent', 15, 2);
            $table->decimal('deposit_amount', 15, 2)->default(0);

            $table->enum('payment_frequency', [
                'monthly',
                'quarterly',
                'semi_annually',
                'annually',
            ])->default('monthly');

            // Contract terms
            $table->text('terms')->nullable();
            $table->text('special_conditions')->nullable();

            // Contract signing
            $table->timestamp('signed_at')->nullable();

            $table->foreignId('signed_by')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            // Lease lifecycle
            $table->enum('status', [
                'draft',
                'pending_signature',
                'active',
                'expired',
                'terminated',
                'cancelled',
            ])->default('draft');

            $table->timestamp('terminated_at')->nullable();
            $table->text('termination_reason')->nullable();

            $table->text('notes')->nullable();

            $table->timestamps();

            $table->index('tenant_id');
            $table->index('unit_id');
            $table->index('tenant_application_id');
            $table->index('status');
            $table->index([
                'unit_id',
                'status',
            ]);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('leases');
    }
};