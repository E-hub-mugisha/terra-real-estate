<?php

namespace App\Http\Controllers\Users;

use App\Http\Controllers\Controller;
use App\Models\ConsultantBooking;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UsersClientController extends Controller
{
    public function index(Request $request)
    {
        $consultant = Auth::user()->consultant;
 
        if (! $consultant) {
            abort(403, 'No consultant profile found for this account.');
        }
 
        // All unique clients who booked this consultant
        $clientsQuery = User::whereHas('consultantBookings', function ($q) use ($consultant) {
            $q->where('consultant_id', $consultant->id);
        })->withCount([
            'consultantBookings as total_bookings' => fn($q) => $q->where('consultant_id', $consultant->id),
            'consultantBookings as confirmed_bookings' => fn($q) => $q->where('consultant_id', $consultant->id)->where('status', 'confirmed'),
            'consultantBookings as pending_bookings' => fn($q) => $q->where('consultant_id', $consultant->id)->where('status', 'pending'),
        ])->withSum(
            ['consultantBookings as total_paid' => fn($q) => $q->where('consultant_id', $consultant->id)->where('payment_status', 'paid')],
            'fee'
        )->with([
            'consultantBookings' => fn($q) => $q->where('consultant_id', $consultant->id)->latest()->limit(1),
        ]);
 
        // Search
        if ($request->filled('search')) {
            $search = $request->search;
            $clientsQuery->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%");
            });
        }
 
        // Filter by booking status
        if ($request->filled('status')) {
            $clientsQuery->whereHas('consultantBookings', function ($q) use ($consultant, $request) {
                $q->where('consultant_id', $consultant->id)->where('status', $request->status);
            });
        }
 
        // Sort
        $sort = $request->get('sort', 'latest');
        match ($sort) {
            'name'     => $clientsQuery->orderBy('name'),
            'bookings' => $clientsQuery->orderByDesc('total_bookings'),
            'revenue'  => $clientsQuery->orderByDesc('total_paid'),
            default    => $clientsQuery->orderByDesc('created_at'),
        };
 
        $clients = $clientsQuery->paginate(12)->withQueryString();
 
        $totalClients   = User::whereHas('consultantBookings', fn($q) => $q->where('consultant_id', $consultant->id))->count();
        $totalRevenue   = ConsultantBooking::where('consultant_id', $consultant->id)->where('payment_status', 'paid')->sum('fee');
        $returningCount = User::whereHas('consultantBookings', function ($q) use ($consultant) {
            $q->where('consultant_id', $consultant->id)->havingRaw('COUNT(*) > 1');
        }, '>=', 2)->count();
 
        return view('users.clients.index', compact(
            'clients',
            'totalClients',
            'totalRevenue',
            'returningCount',
        ));
    }
 
    public function show(Request $request, User $client)
    {
        $consultant = Auth::user()->consultant;
 
        if (! $consultant) {
            abort(403, 'No consultant profile found for this account.');
        }
 
        // Ensure this client has at least one booking with this consultant
        $hasBooking = ConsultantBooking::where('consultant_id', $consultant->id)
            ->where('user_id', $client->id)
            ->exists();
 
        if (! $hasBooking) {
            abort(404, 'Client not found.');
        }
 
        $bookingsQuery = ConsultantBooking::where('consultant_id', $consultant->id)
            ->where('user_id', $client->id)
            ->with('service');
 
        // Filter by status
        if ($request->filled('status')) {
            $bookingsQuery->where('status', $request->status);
        }
 
        $bookings = $bookingsQuery->latest()->paginate(10)->withQueryString();
 
        // Stats for this client
        $totalBookings    = ConsultantBooking::where('consultant_id', $consultant->id)->where('user_id', $client->id)->count();
        $confirmedCount   = ConsultantBooking::where('consultant_id', $consultant->id)->where('user_id', $client->id)->where('status', 'confirmed')->count();
        $pendingCount     = ConsultantBooking::where('consultant_id', $consultant->id)->where('user_id', $client->id)->where('status', 'pending')->count();
        $rejectedCount    = ConsultantBooking::where('consultant_id', $consultant->id)->where('user_id', $client->id)->where('status', 'rejected')->count();
        $totalSpent       = ConsultantBooking::where('consultant_id', $consultant->id)->where('user_id', $client->id)->where('payment_status', 'paid')->sum('fee');
        $firstBookingDate = ConsultantBooking::where('consultant_id', $consultant->id)->where('user_id', $client->id)->oldest()->value('created_at');
        $lastBookingDate  = ConsultantBooking::where('consultant_id', $consultant->id)->where('user_id', $client->id)->latest()->value('created_at');
 
        return view('users.clients.show', compact(
            'client',
            'bookings',
            'totalBookings',
            'confirmedCount',
            'pendingCount',
            'rejectedCount',
            'totalSpent',
            'firstBookingDate',
            'lastBookingDate',
        ));
    }
}
