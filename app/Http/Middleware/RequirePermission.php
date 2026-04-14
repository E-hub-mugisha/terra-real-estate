<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RequirePermission
{
    /**
     * Usage in routes:
     *   Route::post(...)->middleware('permission:add');
     *   Route::delete(...)->middleware('permission:delete');
     */
    public function handle(Request $request, Closure $next, string ...$permissions): Response
    {
        $user = $request->user();

        if (!$user) {
            abort(401, 'Unauthenticated.');
        }

        foreach ($permissions as $permission) {
            if (!$user->hasPermission($permission)) {
                if ($request->expectsJson()) {
                    return response()->json(['error' => 'Forbidden — missing permission: ' . $permission], 403);
                }

                abort(403, "You don't have permission to perform this action.");
            }
        }

        return $next($request);
    }
}
