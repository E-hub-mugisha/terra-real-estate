<?php

use App\Http\Controllers\Admin\AdminPropertyPlanController;
use App\Http\Controllers\Admin\AgentLevelController;
use App\Http\Controllers\Admin\ArchitecturalDesignController;
use App\Http\Controllers\Admin\ConsultantCommissionTierController;
use App\Http\Controllers\Admin\ConsultantController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\DurationDiscountController;
use App\Http\Controllers\Admin\FacilityController;
use App\Http\Controllers\Admin\NewsAdsController;
use App\Http\Controllers\Admin\PartnersController;
use App\Http\Controllers\Admin\PricingPlanController;
use App\Http\Controllers\Admin\Properties\HouseController;
use App\Http\Controllers\Admin\Properties\LandController;
use App\Http\Controllers\Admin\RolePermissionController;
use App\Http\Controllers\Admin\ServiceCategoryController;
use App\Http\Controllers\Admin\ServiceController;
use App\Http\Controllers\Admin\ServiceSubCategoryController;
use App\Http\Controllers\Admin\TenderController;
use App\Http\Controllers\Admin\Users\AgentController;
use App\Http\Controllers\Admin\Users\ProfessionalController;
use App\Http\Controllers\BlogCategoryController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\Agents\AgentDashboardController;
use App\Http\Controllers\Agents\AgentHouseController;
use App\Http\Controllers\Agents\AgentLandController;
use App\Http\Controllers\Agents\AgentProfileController;
use App\Http\Controllers\Agents\HomeAgentController;
use App\Http\Controllers\Consultants\HomeConsultantsController;
use App\Http\Controllers\front\AnAdsController;
use App\Http\Controllers\Front\HomeController;
use App\Http\Controllers\Front\HomeServiceController;
use App\Http\Controllers\Front\MarketplaceController;
use App\Http\Controllers\Front\UserListingController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PropertyController;
use App\Http\Controllers\PropertyPlanController;
use App\Http\Controllers\Staff\DepartmentController;
use App\Http\Controllers\Staff\PermissionManagerController;
use App\Http\Controllers\Staff\StaffController;
use App\Http\Controllers\Admin\ListingPackageController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('front.home');
Route::get('/about', [HomeController::class, 'about'])->name('front.about');
Route::get('/properties', [HomeController::class, 'properties'])->name('front.properties');
Route::get('/contact', [HomeController::class, 'contact'])->name('front.contact');
Route::get('/agents', [HomeController::class, 'agents'])->name('front.agents');
Route::get('agents/{agent}', [HomeController::class, 'agentDetails'])->name('front.agent.details');
Route::get('/buy/homes', [HomeController::class, 'homes'])->name('front.buy.homes');
Route::get('/buy/homes/{home}', [HomeController::class, 'homeDetails'])->name('front.buy.home.details');
Route::post('/home/inquiry', [HomeController::class, 'sendInquiry'])->name('front.buy.home.inquiry');
Route::get('/buy/lands', [HomeController::class, 'lands'])->name('front.buy.lands');
Route::get('/buy/lands/{land}', [HomeController::class, 'landDetails'])->name('front.buy.land.details');
Route::post('/land/inquiry', [HomeController::class, 'sendLandInquiry'])->name('front.buy.land.inquiry');
Route::get('/properties/{province}', [HomeController::class, 'propertiesByProvince'])->name('properties.by.province');

Route::prefix('designs')->group(function () {
    Route::get('/', [MarketplaceController::class, 'index'])->name('front.buy.design'); // Marketplace listing
    Route::get('/{slug}', [MarketplaceController::class, 'show'])->name('front.buy.design.show'); // Design details page
    Route::get('/purchase/{slug}', [MarketplaceController::class, 'purchase'])->name('front.buy.design.purchase'); // Purchase page
    Route::post('/inquiry', [MarketplaceController::class, 'sendInquiry'])->name('front.buy.design.inquiry');
    Route::get('download/{slug}', [MarketplaceController::class, 'download'])->name('front.buy.design.download');
});

