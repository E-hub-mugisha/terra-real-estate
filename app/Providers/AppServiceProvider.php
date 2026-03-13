<?php

namespace App\Providers;

use App\Models\Permission as ModelsPermission;
use Illuminate\Support\ServiceProvider;
use App\Services\PermissionService;
use Illuminate\Support\Facades\Gate;
class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton(PermissionService::class);
    }

    public function boot(): void
    {
        // Dynamically register all permissions as Gates
        try {
            ModelsPermission::all()->each(function ($permission) {
                Gate::define($permission->name, fn($user) =>
                    $user->hasPermissionTo($permission->name)
                );
            });
        } catch (\Exception $e) {
            // Silently fail before migrations run
        }
    }
}
