<?php

namespace App\Models\Concerns;

use App\Models\Agent;
use App\Models\Commission;
use App\Models\Inquiry;
use App\Models\ListingAssignment;
use App\Models\ListingPromotion;
use App\Models\Offer;
use App\Models\SavedListing;
use App\Models\User;
use App\Models\Viewing;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;

/**
 * Shared marketplace behaviour for House, Land and ArchitecturalDesign.
 */
trait IsListing
{
    public static function listingKind(): string
    {
        return match (static::class) {
            \App\Models\House::class => 'house',
            \App\Models\Land::class => 'land',
            default => 'design',
        };
    }

    public function kind(): string
    {
        return static::listingKind();
    }

    public function ownerUser(): BelongsTo
    {
        return $this->belongsTo(User::class, 'owner_user_id');
    }

    public function partner(): BelongsTo
    {
        return $this->belongsTo(User::class, 'partner_id');
    }

    public function promotions(): MorphMany
    {
        return $this->morphMany(ListingPromotion::class, 'listable');
    }

    public function activePromotion(): MorphOne
    {
        return $this->morphOne(ListingPromotion::class, 'listable')
            ->where('status', 'active')
            ->where('starts_at', '<=', now())
            ->where('ends_at', '>', now())
            ->latestOfMany('ends_at');
    }

    public function inquiries(): MorphMany
    {
        return $this->morphMany(Inquiry::class, 'listable');
    }

    public function viewings(): MorphMany
    {
        return $this->morphMany(Viewing::class, 'listable');
    }

    public function offers(): MorphMany
    {
        return $this->morphMany(Offer::class, 'listable');
    }

    public function saves(): MorphMany
    {
        return $this->morphMany(SavedListing::class, 'listable');
    }

    public function assignments(): MorphMany
    {
        return $this->morphMany(ListingAssignment::class, 'listable');
    }

    public function commissions(): MorphMany
    {
        return $this->morphMany(Commission::class, 'listable');
    }

    public function documents(): MorphMany
    {
        return $this->morphMany(\App\Models\ListingDocument::class, 'listable');
    }

    /** The account buyers deal with: the owner if they have an account, otherwise the agent, otherwise the submitter. */
    public function contactUser(): ?User
    {
        if ($this->owner_user_id && $this->ownerUser) {
            return $this->ownerUser;
        }
        $agent = $this->agent_id ? Agent::find($this->agent_id) : null;
        if ($agent?->user) {
            return $agent->user;
        }

        return $this->user;
    }

    /** Everyone who may manage this listing from their room. */
    public function isManagedBy(?User $user): bool
    {
        if (!$user) {
            return false;
        }
        if ($user->isStaff()) {
            return true;
        }

        return in_array($user->id, array_filter([
            $this->user_id, $this->owner_user_id, $this->partner_id,
            $this->agent_id ? Agent::where('id', $this->agent_id)->value('user_id') : null,
        ]), false);
    }

    public function publicUrl(): string
    {
        return match ($this->kind()) {
            'house' => route('front.buy.home.details', $this),
            'land' => route('front.buy.land.details', $this),
            default => route('front.buy.design.show', $this->slug),
        };
    }

    /** Card image for room tables and lists (falls back to a stock photo). */
    public function thumbUrl(): string
    {
        $card = \App\Support\Listing::collect([$this])->first();

        return $card['image'] ?? asset('front/assets/img/all-images/' . match ($this->kind()) {
            'land' => 'hero/plot.png',
            'design' => 'properties/property-img26.png',
            default => 'properties/property-img1.png',
        });
    }

    /** "Approved", "Pending review" or "Rejected" for room badges. */
    public function reviewState(): string
    {
        if ($this->isApproved()) {
            return 'live';
        }

        return ($this->kind() === 'design' && $this->status === 'rejected') || $this->rejection_reason ? 'rejected' : 'pending';
    }

    public function isApproved(): bool
    {
        return $this->kind() === 'design' ? $this->status === 'approved' : (bool) $this->is_approved;
    }

    /** Listings a user can manage (submitted, owned, brought in as partner, or as agent). */
    public function scopeManagedBy(Builder $query, User $user): Builder
    {
        $agentId = $user->agent?->id;

        return $query->where(function ($q) use ($user, $agentId) {
            $q->where('user_id', $user->id)
                ->orWhere('owner_user_id', $user->id)
                ->orWhere('partner_id', $user->id);
            if ($agentId) {
                $q->orWhere('agent_id', $agentId);
            }
        });
    }

    public function scopePubliclyVisible(Builder $query): Builder
    {
        static::listingKind() === 'design'
            ? $query->where('status', 'approved')
            : $query->where('is_approved', true);

        // Optional (Admin → Settings): hide listings whose paid period has run out.
        if (\App\Support\Settings::number('listings.hide_expired') >= 1) {
            $query->where(fn ($q) => $q->whereNull('listing_expires_at')->orWhere('listing_expires_at', '>=', now()));
        }

        return $query;
    }
}
