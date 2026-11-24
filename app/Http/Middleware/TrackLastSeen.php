<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Records when a signed-in user was last active (at most once every 5 minutes)
 * and blocks accounts an admin has deactivated.
 */
class TrackLastSeen
{
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        if ($user && $user->is_active === false) {
            auth()->guard('web')->logout();
            $request->session()->invalidate();

            return redirect()->route('login')->withErrors(['email' => 'Your account has been deactivated. Contact Terra support.']);
        }

        if ($user && (!$user->last_seen_at || $user->last_seen_at->lt(now()->subMinutes(5)))) {
            $user->forceFill(['last_seen_at' => now()])->saveQuietly();
        }

        return $next($request);
    }
}
