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

            $table->foreignId('tenant_id')
                ->constrained('tenants')
                ->restrictOnDelete();

            $table->foreignId('unit_id')
                ->constrained('units')
                ->restrictOnDelete();

            $table->foreignId('created_by')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            $table->string('lease_number')->unique();

            $table->date('start_date');
            $table->date('end_date')->nullable();

            $table->decimal('monthly_rent', 15, 2);
            $table->decimal('security_deposit', 15, 2)->default(0);
            $table->unsignedTinyInteger('rent_due_day')->default(1);

            $table->string('currency', 3)->default('RWF');
            $table->string('payment_frequency')->default('monthly');

            $table->string('status')->default('draft');
            // Suggested values: draft, active, expired, terminated

            $table->date('terminated_at')->nullable();
            $table->text('termination_reason')->nullable();

            $table->longText('terms')->nullable();

            $table->timestamps();

            $table->index(['tenant_id', 'status']);
            $table->index(['unit_id', 'status']);
            $table->index(['start_date', 'end_date']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('leases');
    }
};