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
            $table->string('province')->nullable();
            $table->string('district')->nullable();
            $table->string('sector')->nullable();

            $table->enum('status', [
                'Active',
                'Suspended',
                'Pending Approval'
            ])->default('Pending Approval');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('agents', function (Blueprint $table) {
            $table->dropColumn([
                'province',
                'district',
                'sector',
                'status'
            ]);
        });
    }
};
