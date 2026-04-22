<?php

namespace App\Models\Concerns;

use App\Models\ModelView;
use Illuminate\Http\Request;

/**
 * Generic view-tracking trait.
 *
 * Works for ANY model — lands, houses, jobs, news, etc.
 * Uses the shared polymorphic `model_views` table.
 *
 * Usage — add to any model:
 *
 *   use App\Models\Concerns\TracksViews;
 *
 *   class Land extends Model {
 *       use TracksViews;
 *   }
 *
 * Optional: override $viewableStatus to control which status value
 * means "this record is public and should be tracked":
 *
 *   protected string $viewableStatus = 'published'; // default: 'active'
 *
 * If your model has NO status column (e.g. News always public), set:
 *
 *   protected bool $requiresActiveStatus = false;
 */
trait TracksViews
{
    // ── Relationship ─────────────────────────────────────────────────────────

    public function views()
    {
        return $this->morphMany(ModelView::class, 'viewable');
    }

    // ── Core recording ───────────────────────────────────────────────────────

    public function recordView(Request $request): void
    {
        // Respect status gate (can be disabled per model)
        if ($this->shouldGateOnStatus() && ! $this->isViewable()) {
            return;
        }

        $ip        = $request->ip();
        $sessionId = $request->session()->getId();
        $userAgent = $request->userAgent();
        $isBot     = ModelView::detectBot($userAgent);

        // Same session = same browser tab, skip
        $alreadyThisSession = ! $isBot && ModelView::where('viewable_type', get_class($this))
            ->where('viewable_id', $this->id)
            ->where('session_id', $sessionId)
            ->exists();

        if ($alreadyThisSession) {
            return;
        }

        // First time this IP has ever hit this specific record
        $isUnique = ! $isBot && ! ModelView::where('viewable_type', get_class($this))
            ->where('viewable_id', $this->id)
            ->where('ip_address', $ip)
            ->exists();

        ModelView::create([
            'viewable_type' => get_class($this),
            'viewable_id'   => $this->id,
            'user_id'       => auth()->id(),
            'ip_address'    => $ip,
            'session_id'    => $sessionId,
            'user_agent'    => $userAgent,
            'is_unique'     => $isUnique,
            'is_bot'        => $isBot,
            'viewed_at'     => now(),
        ]);

        if (! $isBot) {
            $this->increment('views_count');

            if ($isUnique) {
                $this->increment('unique_views_count');
            }
        }
    }

    // ── Status gating helpers ─────────────────────────────────────────────────

    protected function shouldGateOnStatus(): bool
    {
        return property_exists($this, 'requiresActiveStatus')
            ? $this->requiresActiveStatus
            : true;
    }

    protected function isViewable(): bool
    {
        $statusColumn = 'status';
        $activeValue  = property_exists($this, 'viewableStatus')
            ? $this->viewableStatus
            : 'active';

        return isset($this->$statusColumn) && $this->$statusColumn === $activeValue;
    }

    // ── Analytics helpers ────────────────────────────────────────────────────

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
     * Returns ['Y-m-d' => count] for the last N days (gaps filled with 0).
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

        $result = [];
        for ($i = $days - 1; $i >= 0; $i--) {
            $date          = now()->subDays($i)->format('Y-m-d');
            $result[$date] = $rows[$date] ?? 0;
        }

        return $result;
    }
}