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
        Schema::create('lands', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();

            // Basic info
            $table->string('title');
            $table->text('description')->nullable();
            $table->decimal('price', 15, 2);

            // Land details (Rwanda)
            $table->decimal('size_sqm', 12, 2); // plot size in square meters
            $table->enum('zoning', ['R1', 'R2', 'R3', 'Commercial', 'Industrial', 'Agricultural']);
            $table->string('land_use')->nullable(); // Residential, Mixed-use, etc

            // Location (Rwanda administrative units)
            $table->string('province');  // Kigali City, Northern, Southern, Eastern, Western
            $table->string('district');
            $table->string('sector');
            $table->string('cell');
            $table->string('village')->nullable();

            // Title & compliance
            $table->string('upi')->nullable(); // RLMUA title ref
            $table->string('title_doc')->nullable(); // uploaded PDF/image
            $table->boolean('is_title_verified')->default(false);

            // Listing control
            $table->enum('status', ['available', 'reserved', 'sold'])->default('available');
            $table->boolean('is_approved')->default(false);
            $table->timestamp('expires_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lands');
    }
};
