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
        Schema::create('tenders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete(); // who posted
            $table->string('title');
            $table->text('description');
            $table->string('reference_no')->unique()->nullable();
            $table->decimal('budget', 14, 2)->nullable();

            $table->date('submission_deadline');
            $table->string('location')->nullable(); // Rwanda: Kigali, Gasabo, etc.

            $table->string('document_path')->nullable(); // tender document (PDF)
            $table->boolean('is_open')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tenders');
    }
};
