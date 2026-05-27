<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('houses_and_lands_tables', function (Blueprint $table) {
            // Houses table
            DB::statement("
            ALTER TABLE houses 
            MODIFY status ENUM('available', 'reserved', 'sold', 'rented') 
            DEFAULT 'available'
        ");

            // Lands table
            DB::statement("
            ALTER TABLE lands 
            MODIFY status ENUM('available', 'reserved', 'sold', 'rented') 
            DEFAULT 'available'
        ");
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('houses_and_lands_tables', function (Blueprint $table) {
            // Houses table
            DB::statement("
            ALTER TABLE houses 
            MODIFY status ENUM('available', 'reserved', 'sold') 
            DEFAULT 'available'
        ");

            // Lands table
            DB::statement("
            ALTER TABLE lands 
            MODIFY status ENUM('available', 'reserved', 'sold') 
            DEFAULT 'available'
        ");
        });
    }
};
