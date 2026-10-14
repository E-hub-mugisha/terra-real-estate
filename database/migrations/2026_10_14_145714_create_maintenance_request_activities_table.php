<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('maintenance_request_activities', function (Blueprint $table) {
            $table->id();

            $table->foreignId('maintenance_request_id')
                ->constrained('maintenance_requests')
                ->cascadeOnDelete();

            $table->foreignId('user_id')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            $table->string('from_status')->nullable();
            $table->string('to_status');
            $table->text('notes')->nullable();

            $table->timestamps();

            $table->index(
                ['maintenance_request_id', 'created_at'],
                'mra_request_created_idx'
            );
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('maintenance_request_activities');
    }
};
