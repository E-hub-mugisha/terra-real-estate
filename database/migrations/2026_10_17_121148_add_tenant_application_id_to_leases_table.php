<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('leases', function (Blueprint $table) {
            $table->foreignId('tenant_application_id')
                ->nullable()
                ->unique()
                ->constrained('tenant_applications')
                ->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('leases', function (Blueprint $table) {
            $table->dropForeign(['tenant_application_id']);
            $table->dropUnique(['tenant_application_id']);
            $table->dropColumn('tenant_application_id');
        });
    }
};