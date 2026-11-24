<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Services\PermissionService;
use Illuminate\Support\Facades\Blade;
use Illuminate\Pagination\Paginator;

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
        // @permission('approve')  ...  @endpermission
        Blade::directive('permission', function (string $expression) {
            return "<?php if(auth()->check() && auth()->user()->hasPermission({$expression})): ?>";
        });
        Blade::directive('endpermission', fn() => '<?php endif; ?>');

        // @role('administrator')  ...  @endrole
        Blade::directive('role', function (string $expression) {
            return "<?php if(auth()->check() && auth()->user()->hasRole({$expression})): ?>";
        });
        Blade::directive('endrole', fn() => '<?php endif; ?>');

        // @anypermission(['edit','update'])  ...  @endanypermission
        Blade::directive('anypermission', function (string $expression) {
            return "<?php if(auth()->check() && auth()->user()->hasAnyPermission({$expression})): ?>";
        });
        Blade::directive('endanypermission', fn() => '<?php endif; ?>');

        Paginator::useBootstrap();
    }
}
