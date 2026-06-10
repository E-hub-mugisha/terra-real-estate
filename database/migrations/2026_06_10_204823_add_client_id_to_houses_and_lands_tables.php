<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // ── Houses table ─────────────────────────────────────
        Schema::table('houses', function (Blueprint $table) {
            $table->foreignId('client_id')
                  ->nullable()          // adjust to whatever column it should follow
                  ->constrained('clients')
                  ->nullOnDelete();
        });

        // ── Lands table ──────────────────────────────────────
        Schema::table('lands', function (Blueprint $table) {
            $table->foreignId('client_id')
                  ->nullable()
                  ->constrained('clients')
                  ->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('houses', function (Blueprint $table) {
            $table->dropForeign(['client_id']);
            $table->dropColumn('client_id');
        });

        Schema::table('lands', function (Blueprint $table) {
            $table->dropForeign(['client_id']);
            $table->dropColumn('client_id');
        });
    }
};
