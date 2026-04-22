<?php

namespace App\Http\Controllers\Users;

use App\Http\Controllers\Controller;
use App\Models\ConsultantBooking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UsersDashboardController extends Controller
{
    public function index()
    {
        $consultant = Auth::user()->consultant;

        $bookingsQuery = ConsultantBooking::where('consultant_id', $consultant->id);

        $totalBookings    = (clone $bookingsQuery)->count();
        $confirmedBookings = (clone $bookingsQuery)->where('status', 'confirmed')->count();
        $pendingBookings  = (clone $bookingsQuery)->where('status', 'pending')->count();
        $rejectedBookings = (clone $bookingsQuery)->where('status', 'rejected')->count();

        $totalEarnings = (clone $bookingsQuery)
            ->where('payment_status', 'paid')
            ->sum('fee');

        $recentBookings = (clone $bookingsQuery)
            ->with('service')
            ->latest()
            ->take(8)
            ->get();

        $upcomingBookings = (clone $bookingsQuery)
            ->with('service')
            ->whereIn('status', ['confirmed', 'pending'])
            ->where('appointment_date', '>=', now()->toDateString())
            ->orderBy('appointment_date')
            ->take(5)
            ->get();

        // This month
        $monthBookings  = (clone $bookingsQuery)->whereMonth('created_at', now()->month)->whereYear('created_at', now()->year)->count();
        $monthConfirmed = (clone $bookingsQuery)->where('status', 'confirmed')->whereMonth('created_at', now()->month)->whereYear('created_at', now()->year)->count();

        $uniqueClients  = (clone $bookingsQuery)->distinct('user_id')->count('user_id');
        $activeServices = $consultant->services()->count();

        return view('users.dashboard.index', compact(
            'totalBookings',
            'confirmedBookings',
            'pendingBookings',
            'rejectedBookings',
            'totalEarnings',
            'recentBookings',
            'upcomingBookings',
            'monthBookings',
            'monthConfirmed',
            'uniqueClients',
            'activeServices'
        ));
    }
}
