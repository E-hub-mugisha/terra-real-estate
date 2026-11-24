<?php

use App\Http\Controllers\Admin\AdminPropertyPlanController;
use App\Http\Controllers\Admin\ArchitecturalDesignController;
use App\Http\Controllers\Admin\ClientController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\DurationDiscountController;
use App\Http\Controllers\Admin\FacilityController;
use App\Http\Controllers\Admin\ListingPackageController;
use App\Http\Controllers\Admin\PricingPlanController;
use App\Http\Controllers\Admin\Properties\HouseController;
use App\Http\Controllers\Admin\Properties\LandController;
use App\Http\Controllers\Admin\RolePermissionController;
use App\Http\Controllers\Admin\StaffController;
use App\Http\Controllers\Admin\Users\AgentController;
use App\Http\Controllers\Admin\Users\UserController;
use App\Http\Controllers\Agents\AgentDashboardController;
use App\Http\Controllers\Agents\AgentDesignController;
use App\Http\Controllers\Agents\AgentHouseController;
use App\Http\Controllers\Agents\AgentLandController;
use App\Http\Controllers\Agents\AgentProfileController;
use App\Http\Controllers\Agents\HomeAgentController;
use App\Http\Controllers\Front\HomeController;
use App\Http\Controllers\Front\LocationController;
use App\Http\Controllers\Front\MarketplaceController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PropertyPlanController;
use App\Http\Controllers\Admin\MarketplaceController as AdminMarketplaceController;
use App\Http\Controllers\Front\AiAssistantController;
use App\Http\Controllers\Front\PartnerApplicationController;
use App\Http\Controllers\Room\DashboardController as RoomDashboardController;
use App\Http\Controllers\Room\InquiryController as RoomInquiryController;
use App\Http\Controllers\Room\InsightController;
use App\Http\Controllers\Room\ListingController as RoomListingController;
use App\Http\Controllers\Room\MessageController;
use App\Http\Controllers\Room\OfferController;
use App\Http\Controllers\Room\ReferralController;
use App\Http\Controllers\Room\SavedController;
use App\Http\Controllers\Room\ViewingController;
use App\Http\Controllers\Staff\DepartmentController;
use App\Http\Controllers\Staff\PermissionManagerController;
use App\Models\Role;
use App\Models\User;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route;

// =============================================================================
// PUBLIC — Lands, Houses, Architectural Designs, Agents
// =============================================================================

// The marketplace is the homepage. `home` is kept as an alias name for old links.
Route::get('/', [HomeController::class, 'index'])->name('front.home');
Route::permanentRedirect('/marketplace', '/')->name('home');

// ── Agents ───────────────────────────────────────────────────────────────────
Route::get('/agents', [HomeController::class, 'agents'])->name('front.agents');
Route::get('agents/{agent}', [HomeController::class, 'agentDetails'])->name('front.agent.details');
Route::get('/find/agents/near-me', [HomeController::class, 'agentNearMe'])->name('agents.search.near.me');
Route::get('/register/agents', [HomeAgentController::class, 'create'])->name('front.agents.register');
Route::post('/register/agents', [HomeAgentController::class, 'store'])->name('front.agents.register.store');

// ── Houses ───────────────────────────────────────────────────────────────────
Route::get('/buy/homes', [HomeController::class, 'homes'])->name('front.buy.homes');
Route::get('/buy/homes/{home}', [HomeController::class, 'homeDetails'])->name('front.buy.home.details');
Route::post('/home/inquiry', [HomeController::class, 'sendInquiry'])->name('front.buy.home.inquiry');
Route::get('/property/rent/homes', [HomeController::class, 'rentHomes'])->name('front.rent.homes');
Route::get('/apartments/rent', [HomeController::class, 'apartmentsRent'])->name('front.rent.apartments');
Route::get('/short-stays/rent', [HomeController::class, 'shortStaysRent'])->name('front.rent.short-stays');
Route::get('/rent/near-me', [HomeController::class, 'rentNearMe'])->name('rent.search.near.me');

// ── Lands ────────────────────────────────────────────────────────────────────
Route::get('/buy/lands', [HomeController::class, 'lands'])->name('front.buy.lands');
Route::get('/buy/lands/{land}', [HomeController::class, 'landDetails'])->name('front.buy.land.details');
Route::post('/land/inquiry', [HomeController::class, 'sendLandInquiry'])->name('front.buy.land.inquiry');
Route::get('/property/rent/lands', [HomeController::class, 'rentLands'])->name('front.rent.lands');

// ── Combined listings ────────────────────────────────────────────────────────
Route::get('/properties/{province}', [HomeController::class, 'propertiesByProvince'])->name('properties.by.province');
Route::get('/buy/listings', [HomeController::class, 'buy'])->name('front.properties.buy');
Route::get('/rent/listings', [HomeController::class, 'rentHomes'])->name('front.properties.rent');

// ── Architectural Designs ────────────────────────────────────────────────────
Route::get('/architecture/listings', [MarketplaceController::class, 'index'])->name('front.properties.architecture');

