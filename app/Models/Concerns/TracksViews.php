<?php

// ══════════════════════════════════════════════════════════════════════════════
// FILE: app/Models/Concerns/TracksViews.php
//
// Add this trait to JobListing:
//
//   use App\Models\Concerns\TracksViews;
//
//   class JobListing extends Model {
//       use TracksViews;
//       ...
//   }
// ══════════════════════════════════════════════════════════════════════════════

namespace App\Models\Concerns;

use App\Models\JobListingView;
use Illuminate\Http\Request;

trait TracksViews
{
    // ── Relationships ────────────────────────────────────────────────────────

    public function views()
    {
        return $this->hasMany(JobListingView::class);
    }

    // ── Core recording method ────────────────────────────────────────────────

    /**
     * Record a view for this listing from the given request.
     * Deduplicates within the same session and updates the denormalised counters.
     *
     * Call from your controller's show() method.
     */
    public function recordView(Request $request): void
    {
        // Only track active listings
        if ($this->status !== 'active') {
            return;
        }

        $ip        = $request->ip();
        $sessionId = $request->session()->getId();
        $userAgent = $request->userAgent();
        $isBot     = JobListingView::detectBot($userAgent);

        // Skip bots from session deduplication but still record them
        $alreadyThisSession = !$isBot && JobListingView::where('job_listing_id', $this->id)
            ->where('session_id', $sessionId)
            ->exists();

        if ($alreadyThisSession) {
            return; // same browser tab / session already counted
        }

        // A "unique" view = first time this IP hits this listing ever
        $isUnique = !$isBot && !JobListingView::where('job_listing_id', $this->id)
            ->where('ip_address', $ip)
            ->exists();

        JobListingView::create([
            'job_listing_id' => $this->id,
            'user_id'        => auth()->id(),
            'ip_address'     => $ip,
            'session_id'     => $sessionId,
            'user_agent'     => $userAgent,
            'is_unique'      => $isUnique,
            'is_bot'         => $isBot,
            'viewed_at'      => now(),
        ]);

        // Increment denormalised counters (no full model reload)
        if (!$isBot) {
            $this->increment('views_count');

            if ($isUnique) {
                $this->increment('unique_views_count');
            }
        }
    }

    // ── Convenience analytics helpers ────────────────────────────────────────

    public function viewsToday(): int
    {
        return $this->views()->real()->today()->count();
    }

    public function viewsThisWeek(): int
    {
        return $this->views()->real()->thisWeek()->count();
    }

    public function viewsThisMonth(): int
    {
        return $this->views()->real()->thisMonth()->count();
    }

    /**
     * Returns an array of ['date' => 'YYYY-MM-DD', 'views' => N]
     * for the last $days days — used to render the sparkline chart.
     */
    public function dailyViewsForPast(int $days = 14): array
    {
        $rows = $this->views()
            ->real()
            ->where('viewed_at', '>=', now()->subDays($days - 1)->startOfDay())
            ->selectRaw('DATE(viewed_at) as date, COUNT(*) as views')
            ->groupBy('date')
            ->orderBy('date')
            ->pluck('views', 'date')
            ->toArray();

        // Fill in missing days with zero so the chart has no gaps
        $result = [];
        for ($i = $days - 1; $i >= 0; $i--) {
            $date          = now()->subDays($i)->format('Y-m-d');
            $result[$date] = $rows[$date] ?? 0;
        }

        return $result;
    }
}


// ══════════════════════════════════════════════════════════════════════════════
// CONTROLLER SNIPPET — add/update your show() method
// In: app/Http/Controllers/Admin/JobListingController.php
// ══════════════════════════════════════════════════════════════════════════════

/*

public function show(Request $request, JobListing $jobListing): \Illuminate\View\View
{
    // Eager-load the package relationship (used in billing card)
    $jobListing->load('listingPackage');

    // Record the view — trait handles deduplication & bot filtering
    $jobListing->recordView($request);

    // Precompute analytics for the view
    $viewStats = [
        'total'        => $jobListing->views_count,
        'unique'       => $jobListing->unique_views_count,
        'today'        => $jobListing->viewsToday(),
        'this_week'    => $jobListing->viewsThisWeek(),
        'this_month'   => $jobListing->viewsThisMonth(),
        'daily_chart'  => $jobListing->dailyViewsForPast(14), // ['Y-m-d' => count, ...]
    ];

    return view('admin.job-listings.show', compact('jobListing', 'viewStats'));
}

*/