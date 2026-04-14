<?php

namespace App\Providers;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;
use App\Models\Permission;

class AuthServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        // ── 1. Register a Gate for every permission in the DB ────
        // Gates are cached per-request via the closure below.
        // Usage in controllers: Gate::authorize('delete');
        // Usage in Blade:       @can('delete') … @endcan
        $this->registerPermissionGates();

        // ── 2. Custom Blade directives ───────────────────────────
        // @permission('edit') … @endpermission
        Blade::if('permission', function (string $permission) {
            return auth()->check() && auth()->user()->hasPermission($permission);
        });

        // @role('administrator') … @endrole
        Blade::if('role', function (string $role) {
            return auth()->check() && auth()->user()->hasRole($role);
        });
    }

    private function registerPermissionGates(): void
    {
        try {
            Permission::all()->each(function ($permission) {
                Gate::define($permission->name, function ($user) use ($permission) {
                    return $user->hasPermission($permission->name);
                });
            });
        } catch (\Exception $e) {
            // Silently skip if DB is not yet migrated (e.g. during fresh install)
        }
    }
}
