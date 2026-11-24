<?php

namespace App\Http\Controllers\Agents;

use App\Http\Controllers\Controller;
use App\Models\ArchitecturalDesign;
use App\Models\House;
use App\Models\Land;
use App\Models\ListingPayment;
use Illuminate\Support\Facades\Auth;

class AgentDashboardController extends Controller
{
    public function index()
    {
        $user  = Auth::user();
        $agent = $user->agent;

        $houses  = House::where('user_id', $user->id);
        $lands   = Land::where('user_id', $user->id);
        $designs = ArchitecturalDesign::where('user_id', $user->id);

        // ── Listing counts ────────────────────────────────────────
        $totalHouses  = (clone $houses)->count();
        $totalLands   = (clone $lands)->count();
        $totalDesigns = (clone $designs)->count();

        $pendingApproval = (clone $houses)->where('is_approved', false)->count()
            + (clone $lands)->where('is_approved', false)->count()
            + (clone $designs)->where('is_approved', false)->count();

        // ── Listing fees ──────────────────────────────────────────
        $payments        = ListingPayment::where('user_id', $user->id);
        $feesPaid        = (clone $payments)->where('status', 'completed')->sum('amount');
        $pendingPayments = (clone $payments)->where('status', 'pending')->count();

        // ── Listings added per month (last 6 months) ──────────────
        $listingChart = collect(range(5, 0))->map(function ($i) use ($houses, $lands, $designs) {
            $month = now()->subMonthsNoOverflow($i);
            $count = fn ($query) => (clone $query)
                ->whereMonth('created_at', $month->month)
                ->whereYear('created_at', $month->year)
                ->count();

            return [
                'label' => $month->format('M'),
                'count' => $count($houses) + $count($lands) + $count($designs),
            ];
        });

        // ── Recent listings ───────────────────────────────────────
        $recentListings = collect()
            ->merge((clone $houses)->latest()->take(5)->get()->map(fn ($h) => [
                'title'   => $h->title,
                'type'    => 'House',
                'status'  => $h->status,
                'approved'=> (bool) $h->is_approved,
                'url'     => route('agent.properties.houses.show', $h->id),
                'created' => $h->created_at,
            ]))
            ->merge((clone $lands)->latest()->take(5)->get()->map(fn ($l) => [
                'title'   => $l->title,
                'type'    => 'Land',
                'status'  => $l->status,
                'approved'=> (bool) $l->is_approved,
                'url'     => route('agent.properties.lands.show', $l->id),
                'created' => $l->created_at,
            ]))
            ->merge((clone $designs)->latest()->take(5)->get()->map(fn ($d) => [
                'title'   => $d->title,
                'type'    => 'Design',
                'status'  => $d->status,
                'approved'=> (bool) $d->is_approved,
                'url'     => route('agent.designs.show', $d->id),
                'created' => $d->created_at,
            ]))
            ->sortByDesc('created')
            ->values()
            ->take(6);

        return view('agents.dashboard.index', [
            'isVerified'      => (bool) $agent?->is_verified,
            'agent'           => $agent,
            'user'            => $user,
            'totalHouses'     => $totalHouses,
            'totalLands'      => $totalLands,
            'totalDesigns'    => $totalDesigns,
            'pendingApproval' => $pendingApproval,
            'feesPaid'        => $feesPaid,
            'pendingPayments' => $pendingPayments,
            'listingChart'    => $listingChart,
            'recentListings'  => $recentListings,
            'room' => [
                'inquiries' => $user->inquiriesReceived()->where('status', 'new')->count(),
                'viewings'  => $user->viewingsHosted()->where('status', 'requested')->count(),
                'offers'    => $user->offersReceived()->where('status', 'pending')->count(),
                'leads'     => $user->referrals()->whereNotIn('status', ['converted', 'lost'])->count(),
                'assigned'  => $user->assignedListings()->count(),
                'earned'    => (float) $user->commissions()->whereIn('status', ['approved', 'paid'])->sum('amount'),
                'pending'   => (float) $user->commissions()->where('status', 'pending')->sum('amount'),
            ],
            'latestInquiries' => $user->inquiriesReceived()->with('listable')->latest()->take(5)->get(),
        ]);
    }
}
