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
 
        // Super-admin bypass — users with role 'administrator' pass everything
        if ($user->hasRole('administrator')) {
            return $next($request);
        }
 
        // Check if user has any of the required permissions
        if (!$user->hasAnyPermission($permissions)) {
            if ($request->expectsJson()) {
                return response()->json(['message' => 'Unauthorized.'], 403);
            }
 
            abort(403, 'You do not have permission to perform this action.');
        }
 
        return $next($request);
    }
}
