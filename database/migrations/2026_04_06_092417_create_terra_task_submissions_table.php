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
        Schema::create('terra_task_submissions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('terra_task_id')->constrained('terra_tasks')->cascadeOnDelete();
            $table->foreignId('submitted_by')->constrained('users')->cascadeOnDelete();
            $table->enum('submission_type', [
                'progress_update',
                'final_delivery',
                'additional_documents',
                'revision'
            ]);
            $table->string('subject', 120);
            $table->text('notes')->nullable();
            $table->enum('status', ['under_review', 'approved', 'rejected'])->default('under_review');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('terra_task_submissions');
    }
};
