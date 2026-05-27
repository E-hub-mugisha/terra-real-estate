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
        Schema::create('property_requests', function (Blueprint $table) {
            $table->id();
            // Step 1 — Personal Information
            $table->string('full_name');
            $table->string('email');
            $table->string('phone');
            $table->string('nationality')->nullable();
            $table->enum('preferred_contact', ['email', 'phone', 'whatsapp'])->default('email');
 
            // Step 2 — Property Type & Purpose
            $table->enum('request_type', ['buy', 'rent', 'invest']); // buy / rent / invest
            $table->enum('property_type', ['house', 'apartment', 'land', 'commercial', 'architectural_design']);
            $table->enum('property_status', ['new', 'existing', 'any'])->default('any');
 
            // Step 3 — Location Preferences
            $table->string('preferred_province')->nullable();
            $table->string('preferred_district')->nullable();
            $table->string('preferred_sector')->nullable();
            $table->text('location_notes')->nullable();
 
            // Step 4 — Budget & Timeline
            $table->enum('currency', ['RWF', 'USD', 'EUR'])->default('USD');
            $table->decimal('budget_min', 15, 2)->nullable();
            $table->decimal('budget_max', 15, 2)->nullable();
            $table->enum('timeline', ['immediate', '1_3_months', '3_6_months', '6_12_months', 'flexible'])->default('flexible');
            $table->boolean('financing_needed')->default(false);
 
            // Step 5 — Property Features & Specifications
            $table->unsignedTinyInteger('bedrooms_min')->nullable();
            $table->unsignedTinyInteger('bathrooms_min')->nullable();
            $table->decimal('land_size_min', 10, 2)->nullable(); // m²
            $table->decimal('land_size_max', 10, 2)->nullable();
            $table->json('amenities')->nullable(); // ['parking','garden','pool','security','generator']
            $table->json('must_have_features')->nullable();
            $table->json('nice_to_have_features')->nullable();
 
            // Step 6 — Additional Notes & Submission
            $table->text('additional_notes')->nullable();
            $table->boolean('newsletter_opt_in')->default(false);
            $table->string('how_did_you_hear')->nullable();
            $table->enum('urgency', ['low', 'medium', 'high'])->default('medium');
 
            // Internal tracking
            $table->enum('status', ['new', 'in_review', 'matched', 'closed'])->default('new');
            $table->string('reference_number')->unique();
            $table->string('assigned_agent')->nullable();
            $table->text('admin_notes')->nullable();
            $table->timestamp('reviewed_at')->nullable();
 
            $table->timestamps();
            $table->softDeletes();
 
            // Indexes
            $table->index('status');
            $table->index('request_type');
            $table->index('property_type');
            $table->index('created_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('property_requests');
    }
};
