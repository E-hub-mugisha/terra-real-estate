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
        Schema::create('architectural_designs', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('category_id')->constrained('design_categories')->cascadeOnDelete();

            $table->text('description')->nullable();

            $table->string('design_file'); // PDF / ZIP / DWG
            $table->string('preview_image')->nullable(); // watermarked

            $table->decimal('price', 10, 2)->default(0);
            $table->boolean('is_free')->default(false);

            $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending');
            $table->boolean('featured')->default(false);

            $table->integer('download_count')->default(0);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('architectural_designs');
    }
};
