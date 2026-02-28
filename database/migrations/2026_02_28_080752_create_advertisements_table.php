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
        Schema::create('advertisements', function (Blueprint $table) {
            $table->id();
            $table->foreignId('agent_id')->constrained('agents')->cascadeOnDelete();

            // Polymorphic relation
            $table->morphs('advertisable');
            // advertiable_type: App\Models\House | Land | Service | Agent
            // advertiable_id

            $table->string('ad_type'); // featured, spotlight, banner, boost
            $table->string('title');
            $table->text('description')->nullable();
            $table->string('banner_image')->nullable();

            $table->decimal('price', 10, 2)->default(0);
            $table->date('start_date');
            $table->date('end_date');

            $table->enum('status', ['pending', 'active', 'expired'])->default('pending');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('advertisements');
    }
};
