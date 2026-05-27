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
        Schema::table('houses_and_lands_tables', function (Blueprint $table) {
            Schema::table('houses', function (Blueprint $table) {
                $table->enum('negotiable', ['negotiable', 'non_negotiable'])
                    ->default('negotiable')
                    ->after('status');
            });

            Schema::table('lands', function (Blueprint $table) {
                $table->enum('negotiable', ['negotiable', 'non_negotiable'])
                    ->default('negotiable')
                    ->after('status');
            });
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('houses_and_lands_tables', function (Blueprint $table) {
            $table->dropColumn('negotiable');
        });
    }
};
