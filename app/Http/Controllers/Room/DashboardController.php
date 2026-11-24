<?php

namespace App\Http\Controllers\Room;

use App\Http\Controllers\Controller;
use App\Models\ArchitecturalDesign;
use App\Models\House;
use App\Models\Land;
use App\Support\Listing;
use App\Support\ListingRef;
use Illuminate\Http\Request;

/**
 * Dashboards for the property owner, client and independent partner rooms.
 * (Agents keep their dashboard at /panel/agent/dashboard.)
 */
class DashboardController extends Controller
{
    public function home(Request $request)
    {
        return redirect()->route($request->user()->redirectRoute());
    }

    public function owner(Request $request)
    {
        $user = $request->user();
        $listings = $this->managedListings($user);

        return view('room.dashboards.owner', [
            'user' => $user,
            'stats' => [
                'listings' => $listings->count(),
                'live' => $listings->filter->isApproved()->count(),
                'inquiries' => $user->inquiriesReceived()->where('status', 'new')->count(),
                'viewings' => $user->viewingsHosted()->where('status', 'requested')->count(),
                'offers' => $user->offersReceived()->where('status', 'pending')->count(),
                'messages' => $user->unreadMessagesCount(),
                'views' => $listings->sum('views_count'),
            ],
            'listings' => $listings->take(6),
            'inquiries' => $user->inquiriesReceived()->with('listable')->latest()->take(5)->get(),
            'viewings' => $user->viewingsHosted()->with(['listable', 'client'])->whereIn('status', ['requested', 'confirmed'])
                ->where('scheduled_at', '>=', now()->startOfDay())->orderBy('scheduled_at')->take(5)->get(),
            'offers' => $user->offersReceived()->with(['listable', 'client'])->whereIn('status', ['pending', 'countered'])->latest()->take(5)->get(),
        ]);
    }

    public function client(Request $request)
    {
        $user = $request->user();
        $savedListings = $user->savedListings()->with('listable')->latest()->take(4)->get()->map->listable->filter();

        return view('room.dashboards.client', [
            'user' => $user,
            'stats' => [
                'saved' => $user->savedListings()->count(),
                'inquiries' => $user->inquiriesSent()->count(),
                'viewings' => $user->viewingsRequested()->whereIn('status', ['requested', 'confirmed'])->count(),
                'offers' => $user->offersMade()->whereIn('status', ['pending', 'countered'])->count(),
                'messages' => $user->unreadMessagesCount(),
            ],
            'saved' => Listing::collect($savedListings),
            'viewings' => $user->viewingsRequested()->with(['listable', 'host'])->whereIn('status', ['requested', 'confirmed'])
                ->orderBy('scheduled_at')->take(5)->get(),
            'offers' => $user->offersMade()->with('listable')->latest()->take(5)->get(),
            'recommended' => Listing::collect(
                House::publiclyVisible()->with(['images'])->latest()->take(4)->get(),
                Land::publiclyVisible()->with(['images'])->latest()->take(2)->get(),
            )->take(6),
        ]);
    }

    public function partner(Request $request)
    {
        $user = $request->user();
        $listings = $this->managedListings($user);
        $pipeline = $user->referrals()->selectRaw('status, count(*) as total')->groupBy('status')->pluck('total', 'status');

        return view('room.dashboards.partner', [
            'user' => $user,
            'profile' => $user->partnerProfile,
            'stats' => [
                'listings' => $listings->count(),
                'referrals' => $pipeline->sum(),
                'converted' => (int) ($pipeline['converted'] ?? 0),
                'earned' => $user->commissions()->whereIn('status', ['approved', 'paid'])->sum('amount'),
                'pending' => $user->commissions()->where('status', 'pending')->sum('amount'),
                'assigned' => $user->assignedListings()->count(),
            ],
            'pipeline' => $pipeline,
            'referrals' => $user->referrals()->latest()->take(5)->get(),
            'listings' => $listings->take(5),
            'commissions' => $user->commissions()->with('listable')->latest()->take(5)->get(),
        ]);
    }

    private function managedListings($user)
    {
        return ListingRef::collect(fn ($q) => $q->managedBy($user)->with('activePromotion')->withCount(['inquiries', 'saves']))
            ->sortByDesc('created_at')->values();
    }
}
