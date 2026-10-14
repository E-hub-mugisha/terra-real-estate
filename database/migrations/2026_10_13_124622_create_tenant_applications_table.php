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
                ->restrictOnDelete();

            $table->foreignId('unit_id')
                ->constrained('units')
                ->restrictOnDelete();

            $table->foreignId('reviewed_by')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            $table->string('application_number')->unique();
            $table->date('application_date');
            $table->date('desired_move_in_date')->nullable();

            $table->unsignedSmallInteger('number_of_occupants')->default(1);
            $table->decimal('offered_monthly_rent', 15, 2)->nullable();
            $table->string('currency', 3)->default('RWF');

            $table->string('employment_status')->nullable();
            $table->text('additional_information')->nullable();

            $table->string('status')->default('pending');
            // Suggested values: pending, under_review, approved,
            // rejected, withdrawn

            $table->timestamp('reviewed_at')->nullable();
            $table->text('decision_notes')->nullable();

            $table->timestamps();

            $table->index(['unit_id', 'status']);
            $table->index(['tenant_id', 'status']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tenant_applications');
    }
};