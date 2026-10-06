<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class PropertyManagementAccess
{
    public function handle(Request $request, Closure $next): Response
    {
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        $user = auth()->user();

        /*
        |--------------------------------------------------------------------------
        | Legacy role column
        |--------------------------------------------------------------------------
        */
        $legacyRoles = [
            'admin',
            'staff',
            'landlord',
            'owner',
            'property_manager',
            'manager',
            'agent',
            'accountant',
        ];

        if (in_array($user->role, $legacyRoles, true)) {
            return $next($request);
        }

        /*
        |--------------------------------------------------------------------------
        | Existing role/permission system
        |--------------------------------------------------------------------------
        */
        $managementRoles = [
            'admin',
            'staff',
            'landlord',
            'property_owner',
            'property_manager',
            'real_estate_agent',
            'accountant',
        ];

        foreach ($managementRoles as $role) {
            if ($user->hasRole($role)) {
                return $next($request);
            }
        }

        /*
        |--------------------------------------------------------------------------
        | Permission-based access
        |--------------------------------------------------------------------------
        */
        if ($user->hasAnyPermission([
            'property_management.view',
            'property_management.manage',
            'property.view',
            'property.manage',
        ])) {
            return $next($request);
        }

        abort(403, 'You do not have permission to access Property Management.');
    }
}