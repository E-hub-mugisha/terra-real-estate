<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Tables that need views_count / unique_views_count columns added.
     * Add or remove from this list as your schema grows.
     */
    private array $viewableTables = [
        'lands',
        'houses',
        'architectural_designs',
        'blogs',
        'tenders',
        'consultants',
        'agents',
        'professionals',
        'advertisements',
        'announcements',
        // job_listings already has these columns from the previous migration
        // 'job_listings',
    ];

    public function up(): void
    {
        // ── Single polymorphic views table for ALL models ─────────────────
        Schema::create('model_views', function (Blueprint $table) {
            $table->id();

            // Polymorphic relation: viewable_type = App\Models\Land, viewable_id = 5
            $table->morphs('viewable');

            $table->foreignId('user_id')
                  ->nullable()
                  ->constrained('users')
                  ->nullOnDelete();

            $table->string('ip_address', 45)->nullable();
            $table->string('session_id', 100)->nullable();
            $table->text('user_agent')->nullable();
            $table->boolean('is_unique')->default(false);
            $table->boolean('is_bot')->default(false);

            $table->timestamp('viewed_at')->useCurrent();

            // ── Indexes ───────────────────────────────────────────────────
            $table->index(['viewable_type', 'viewable_id', 'viewed_at']);
            $table->index(['viewable_type', 'viewable_id', 'is_unique']);
            $table->index(['viewable_type', 'ip_address']);
            $table->index('session_id');
        });

        // ── Add denormalised counters to every viewable table ─────────────
        foreach ($this->viewableTables as $table) {
            Schema::table($table, function (Blueprint $t) {
                $t->unsignedBigInteger('views_count')->default(0)->after('id');
                $t->unsignedBigInteger('unique_views_count')->default(0)->after('views_count');
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('model_views');

        foreach ($this->viewableTables as $table) {
            Schema::table($table, function (Blueprint $t) {
                $t->dropColumn(['views_count', 'unique_views_count']);
            });
        }
    }
};