Route::get('/ads', [AnAdsController::class, 'showAds'])->name('front.ads.index');
Route::get('/announcements', [AnAdsController::class, 'showAnnouncements'])->name('front.announcements.index');
Route::get('news', [HomeController::class, 'news'])->name('front.news.index');
Route::get('news/{slug}', [HomeController::class, 'newsDetails'])->name('front.news.details');
Route::get('tenders', [HomeController::class, 'tenders'])->name('front.tenders.index');
Route::get('tenders/{id}', [HomeController::class, 'tendersDetails'])->name('front.tenders.details');

Route::get('/get/service/{id}', [HomeController::class, 'serviceDetails'])
    ->name('services.category');

Route::get('/add/property/land', [HomeController::class, 'addLand'])->name('front.add.property.land');
Route::get('/add/property/architectural', [HomeController::class, 'addArch'])->name('front.add.property.arch');
Route::get('/add/property/house', [HomeController::class, 'addHouse'])->name('front.add.property.house');
Route::get('/consultants', [HomeConsultantsController::class, 'index'])->name('front.consultants.index');
Route::get('consultants/{consultant}', [HomeConsultantsController::class, 'show'])->name('front.consultant.details');
Route::get('/become-a-consultant', [HomeConsultantsController::class, 'consultantBecame'])->name('consultant.become');
Route::get('/register/consultant', [HomeConsultantsController::class, 'create'])->name('consultant.register');
Route::post('/register/consultant', [HomeConsultantsController::class, 'store'])->name('consultant.register.store');

Route::get('/register/agents', [HomeAgentController::class, 'create'])->name('front.agents.register');
Route::post('/register/agents', [HomeAgentController::class, 'store'])->name('front.agents.register.store');
Route::get('/agent/advertising', [HomeAgentController::class, 'advertising'])->name('front.agent.advertising');

Route::post('/user/properties/houses', [UserListingController::class, 'store'])->name('user.properties.houses.store');
Route::post('/user/properties/lands', [UserListingController::class, 'storeLand'])->name('user.properties.land.store');

Route::get('/homes/rent', [HomeController::class, 'homesRent'])->name('front.rent.homes');
Route::get('/apartments/rent', [HomeController::class, 'apartmentsRent'])->name('front.rent.apartments');
Route::get('/short-stays/rent', [HomeController::class, 'shortStaysRent'])->name('front.rent.short-stays');
Route::get('/rent/near-me', [HomeController::class, 'rentNearMe'])->name('rent.search.near.me');
Route::get('/find/agents/near-me', [HomeController::class, 'agentNearMe'])->name('agents.search.near.me');
Route::get('/our-services', [HomeController::class, 'ourServices'])->name('front.our.services');

Route::get('/buy/listings', [HomeController::class, 'buy'])->name('front.properties.buy');
Route::get('/rent/listings', [HomeController::class, 'rent'])->name('front.properties.rent');
Route::get('/architecture/listings', [MarketplaceController::class, 'index'])->name('front.properties.architecture');

Route::prefix('sell')->group(function () {

    Route::get('/listings', [UserListingController::class, 'sellForm'])->name('front.properties.sell');

    Route::post('/house', [UserListingController::class, 'store'])->name('sell.house');

    Route::post('/land', [UserListingController::class, 'storeLand'])->name('sell.land');

    Route::post('/design', [UserListingController::class, 'storeDesign'])->name('sell.design');
});

Route::post('/plans/momo-pay', [PropertyPlanController::class, 'payMomo'])->name('plans.pay.momo');
Route::get('/properties/category/{category}', [HomeController::class, 'categoryView'])->name('front.properties.category');

