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
        Schema::create('professionals', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete();

            // Identity
            $table->string('full_name');
            $table->string('email')->unique();
            $table->string('phone');
            $table->enum('profession', ['architect', 'engineer', 'valuer', 'surveyor']);
            $table->string('license_number')->nullable(); // local registration/license
            $table->integer('years_experience')->default(0);
            $table->decimal('rating', 2, 1)->default(0.0);
            $table->text('bio')->nullable();

            // Services & portfolio
            $table->string('services')->nullable(); // comma-separated or short text
            $table->string('portfolio_url')->nullable();
            $table->string('credentials_doc')->nullable(); // PDF/image upload

            // Contact & socials
            $table->string('linkedin')->nullable();
            $table->string('website')->nullable();
            $table->string('whatsapp')->nullable();
            $table->string('office_location')->nullable();
            $table->string('languages')->nullable(); // English, Kinyarwanda, French

            // Profile image
            $table->string('profile_image')->nullable();

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
        Schema::dropIfExists('professionals');
    }
};
