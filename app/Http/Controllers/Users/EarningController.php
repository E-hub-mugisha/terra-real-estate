<?php

namespace App\Http\Controllers\Users;

use App\Http\Controllers\Controller;
use App\Models\ConsultantBooking;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EarningController extends Controller
{
    public function index()
    {
        $consultantId = Auth::user()->consultant->id;

        // All paid bookings (used for totals)
        $allPaid = ConsultantBooking::where('consultant_id', $consultantId)
            ->whereIn('payment_status', ['paid', 'escrow', 'pending'])
            ->get();

        // ── Summary stats ──────────────────────────────────────
        $totalEarned = ConsultantBooking::where('consultant_id', $consultantId)
            ->where('payment_status', 'paid')
            ->sum('fee');

        $totalBookingCount = ConsultantBooking::where('consultant_id', $consultantId)
            ->where('payment_status', 'paid')
            ->count();

        $now           = Carbon::now();
        $startOfMonth  = $now->copy()->startOfMonth();
        $startOfLast   = $now->copy()->subMonth()->startOfMonth();
        $endOfLast     = $now->copy()->subMonth()->endOfMonth();

        $thisMonthEarned = ConsultantBooking::where('consultant_id', $consultantId)
            ->where('payment_status', 'paid')
            ->whereBetween('appointment_date', [$startOfMonth, $now])
            ->sum('fee');

        $lastMonthEarned = ConsultantBooking::where('consultant_id', $consultantId)
            ->where('payment_status', 'paid')
            ->whereBetween('appointment_date', [$startOfLast, $endOfLast])
            ->sum('fee');

        $lastMonthCount = ConsultantBooking::where('consultant_id', $consultantId)
            ->where('payment_status', 'paid')
            ->whereBetween('appointment_date', [$startOfLast, $endOfLast])
            ->count();

        // % change vs last month
        $monthlyChange = $lastMonthEarned > 0
            ? round((($thisMonthEarned - $lastMonthEarned) / $lastMonthEarned) * 100)
            : ($thisMonthEarned > 0 ? 100 : 0);

        // Pending / escrow balance
        $pendingBalance = ConsultantBooking::where('consultant_id', $consultantId)
            ->whereIn('payment_status', ['escrow', 'pending'])
            ->sum('fee');

        $pendingCount = ConsultantBooking::where('consultant_id', $consultantId)
            ->whereIn('payment_status', ['escrow', 'pending'])
            ->count();

        // Next payout: last business day of this month (simple heuristic)
        $lastDay = $now->copy()->endOfMonth();
        while ($lastDay->isWeekend()) {
            $lastDay->subDay();
        }
        $nextPayoutDate = $lastDay->format('d M Y');

        // ── Transaction list (with eager loads) ───────────────
        $bookings = ConsultantBooking::where('consultant_id', $consultantId)
            ->with(['service'])
            ->orderByDesc('appointment_date')
            ->get();

        return view('users.earnings.index', compact(
            'totalEarned',
            'totalBookingCount',
            'thisMonthEarned',
            'lastMonthEarned',
            'lastMonthCount',
            'monthlyChange',
            'pendingBalance',
            'pendingCount',
            'nextPayoutDate',
            'bookings'
        ));
    }
}
