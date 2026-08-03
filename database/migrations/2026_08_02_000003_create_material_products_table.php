<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('material_products', function (Blueprint $table) {
            $table->id();
            $table->foreignId('shop_id')->constrained('shops')->cascadeOnDelete();
            $table->foreignId('material_category_id')->constrained('material_categories')->restrictOnDelete();
            $table->foreignId('material_subcategory_id')->nullable()->constrained('material_subcategories')->nullOnDelete();

            $table->string('title');
            $table->string('slug');
            $table->text('description')->nullable();

            // Price is nullable — many construction materials are quoted on request
            $table->decimal('price', 14, 2)->nullable();
            $table->string('currency', 3)->default('RWF');
            // e.g. "per bag", "per m2", "per truck", "per piece", "per ton"
            $table->string('unit')->nullable();
            $table->unsignedInteger('min_order_quantity')->nullable();

            $table->enum('stock_status', ['in_stock', 'out_of_stock', 'made_to_order'])
                ->default('in_stock');

            // Admin moderation, independent of shop approval
            $table->enum('status', ['pending', 'approved', 'rejected'])
                ->default('pending')
                ->index();
            $table->text('rejection_reason')->nullable();

            $table->boolean('is_featured')->default(false);
            $table->unsignedInteger('views_count')->default(0);
            $table->unsignedInteger('whatsapp_clicks_count')->default(0);

            $table->timestamps();
            $table->softDeletes();

            $table->index(['status', 'material_category_id']);
        });

        Schema::create('material_product_images', function (Blueprint $table) {
            $table->id();
            $table->foreignId('material_product_id')->constrained('material_products')->cascadeOnDelete();
            $table->string('image_path');
            $table->boolean('is_primary')->default(false);
            $table->unsignedInteger('order')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('material_product_images');
        Schema::dropIfExists('material_products');
    }
};
