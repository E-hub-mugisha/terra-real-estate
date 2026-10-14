<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('property_expenses', function (Blueprint $table) {
            $table->id();

            $table->foreignId('managed_property_id')
                ->constrained('managed_properties')
                ->restrictOnDelete();

            $table->foreignId('unit_id')
                ->nullable()
                ->constrained('units')
                ->nullOnDelete();

            $table->foreignId('recorded_by')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            $table->string('expense_reference')->unique();

            $table->string('category');
            // Examples: repairs, utilities, cleaning, security, tax, other

            $table->string('description');
            $table->decimal('amount', 15, 2);
            $table->string('currency', 3)->default('RWF');

            $table->date('expense_date');

            $table->string('vendor_name')->nullable();
            $table->string('receipt_path')->nullable();

            $table->string('status')->default('recorded');
            // Suggested values: recorded, pending, approved, rejected

            $table->text('notes')->nullable();

            $table->timestamps();

            $table->index(['managed_property_id', 'expense_date']);
            $table->index(['category', 'status']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('property_expenses');
    }
};