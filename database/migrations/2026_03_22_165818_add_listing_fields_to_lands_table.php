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
        Schema::table('lands', function (Blueprint $table) {
            // Who added it
            $table->foreignId('agent_id')
                ->nullable()->after('user_id')
                ->constrained('agents')->nullOnDelete();
            $table->foreignId('added_by')
                ->nullable()->after('agent_id')
                ->constrained('users')->nullOnDelete();

            // Which listing package the owner chose
            $table->foreignId('listing_package_id')
                ->nullable()->after('added_by')
                ->constrained('listing_packages')->nullOnDelete();

            // How many days to list
            $table->integer('listing_days')->default(30)->after('listing_package_id');

            // Calculated at listing time and stored
            $table->decimal('listing_fee_total', 12, 2)->default(0)->after('listing_days');
            $table->decimal('agent_listing_commission', 12, 2)->default(0)->after('listing_fee_total');
            $table->decimal('terra_listing_revenue', 12, 2)->default(0)->after('agent_listing_commission');

            // Owner info
            $table->string('owner_name')->nullable()->after('terra_listing_revenue');
            $table->string('owner_email')->nullable()->after('owner_name');
            $table->string('owner_phone')->nullable()->after('owner_email');
            $table->string('owner_id_number')->nullable()->after('owner_phone');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('lands', function (Blueprint $table) {
            //
        });
    }
};
