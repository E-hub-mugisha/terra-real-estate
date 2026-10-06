<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('properties', function (Blueprint $table) {

            // Property classification
            $table->string('property_category')
                ->nullable()
                ->after('type');

            // Sale / rent / lease
            $table->string('listing_type')
                ->nullable()
                ->after('property_category');

            // More detailed location
            $table->string('village')
                ->nullable()
                ->after('cell');

            $table->string('address')
                ->nullable()
                ->after('village');

            // GIS
            $table->decimal('latitude', 10, 7)
                ->nullable()
                ->after('address');

            $table->decimal('longitude', 10, 7)
                ->nullable()
                ->after('latitude');

            // Property identification
            $table->string('upi_reference')
                ->nullable()
                ->after('longitude');

            // Management
            $table->enum('management_status', [
                'not_managed',
                'active',
                'inactive',
            ])->default('not_managed')
              ->after('status');

            $table->boolean('is_managed')
                ->default(false)
                ->after('is_approved');
        });
    }

    public function down(): void
    {
        Schema::table('properties', function (Blueprint $table) {
            $table->dropColumn([
                'property_category',
                'listing_type',
                'village',
                'address',
                'latitude',
                'longitude',
                'upi_reference',
                'management_status',
                'is_managed',
            ]);
        });
    }
};