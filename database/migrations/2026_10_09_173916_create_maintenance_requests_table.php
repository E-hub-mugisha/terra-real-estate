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

            $table->string('request_number')->unique();

            $table->foreignId('tenant_id')
                ->constrained('tenants')
                ->cascadeOnDelete();

            $table->foreignId('lease_id')
                ->constrained('leases')
                ->cascadeOnDelete();

            $table->foreignId('unit_id')
                ->constrained('units')
                ->cascadeOnDelete();

            $table->string('title');
            $table->string('category');
            $table->text('description');

            $table->enum('priority', [
                'low',
                'normal',
                'high',
                'urgent',
            ])->default('normal');

            $table->enum('status', [
                'pending',
                'approved',
                'in_progress',
                'on_hold',
                'completed',
                'rejected',
            ])->default('pending');

            $table->string('attachment_path')->nullable();
            $table->dateTime('preferred_access_at')->nullable();

            $table->foreignId('assigned_to')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            $table->text('manager_notes')->nullable();

            $table->dateTime('completed_at')->nullable();

            $table->timestamps();

            $table->index(['tenant_id', 'status']);
            $table->index(['unit_id', 'status']);
            $table->index(['priority', 'status']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('maintenance_requests');
    }
};