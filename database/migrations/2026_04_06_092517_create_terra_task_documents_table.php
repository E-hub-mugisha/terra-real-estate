<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('terra_task_documents', function (Blueprint $table) {
            $table->id();
            $table->foreignId('terra_task_id')->constrained('terra_tasks')->cascadeOnDelete();
            $table->foreignId('terra_submission_id')->nullable()
                ->constrained('terra_task_submissions')->nullOnDelete();
            $table->foreignId('uploaded_by')->constrained('users')->cascadeOnDelete();
            $table->string('original_name');
            $table->string('path');               // stored on private disk
            $table->string('mime_type')->nullable();
            $table->unsignedBigInteger('size')->default(0); // bytes
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('terra_task_documents');
    }
};
