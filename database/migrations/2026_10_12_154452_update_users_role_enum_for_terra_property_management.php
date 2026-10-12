<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        /*
        |--------------------------------------------------------------------------
        | Step 1: Temporarily allow all existing role values
        |--------------------------------------------------------------------------
        */
        Schema::table('users', function (Blueprint $table) {
            $table->string('role', 100)
                ->default('user')
                ->change();
        });

        /*
        |--------------------------------------------------------------------------
        | Step 2: Normalize unsupported existing values
        |--------------------------------------------------------------------------
        */
        DB::table('users')
            ->whereNotIn('role', [
                'user',
                'agent',
                'professional',
                'consultant',
                'admin',
                'property_owner',
                'property_manager',
                'tenant',
                'real_estate_agent',
                'service_provider',
                'accountant',
            ])
            ->update(['role' => 'user']);

        /*
        |--------------------------------------------------------------------------
        | Step 3: Apply the expanded enum
        |--------------------------------------------------------------------------
        */
        Schema::table('users', function (Blueprint $table) {
            $table->enum('role', [
                'user',
                'agent',
                'professional',
                'consultant',
                'admin',
                'property_owner',
                'property_manager',
                'tenant',
                'real_estate_agent',
                'service_provider',
                'accountant',
            ])->default('user')->change();
        });
    }

    public function down(): void
    {
        /*
        |--------------------------------------------------------------------------
        | Convert Terra-specific roles to the original default
        |--------------------------------------------------------------------------
        */
        DB::table('users')
            ->whereIn('role', [
                'property_owner',
                'property_manager',
                'tenant',
                'real_estate_agent',
                'service_provider',
                'accountant',
            ])
            ->update(['role' => 'user']);

        Schema::table('users', function (Blueprint $table) {
            $table->enum('role', [
                'user',
                'agent',
                'professional',
                'consultant',
                'admin',
            ])->default('user')->change();
        });
    }
};