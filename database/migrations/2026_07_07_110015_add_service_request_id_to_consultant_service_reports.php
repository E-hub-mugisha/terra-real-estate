<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('consultant_service_reports', function (Blueprint $table) {
            $table->foreignId('service_request_id')
                ->nullable()
                ->after('consultant_id')
                ->constrained('service_requests')
                ->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('consultant_service_reports', function (Blueprint $table) {
            $table->dropConstrainedForeignId('service_request_id');
        });
    }
};
