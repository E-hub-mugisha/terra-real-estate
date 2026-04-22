<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckPermission
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string ...$permissions): Response
    {
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        $user = auth()->user();

        // Administrator column bypass (before pivot table was seeded)
        if ($user->role === 'administrator' || $user->hasRole('administrator')) {
            return $next($request);
        }

        if (!$user->hasAnyPermission($permissions)) {
            if ($request->expectsJson()) {
                return response()->json(['message' => 'Unauthorized.'], 403);
            }

            return redirect()->back()->with('permission_denied', 'You do not have permission to perform this action.');
        }

        return $next($request);
    }
}
