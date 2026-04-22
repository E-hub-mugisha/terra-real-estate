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
        Schema::create('agents', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete(); // optional link to user account

            // Basic info
            $table->string('full_name');
            $table->string('email')->unique();
            $table->string('phone');
            $table->integer('years_experience');
            $table->text('bio')->nullable();

            // Social
            $table->string('linkedin')->nullable();
            $table->string('facebook')->nullable();
            $table->string('instagram')->nullable();
            $table->string('twitter')->nullable();

            // Extra
            $table->string('profile_image')->nullable();
            $table->string('whatsapp')->nullable();
            $table->string('office_location')->nullable();
            $table->string('languages')->nullable();

            // Verification
            $table->boolean('is_verified')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('agents');
    }
};
