<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

/**
 * Terra Marketplace foundation — one shared database for every room:
 * public site, property owners, clients, agents, independent partners and admin.
 *
 * Listings (houses, lands, architectural designs) are referenced polymorphically
 * through a `listable` morph so inquiries, viewings, offers, saves, promotions and
 * commissions work the same for all three listing types.
 */
return new class extends Migration
{
    private array $listingTables = ['houses', 'lands', 'architectural_designs'];

    public function up(): void
    {
        // ── Users: free-form role + shared profile fields ─────────────────────
        if (DB::getDriverName() === 'mysql') {
            DB::statement("ALTER TABLE users MODIFY role VARCHAR(30) NOT NULL DEFAULT 'client'");
        }
        DB::table('users')->whereIn('role', ['user', 'consultant', 'professional', 'shopowner'])->update(['role' => 'client']);

        Schema::table('users', function (Blueprint $t) {
            foreach ([
                'whatsapp'    => fn () => $t->string('whatsapp', 30)->nullable(),
                'avatar'      => fn () => $t->string('avatar')->nullable(),
                'national_id' => fn () => $t->string('national_id', 30)->nullable(),
                'bio'         => fn () => $t->text('bio')->nullable(),
                'province'    => fn () => $t->string('province', 100)->nullable(),
                'district'    => fn () => $t->string('district', 100)->nullable(),
                'is_active'   => fn () => $t->boolean('is_active')->default(true),
                'last_seen_at'=> fn () => $t->timestamp('last_seen_at')->nullable(),
            ] as $col => $add) {
                if (!Schema::hasColumn('users', $col)) $add();
            }
        });

        // ── Listings: who owns it, which partner brought it in, how long it runs ─
        foreach ($this->listingTables as $table) {
            Schema::table($table, function (Blueprint $t) use ($table) {
                if (!Schema::hasColumn($table, 'owner_user_id')) {
                    $t->foreignId('owner_user_id')->nullable()->constrained('users')->nullOnDelete();
                }
                if (!Schema::hasColumn($table, 'partner_id')) {
                    $t->foreignId('partner_id')->nullable()->constrained('users')->nullOnDelete();
                }
                if (!Schema::hasColumn($table, 'listing_expires_at')) {
                    $t->timestamp('listing_expires_at')->nullable();
                }
                if (!Schema::hasColumn($table, 'rejection_reason')) {
                    $t->string('rejection_reason')->nullable();
                }
            });
        }

        // ── Payments remember which package and how many days were bought ─────
        Schema::table('listing_payments', function (Blueprint $t) {
            if (!Schema::hasColumn('listing_payments', 'listing_package_id')) {
                $t->foreignId('listing_package_id')->nullable()->constrained('listing_packages')->nullOnDelete();
            }
            if (!Schema::hasColumn('listing_payments', 'days')) {
                $t->unsignedInteger('days')->nullable();
            }
            if (!Schema::hasColumn('listing_payments', 'verified_by')) {
                $t->foreignId('verified_by')->nullable()->constrained('users')->nullOnDelete();
            }
        });

        // Package tiers: basic / medium / premium
        DB::table('listing_packages')->where('package_tier', 'standard')->update(['package_tier' => 'premium']);

        // ── Independent partner profiles ──────────────────────────────────────
        Schema::create('partner_profiles', function (Blueprint $t) {
            $t->id();
            $t->foreignId('user_id')->unique()->constrained()->cascadeOnDelete();
            $t->string('company_name')->nullable();
            $t->string('phone', 30)->nullable();
            $t->string('whatsapp', 30)->nullable();
            $t->string('areas')->nullable();          // districts / sectors they cover
            $t->text('bio')->nullable();
            $t->string('status', 20)->default('pending'); // pending | active | suspended
            $t->boolean('is_verified')->default(false);
            $t->timestamps();
        });

        // ── System settings (commission rates, ad shares, contacts) ───────────
        Schema::create('settings', function (Blueprint $t) {
            $t->id();
            $t->string('key')->unique();
            $t->text('value')->nullable();
            $t->timestamps();
        });

        // ── Package promotions: timing for listing + ads + homepage spotlight ─
        Schema::create('listing_promotions', function (Blueprint $t) {
            $t->id();
            $t->morphs('listable');
            $t->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            $t->foreignId('listing_package_id')->nullable()->constrained('listing_packages')->nullOnDelete();
            $t->foreignId('listing_payment_id')->nullable()->constrained('listing_payments')->nullOnDelete();
            $t->string('tier', 20);                     // basic | medium | premium
            $t->unsignedInteger('days');
            $t->dateTime('starts_at');
            $t->dateTime('ends_at');
            $t->dateTime('ad_ends_at')->nullable();    // ad rotation window
            $t->boolean('spotlight')->default(false);   // homepage pop-up (premium)
            $t->string('status', 20)->default('active'); // active | cancelled
            $t->timestamps();
            $t->index(['status', 'ends_at']);
            $t->index(['status', 'ad_ends_at']);
        });

        // ── Inquiries ─────────────────────────────────────────────────────────
        Schema::create('inquiries', function (Blueprint $t) {
            $t->id();
            $t->morphs('listable');
            $t->foreignId('sender_id')->nullable()->constrained('users')->nullOnDelete();
            $t->foreignId('recipient_id')->nullable()->constrained('users')->nullOnDelete();
            $t->string('name');
            $t->string('email');
            $t->string('phone', 30)->nullable();
            $t->text('message');
            $t->string('status', 20)->default('new');   // new | replied | closed
            $t->foreignId('conversation_id')->nullable();
            $t->timestamps();
            $t->index(['recipient_id', 'status']);
        });

        // ── Direct messaging ──────────────────────────────────────────────────
        Schema::create('conversations', function (Blueprint $t) {
            $t->id();
            $t->nullableMorphs('listable');
            $t->string('subject')->nullable();
            $t->timestamp('last_message_at')->nullable();
            $t->timestamps();
        });
        Schema::create('conversation_participants', function (Blueprint $t) {
            $t->id();
            $t->foreignId('conversation_id')->constrained()->cascadeOnDelete();
            $t->foreignId('user_id')->constrained()->cascadeOnDelete();
            $t->timestamp('last_read_at')->nullable();
            $t->timestamps();
            $t->unique(['conversation_id', 'user_id']);
        });
        Schema::create('messages', function (Blueprint $t) {
            $t->id();
            $t->foreignId('conversation_id')->constrained()->cascadeOnDelete();
            $t->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            $t->text('body');
            $t->timestamps();
            $t->index(['conversation_id', 'created_at']);
        });

        // ── Viewing appointments ──────────────────────────────────────────────
        Schema::create('viewings', function (Blueprint $t) {
            $t->id();
            $t->morphs('listable');
            $t->foreignId('client_id')->constrained('users')->cascadeOnDelete();
            $t->foreignId('host_id')->nullable()->constrained('users')->nullOnDelete();
            $t->dateTime('scheduled_at');
            $t->string('status', 20)->default('requested'); // requested | confirmed | declined | completed | cancelled
            $t->text('note')->nullable();
            $t->text('response_note')->nullable();
            $t->timestamps();
            $t->index(['host_id', 'status']);
        });

        // ── Offers ────────────────────────────────────────────────────────────
        Schema::create('offers', function (Blueprint $t) {
            $t->id();
            $t->morphs('listable');
            $t->foreignId('client_id')->constrained('users')->cascadeOnDelete();
            $t->foreignId('recipient_id')->nullable()->constrained('users')->nullOnDelete();
            $t->decimal('amount', 14, 2);
            $t->string('currency', 10)->default('RWF');
            $t->text('message')->nullable();
            $t->decimal('counter_amount', 14, 2)->nullable();
            $t->text('response_note')->nullable();
            $t->string('status', 20)->default('pending'); // pending | countered | accepted | rejected | withdrawn
            $t->timestamp('responded_at')->nullable();
            $t->timestamps();
            $t->index(['recipient_id', 'status']);
        });

        // ── Saved properties (server-side, for signed-in users) ───────────────
        Schema::create('saved_listings', function (Blueprint $t) {
            $t->id();
            $t->foreignId('user_id')->constrained()->cascadeOnDelete();
            $t->morphs('listable');
            $t->timestamps();
            $t->unique(['user_id', 'listable_type', 'listable_id']);
        });

        // ── Referrals / leads brought in by partners and agents ───────────────
        Schema::create('referrals', function (Blueprint $t) {
            $t->id();
            $t->foreignId('referrer_id')->constrained('users')->cascadeOnDelete();
            $t->string('type', 20);                     // owner | client
            $t->string('name');
            $t->string('phone', 30)->nullable();
            $t->string('email')->nullable();
            $t->string('interest')->nullable();         // e.g. "3-bed house in Kicukiro"
            $t->text('notes')->nullable();
            $t->string('status', 20)->default('new');   // new | contacted | qualified | converted | lost
            $t->foreignId('converted_user_id')->nullable()->constrained('users')->nullOnDelete();
            $t->nullableMorphs('listable');
            $t->timestamps();
            $t->index(['referrer_id', 'status']);
        });

        // ── Listings assigned to agents / partners for promotion ──────────────
        Schema::create('listing_assignments', function (Blueprint $t) {
            $t->id();
            $t->morphs('listable');
            $t->foreignId('user_id')->constrained()->cascadeOnDelete();
            $t->foreignId('assigned_by')->nullable()->constrained('users')->nullOnDelete();
            $t->text('note')->nullable();
            $t->timestamps();
            $t->unique(['listable_type', 'listable_id', 'user_id']);
        });

        // ── Property documents (title deed, permits, plans…) ──────────────────
        Schema::create('listing_documents', function (Blueprint $t) {
            $t->id();
            $t->morphs('listable');
            $t->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            $t->string('title');
            $t->string('type', 30)->default('other'); // title_deed | permit | plan | survey | other
            $t->string('path');
            $t->string('original_name')->nullable();
            $t->unsignedInteger('size')->nullable();
            $t->boolean('is_public')->default(false);  // shown to buyers on the listing page
            $t->string('status', 20)->default('pending'); // pending | verified | rejected (admin check)
            $t->timestamps();
        });

        // ── Commissions & partnership earnings ────────────────────────────────
        Schema::create('commissions', function (Blueprint $t) {
            $t->id();
            $t->foreignId('user_id')->constrained()->cascadeOnDelete();   // agent or partner
            $t->string('role', 20);                     // agent | partner
            $t->string('type', 20);                     // listing_fee | deal | referral
            $t->nullableMorphs('listable');
            $t->foreignId('listing_payment_id')->nullable()->constrained('listing_payments')->nullOnDelete();
            $t->decimal('base_amount', 14, 2);
            $t->decimal('rate', 5, 2);
            $t->decimal('amount', 14, 2);
            $t->string('currency', 10)->default('RWF');
            $t->string('status', 20)->default('pending'); // pending | approved | paid | cancelled
            $t->string('notes')->nullable();
            $t->timestamp('paid_at')->nullable();
            $t->timestamps();
            $t->index(['user_id', 'status']);
        });
    }

    public function down(): void
    {
        foreach (['commissions', 'listing_documents', 'listing_assignments', 'referrals', 'saved_listings', 'offers', 'viewings',
                  'messages', 'conversation_participants', 'conversations', 'inquiries', 'listing_promotions',
                  'settings', 'partner_profiles'] as $table) {
            Schema::dropIfExists($table);
        }
        DB::table('listing_packages')->where('package_tier', 'premium')->update(['package_tier' => 'standard']);
    }
};
