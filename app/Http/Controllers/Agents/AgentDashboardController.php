<?php

namespace App\Http\Controllers\Agents;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\AgentCommission;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AgentDashboardController extends Controller
{
    public function index()
    {
        $user  = Auth::user();
        $agent = $user->agent()->with(['level', 'reviews', 'commissions'])->first();
 
        // ── Commission stats ──────────────────────────────────────
        $totalCommission = $agent?->commissions()->sum(DB::raw('listing_commission + sale_commission')) ?? 0;
 
        $thisMonthCommission = $agent?->commissions()
            ->whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->sum(DB::raw('listing_commission + sale_commission')) ?? 0;
 
        $lastMonthCommission = $agent?->commissions()
            ->whereMonth('created_at', now()->subMonth()->month)
            ->whereYear('created_at', now()->subMonth()->year)
            ->sum(DB::raw('listing_commission + sale_commission')) ?? 0;
 
        $commissionGrowth = $lastMonthCommission > 0
            ? round((($thisMonthCommission - $lastMonthCommission) / $lastMonthCommission) * 100, 1)
            : ($thisMonthCommission > 0 ? 100 : 0);
 
        // ── Commission chart (last 6 months) ─────────────────────
        $commissionChart = collect(range(5, 0))->map(function ($i) use ($agent) {
            $month = now()->subMonths($i);
            return [
                'label'  => $month->format('M'),
                'amount' => (int) ($agent?->commissions()
                    ->whereMonth('created_at', $month->month)
                    ->whereYear('created_at', $month->year)
                    ->sum(DB::raw('listing_commission + sale_commission')) ?? 0),
            ];
        });
 
        // ── Reviews ───────────────────────────────────────────────
        $avgRating    = $agent?->reviews()->avg('rating') ?? 0;
        $reviewCount  = $agent?->reviews()->count() ?? 0;
 
        // ── Recent commissions ────────────────────────────────────
        $recentCommissions = $agent?->commissions()
            ->with('listingPackage')
            ->latest()
            ->limit(6)
            ->get() ?? collect();
 
        // ── Level progress ────────────────────────────────────────
        $levelThresholds = [
            'bronze' => ['referrals' => 0,   'revenue' => 0],
            'silver' => ['referrals' => 10,  'revenue' => 500_000],
            'gold'   => ['referrals' => 30,  'revenue' => 2_000_000],
            'elite'  => ['referrals' => 75,  'revenue' => 10_000_000],
        ];
 
        $currentLevelName = strtolower($agent?->level?->level_name ?? 'bronze');
        $levels           = array_keys($levelThresholds);
        $currentIndex     = array_search($currentLevelName, $levels);
        $nextLevelName    = $levels[min($currentIndex + 1, count($levels) - 1)] ?? null;
        $nextThreshold    = $levelThresholds[$nextLevelName] ?? null;
 
        $referralProgress = $nextThreshold
            ? min(100, round(($agent?->total_referrals ?? 0) / max($nextThreshold['referrals'], 1) * 100))
            : 100;
 
        $revenueProgress = $nextThreshold
            ? min(100, round(($agent?->total_revenue_generated ?? 0) / max($nextThreshold['revenue'], 1) * 100))
            : 100;
 
        return view('agents.dashboard.index', [
            'isVerified'          => (bool) $user->is_verified,
            'agent'               => $agent,
            'user'                => $user,
 
            // Commission
            'totalCommission'     => $totalCommission,
            'thisMonthCommission' => $thisMonthCommission,
            'lastMonthCommission' => $lastMonthCommission,
            'commissionGrowth'    => $commissionGrowth,
            'commissionChart'     => $commissionChart,
 
            // Reviews
            'avgRating'           => round($avgRating, 1),
            'reviewCount'         => $reviewCount,
 
            // Activity
            'totalReferrals'      => $agent?->total_referrals ?? 0,
            'totalRevenue'        => $agent?->total_revenue_generated ?? 0,
            'recentCommissions'   => $recentCommissions,
 
            // Level
            'currentLevel'        => $currentLevelName,
            'nextLevel'           => $nextLevelName,
            'referralProgress'    => $referralProgress,
            'revenueProgress'     => $revenueProgress,
            'saleCommissionRate'  => $agent?->getSaleCommissionRate() ?? 0,
        ]);
    }
}
