<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        DB::statement("
            ALTER TABLE property_requests
            MODIFY COLUMN status ENUM(
                'new', 'in_review', 'matched', 'closed', 'unmatched'
            ) NOT NULL DEFAULT 'new'
        ");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement("
            ALTER TABLE property_requests
            MODIFY COLUMN status ENUM(
                'new', 'in_review', 'matched', 'closed', 'unmatched'
            ) NOT NULL DEFAULT 'new'
        ");
    }
};
