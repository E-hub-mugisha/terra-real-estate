<?php

namespace App\Http\Controllers\Room;

use App\Http\Controllers\Controller;
use App\Support\ListingRef;
use Illuminate\Http\Request;

/**
 * Earnings (agents & partners), listing performance (owners, agents, partners)
 * and listings assigned by admin (agents & partners).
 */
class InsightController extends Controller
{
    public function earnings(Request $request)
    {
        $user = $request->user();
        $commissions = $user->commissions()->with('listable')
            ->when($request->query('status'), fn ($q, $s) => $q->where('status', $s))
            ->latest()->paginate(20)->withQueryString();

        $totals = $user->commissions()->selectRaw('status, sum(amount) as total, count(*) as n')->groupBy('status')->get()->keyBy('status');
        $byMonth = $user->commissions()->where('status', '!=', 'cancelled')
            ->where('created_at', '>=', now()->subMonthsNoOverflow(5)->startOfMonth())
            ->get()->groupBy(fn ($c) => $c->created_at->format('Y-m'))->map->sum('amount');
        $months = collect(range(5, 0))->mapWithKeys(fn ($i) => [now()->subMonthsNoOverflow($i)->format('Y-m') => 0])->merge($byMonth);

        return view('room.earnings.index', compact('commissions', 'totals', 'months'));
    }

    public function performance(Request $request)
    {
        $user = $request->user();
        $listings = ListingRef::collect(fn ($q) => $q->managedBy($user)
            ->with('activePromotion')
            ->withCount(['inquiries', 'viewings', 'offers', 'saves']))
            ->sortByDesc('views_count')->values();

        $totals = [
            'views' => $listings->sum('views_count'),
            'unique' => $listings->sum('unique_views_count'),
            'inquiries' => $listings->sum('inquiries_count'),
            'saves' => $listings->sum('saves_count'),
            'viewings' => $listings->sum('viewings_count'),
            'offers' => $listings->sum('offers_count'),
        ];
        $totals['conversion'] = $totals['views'] > 0 ? round($totals['inquiries'] / $totals['views'] * 100, 1) : 0;

        return view('room.performance.index', compact('listings', 'totals'));
    }

    public function assigned(Request $request)
    {
        $assignments = $request->user()->assignedListings()->with(['listable', 'assigner'])->latest()->get()
            ->filter(fn ($a) => $a->listable);

        return view('room.assigned.index', compact('assignments'));
    }
}
