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

            $table->foreignId('user_id')
                ->unique()
                ->constrained('users')
                ->cascadeOnDelete();

            $table->string('owner_type')->default('individual');
            $table->string('phone')->nullable();
            $table->string('national_id')->nullable()->unique();
            $table->string('company_name')->nullable();
            $table->string('tin')->nullable()->unique();
            $table->text('address')->nullable();

            $table->string('verification_status')
                ->default('pending');

            $table->text('notes')->nullable();

            $table->timestamps();

            $table->index('verification_status');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('property_owners');
    }
};