Route::get('/select-plan/{type}/{id}', [PropertyPlanController::class, 'selectPlan'])->name('plans.select');
Route::post('/store-plan', [PropertyPlanController::class, 'store'])->name('plans.store');
Route::get('/plan-payment/{order}', [PropertyPlanController::class, 'payment'])->name('plans.payment');

Route::get('/get-districts/{provinceId}', [UserListingController::class, 'getDistricts']);
Route::get('/get-sectors/{districtId}', [UserListingController::class, 'getSectors']);
Route::get('/get-cells/{sectorId}', [UserListingController::class, 'getCells']);
Route::get('/get-villages/{cellId}', [UserListingController::class, 'getVillages']);

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware(['auth'])
    ->prefix('admin')
    ->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');
        Route::get('/create/properties', [PropertyController::class, 'create'])->name('admin.property.create');
        Route::get('/properties/pending', [PropertyController::class, 'index'])->name('admin.properties.pending');
        Route::post('/properties/{property}/approve', [PropertyController::class, 'approve'])->name('admin.properties.approve');
    });

Route::middleware(['auth'])
    ->prefix('admin')
    ->group(function () {
        Route::get('/admin/house', [HouseController::class, 'index'])->name('admin.properties.house.index');
        Route::get('/houses/create', [HouseController::class, 'create'])->name('admin.properties.houses.create');
        Route::post('/houses', [HouseController::class, 'store'])->name('admin.properties.houses.store');
        Route::get('/houses/{house}', [HouseController::class, 'show'])->name('admin.properties.houses.show');
        Route::post('/houses/{house}/approve', [HouseController::class, 'approve'])->name('admin.properties.houses.approve');

        Route::get('/admin/land', [LandController::class, 'index'])->name('admin.properties.land.index');
        Route::get('/lands/create', [LandController::class, 'create'])->name('admin.properties.lands.create');
        Route::get('/lands/{land}', [LandController::class, 'show'])->name('admin.properties.lands.show');
        Route::post('/lands', [LandController::class, 'store'])->name('admin.properties.lands.store');
        Route::post('/lands/{land}/approve', [LandController::class, 'approve'])->name('admin.properties.lands.approve');

        Route::get('/agents', [AgentController::class, 'index'])->name('admin.agents.index');
        Route::get('/agents/create', [AgentController::class, 'create'])->name('admin.agents.create');
        Route::post('/agents', [AgentController::class, 'store'])->name('admin.agents.store');
        Route::get('/agents/{agent}', [AgentController::class, 'show'])->name('admin.agents.show');
        Route::put('/agents/{agent}/approve', [AgentController::class, 'approve'])->name('admin.agents.approve');
        Route::put('/agents/{agent}/reject', [AgentController::class, 'reject'])->name('admin.agents.reject');

        Route::get('/professionals', [ProfessionalController::class, 'index'])->name('admin.professionals.index');
        Route::get('/professionals/create', [ProfessionalController::class, 'create'])->name('admin.professionals.create');
        Route::post('/professionals', [ProfessionalController::class, 'store'])->name('admin.professionals.store');
        Route::get('/professionals/{professional}', [ProfessionalController::class, 'show'])->name('admin.professionals.show');

        Route::get('/tenders/create', [TenderController::class, 'create'])->name('admin.tenders.create');
        Route::post('/tenders', [TenderController::class, 'store'])->name('admin.tenders.store');
        Route::get('/tenders', [TenderController::class, 'index'])->name('admin.tenders.index');
        Route::get('/tenders/{tender}', [TenderController::class, 'show'])->name('admin.tenders.show');
        Route::get('/tenders/{tender}/edit', [TenderController::class, 'edit'])->name('admin.tenders.edit');
        Route::put('/tenders/{tender}', [TenderController::class, 'update'])->name('admin.tenders.update');
        Route::delete('/tenders/{tender}', [TenderController::class, 'destroy'])->name('admin.tenders.destroy');

        Route::get('/design-categories', [ArchitecturalDesignController::class, 'designCategoryIndex'])->name('admin.design-categories.index');
        Route::post('/design-categories', [ArchitecturalDesignController::class, 'designCategoryStore'])->name('admin.design-categories.store');
        Route::put('/design-categories/{design_category}', [ArchitecturalDesignController::class, 'designCategoryUpdate'])->name('admin.design-categories.update');
        Route::delete('/design-categories/{design_category}', [ArchitecturalDesignController::class, 'designCategoryDestroy'])->name('admin.design-categories.destroy');

        Route::get('/architectural-designs/create', [ArchitecturalDesignController::class, 'create'])->name('admin.architectural-designs.create');
        Route::post('/architectural-designs', [ArchitecturalDesignController::class, 'store'])->name('admin.architectural-designs.store');
        Route::get('/architectural-designs', [ArchitecturalDesignController::class, 'index'])->name('admin.architectural-designs.index');
        Route::get('/architectural-designs/{architecturalDesign}', [ArchitecturalDesignController::class, 'show'])->name('admin.architectural-designs.show');
        Route::get('/architectural-designs/{architecturalDesign}/edit', [ArchitecturalDesignController::class, 'edit'])->name('admin.architectural-designs.edit');
        Route::put('/architectural-designs/{architecturalDesign}', [ArchitecturalDesignController::class, 'update'])->name('admin.architectural-designs.update');
        Route::delete('/architectural-designs/{architecturalDesign}', [ArchitecturalDesignController::class, 'destroy'])->name('admin.architectural-designs.destroy');

        Route::get('ads', [NewsAdsController::class, 'adsIndex'])->name('admin.ads.index');
        Route::get('ads/create', [NewsAdsController::class, 'adsCreate'])->name('admin.ads.create');
        Route::post('ads', [NewsAdsController::class, 'adsStore'])->name('admin.ads.store');
        Route::get('ads/{ad}/edit', [NewsAdsController::class, 'adsEdit'])->name('admin.ads.edit');
        Route::get('ads/{ad}', [NewsAdsController::class, 'adsSow'])->name('admin.ads.show');
        Route::put('ads/{ad}', [NewsAdsController::class, 'adsUpdate'])->name('admin.ads.update');
        Route::delete('ads/{ad}', [NewsAdsController::class, 'adsDestroy'])->name('admin.ads.destroy');

        Route::get('announcements', [NewsAdsController::class, 'announceIndex'])->name('admin.announcements.index');
        Route::get('announcements/create', [NewsAdsController::class, 'announceCreate'])->name('admin.announcements.create');
        Route::post('announcements', [NewsAdsController::class, 'announceStore'])->name('admin.announcements.store');
        Route::get('announcements/{announcement}', [NewsAdsController::class, 'announceSow'])->name('admin.announcements.show');
        Route::get('announcements/{announcement}/edit', [NewsAdsController::class, 'announceEdit'])->name('admin.announcements.edit');
        Route::put('announcements/{announcement}', [NewsAdsController::class, 'announceUpdate'])->name('admin.announcements.update');
        Route::delete('announcements/{announcement}', [NewsAdsController::class, 'announceDestroy'])->name('admin.announcements.destroy');

        // Service Categories
        Route::resource('service-categories', ServiceCategoryController::class)->except(['show']);
        // Service Subcategories
        Route::resource('service-subcategories', ServiceSubCategoryController::class)->except(['show']);
        // Service
        Route::resource('services', ServiceController::class)->except(['show']);
        // web.php

        Route::get('/consultants', [ConsultantController::class, 'index'])->name('admin.consultants.index');
        Route::get('/consultants/create', [ConsultantController::class, 'create'])->name('admin.consultants.create');
        Route::post('/consultants', [ConsultantController::class, 'store'])->name('admin.consultants.store');
        Route::get('consultants/{consultant}/edit', [ConsultantController::class, 'edit'])->name('admin.consultants.edit');
        Route::get('/consultants/{consultant}', [ConsultantController::class, 'show'])->name('admin.consultants.show');
        Route::delete('consultants/{consultant}', [ConsultantController::class, 'destroy'])->name('admin.consultants.destroy');

        Route::resource('pricing-plans', PricingPlanController::class)->names('admin.pricing-plans');
        Route::get('create-agent-pricing-plans/create', [PricingPlanController::class, 'createAgentPlan'])->name('admin.create-agent-pricing-plans.create');
        Route::get('property-plan-orders', [AdminPropertyPlanController::class, 'index'])->name('admin.property-plan-orders.index');
        Route::post('property-plan-orders/{order}/approve', [AdminPropertyPlanController::class, 'approve'])->name('admin.property-plan-orders.approve');

        Route::get('/partners', [PartnersController::class, 'index'])->name('admin.partners.index');
        Route::post('/partners', [PartnersController::class, 'store'])->name('admin.partners.store');
        Route::put('/partners/{partner}', [PartnersController::class, 'update'])->name('admin.partners.update');
        Route::delete('/partners/{partner}', [PartnersController::class, 'destroy'])->name('admin.partners.destroy');

        Route::get('/facilities', [FacilityController::class, 'index'])->name('admin.facilities.index');
        Route::post('/facilities', [FacilityController::class, 'store'])->name('admin.facilities.store');
        Route::put('/facilities/{facility}', [FacilityController::class, 'update'])->name('admin.facilities.update');
        Route::delete('/facilities/{facility}', [FacilityController::class, 'destroy'])->name('admin.facilities.destroy');

        Route::resource('blogs', BlogController::class)->names('admin.blogs');

        Route::resource('blog-categories', BlogCategoryController::class)->names('admin.blog-categories');
    });


