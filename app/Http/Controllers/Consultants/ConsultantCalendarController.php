<?php

namespace App\Http\Controllers\Consultants;

use App\Http\Controllers\Controller;
use App\Models\ConsultantBooking;
use App\Models\ConsultantUnavailableDate;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ConsultantCalendarController extends Controller
{
    private function getConsultant()
    {
        $consultant = Auth::user()->consultant;

        if (! $consultant) {
            abort(403, 'No consultant profile found for this account.');
        }

        return $consultant;
    }

    /**
     * Render calendar view with all event data encoded as JSON.
     */
    public function index()
    {
        $consultant = $this->getConsultant();

        // Load all bookings for the calendar (no hard date range — FullCalendar
        // will request only what it needs if we switch to a JSON feed later;
        // for now we load ±6 months which is fast enough)
        $from = now()->subMonths(2)->startOfMonth();
        $to   = now()->addMonths(6)->endOfMonth();

        $bookings = ConsultantBooking::where('consultant_id', $consultant->id)
            ->with('service', 'user')
            ->whereBetween('appointment_date', [$from->toDateString(), $to->toDateString()])
            ->get();

        // Map bookings to FullCalendar event objects
        $events = $bookings->map(function (ConsultantBooking $b) {
            $colorMap = [
                'confirmed' => ['color' => '#1e40af', 'textColor' => '#fff'],   // blue
                'pending'   => ['color' => '#d97706', 'textColor' => '#fff'],   // amber
                'rejected'  => ['color' => '#dc2626', 'textColor' => '#fff'],   // red
                'completed' => ['color' => '#059669', 'textColor' => '#fff'],   // green
            ];

            $palette = $colorMap[$b->status] ?? ['color' => '#6b7280', 'textColor' => '#fff'];

            $time = $b->appointment_time
                ? Carbon::parse($b->appointment_time)->format('H:i')
                : null;

            return [
                'id'              => $b->id,
                'title'           => ($b->user->name ?? 'Client') . ($b->service ? ' · ' . $b->service->name : ''),
                'start'           => $b->appointment_date . ($time ? 'T' . $time : ''),
                'allDay'          => ! $time,
                'backgroundColor' => $palette['color'],
                'borderColor'     => $palette['color'],
                'textColor'       => $palette['textColor'],
                'extendedProps'   => [
                    'bookingId'     => $b->id,
                    'client'        => $b->user->name ?? '—',
                    'email'         => $b->user->email ?? '—',
                    'service'       => $b->service->name ?? '—',
                    'fee'           => number_format($b->fee) . ' RWF',
                    'status'        => ucfirst($b->status),
                    'paymentStatus' => ucfirst($b->payment_status),
                    'notes'         => $b->notes ?? '',
                ],
            ];
        });

        // Unavailable dates → FullCalendar background events
        $unavailableDates = ConsultantUnavailableDate::where('consultant_id', $consultant->id)
            ->whereBetween('date', [$from->toDateString(), $to->toDateString()])
            ->get();

        $blockedEvents = $unavailableDates->map(fn($u) => [
            'id'       => 'blocked_' . $u->id,
            'start'    => $u->date->toDateString(),
            'end'      => $u->date->copy()->addDay()->toDateString(),
            'display'  => 'background',
            'color'    => '#d1d5db',
            'title'    => $u->reason ?? 'Unavailable',
            'extendedProps' => [
                'type'   => 'blocked',
                'reason' => $u->reason ?? 'Unavailable',
                'dateId' => $u->id,
            ],
        ]);

        // Plain list of blocked date strings for the toggle button state
        $blockedDateStrings = $unavailableDates->pluck('date')
            ->map(fn($d) => $d->toDateString())
            ->values();

        return view('users.calendar.index', [
            'events'             => $events->merge($blockedEvents)->values(),
            'blockedDates'       => $blockedDateStrings,
            'totalBookings'      => $bookings->count(),
            'confirmedBookings'  => $bookings->where('status', 'confirmed')->count(),
            'pendingBookings'    => $bookings->where('status', 'pending')->count(),
        ]);
    }

    /**
     * Toggle an unavailable date on/off. Returns JSON.
     */
    public function toggleUnavailable(Request $request)
    {
        $consultant = $this->getConsultant();

        $request->validate([
            'date'   => ['required', 'date', 'date_format:Y-m-d'],
            'reason' => ['nullable', 'string', 'max:255'],
        ]);

        $date = $request->date;

        $existing = ConsultantUnavailableDate::where('consultant_id', $consultant->id)
            ->where('date', $date)
            ->first();

        if ($existing) {
            $existing->delete();
            return response()->json(['blocked' => false, 'date' => $date]);
        }

        ConsultantUnavailableDate::create([
            'consultant_id' => $consultant->id,
            'date'          => $date,
            'reason'        => $request->reason,
        ]);

        return response()->json(['blocked' => true, 'date' => $date]);
    }

    /**
     * Export confirmed bookings as an iCalendar (.ics) file.
     */
    public function exportIcal()
    {
        $consultant = $this->getConsultant();

        $bookings = ConsultantBooking::where('consultant_id', $consultant->id)
            ->whereIn('status', ['confirmed', 'pending'])
            ->with('service', 'user')
            ->get();

        $lines = [
            'BEGIN:VCALENDAR',
            'VERSION:2.0',
            'PRODID:-//Terra Consultants//Calendar//EN',
            'CALSCALE:GREGORIAN',
            'METHOD:PUBLISH',
            'X-WR-CALNAME:My Consulting Schedule',
            'X-WR-TIMEZONE:Africa/Kigali',
        ];

        foreach ($bookings as $b) {
            $dtstart = Carbon::parse($b->appointment_date . ' ' . ($b->appointment_time ?? '00:00:00'));
            $dtend   = $dtstart->copy()->addHour(); // default 1-hour slot

            $uid     = 'booking-' . $b->id . '@terra.rw';
            $summary = 'Booking: ' . ($b->user->name ?? 'Client') . ' — ' . ($b->service->name ?? 'Session');
            $desc    = 'Status: ' . ucfirst($b->status) . '\nFee: ' . number_format($b->fee) . ' RWF';

            $lines[] = 'BEGIN:VEVENT';
            $lines[] = 'UID:' . $uid;
            $lines[] = 'DTSTAMP:' . now()->format('Ymd\THis\Z');
            $lines[] = 'DTSTART:' . $dtstart->format('Ymd\THis');
            $lines[] = 'DTEND:' . $dtend->format('Ymd\THis');
            $lines[] = 'SUMMARY:' . $this->icalEscape($summary);
            $lines[] = 'DESCRIPTION:' . $this->icalEscape($desc);
            $lines[] = 'STATUS:' . ($b->status === 'confirmed' ? 'CONFIRMED' : 'TENTATIVE');
            $lines[] = 'END:VEVENT';
        }

        $lines[] = 'END:VCALENDAR';

        $ical = implode("\r\n", $lines) . "\r\n";

        return response($ical, 200, [
            'Content-Type'        => 'text/calendar; charset=utf-8',
            'Content-Disposition' => 'attachment; filename="consulting-schedule.ics"',
        ]);
    }

    private function icalEscape(string $text): string
    {
        return str_replace(["\r\n", "\n", "\r", ',', ';'], ['\\n', '\\n', '\\n', '\,', '\;'], $text);
    }
}