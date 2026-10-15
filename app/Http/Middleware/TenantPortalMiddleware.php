<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class TenantPortalMiddleware
{
    public function handle(
        Request $request,
        Closure $next
    ): Response {
        $user = $request->user();

        if (!$user) {
            return redirect()->route('login');
        }

        if ($user->role !== 'tenant') {
            abort(403, 'You are not authorized to access the tenant portal.');
        }

        // A tenant account must have a linked tenant profile.
        if (!$user->tenantProfile) {
            abort(403, 'Your tenant profile has not been linked to your account. Please contact the property manager.');
        }

        return $next($request);
    }
}