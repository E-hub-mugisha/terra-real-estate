<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tenant_applications', function (Blueprint $table) {
            $table->id();

            $table->foreignId('tenant_id')
                ->constrained('tenants')
                ->cascadeOnDelete();

            $table->foreignId('unit_id')
                ->constrained('units')
                ->cascadeOnDelete();

            $table->date('application_date');

            $table->date('preferred_move_in_date')->nullable();

            $table->decimal('offered_rent', 15, 2)->nullable();

            $table->decimal('offered_deposit', 15, 2)->nullable();

            $table->enum('status', [
                'pending',
                'under_review',
                'approved',
                'rejected',
                'withdrawn',
            ])->default('pending');

            $table->text('notes')->nullable();

            $table->text('rejection_reason')->nullable();

            $table->timestamp('reviewed_at')->nullable();

            $table->foreignId('reviewed_by')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            $table->timestamps();

            $table->index('tenant_id');
            $table->index('unit_id');
            $table->index('status');
            $table->index('application_date');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tenant_applications');
    }
};