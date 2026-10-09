<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureTenantPortalAccess
{
    public function handle(
        Request $request,
        Closure $next
    ): Response {
        $user = $request->user();

        if (!$user) {
            return redirect()->route('login');
        }

        $isTenant = $user->hasRole('tenant')
            || $user->role === 'tenant';

        if (!$isTenant) {
            abort(403, 'Tenant portal access is restricted.');
        }

        return $next($request);
    }
}