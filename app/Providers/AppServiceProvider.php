<?php

namespace App\Providers;

use App\Models\Permission as ModelsPermission;
use Illuminate\Support\ServiceProvider;
use App\Services\PermissionService;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Blade;
use App\Models\{Land, House, Agent, Consultant, Professional, ArchitecturalDesign, Tender, Blog, Advertisement, Announcement};
use App\Observers\{LandObserver, HouseObserver, AgentObserver, ConsultantObserver, ProfessionalObserver, ArchitecturalObserver, TenderObserver, BlogPostObserver, AdvertisementObserver, AnnouncementObserver};

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton(PermissionService::class);
    }

    // public function boot(): void
    // {
    //     // Dynamically register all permissions as Gates
    //     try {
    //         ModelsPermission::all()->each(function ($permission) {
    //             Gate::define(
    //                 $permission->name,
    //                 fn($user) =>
    //                 $user->hasPermissionTo($permission->name)
    //             );
    //         });
    //     } catch (\Exception $e) {
    //         // Silently fail before migrations run
    //     }
    // }

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

        Land::observe(LandObserver::class);
        House::observe(HouseObserver::class);
        Agent::observe(AgentObserver::class);
        Consultant::observe(ConsultantObserver::class);
        Professional::observe(ProfessionalObserver::class);
        ArchitecturalDesign::observe(ArchitecturalObserver::class);
        Tender::observe(TenderObserver::class);
        Blog::observe(BlogPostObserver::class);
        Advertisement::observe(AdvertisementObserver::class);
        Announcement::observe(AnnouncementObserver::class);
    }
}
