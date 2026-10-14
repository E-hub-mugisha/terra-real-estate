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

            // Optional login account; a tenant can exist without one.
            $table->foreignId('user_id')
                ->nullable()
                ->unique()
                ->constrained('users')
                ->nullOnDelete();

            $table->string('tenant_code')->unique();

            $table->string('first_name');
            $table->string('last_name');
            $table->string('email')->nullable()->index();
            $table->string('phone');
            $table->string('alternative_phone')->nullable();

            $table->string('national_id')->nullable()->unique();
            $table->date('date_of_birth')->nullable();
            $table->string('gender')->nullable();

            $table->string('occupation')->nullable();
            $table->string('employer')->nullable();

            $table->string('emergency_contact_name')->nullable();
            $table->string('emergency_contact_phone')->nullable();

            $table->text('address')->nullable();
            $table->string('status')->default('active');
            // Suggested values: active, inactive, blacklisted

            $table->text('notes')->nullable();

            $table->timestamps();

            $table->index(['last_name', 'first_name']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tenants');
    }
};