Route::prefix('designs')->group(function () {
    Route::get('/', [MarketplaceController::class, 'index'])->name('front.buy.design'); // Marketplace listing
    Route::get('/{slug}', [MarketplaceController::class, 'show'])->name('front.buy.design.show'); // Design details page
    Route::get('/purchase/{slug}', [MarketplaceController::class, 'purchase'])->name('front.buy.design.purchase'); // Purchase page
    Route::post('/inquiry', [MarketplaceController::class, 'sendInquiry'])->name('front.buy.design.inquiry');
    Route::get('download/{slug}', [MarketplaceController::class, 'download'])->name('front.buy.design.download');
});

// ── Listing plans ────────────────────────────────────────────────────────────
Route::post('/plans/momo-pay', [PropertyPlanController::class, 'payMomo'])->name('plans.pay.momo');
Route::get('/select-plan/{type}/{id}', [PropertyPlanController::class, 'selectPlan'])->name('plans.select');
Route::post('/store-plan', [PropertyPlanController::class, 'store'])->name('plans.store');
Route::get('/plan-payment/{order}', [PropertyPlanController::class, 'payment'])->name('plans.payment');

// ── Location dropdowns (Province → District → Sector → Cell → Village) ──────
Route::get('/get-districts/{provinceId}', [LocationController::class, 'getDistricts']);
Route::get('/get-sectors/{districtId}', [LocationController::class, 'getSectors']);
Route::get('/get-cells/{sectorId}', [LocationController::class, 'getCells']);
Route::get('/get-villages/{cellId}', [LocationController::class, 'getVillages']);

// Language switcher
Route::get('/lang/{locale}', function (string $locale) {
    if (in_array($locale, ['en', 'fr', 'rw'])) {
        return back()->withCookie(cookie('locale', $locale, 60 * 24 * 365));
    }
    return back();
})->name('locale.switch');

