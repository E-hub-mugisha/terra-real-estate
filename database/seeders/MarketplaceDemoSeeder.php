<?php

namespace Database\Seeders;

use App\Models\ArchitecturalDesign;
use App\Models\Commission;
use App\Models\Conversation;
use App\Models\House;
use App\Models\Inquiry;
use App\Models\Land;
use App\Models\ListingPackage;
use App\Models\Offer;
use App\Models\PartnerProfile;
use App\Models\Referral;
use App\Models\SavedListing;
use App\Models\User;
use App\Models\Viewing;
use App\Services\Marketplace\PromotionService;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

/**
 * Demo accounts for every room plus some marketplace activity.
 * Logins (password: "password"): owner@terra.rw, client@terra.rw, partner@terra.rw
 */
class MarketplaceDemoSeeder extends Seeder
{
    public function run(): void
    {
        $owner = User::updateOrCreate(['email' => 'owner@terra.rw'], [
            'name' => 'Grace Mukeshimana', 'password' => Hash::make('password'), 'role' => 'owner',
            'phone' => '+250788100200', 'whatsapp' => '250788100200', 'province' => 'Kigali City', 'district' => 'Gasabo',
        ]);
        $client = User::updateOrCreate(['email' => 'client@terra.rw'], [
            'name' => 'Olivier Habimana', 'password' => Hash::make('password'), 'role' => 'client',
            'phone' => '+250788300400', 'whatsapp' => '250788300400',
        ]);
        $partner = User::updateOrCreate(['email' => 'partner@terra.rw'], [
            'name' => 'Aline Uwase', 'password' => Hash::make('password'), 'role' => 'partner',
            'phone' => '+250788500600', 'whatsapp' => '250788500600',
        ]);
        PartnerProfile::updateOrCreate(['user_id' => $partner->id], [
            'company_name' => 'Uwase Property Links', 'phone' => $partner->phone, 'whatsapp' => $partner->whatsapp,
            'areas' => 'Kicukiro, Gasabo', 'bio' => 'Independent partner connecting owners and buyers in Kigali.',
            'status' => 'active', 'is_verified' => true,
        ]);

        // Ownership: the owner owns two houses, the partner brought in a plot.
        $houses = House::orderBy('id')->take(2)->get();
        $houses->each(fn ($h) => $h->forceFill(['owner_user_id' => $owner->id])->save());
        $land = Land::orderBy('id')->first();
        $land?->forceFill(['partner_id' => $partner->id])->save();
        $design = ArchitecturalDesign::orderBy('id')->first();

        // Packages → promotions (premium spotlight, medium & basic ad rotation)
        $promotions = app(PromotionService::class);
        $pkg = fn ($type, $tier) => ListingPackage::where('listing_type', 'like', $type . '%')->where('package_tier', $tier)->first()
            ?? ListingPackage::where('package_tier', $tier)->first();
        if ($h = $houses->first()) {
            $promotions->activate($h, $pkg('house', 'premium'), 30);
        }
        if ($h2 = $houses->get(1)) {
            $promotions->activate($h2, $pkg('house', 'medium') ?? $pkg('house', 'basic'), 30);
        }
        if ($land) {
            $promotions->activate($land, $pkg('land', 'basic'), 20);
        }
        if ($design) {
            $promotions->activate($design, $pkg('design', 'premium'), 14);
        }

        // Client activity on the owner's first house
        if ($h = $houses->first()) {
            Inquiry::firstOrCreate(['listable_type' => House::class, 'listable_id' => $h->id, 'sender_id' => $client->id], [
                'recipient_id' => $owner->id, 'name' => $client->name, 'email' => $client->email, 'phone' => $client->phone,
                'message' => 'Hello, is this house still available? I would like to visit this weekend.', 'status' => 'new',
            ]);
            $conversation = Conversation::between($client, $owner, $h);
            if ($conversation->messages()->count() === 0) {
                $conversation->messages()->create(['user_id' => $client->id, 'body' => 'Hi Grace, can I see the house on Saturday morning?']);
                $conversation->messages()->create(['user_id' => $owner->id, 'body' => 'Yes, Saturday at 10:00 works. Please request the viewing so I can confirm.']);
                $conversation->update(['last_message_at' => now()]);
            }
            Viewing::firstOrCreate(['listable_type' => House::class, 'listable_id' => $h->id, 'client_id' => $client->id], [
                'host_id' => $owner->id, 'scheduled_at' => now()->next('Saturday')->setTime(10, 0), 'status' => 'requested',
                'note' => 'Coming with my wife.',
            ]);
            Offer::firstOrCreate(['listable_type' => House::class, 'listable_id' => $h->id, 'client_id' => $client->id], [
                'recipient_id' => $owner->id, 'amount' => round($h->price * 0.92), 'currency' => $h->currency ?: 'RWF',
                'message' => 'Ready to pay quickly if we agree on this price.', 'status' => 'pending',
            ]);
            SavedListing::firstOrCreate(['user_id' => $client->id, 'listable_type' => House::class, 'listable_id' => $h->id]);
        }

        // Partner referrals + an earning
        Referral::firstOrCreate(['referrer_id' => $partner->id, 'name' => 'Jean de Dieu N.'], [
            'type' => 'owner', 'phone' => '+250788700800', 'interest' => 'Wants to sell a 600 m² plot in Kicukiro', 'status' => 'contacted',
        ]);
        Referral::firstOrCreate(['referrer_id' => $partner->id, 'name' => 'Claudine M.'], [
            'type' => 'client', 'phone' => '+250788900100', 'interest' => 'Looking for a 3-bedroom house to rent in Kimihurura', 'status' => 'new',
        ]);
        if ($land) {
            Commission::firstOrCreate(['user_id' => $partner->id, 'type' => 'listing_fee', 'listable_type' => Land::class, 'listable_id' => $land->id], [
                'role' => 'partner', 'base_amount' => 20000, 'rate' => 15, 'amount' => 3000, 'status' => 'approved',
            ]);
        }
    }
}
