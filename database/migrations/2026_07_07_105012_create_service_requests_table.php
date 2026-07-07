<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('service_requests', function (Blueprint $table) {
            $table->id();
            $table->foreignId('service_id')->constrained('services')->cascadeOnDelete();
            $table->foreignId('assigned_consultant_id')->nullable()->constrained('consultants')->nullOnDelete();

            $table->string('full_name');
            $table->string('phone');
            $table->string('email')->nullable();
            $table->string('location');

            $table->date('preferred_date');
            $table->string('preferred_time');
            $table->text('message')->nullable();

            $table->string('status')->default('new'); // new, assigned, contacted, completed, cancelled

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('service_requests');
    }
};