Route::middleware('auth')->group(function () {
    Route::get('profile',          [ProfileController::class, 'show'])->name('profile.show');
    Route::put('profile',          [ProfileController::class, 'update'])->name('profile.update');
    Route::put('profile/password', [ProfileController::class, 'updatePassword'])->name('profile.password');
    Route::delete('profile',         [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// =============================================================================
// ADMIN
// =============================================================================

Route::middleware(['auth'])
    ->prefix('admin')
    ->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');
    });

Route::middleware(['auth', 'role:admin,staff'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {

        // ── Lands ─────────────────────────────────────────────────────────────
        Route::prefix('properties')->name('properties.')->group(function () {

            Route::get('lands',             [LandController::class, 'index'])->name('lands.index')->middleware('permission:review');
            Route::get('lands/create',      [LandController::class, 'create'])->name('lands.create')->middleware('permission:add');
            Route::post('lands',            [LandController::class, 'store'])->name('lands.store')->middleware('permission:add');
            Route::get('lands/{land}',      [LandController::class, 'show'])->name('lands.show')->middleware('permission:review');
            Route::get('lands/{land}/edit', [LandController::class, 'edit'])->name('lands.edit')->middleware('permission:edit');
            Route::put('lands/{land}',      [LandController::class, 'update'])->name('lands.update')->middleware('permission:edit');
            Route::delete('lands/{land}',   [LandController::class, 'destroy'])->name('lands.destroy')->middleware('permission:delete');
            Route::post('lands/{land}/approve',          [LandController::class, 'approve'])->name('lands.approve')->middleware('permission:edit');
            Route::get('lands/{land}/images/download',   [LandController::class, 'downloadImages'])->name('lands.images.download')->middleware('permission:review');
            Route::post('lands/{land}/images/upload',    [LandController::class, 'uploadImages'])->name('lands.images.upload')->middleware('permission:edit');
            Route::patch('lands/{land}/status',         [LandController::class, 'updateStatus'])->name('lands.status')->middleware('permission:edit');
        });

        // ── Houses ────────────────────────────────────────────────────────────
        Route::get('houses',                 [HouseController::class, 'index'])->name('properties.houses.index')->middleware('permission:review');
        Route::get('houses/create',          [HouseController::class, 'create'])->name('properties.houses.create')->middleware('permission:add');
        Route::post('houses',                [HouseController::class, 'store'])->name('properties.houses.store')->middleware('permission:add');
        Route::get('houses/{house}',         [HouseController::class, 'show'])->name('properties.houses.show')->middleware('permission:review');
        Route::get('houses/{house}/edit',    [HouseController::class, 'edit'])->name('properties.houses.edit')->middleware('permission:edit');
        Route::put('houses/{house}',         [HouseController::class, 'update'])->name('properties.houses.update')->middleware('permission:edit');
        Route::delete('houses/{house}',      [HouseController::class, 'destroy'])->name('properties.houses.destroy')->middleware('permission:delete');
        Route::post('houses/{house}/approve',           [HouseController::class, 'approve'])->name('properties.houses.approve')->middleware('permission:edit');
        Route::post('houses/{house}/images/upload',     [HouseController::class, 'uploadImages'])->name('properties.houses.images.upload')->middleware('permission:edit');
        Route::get('houses/{house}/images/download',    [HouseController::class, 'downloadImages'])->name('properties.houses.images.download')->middleware('permission:review');
        Route::delete('houses/{house}/images/{image}',  [HouseController::class, 'deleteImage'])->name('properties.houses.images.delete')->middleware('permission:delete');
        Route::patch('houses/{house}/status',         [HouseController::class, 'updateStatus'])->name('properties.houses.status')->middleware('permission:edit');

        // ── Agents ────────────────────────────────────────────────────────────
        Route::get('agents',                 [AgentController::class, 'index'])->name('agents.index')->middleware('permission:review');
        Route::get('agents/create',          [AgentController::class, 'create'])->name('agents.create')->middleware('permission:add');
        Route::post('agents',                [AgentController::class, 'store'])->name('agents.store')->middleware('permission:add');
        Route::get('agents/{agent}/profile', [AgentController::class, 'show'])->name('agents.show')->middleware('permission:review');
        Route::get('agents/{agent}/edit',    [AgentController::class, 'edit'])->name('agents.edit')->middleware('permission:edit');
        Route::put('agents/{agent}',         [AgentController::class, 'update'])->name('agents.update')->middleware('permission:edit');
        Route::delete('agents/{agent}',      [AgentController::class, 'destroy'])->name('agents.destroy')->middleware('permission:delete');
        Route::put('agents/{agent}/approve',        [AgentController::class, 'approve'])->name('agents.approve')->middleware('permission:edit');
        Route::put('agents/{agent}/reject',         [AgentController::class, 'reject'])->name('agents.reject')->middleware('permission:edit');
        Route::post('agents/{agent}/reset-password', [AgentController::class, 'resetPassword'])->name('agents.reset-password')->middleware('permission:edit');
        Route::patch('agents/{agent}/verify',       [AgentController::class, 'verifyAgent'])->name('agents.verify')->middleware('permission:edit');
        Route::patch('agents/{agent}/status',         [AgentController::class, 'updateStatus'])->name('agents.update-status')->middleware('permission:edit');

        // ── Users ─────────────────────────────────────────────────────────────
        Route::get('users',              [UserController::class, 'index'])->name('users.index')->middleware('permission:review');
        Route::get('users/create',       [UserController::class, 'create'])->name('users.create')->middleware('permission:add');
        Route::post('users',             [UserController::class, 'store'])->name('users.store')->middleware('permission:add');
        Route::get('users/{user}/show',  [UserController::class, 'show'])->name('users.show')->middleware('permission:review');
        Route::get('users/{user}/edit',  [UserController::class, 'edit'])->name('users.edit')->middleware('permission:edit');
        Route::put('users/{user}',       [UserController::class, 'update'])->name('users.update')->middleware('permission:edit');
        Route::delete('users/{user}',    [UserController::class, 'destroy'])->name('users.destroy')->middleware('permission:delete');
        Route::put('users/{user}/approve',         [UserController::class, 'approve'])->name('users.approve')->middleware('permission:edit');
        Route::put('users/{user}/reject',          [UserController::class, 'reject'])->name('users.reject')->middleware('permission:edit');
        Route::post('users/{user}/reset-password', [UserController::class, 'resetPassword'])->name('users.reset-password')->middleware('permission:edit');
        Route::patch('users/{user}/verify',        [UserController::class, 'verifyUser'])->name('users.verify')->middleware('permission:edit');


        // ── Architectural Designs ─────────────────────────────────────────────
        Route::get('design-categories',                  [ArchitecturalDesignController::class, 'designCategoryIndex'])->name('design-categories.index')->middleware('permission:review');
        Route::post('design-categories',                 [ArchitecturalDesignController::class, 'designCategoryStore'])->name('design-categories.store')->middleware('permission:add');
        Route::put('design-categories/{design_category}', [ArchitecturalDesignController::class, 'designCategoryUpdate'])->name('design-categories.update')->middleware('permission:edit');
        Route::delete('design-categories/{design_category}', [ArchitecturalDesignController::class, 'designCategoryDestroy'])->name('design-categories.destroy')->middleware('permission:delete');

        Route::get('architectural-designs',                                   [ArchitecturalDesignController::class, 'index'])->name('architectural-designs.index')->middleware('permission:review');
        Route::get('architectural-designs/create',                            [ArchitecturalDesignController::class, 'create'])->name('architectural-designs.create')->middleware('permission:add');
        Route::post('architectural-designs',                                  [ArchitecturalDesignController::class, 'store'])->name('architectural-designs.store')->middleware('permission:add');
        Route::get('architectural-designs/{architecturalDesign}/details',     [ArchitecturalDesignController::class, 'show'])->name('properties.architectural-designs.show')->middleware('permission:review');
        Route::get('architectural-designs/{architecturalDesign}/edit',        [ArchitecturalDesignController::class, 'edit'])->name('architectural-designs.edit')->middleware('permission:edit');
        Route::put('architectural-designs/{architecturalDesign}/update',      [ArchitecturalDesignController::class, 'update'])->name('architectural-designs.update')->middleware('permission:edit');
        Route::delete('architectural-designs/{architecturalDesign}/delete',   [ArchitecturalDesignController::class, 'destroy'])->name('architectural-designs.destroy')->middleware('permission:delete');
        Route::patch('architectural-designs/{architecturalDesign}/status',    [ArchitecturalDesignController::class, 'updateStatus'])->name('architectural-designs.status')->middleware('permission:edit');
        Route::patch('architectural-designs/{architecturalDesign}/feature',   [ArchitecturalDesignController::class, 'toggleFeature'])->name('architectural-designs.feature')->middleware('permission:edit');
        Route::post('architectural-designs/{architecturalDesign}/approve',    [ArchitecturalDesignController::class, 'approve'])->name('architectural-designs.approve')->middleware('permission:edit');

        // ── Pricing Plans ─────────────────────────────────────────────────────
        Route::get('pricing-plans',              [PricingPlanController::class, 'index'])->name('pricing-plans.index')->middleware('permission:review');
        Route::get('pricing-plans/create',       [PricingPlanController::class, 'create'])->name('pricing-plans.create')->middleware('permission:add');
        Route::post('pricing-plans',             [PricingPlanController::class, 'store'])->name('pricing-plans.store')->middleware('permission:add');
        Route::get('pricing-plans/{pricing_plan}',       [PricingPlanController::class, 'show'])->name('pricing-plans.show')->middleware('permission:review');
        Route::get('pricing-plans/{pricing_plan}/edit',  [PricingPlanController::class, 'edit'])->name('pricing-plans.edit')->middleware('permission:edit');
        Route::put('pricing-plans/{pricing_plan}',       [PricingPlanController::class, 'update'])->name('pricing-plans.update')->middleware('permission:edit');
        Route::delete('pricing-plans/{pricing_plan}',    [PricingPlanController::class, 'destroy'])->name('pricing-plans.destroy')->middleware('permission:delete');
        Route::get('create-agent-pricing-plans/create',  [PricingPlanController::class, 'createAgentPlan'])->name('create-agent-pricing-plans.create')->middleware('permission:add');

        Route::get('property-plan-orders',                     [AdminPropertyPlanController::class, 'index'])->name('property-plan-orders.index')->middleware('permission:review');
        Route::post('property-plan-orders/{order}/approve',    [AdminPropertyPlanController::class, 'approve'])->name('property-plan-orders.approve')->middleware('permission:edit');

        // ── Facilities ────────────────────────────────────────────────────────
        Route::get('facilities',               [FacilityController::class, 'index'])->name('facilities.index')->middleware('permission:review');
        Route::post('facilities',              [FacilityController::class, 'store'])->name('facilities.store')->middleware('permission:add');
        Route::put('facilities/{facility}',    [FacilityController::class, 'update'])->name('facilities.update')->middleware('permission:edit');
        Route::delete('facilities/{facility}', [FacilityController::class, 'destroy'])->name('facilities.destroy')->middleware('permission:delete');

        // ── Staff ─────────────────────────────────────────────────────────────
        Route::get('staff',              [StaffController::class, 'index'])->name('staff.index')->middleware('permission:review');
        Route::get('staff/create',       [StaffController::class, 'create'])->name('staff.create')->middleware('permission:add');
        Route::post('staff',             [StaffController::class, 'store'])->name('staff.store')->middleware('permission:add');
        Route::get('staff/{staff}',      [StaffController::class, 'show'])->name('staff.show')->middleware('permission:review');
        Route::get('staff/{staff}/edit', [StaffController::class, 'edit'])->name('staff.edit')->middleware('permission:edit');
        Route::put('staff/{staff}',      [StaffController::class, 'update'])->name('staff.update')->middleware('permission:edit');
        Route::delete('staff/{staff}',   [StaffController::class, 'destroy'])->name('staff.destroy')->middleware('permission:delete');
        Route::patch('staff/{staff}/status',         [StaffController::class, 'updateStatus'])->name('staff.status')->middleware('permission:edit');
        Route::post('staff/{staff}/reset-password',  [StaffController::class, 'resetPassword'])->name('staff.reset-password')->middleware('permission:edit');

        // ── Packages / Tiers / Levels / Discounts ─────────────────────────────
        Route::get('listing-packages',           [ListingPackageController::class, 'index'])->name('listing-packages.index')->middleware('permission:review');
        Route::get('listing-packages/create',    [ListingPackageController::class, 'create'])->name('listing-packages.create')->middleware('permission:add');
        Route::post('listing-packages',          [ListingPackageController::class, 'store'])->name('listing-packages.store')->middleware('permission:add');
        Route::get('listing-packages/{listing_package}',       [ListingPackageController::class, 'show'])->name('listing-packages.show')->middleware('permission:review');
        Route::get('listing-packages/{listing_package}/edit',  [ListingPackageController::class, 'edit'])->name('listing-packages.edit')->middleware('permission:edit');
        Route::put('listing-packages/{listing_package}',       [ListingPackageController::class, 'update'])->name('listing-packages.update')->middleware('permission:edit');
        Route::delete('listing-packages/{listing_package}',    [ListingPackageController::class, 'destroy'])->name('listing-packages.destroy')->middleware('permission:delete');

        Route::get('duration-discounts',           [DurationDiscountController::class, 'index'])->name('duration-discounts.index')->middleware('permission:review');
        Route::get('duration-discounts/create',    [DurationDiscountController::class, 'create'])->name('duration-discounts.create')->middleware('permission:add');
        Route::post('duration-discounts',          [DurationDiscountController::class, 'store'])->name('duration-discounts.store')->middleware('permission:add');
        Route::get('duration-discounts/{duration_discount}',       [DurationDiscountController::class, 'show'])->name('duration-discounts.show')->middleware('permission:review');
        Route::get('duration-discounts/{duration_discount}/edit',  [DurationDiscountController::class, 'edit'])->name('duration-discounts.edit')->middleware('permission:edit');
        Route::put('duration-discounts/{duration_discount}',       [DurationDiscountController::class, 'update'])->name('duration-discounts.update')->middleware('permission:edit');
        Route::delete('duration-discounts/{duration_discount}',    [DurationDiscountController::class, 'destroy'])->name('duration-discounts.destroy')->middleware('permission:delete');
    });

// =============================================================================
// STAFF — Departments & Permissions (auth)
// =============================================================================

Route::middleware(['auth'])
    ->prefix('staff')
    ->name('staff.')
    ->group(function () {

        // Departments — static prefix before /{staff} wildcard
        Route::prefix('departments')->name('departments.')->group(function () {
            Route::get('/',                      [DepartmentController::class, 'index'])->name('index')->middleware('permission:review');
            Route::post('/',                     [DepartmentController::class, 'store'])->name('store')->middleware('permission:add');
            Route::put('/{department}',          [DepartmentController::class, 'update'])->name('update')->middleware('permission:edit');
            Route::delete('/{department}',       [DepartmentController::class, 'destroy'])->name('destroy')->middleware('permission:delete');
            Route::patch('/{department}/toggle', [DepartmentController::class, 'toggleStatus'])->name('toggle')->middleware('permission:edit');
        });

        // Staff permissions — /{staff}/permissions has fixed second segment, safe after prefix group
        Route::get('/{staff}/permissions',        [PermissionManagerController::class, 'edit'])->name('permissions.edit')->middleware('permission:review');
        Route::post('/{staff}/permissions',       [PermissionManagerController::class, 'save'])->name('permissions.save')->middleware('permission:edit');
        Route::post('/{staff}/permissions/reset', [PermissionManagerController::class, 'reset'])->name('permissions.reset')->middleware('permission:edit');
    });


// =============================================================================
// ADMIN — Roles & Permissions (auth + role:admin)
// =============================================================================

Route::middleware(['auth', 'role:admin'])
    ->prefix('admin/roles')
    ->name('admin.roles.')
    ->group(function () {

        Route::get('/', [RolePermissionController::class, 'index'])->name('index')->middleware('permission:review');

        // Role assignment
        Route::get('/users',                    [RolePermissionController::class, 'users'])->name('users')->middleware('permission:review');
        Route::get('/users/{user}/assign',      [RolePermissionController::class, 'assignView'])->name('assign-view')->middleware('permission:review');
        Route::post('/users/{user}/assign',     [RolePermissionController::class, 'assignRole'])->name('assign')->middleware('permission:edit');
        Route::post('/users/{user}/remove',     [RolePermissionController::class, 'removeRole'])->name('remove')->middleware('permission:edit');

        // Roles CRUD
        Route::post('/roles',           [RolePermissionController::class, 'store'])->name('store')->middleware('permission:add');
        Route::put('/roles/{id}/update',     [RolePermissionController::class, 'update'])->name('update')->middleware('permission:edit');
        Route::delete('/roles/{id}/delete',  [RolePermissionController::class, 'destroy'])->name('destroy')->middleware('permission:delete');

        // Permissions CRUD
        Route::post('/permissions',                    [RolePermissionController::class, 'storePermission'])->name('permissions.store')->middleware('permission:add');
        Route::delete('/permissions/{permission}',     [RolePermissionController::class, 'destroyPermission'])->name('permissions.destroy')->middleware('permission:delete');
    });

// Admin/staff client management
Route::middleware(['auth'])->prefix('admin/clients')->name('admin.clients.')->group(function () {

    // ── AJAX routes first (no {id} conflict) ──────────────────────
    Route::get('/search',     [ClientController::class, 'search'])->name('search');
    Route::post('/quick-add', [ClientController::class, 'quickAdd'])->name('quick-add');

    // ── Resource-style routes ──────────────────────────────────────
    Route::get('/',           [ClientController::class, 'index'])->name('index');
    Route::get('/create',     [ClientController::class, 'create'])->name('create');
    Route::post('/store',     [ClientController::class, 'store'])->name('store');
    Route::get('/{id}',       [ClientController::class, 'show'])->name('show');
    Route::get('/{id}/edit',  [ClientController::class, 'edit'])->name('edit');
    Route::put('/{id}',       [ClientController::class, 'update'])->name('update');
    Route::delete('/{id}',    [ClientController::class, 'destroy'])->name('destroy');
});

// =============================================================================
// AGENT PANEL
// =============================================================================

Route::middleware(['auth'])
    ->prefix('panel')
    ->group(function () {

        Route::get('/agent/dashboard', [AgentDashboardController::class, 'index'])->name('agent.dashboard.index');
        Route::get('/agent/view', [AgentProfileController::class, 'index'])->name('agent.profile.view');
        Route::get('/agent/house', [AgentHouseController::class, 'index'])->name('agent.properties.houses.index');
        Route::get('/agent/houses/create', [AgentHouseController::class, 'create'])->name('agent.properties.houses.create');
        Route::post('/agent/houses', [AgentHouseController::class, 'store'])->name('agent.properties.houses.store');
        Route::get('/agent/houses/{house}', [AgentHouseController::class, 'show'])->name('agent.properties.houses.show');
        Route::get('/agent/houses/{house}/edit', [AgentHouseController::class, 'edit'])->name('agent.properties.houses.edit'); // ✅ /edit suffix added
        Route::put('/agent/houses/{house}', [AgentHouseController::class, 'update'])->name('agent.properties.houses.update'); // ✅ Add update too
        Route::delete('/agent/houses/{house}', [AgentHouseController::class, 'destroy'])->name('agent.properties.houses.destroy'); // ✅ And destroy
        Route::post('/agent/houses/{house}/images/upload',  [AgentHouseController::class, 'uploadImages'])->name('agent.properties.houses.images.upload');
        Route::get('/agent/houses/{house}/images/download', [AgentHouseController::class, 'downloadImages'])->name('agent.properties.houses.images.download');
        Route::delete('/agent/houses/{house}/images/{image}', [AgentHouseController::class, 'deleteImage'])->name('agent.properties.houses.images.delete');

        Route::get('/agent/land', [AgentLandController::class, 'index'])->name('agent.properties.land.index');
        Route::get('/agent/lands/create', [AgentLandController::class, 'create'])->name('agent.properties.lands.create');
        Route::post('/agent/lands', [AgentLandController::class, 'store'])->name('agent.properties.lands.store');
        Route::get('/agent/lands/{land}', [AgentLandController::class, 'show'])->name('agent.properties.lands.show');
        Route::get('/agent/lands/{land}/edit', [AgentLandController::class, 'edit'])->name('agent.properties.lands.edit'); // ✅ /edit suffix added
        Route::put('/agent/lands/{land}', [AgentLandController::class, 'update'])->name('agent.properties.lands.update'); // ✅ Add update too
        Route::delete('/agent/lands/{land}', [AgentLandController::class, 'destroy'])->name('agent.properties.lands.destroy');
        Route::post('/agent/lands/{land}/images/upload',  [AgentLandController::class, 'uploadImages'])->name('agent.properties.lands.images.upload');
        Route::get('/agent/lands/{land}/images/download', [AgentLandController::class, 'downloadImages'])->name('agent.properties.lands.images.download');
        Route::delete('/agent/lands/{land}/images/{image}', [AgentLandController::class, 'deleteImage'])->name('agent.properties.lands.images.delete');

        Route::get('/design-categories', [ArchitecturalDesignController::class, 'designCategoryIndex'])->name('agents.design-categories.index');
        Route::post('/design-categories', [ArchitecturalDesignController::class, 'designCategoryStore'])->name('agents.design-categories.store');
        Route::put('/design-categories/{design_category}', [ArchitecturalDesignController::class, 'designCategoryUpdate'])->name('agents.design-categories.update');
        Route::delete('/design-categories/{design_category}', [ArchitecturalDesignController::class, 'designCategoryDestroy'])->name('agents.design-categories.destroy');

        Route::get('/agent/designs/create', [AgentDesignController::class, 'create'])->name('agent.designs.create');
        Route::post('/agent/designs', [AgentDesignController::class, 'store'])->name('agent.designs.store');
        Route::get('/agent/designs', [AgentDesignController::class, 'index'])->name('agent.designs.index');
        Route::get('/agent/designs/{architecturalDesign}', [AgentDesignController::class, 'show'])->name('agent.designs.show');
        Route::get('/agent/designs/{architecturalDesign}/edit', [AgentDesignController::class, 'edit'])->name('agent.designs.edit');
        Route::put('/agent/designs/{architecturalDesign}', [AgentDesignController::class, 'update'])->name('agent.designs.update');
        Route::delete('/agent/designs/{architecturalDesign}', [AgentDesignController::class, 'destroy'])->name('agent.designs.destroy');
    });

// =============================================================================
// ADMIN — MARKETPLACE CONSOLE (approvals, people, money, reports, settings)
// =============================================================================
Route::middleware(['auth', 'role:admin,staff'])->prefix('admin/marketplace')->name('admin.marketplace.')->group(function () {
    Route::get('approvals', [AdminMarketplaceController::class, 'approvals'])->name('approvals');
    Route::patch('listings/{type}/{id}/decide', [AdminMarketplaceController::class, 'decide'])->whereIn('type', ['house', 'land', 'design'])->whereNumber('id')->name('decide');
    Route::post('listings/{type}/{id}/deal', [AdminMarketplaceController::class, 'recordDeal'])->whereIn('type', ['house', 'land'])->whereNumber('id')->name('deal');

    Route::get('documents', [AdminMarketplaceController::class, 'documents'])->name('documents');
    Route::patch('documents/{document}', [AdminMarketplaceController::class, 'reviewDocument'])->name('documents.review');

    Route::get('inquiries', [AdminMarketplaceController::class, 'inquiries'])->name('inquiries');
    Route::get('deals', [AdminMarketplaceController::class, 'deals'])->name('deals');
    Route::get('referrals', [AdminMarketplaceController::class, 'referrals'])->name('referrals');

    Route::get('users', [AdminMarketplaceController::class, 'users'])->name('users');
    Route::patch('users/{user}', [AdminMarketplaceController::class, 'updateUser'])->name('users.update');
    Route::get('partners', [AdminMarketplaceController::class, 'partners'])->name('partners');
    Route::patch('partners/{partner}', [AdminMarketplaceController::class, 'updatePartner'])->name('partners.update');

    Route::get('payments', [AdminMarketplaceController::class, 'payments'])->name('payments');
    Route::patch('payments/{payment}', [AdminMarketplaceController::class, 'verifyPayment'])->name('payments.verify');
    Route::get('promotions', [AdminMarketplaceController::class, 'promotions'])->name('promotions');
    Route::patch('promotions/{promotion}', [AdminMarketplaceController::class, 'updatePromotion'])->name('promotions.update');
    Route::get('commissions', [AdminMarketplaceController::class, 'commissions'])->name('commissions');
    Route::patch('commissions/{commission}', [AdminMarketplaceController::class, 'updateCommission'])->name('commissions.update');
    Route::post('commissions/bulk', [AdminMarketplaceController::class, 'bulkCommissions'])->name('commissions.bulk');

    Route::get('assignments', [AdminMarketplaceController::class, 'assignments'])->name('assignments');
    Route::post('assignments', [AdminMarketplaceController::class, 'storeAssignment'])->name('assignments.store');
    Route::delete('assignments/{assignment}', [AdminMarketplaceController::class, 'destroyAssignment'])->name('assignments.destroy');

    Route::get('reports', [AdminMarketplaceController::class, 'reports'])->name('reports');
    Route::get('reports/export/{dataset}', [AdminMarketplaceController::class, 'export'])->whereIn('dataset', ['payments', 'commissions', 'inquiries', 'listings', 'users'])->name('export');

    Route::middleware('role:admin')->group(function () {
        Route::get('settings', [AdminMarketplaceController::class, 'settings'])->name('settings');
        Route::put('settings', [AdminMarketplaceController::class, 'saveSettings'])->name('settings.save');
    });
});

// =============================================================================
// MARKETPLACE ROOMS — owner, client, agent, partner (one shared database)
// =============================================================================

// Terra AI: plain-language property search + questions (rate limited per visitor).
Route::post('/ai/assistant', AiAssistantController::class)->middleware('throttle:20,1')->name('front.ai.assistant');

// Independent partners apply here (guest).
Route::middleware('guest')->group(function () {
    Route::get('/partners/apply', [PartnerApplicationController::class, 'create'])->name('front.partners.apply');
    Route::post('/partners/apply', [PartnerApplicationController::class, 'store'])->name('front.partners.apply.store');
});

// Actions from a public listing page (any signed-in user).
Route::middleware('auth')->prefix('listings/{type}/{id}')->whereIn('type', ['house', 'land', 'design'])->whereNumber('id')->group(function () {
    Route::post('/viewing', [ViewingController::class, 'store'])->name('listing.viewing');
    Route::post('/offer', [OfferController::class, 'store'])->name('listing.offer');
    Route::post('/message', [MessageController::class, 'start'])->name('listing.message');
});

// Room dashboards
Route::middleware('auth')->group(function () {
    Route::get('/account', [RoomDashboardController::class, 'home'])->name('room.home');
    Route::get('/owner', [RoomDashboardController::class, 'owner'])->middleware('role:owner')->name('owner.dashboard');
    Route::get('/client', [RoomDashboardController::class, 'client'])->middleware('role:client')->name('client.dashboard');
    Route::get('/partner', [RoomDashboardController::class, 'partner'])->middleware('role:partner')->name('partner.dashboard');
});

// Shared room features
Route::middleware('auth')->prefix('account')->name('room.')->group(function () {
    // Communication (every role)
    Route::get('inquiries', [RoomInquiryController::class, 'index'])->name('inquiries.index');
    Route::post('inquiries/{inquiry}/reply', [RoomInquiryController::class, 'reply'])->name('inquiries.reply');
    Route::patch('inquiries/{inquiry}', [RoomInquiryController::class, 'update'])->name('inquiries.update');

    Route::get('messages', [MessageController::class, 'index'])->name('messages.index');
    Route::get('messages/{conversation}', [MessageController::class, 'show'])->name('messages.show');
    Route::post('messages/{conversation}', [MessageController::class, 'store'])->name('messages.store');

    Route::get('viewings', [ViewingController::class, 'index'])->name('viewings.index');
    Route::patch('viewings/{viewing}', [ViewingController::class, 'update'])->name('viewings.update');

    Route::get('offers', [OfferController::class, 'index'])->name('offers.index');
    Route::patch('offers/{offer}', [OfferController::class, 'update'])->name('offers.update');

    Route::get('saved', [SavedController::class, 'index'])->name('saved.index');
    Route::post('saved/toggle', [SavedController::class, 'toggle'])->name('saved.toggle');
    Route::post('saved/sync', [SavedController::class, 'sync'])->name('saved.sync');

    // Listing management (owners, agents, partners)
    Route::middleware('role:owner,agent,partner,admin,staff')->group(function () {
        Route::get('listings', [RoomListingController::class, 'index'])->name('listings.index');
        Route::get('listings/{type}/{id}/promote', [RoomListingController::class, 'promote'])->name('listings.promote');
        Route::post('listings/{type}/{id}/promote', [RoomListingController::class, 'storePromotion'])->name('listings.promote.store');
        Route::get('listings/{type}/{id}/documents', [RoomListingController::class, 'documents'])->name('listings.documents');
        Route::post('listings/{type}/{id}/documents', [RoomListingController::class, 'storeDocument'])->name('listings.documents.store');
        Route::delete('documents/{document}', [RoomListingController::class, 'destroyDocument'])->name('documents.destroy');
        Route::get('performance', [InsightController::class, 'performance'])->name('performance');
    });
    Route::get('documents/{document}/download', [RoomListingController::class, 'downloadDocument'])->name('documents.download');

    // Agents & partners
    Route::middleware('role:agent,partner')->group(function () {
        Route::get('leads', [ReferralController::class, 'index'])->name('referrals.index');
        Route::post('leads', [ReferralController::class, 'store'])->name('referrals.store');
        Route::get('earnings', [InsightController::class, 'earnings'])->name('earnings');
        Route::get('assigned', [InsightController::class, 'assigned'])->name('assigned');
    });
    Route::patch('leads/{referral}', [ReferralController::class, 'update'])->name('referrals.update');
});

// =============================================================================
// LISTING PAYMENTS
// =============================================================================

Route::prefix('payment')->name('payment.')->middleware(['auth'])->group(function () {

    // Show payment details + method selector
    Route::get('/{reference}',           [App\Http\Controllers\PaymentController::class, 'show'])->name('show');

    // Submit payment method & phone, trigger gateway push
    Route::post('/{reference}/initiate', [App\Http\Controllers\PaymentController::class, 'initiate'])->name('initiate');

    // Waiting / polling page
    Route::get('/{reference}/pending',   [App\Http\Controllers\PaymentController::class, 'pending'])->name('pending');

    // AJAX status poll  →  returns JSON { status, redirectUrl }
    Route::get('/{reference}/status',    [App\Http\Controllers\PaymentController::class, 'status'])->name('status');

    Route::post('/{reference}/confirm', [App\Http\Controllers\PaymentController::class, 'confirm'])->name('confirm');

    // Success receipt page
    Route::get('/{reference}/success',   [App\Http\Controllers\PaymentController::class, 'success'])->name('success');
});

// ── Webhook: no auth, but verify signature inside the controller ──────────
Route::post('/payment/callback', [App\Http\Controllers\PaymentController::class, 'callback'])
    ->name('payment.callback')
    ->withoutMiddleware(['auth', 'verified']);

// =============================================================================
// MAINTENANCE HELPERS
// =============================================================================

Route::get('/run-storage-link', function () {
    Artisan::call('storage:link');
    return 'Storage link created!';
});

Route::get('/run-migration', function () {
    Artisan::call('config:clear');

    $output = new \Symfony\Component\Console\Output\BufferedOutput;
    Artisan::call('migrate', ['--force' => true], $output);

    return response('<pre>' . $output->fetch() . '</pre>');
});

Route::get('/run-seeder', function () {
    Artisan::call('db:seed', [
        '--class' => 'RolesAndPermissionsSeeder'
    ]);

    return "Seeder executed successfully!";
});

Route::get('/migrate-fresh', function () {
    Artisan::call('migrate:fresh');

    return "Database refreshed successfully!";
});

// routes/web.php
Route::get('/clear-all', function () {
    Artisan::call('config:clear');
    Artisan::call('cache:clear');
    Artisan::call('view:clear');
    Artisan::call('route:clear');

    return response()->json([
        'status' => 'success',
        'message' => 'All caches cleared!'
    ]);
});

Route::get('/create-admin', function () {

    // 1. Get administrator role
    $adminRole = Role::where('name', 'administrator')->first();

    if (!$adminRole) {
        return "❌ Administrator role not found. Run seeder first.";
    }

    // 2. Create or update user
    $user = User::updateOrCreate(
        ['email' => 'info@terra.rw'],
        [
            'name' => 'Global Administrator',
            'password' => Hash::make('StrongPassword123!'),
            'role' => 'admin', // optional
        ]
    );

    // 3. Attach role
    $user->roles()->syncWithoutDetaching([$adminRole->id]);

    // 4. (Optional) Sync all permissions directly (if user has direct permissions)
    if (method_exists($user, 'syncPermissionsByName')) {
        $permissions = $adminRole->permissions->pluck('name')->toArray();
        $user->syncPermissionsByName($permissions);
    }

    return "✅ Admin user created and synced successfully!";
});

require __DIR__ . '/auth.php';
