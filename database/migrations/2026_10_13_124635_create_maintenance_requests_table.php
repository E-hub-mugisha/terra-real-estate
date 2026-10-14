<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('maintenance_requests', function (Blueprint $table) {
            $table->id();

            $table->foreignId('managed_property_id')
                ->constrained('managed_properties')
                ->restrictOnDelete();

            $table->foreignId('unit_id')
                ->nullable()
                ->constrained('units')
                ->nullOnDelete();

            $table->foreignId('tenant_id')
                ->nullable()
                ->constrained('tenants')
                ->nullOnDelete();

            $table->foreignId('requested_by')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            $table->foreignId('assigned_to')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            $table->string('request_number')->unique();
            $table->string('title');
            $table->text('description');

            $table->string('category')->default('general');
            $table->string('priority')->default('medium');
            // Suggested values: low, medium, high, urgent

            $table->string('status')->default('submitted');
            // Suggested values: submitted, assigned, in_progress,
            // completed, cancelled

            $table->date('requested_date');
            $table->date('scheduled_date')->nullable();
            $table->date('completed_date')->nullable();

            $table->decimal('estimated_cost', 15, 2)->nullable();
            $table->decimal('actual_cost', 15, 2)->nullable();
            $table->string('currency', 3)->default('RWF');

            $table->text('resolution_notes')->nullable();

            $table->timestamps();

            $table->index(['managed_property_id', 'status']);
            $table->index(['assigned_to', 'status']);
            $table->index(['priority', 'status']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('maintenance_requests');
    }
};