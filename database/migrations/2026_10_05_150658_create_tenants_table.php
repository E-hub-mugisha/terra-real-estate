<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tenants', function (Blueprint $table) {
            $table->id();

            // Optional link to the Terra user account
            $table->foreignId('user_id')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            // Identity
            $table->string('first_name');
            $table->string('last_name');
            $table->string('email')->nullable();
            $table->string('phone');

            // KYC
            $table->string('national_id')->nullable()->unique();
            $table->date('date_of_birth')->nullable();
            $table->string('gender')->nullable();

            // Address
            $table->string('district')->nullable();
            $table->string('sector')->nullable();
            $table->string('cell')->nullable();
            $table->string('village')->nullable();
            $table->text('address')->nullable();

            // Emergency contact
            $table->string('emergency_contact_name')->nullable();
            $table->string('emergency_contact_phone')->nullable();
            $table->string('emergency_contact_relationship')->nullable();

            // KYC / tenant status
            $table->enum('kyc_status', [
                'pending',
                'verified',
                'rejected',
            ])->default('pending');

            $table->enum('status', [
                'active',
                'inactive',
                'blacklisted',
            ])->default('active');

            $table->text('notes')->nullable();

            $table->timestamps();

            $table->index('user_id');
            $table->index('phone');
            $table->index('kyc_status');
            $table->index('status');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tenants');
    }
};