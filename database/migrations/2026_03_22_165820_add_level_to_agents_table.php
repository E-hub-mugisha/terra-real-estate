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
        Schema::table('agents', function (Blueprint $table) {
            $table->foreignId('agent_level_id')
                ->nullable()->after('id')
                ->constrained('agent_levels')->nullOnDelete();

            // Running totals used for level-up checks
            $table->integer('total_referrals')->default(0)->after('agent_level_id');
            $table->decimal('total_revenue_generated', 14, 2)->default(0)->after('total_referrals');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('agents', function (Blueprint $table) {
            //
        });
    }
};
