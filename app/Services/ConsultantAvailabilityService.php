<?php

// ─────────────────────────────────────────────────────────────────────────────
// Booking flow: Step 5 — availability sync
// Drop this validation logic into whichever controller handles the booking
// creation / date-selection step of your booking flow.
// ─────────────────────────────────────────────────────────────────────────────

namespace App\Services;

use App\Models\ConsultantUnavailableDate;
use Carbon\Carbon;

class ConsultantAvailabilityService
{
    /**
     * Check whether a consultant is available on a given date.
     *
     * Usage in booking controller:
     *
     *   $service = new ConsultantAvailabilityService();
     *   if (! $service->isAvailable($consultant->id, $request->appointment_date)) {
     *       return back()->withErrors(['appointment_date' => 'The consultant is unavailable on this date.']);
     *   }
     */
    public function isAvailable(int $consultantId, string $date): bool
    {
        return ! ConsultantUnavailableDate::where('consultant_id', $consultantId)
            ->where('date', Carbon::parse($date)->toDateString())
            ->exists();
    }

    /**
     * Return an array of blocked date strings for a consultant within a range.
     * Pass this to your front-end datepicker to disable those dates.
     *
     *   $blocked = $service->blockedDatesInRange($consultant->id, now(), now()->addMonths(3));
     *   // returns ['2024-07-04', '2024-07-05', ...]
     */
    public function blockedDatesInRange(int $consultantId, Carbon $from, Carbon $to): array
    {
        return ConsultantUnavailableDate::where('consultant_id', $consultantId)
            ->whereBetween('date', [$from->toDateString(), $to->toDateString()])
            ->pluck('date')
            ->map(fn($d) => Carbon::parse($d)->toDateString())
            ->toArray();
    }
}