Route::get('/subcategories/{category}', [ServiceController::class, 'getSubcategories'])->name('services.subcategories');

Route::middleware(['auth'])
    ->prefix('panel')
    ->group(function () {

        Route::get('/agent/dashboard', [AgentDashboardController::class, 'index'])->name('agent.dashboard.index');
        Route::get('/agent/view', [AgentProfileController::class, 'index'])->name('agent.profile.view');
        Route::get('/agent/house', [AgentHouseController::class, 'index'])->name('agents.properties.house.index');
        Route::get('/agent/houses/create', [AgentHouseController::class, 'create'])->name('agents.properties.houses.create');
        Route::post('/agent/houses', [AgentHouseController::class, 'store'])->name('agents.properties.houses.store');
        Route::get('/agent/houses/{house}', [AgentHouseController::class, 'show'])->name('agents.properties.houses.show');

        Route::get('/agent/land', [AgentLandController::class, 'index'])->name('agents.properties.land.index');
        Route::get('/agent/lands/create', [AgentLandController::class, 'create'])->name('agents.properties.lands.create');
        Route::post('/agent/lands', [AgentLandController::class, 'store'])->name('agents.properties.lands.store');
        Route::get('/agent/lands/{land}', [AgentLandController::class, 'show'])->name('agents.properties.lands.show');

        Route::get('/agents', [AgentController::class, 'index'])->name('admin.agents.index');
        Route::get('/agents/create', [AgentController::class, 'create'])->name('admin.agents.create');
        Route::post('/agents', [AgentController::class, 'store'])->name('admin.agents.store');
        Route::get('/agents/{agent}', [AgentController::class, 'show'])->name('admin.agents.show');

        Route::get('/professionals', [ProfessionalController::class, 'index'])->name('admin.professionals.index');
        Route::get('/professionals/create', [ProfessionalController::class, 'create'])->name('admin.professionals.create');
        Route::post('/professionals', [ProfessionalController::class, 'store'])->name('admin.professionals.store');
        Route::get('/professionals/{professional}', [ProfessionalController::class, 'show'])->name('admin.professionals.show');

        Route::get('/tenders/create', [TenderController::class, 'create'])->name('admin.tenders.create');
        Route::post('/tenders', [TenderController::class, 'store'])->name('admin.tenders.store');
        Route::get('/tenders', [TenderController::class, 'index'])->name('admin.tenders.index');
        Route::get('/tenders/{tender}', [TenderController::class, 'show'])->name('admin.tenders.show');
        Route::get('/tenders/{tender}/edit', [TenderController::class, 'edit'])->name('admin.tenders.edit');
        Route::put('/tenders/{tender}', [TenderController::class, 'update'])->name('admin.tenders.update');
        Route::delete('/tenders/{tender}', [TenderController::class, 'destroy'])->name('admin.tenders.destroy');

        Route::get('/design-categories', [ArchitecturalDesignController::class, 'designCategoryIndex'])->name('admin.design-categories.index');
        Route::post('/design-categories', [ArchitecturalDesignController::class, 'designCategoryStore'])->name('admin.design-categories.store');
        Route::put('/design-categories/{design_category}', [ArchitecturalDesignController::class, 'designCategoryUpdate'])->name('admin.design-categories.update');
        Route::delete('/design-categories/{design_category}', [ArchitecturalDesignController::class, 'designCategoryDestroy'])->name('admin.design-categories.destroy');

        Route::get('/architectural-designs/create', [ArchitecturalDesignController::class, 'create'])->name('admin.architectural-designs.create');
        Route::post('/architectural-designs', [ArchitecturalDesignController::class, 'store'])->name('admin.architectural-designs.store');
        Route::get('/architectural-designs', [ArchitecturalDesignController::class, 'index'])->name('admin.architectural-designs.index');
        Route::get('/architectural-designs/{architecturalDesign}', [ArchitecturalDesignController::class, 'show'])->name('admin.architectural-designs.show');
        Route::get('/architectural-designs/{architecturalDesign}/edit', [ArchitecturalDesignController::class, 'edit'])->name('admin.architectural-designs.edit');
        Route::put('/architectural-designs/{architecturalDesign}', [ArchitecturalDesignController::class, 'update'])->name('admin.architectural-designs.update');
        Route::delete('/architectural-designs/{architecturalDesign}', [ArchitecturalDesignController::class, 'destroy'])->name('admin.architectural-designs.destroy');

        Route::get('ads', [NewsAdsController::class, 'adsIndex'])->name('admin.ads.index');
        Route::get('ads/create', [NewsAdsController::class, 'adsCreate'])->name('admin.ads.create');
        Route::post('ads', [NewsAdsController::class, 'adsStore'])->name('admin.ads.store');
        Route::get('ads/{ad}/edit', [NewsAdsController::class, 'adsEdit'])->name('admin.ads.edit');
        Route::get('ads/{ad}', [NewsAdsController::class, 'adsSow'])->name('admin.ads.show');
        Route::put('ads/{ad}', [NewsAdsController::class, 'adsUpdate'])->name('admin.ads.update');
        Route::delete('ads/{ad}', [NewsAdsController::class, 'adsDestroy'])->name('admin.ads.destroy');

        Route::get('announcements', [NewsAdsController::class, 'announceIndex'])->name('admin.announcements.index');
        Route::get('announcements/create', [NewsAdsController::class, 'announceCreate'])->name('admin.announcements.create');
        Route::post('announcements', [NewsAdsController::class, 'announceStore'])->name('admin.announcements.store');
        Route::get('announcements/{announcement}', [NewsAdsController::class, 'announceSow'])->name('admin.announcements.show');
        Route::get('announcements/{announcement}/edit', [NewsAdsController::class, 'announceEdit'])->name('admin.announcements.edit');
        Route::put('announcements/{announcement}', [NewsAdsController::class, 'announceUpdate'])->name('admin.announcements.update');
        Route::delete('announcements/{announcement}', [NewsAdsController::class, 'announceDestroy'])->name('admin.announcements.destroy');

        Route::get('/services', [AgentProfileController::class, 'indexServices'])->name('agents.services.index');
        Route::get('/services/edit', [AgentProfileController::class, 'editServices'])->name('agents.services.edit');
        Route::post('/services', [AgentProfileController::class, 'updateServices'])->name('agents.services.update');

        Route::get('/consultants', [ConsultantController::class, 'index'])->name('admin.consultants.index');
        Route::get('/consultants/create', [ConsultantController::class, 'create'])->name('admin.consultants.create');
        Route::post('/consultants', [ConsultantController::class, 'store'])->name('admin.consultants.store');
        Route::get('consultants/{consultant}/edit', [ConsultantController::class, 'edit'])->name('admin.consultants.edit');
        Route::get('/consultants/{consultant}', [ConsultantController::class, 'show'])->name('admin.consultants.show');
        Route::delete('consultants/{consultant}', [ConsultantController::class, 'destroy'])->name('admin.consultants.destroy');
    });

