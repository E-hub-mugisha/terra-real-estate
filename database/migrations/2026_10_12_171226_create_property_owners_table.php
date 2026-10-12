<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('property_owners', function (Blueprint $table) {
            $table->id();

            // Link to the existing users table
            $table->foreignId('user_id')
                ->unique()
                ->constrained('users')
                ->cascadeOnDelete();

            // Owner details
            $table->enum('owner_type', [
                'individual',
                'company',
            ])->default('individual');

            $table->string('phone', 30)->nullable();
            $table->string('alternate_phone', 30)->nullable();

            // Identification and business details
            $table->string('national_id', 50)->nullable()->unique();
            $table->string('tin_number', 50)->nullable()->unique();
            $table->string('company_name')->nullable();

            // Address
            $table->string('province')->nullable();
            $table->string('district')->nullable();
            $table->string('sector')->nullable();
            $table->text('address')->nullable();

            // Account verification and status
            $table->enum('verification_status', [
                'pending',
                'verified',
                'rejected',
            ])->default('pending');

            $table->enum('status', [
                'active',
                'inactive',
            ])->default('active');

            $table->text('notes')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('property_owners');
    }
};