<?php

namespace App\Services\Marketplace;

use App\Models\Agent;
use App\Models\Commission;
use App\Models\ListingPayment;
use App\Models\Referral;
use App\Models\User;
use App\Support\Settings;
use Illuminate\Database\Eloquent\Model;

/**
 * Agent commissions and partner earnings, using rates set by admin in Settings:
 *  - listing_fee: % of the package fee paid for a listing the agent/partner brought in
 *  - deal:        % of the agreed price when admin marks the listing sold/rented
 *  - referral:    flat reward when a partner's referral converts
 * All entries start as "pending"; admin approves and marks them paid.
 */
class CommissionService
{
    public function forListingPayment(ListingPayment $payment, Model $listing): array
    {
        $created = [];
        foreach ($this->earners($listing) as $role => $user) {
            $rate = Settings::number("commission.{$role}_listing_pct");
            if ($rate <= 0 || $payment->amount <= 0) {
                continue;
            }
            $created[] = Commission::firstOrCreate(
                ['user_id' => $user->id, 'type' => 'listing_fee', 'listing_payment_id' => $payment->id],
                [
                    'role' => $role,
                    'listable_type' => $listing->getMorphClass(),
                    'listable_id' => $listing->getKey(),
                    'base_amount' => $payment->amount,
                    'rate' => $rate,
                    'amount' => round($payment->amount * $rate / 100, 2),
                    'currency' => $payment->currency ?: 'RWF',
                    'status' => 'pending',
                ]
            );
        }

        return $created;
    }

    public function forDeal(Model $listing, float $dealValue, string $currency = 'RWF'): array
    {
        $created = [];
        foreach ($this->earners($listing) as $role => $user) {
            $rate = Settings::number("commission.{$role}_deal_pct");
            if ($rate <= 0 || $dealValue <= 0) {
                continue;
            }
            $created[] = Commission::firstOrCreate(
                ['user_id' => $user->id, 'type' => 'deal', 'listable_type' => $listing->getMorphClass(), 'listable_id' => $listing->getKey()],
                [
                    'role' => $role,
                    'base_amount' => $dealValue,
                    'rate' => $rate,
                    'amount' => round($dealValue * $rate / 100, 2),
                    'currency' => $currency,
                    'status' => 'pending',
                ]
            );
        }

        return $created;
    }

    public function forReferral(Referral $referral): ?Commission
    {
        $amount = Settings::number('commission.partner_referral_flat');
        if ($amount <= 0 || !$referral->referrer?->isPartner()) {
            return null;
        }

        return Commission::firstOrCreate(
            ['user_id' => $referral->referrer_id, 'type' => 'referral', 'notes' => 'Referral #' . $referral->id],
            ['role' => 'partner', 'base_amount' => $amount, 'rate' => 100, 'amount' => $amount, 'currency' => 'RWF', 'status' => 'pending']
        );
    }

    /** @return array<string, User> role => user who earns on this listing */
    private function earners(Model $listing): array
    {
        $earners = [];
        if ($listing->agent_id && ($agentUser = Agent::find($listing->agent_id)?->user)) {
            $earners['agent'] = $agentUser;
        }
        if ($listing->partner_id && ($partner = User::find($listing->partner_id)) && $partner->isPartner()) {
            $earners['partner'] = $partner;
        }

        return $earners;
    }
}
