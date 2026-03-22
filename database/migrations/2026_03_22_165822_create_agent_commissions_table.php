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
        Schema::create('agent_commissions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('agent_id')->constrained('agents')->cascadeOnDelete();

            // Polymorphic — House | Land | ArchitecturalDesign
            $table->nullableMorphs('commissionable');

            // Snapshot fields so display works even if property is deleted
            $table->string('property_type');   // 'house' | 'land' | 'design'
            $table->string('property_title');

            // ── Listing fee commission ──────────────────────────────────────
            $table->foreignId('listing_package_id')
                ->nullable()->constrained('listing_packages')->nullOnDelete();
            $table->integer('listing_days')->default(0);
            $table->decimal('price_per_day', 10, 2)->default(0);
            $table->decimal('discount_applied_pct', 5, 2)->default(0);
            $table->decimal('listing_fee_gross', 12, 2)->default(0);  // before discount
            $table->decimal('listing_fee_net', 12, 2)->default(0);    // after discount
            $table->decimal('listing_agent_pct', 5, 2)->default(0);   // from ListingPackage
            $table->decimal('listing_commission', 12, 2)->default(0); // RWF earned from listing

            // ── Sale commission (paid when property sells) ──────────────────
            $table->decimal('sale_price', 14, 2)->default(0);
            $table->foreignId('agent_level_id')
                ->nullable()->constrained('agent_levels')->nullOnDelete();
            $table->decimal('sale_commission_rate', 5, 2)->default(0); // from AgentLevel
            $table->decimal('sale_commission', 14, 2)->default(0);     // RWF earned on sale

            // ── Status ──────────────────────────────────────────────────────
            $table->enum('listing_commission_status', ['pending', 'paid', 'cancelled'])->default('pending');
            $table->enum('sale_commission_status',    ['pending', 'approved', 'paid', 'cancelled'])->default('pending');

            $table->date('listing_commission_paid_at')->nullable();
            $table->date('sale_commission_paid_at')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('agent_commissions');
    }
};