Route::middleware(['auth'])->prefix('staff')->name('staff.')->group(function () {

    // ── Departments FIRST (before /{staff} wildcard) ──────────────
    Route::prefix('departments')->name('departments.')->group(function () {
        Route::get('/',                      [DepartmentController::class, 'index'])->name('index');
        Route::post('/',                     [DepartmentController::class, 'store'])->name('store');
        Route::put('/{department}',          [DepartmentController::class, 'update'])->name('update');
        Route::delete('/{department}',       [DepartmentController::class, 'destroy'])->name('destroy');
        Route::patch('/{department}/toggle', [DepartmentController::class, 'toggleStatus'])->name('toggle');
    });

    // ── Staff CRUD (wildcard /{staff} comes after fixed segments) ──
    Route::get('/',              [StaffController::class, 'index'])->name('index');
    Route::get('/create',        [StaffController::class, 'create'])->name('create');
    Route::post('/',             [StaffController::class, 'store'])->name('store');
    Route::get('/{staff}',       [StaffController::class, 'show'])->name('show');
    Route::get('/{staff}/edit',  [StaffController::class, 'edit'])->name('edit');
    Route::put('/{staff}',       [StaffController::class, 'update'])->name('update');
    Route::delete('/{staff}',    [StaffController::class, 'destroy'])->name('destroy');

    // ── Permissions (also before would be fine, but after is OK    ──
    // ── since /{staff}/permissions has a fixed second segment)     ──
    Route::get('/{staff}/permissions',        [PermissionManagerController::class, 'edit'])->name('permissions.edit');
    Route::post('/{staff}/permissions',       [PermissionManagerController::class, 'save'])->name('permissions.save');
    Route::post('/{staff}/permissions/reset', [PermissionManagerController::class, 'reset'])->name('permissions.reset');
});

Route::middleware(['auth'])
     ->prefix('admin/roles')
     ->name('admin.roles.')
     ->group(function () {

    Route::get('/',                          [RolePermissionController::class, 'index'])->name('index');

    // Roles
    Route::post('/roles',                    [RolePermissionController::class, 'storeRole'])->name('store');
    Route::put('/roles/{role}',              [RolePermissionController::class, 'updateRole'])->name('update');
    Route::delete('/roles/{role}',           [RolePermissionController::class, 'destroyRole'])->name('destroy');

    // Permissions
    Route::post('/permissions',              [RolePermissionController::class, 'storePermission'])->name('permissions.store');
    Route::delete('/permissions/{permission}', [RolePermissionController::class, 'destroyPermission'])->name('permissions.destroy');
});

Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {
    Route::resource('listing-packages', ListingPackageController::class);
    Route::resource('commission-tiers', ConsultantCommissionTierController::class);
    Route::resource('agent-levels', AgentLevelController::class);
    Route::resource('duration-discounts', DurationDiscountController::class);
});

require __DIR__ . '/auth.php';
