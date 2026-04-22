<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('job_listings', function (Blueprint $table) {
            $table->id();

            // Company info
            $table->string('company_name');
            $table->string('company_email');
            $table->string('company_phone')->nullable();
            $table->string('company_logo')->nullable();
            $table->string('company_website')->nullable();

            // Job details
            $table->string('title');
            $table->string('slug')->unique();
            $table->text('description');
            $table->text('requirements')->nullable();
            $table->text('benefits')->nullable();
            $table->string('location');
            $table->enum('job_type', ['full-time', 'part-time', 'contract', 'internship', 'remote']);
            $table->string('category')->nullable();
            $table->unsignedBigInteger('salary_min')->nullable();
            $table->unsignedBigInteger('salary_max')->nullable();
            $table->string('salary_currency')->default('RWF');
            $table->boolean('show_salary')->default(true);
            $table->date('application_deadline')->nullable();
            $table->string('application_email');
            $table->string('application_url')->nullable();

            // Package & billing
            $table->foreignId('listing_package_id')->constrained('listing_packages')->restrictOnDelete();
            $table->unsignedInteger('days_purchased');
            $table->unsignedBigInteger('total_amount');
            $table->unsignedBigInteger('agent_commission_amount')->default(0);
            $table->unsignedBigInteger('terra_share_amount')->default(0);

            // Payment
            $table->enum('payment_status', ['pending', 'paid', 'failed'])->default('pending');
            $table->string('payment_reference')->nullable();
            $table->string('payment_method')->nullable();
            $table->timestamp('paid_at')->nullable();

            // Lifecycle
            $table->enum('status', ['draft', 'pending_payment', 'active', 'expired', 'rejected', 'paused'])->default('draft');
            $table->timestamp('published_at')->nullable();
            $table->timestamp('expires_at')->nullable();
            $table->text('rejection_reason')->nullable();

            // Ownership
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();

            $table->timestamps();

            $table->index(['status', 'expires_at']);
            $table->index('company_email');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('job_listings');
    }
};