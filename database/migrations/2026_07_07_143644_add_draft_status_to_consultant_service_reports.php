<?php
// database/migrations/xxxx_xx_xx_add_draft_status_to_consultant_service_reports_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // MySQL enum column — adjust if using pgsql (use a check constraint instead)
        DB::statement("ALTER TABLE consultant_service_reports 
            MODIFY status ENUM('draft', 'pending', 'approved', 'rejected') NOT NULL DEFAULT 'draft'");
    }

    public function down(): void
    {
        DB::statement("ALTER TABLE consultant_service_reports 
            MODIFY status ENUM('pending', 'approved', 'rejected') NOT NULL DEFAULT 'pending'");
    }
};