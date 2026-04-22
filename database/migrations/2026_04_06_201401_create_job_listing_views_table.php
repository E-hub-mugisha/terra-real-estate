<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('job_listing_views', function (Blueprint $table) {
            $table->id();
            $table->foreignId('job_listing_id')
                  ->constrained('job_listings')
                  ->cascadeOnDelete();

            // Nullable so guests are also tracked
            $table->foreignId('user_id')
                  ->nullable()
                  ->constrained('users')
                  ->nullOnDelete();

            $table->string('ip_address', 45)->nullable();      // supports IPv6
            $table->string('session_id', 100)->nullable();     // deduplicate within session
            $table->text('user_agent')->nullable();
            $table->boolean('is_unique')->default(false);      // first view from this IP+listing combo
            $table->boolean('is_bot')->default(false);         // crawler / bot flag

            $table->timestamp('viewed_at')->useCurrent();

            // Speed up analytics queries
            $table->index(['job_listing_id', 'viewed_at']);
            $table->index(['job_listing_id', 'is_unique']);
            $table->index(['ip_address', 'job_listing_id']);
            $table->index('session_id');
        });

        // Denormalised counter on the listing itself — fast reads on index pages
        Schema::table('job_listings', function (Blueprint $table) {
            $table->unsignedBigInteger('views_count')->default(0)->after('days_purchased');
            $table->unsignedBigInteger('unique_views_count')->default(0)->after('views_count');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('job_listing_views');

        Schema::table('job_listings', function (Blueprint $table) {
            $table->dropColumn(['views_count', 'unique_views_count']);
        });
    }
};