<?php
// database/migrations/xxxx_xx_xx_create_consultant_service_reports_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('consultant_service_reports', function (Blueprint $table) {
            $table->id();
            $table->foreignId('consultant_id')->constrained('consultants')->cascadeOnDelete();
            $table->foreignId('service_id')->constrained('services')->cascadeOnDelete();

            $table->string('client_name');
            $table->string('client_phone', 15);
            $table->date('service_date');
            $table->time('service_time');
            $table->string('location');

            $table->decimal('amount', 12, 2); // actual amount charged for the service

            // snapshot commission rules at time of submission (protects history if service rates change later)
            $table->enum('commission_type', ['percentage', 'fixed']);
            $table->decimal('commission_value', 10, 2);

            $table->decimal('terra_commission_amount', 12, 2);
            $table->decimal('consultant_amount', 12, 2);

            $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending');
            $table->text('notes')->nullable();       // consultant's notes
            $table->text('admin_notes')->nullable();  // admin's review notes
            $table->foreignId('reviewed_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamp('reviewed_at')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('consultant_service_reports');
    }
};