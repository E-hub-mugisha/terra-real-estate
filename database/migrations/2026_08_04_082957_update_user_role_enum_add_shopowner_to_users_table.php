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
            ALTER TABLE users
            MODIFY COLUMN role ENUM(
                'admin',
                'user',
                'agent',
                'shopowner',
                'consultant',
                'professional'
            ) NOT NULL DEFAULT 'user'
        ");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement("
            ALTER TABLE users
            MODIFY COLUMN role ENUM(
                'admin',
                'user',
                'agent',
                'consultant',
                'professional',
                'shopowner'
            ) NOT NULL DEFAULT 'user'
        ");
    }
};