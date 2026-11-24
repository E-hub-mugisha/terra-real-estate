<?php

namespace App\Services\Marketplace;

use App\Models\ArchitecturalDesign;
use App\Models\House;
use App\Models\Land;
use App\Models\ListingPackage;
use App\Models\ListingPayment;
use App\Models\ListingPromotion;
use App\Support\Settings;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

/**
 * Packages decide how long a listing is promoted and how much of that time it
 * spends in the homepage ads:
 *   premium → whole paid period in ads + homepage pop-up (spotlight)
 *   medium  → ads.medium_share_pct % of the paid days in the ad rotation
 *   basic   → ads.basic_share_pct  % of the paid days in the ad rotation
 * A new purchase for a listing that is still running is added after the current end date.
 */
class PromotionService
{
    public function __construct(private CommissionService $commissions)
    {
    }

    public static function normaliseTier(?string $tier): string
    {
        return match (strtolower((string) $tier)) {
            'premium', 'standard' => 'premium',
            'medium' => 'medium',
            default => 'basic',
        };
    }

    public static function adDays(string $tier, int $days): int
    {
        $pct = Settings::number('ads.' . static::normaliseTier($tier) . '_share_pct');

        return (int) max($pct > 0 ? 1 : 0, round($days * max(0, min(100, $pct)) / 100));
    }

    /** Called when a listing payment is confirmed. Idempotent per payment. */
    public function activateFromPayment(ListingPayment $payment): ?ListingPromotion
    {
        $listing = $payment->payable;
        if (!$listing instanceof Model) {
            return null;
        }
        if ($existing = ListingPromotion::where('listing_payment_id', $payment->id)->first()) {
            return $existing;
        }

        $package = $payment->listing_package_id
            ? ListingPackage::find($payment->listing_package_id)
            : ($listing->listing_package_id ? ListingPackage::find($listing->listing_package_id) : null);
        $days = (int) ($payment->days ?: $listing->listing_days ?: 30);

        return DB::transaction(function () use ($payment, $listing, $package, $days) {
            $promotion = $this->activate($listing, $package, $days, $payment);
            $this->commissions->forListingPayment($payment, $listing);

            return $promotion;
        });
    }

    public function activate(Model $listing, ?ListingPackage $package, int $days, ?ListingPayment $payment = null): ListingPromotion
    {
        $tier = static::normaliseTier($package?->package_tier);

        // Stack after the current active promotion, if any.
        $current = ListingPromotion::active()
            ->where('listable_type', $listing->getMorphClass())
            ->where('listable_id', $listing->getKey())
            ->orderByDesc('ends_at')
            ->first();
        $start = $current ? $current->ends_at->copy() : now();
        $end = $start->copy()->addDays($days);
        $adDays = static::adDays($tier, $days);

        $promotion = ListingPromotion::create([
            'listable_type' => $listing->getMorphClass(),
            'listable_id' => $listing->getKey(),
            'user_id' => $payment?->user_id ?? auth()->id(),
            'listing_package_id' => $package?->id,
            'listing_payment_id' => $payment?->id,
            'tier' => $tier,
            'days' => $days,
            'starts_at' => $start,
            'ends_at' => $end,
            'ad_ends_at' => $adDays > 0 ? $start->copy()->addDays($adDays) : null,
            'spotlight' => $tier === 'premium',
            'status' => 'active',
        ]);

        $listing->forceFill(['listing_expires_at' => $end])->save();

        return $promotion;
    }

    /** Premium listings for the homepage pop-up. */
    public function spotlight(?int $limit = null): Collection
    {
        $limit ??= (int) Settings::number('ads.spotlight_max');

        return $this->listingsFor(ListingPromotion::spotlight(), $limit);
    }

    /** Everything currently in the ad rotation (premium + basic/medium within their ad days). */
    public function adRotation(?int $limit = null): Collection
    {
        $limit ??= (int) Settings::number('ads.rotation_max');

        return $this->listingsFor(ListingPromotion::inAds(), $limit);
    }

    private function listingsFor($query, int $limit): Collection
    {
        return $query->with('listable')
            ->orderByRaw("FIELD(tier, 'premium', 'medium', 'basic')")
            ->inRandomOrder()
            ->get()
            ->map->listable
            ->filter(fn ($l) => $l && method_exists($l, 'isApproved') && $l->isApproved())
            ->unique(fn ($l) => get_class($l) . $l->getKey())
            ->take($limit)
            ->values();
    }

    public static function listingClasses(): array
    {
        return [House::class, Land::class, ArchitecturalDesign::class];
    }
}
