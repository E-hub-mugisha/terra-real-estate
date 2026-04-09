<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Mail\BookingConfirmedClient;
use App\Mail\BookingConfirmedConsultant;
use App\Models\ConsultantBooking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class BookingAdminController extends Controller
{
    public function index(Request $request)
    {
        $bookings = ConsultantBooking::with('consultant')
            ->when($request->status, fn($q, $s) => $q->where('status', $s))
            ->when($request->search, fn($q, $s) => $q->where(function ($q) use ($s) {
                $q->where('reference', 'like', "%$s%")
                    ->orWhere('client_name', 'like', "%$s%")
                    ->orWhere('client_email', 'like', "%$s%");
            }))
            ->latest()
            ->paginate(20);

        $counts = [
            'pending'   => ConsultantBooking::where('status', 'pending')->count(),
            'confirmed' => ConsultantBooking::where('status', 'confirmed')->count(),
            'rejected'  => ConsultantBooking::where('status', 'rejected')->count(),
        ];

        return view('admin.bookings.index', compact('bookings', 'counts'));
    }

    public function show(ConsultantBooking $booking)
    {
        $booking->load('consultant', 'service', 'user');
        return view('admin.bookings.show', compact('booking'));
    }

    public function confirm(ConsultantBooking $booking)
    {
        abort_if(! $booking->isPending(), 403, 'Already processed.');

        $booking->update(['status' => 'confirmed', 'confirmed_at' => now()]);

        Mail::to($booking->client_email)->send(new BookingConfirmedClient($booking));
        Mail::to($booking->consultant->email)->send(new BookingConfirmedConsultant($booking));

        return back()->with('success', 'Booking confirmed and emails sent.');
    }

    public function reject(ConsultantBooking $booking)
    {
        abort_if(! $booking->isPending(), 403, 'Already processed.');

        $booking->update(['status' => 'rejected', 'payment_status' => 'refunded']);

        // Mail::to($booking->client_email)->send(new BookingRejectedClient($booking));

        return back()->with('success', 'Booking rejected.');
    }
}
