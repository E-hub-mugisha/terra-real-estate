<?php

use App\Http\Controllers\Admin\ActivityLogController;
use App\Http\Controllers\Admin\AdminPropertyPlanController;
use App\Http\Controllers\Admin\AgentLevelController;
use App\Http\Controllers\Admin\AnnouncementController;
use App\Http\Controllers\Admin\ArchitecturalDesignController;
use App\Http\Controllers\Admin\CommissionController;
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
use App\Http\Controllers\Admin\StaffController;
use App\Http\Controllers\Admin\ListingPackageController;
use App\Http\Controllers\Admin\TerraJobController;
use App\Http\Controllers\Admin\Users\UserController;
use App\Http\Controllers\Admin\AdminJobListingController;
use App\Http\Controllers\Admin\BookingAdminController;
use App\Http\Controllers\Admin\TaskController;
use App\Http\Controllers\AdvertisementController;
use App\Http\Controllers\Agents\AgentDesignController;
use App\Http\Controllers\Consultants\ConsultantBookingController;
use App\Http\Controllers\Consultants\ConsultantCalendarController;
use App\Http\Controllers\Consultants\ConsultantDashboardController;
use App\Http\Controllers\Front\JobListingController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\Professionals\ProfessionalDashboardController;
use App\Http\Controllers\Professionals\HomeProfessionalController;
use App\Http\Controllers\Professionals\ProDashboardController;
use App\Http\Controllers\Users\EarningController;
use App\Http\Controllers\Users\UserDashboardController;
use App\Http\Controllers\Users\UsersClientController;
use App\Http\Controllers\Users\UsersDashboardController;
use App\Http\Controllers\Users\UsersTasksController;
use App\Models\Role;
use App\Models\User;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('front.home');
Route::get('/about', [HomeController::class, 'about'])->name('front.about');
Route::get('/properties', [HomeController::class, 'properties'])->name('front.properties');
Route::get('/contact', [HomeController::class, 'contact'])->name('front.contact');
Route::post('/contact', [HomeController::class, 'send'])->name('contact.send');
Route::prefix('legal')->name('legal.')->group(function () {
    Route::get('/terms-of-service', fn() => view('front.terms'))->name('terms');
    Route::get('/privacy-policy',   fn() => view('front.privacy'))->name('privacy');
});
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

Route::get('/get/advertisements', [HomeController::class, 'showAdvertisements'])->name('front.ads.index');
Route::get('/announcements', [HomeController::class, 'showAnnouncements'])->name('front.announcements.index');
Route::get('/announcements{slug}', [HomeController::class, 'showAnnouncementDetail'])->name('front.announcements.show');
Route::get('news', [HomeController::class, 'news'])->name('front.news.index');
Route::get('news/{slug}', [HomeController::class, 'newsDetails'])->name('front.news.details');
Route::get('tenders', [HomeController::class, 'tenders'])->name('front.tenders.index');
Route::get('tenders/{id}', [HomeController::class, 'tendersDetails'])->name('front.tenders.details');
Route::prefix('jobs')->name('front.jobs.')->group(function () {
    Route::get('/',               [JobListingController::class, 'index'])->name('index');
    Route::get('/post',           [JobListingController::class, 'create'])->name('create');
    Route::post('/post',          [JobListingController::class, 'store'])->name('store');
    Route::get('/{job}/payment',  [JobListingController::class, 'payment'])->name('payment');
    Route::post('/{job}/payment', [JobListingController::class, 'confirmPayment'])->name('payment.confirm');
    Route::get('/{slug}',         [JobListingController::class, 'show'])->name('show');
    Route::post('/price-preview', [JobListingController::class, 'pricePreview'])->name('price-preview');
});

Route::get('/get/service/{id}', [HomeController::class, 'serviceDetails'])
    ->name('services.category');

Route::get('/add/property/land', [HomeController::class, 'addLand'])->name('front.add.property.land');
Route::get('/add/property/architectural', [HomeController::class, 'addArch'])->name('front.add.property.arch');
Route::get('/add/property/house', [HomeController::class, 'addHouse'])->name('front.add.property.house');
Route::get('/consultants', [HomeConsultantsController::class, 'index'])->name('front.consultants.index');
Route::get('/professionals', [HomeProfessionalController::class, 'index'])->name('front.professionals.index');
Route::get('consultants/{consultant}', [HomeConsultantsController::class, 'show'])->name('front.consultant.details');
Route::get('professionals/{professional}', [HomeProfessionalController::class, 'show'])->name('front.professional.details');
Route::get('/become-a-consultant', [HomeConsultantsController::class, 'consultantBecame'])->name('consultant.become');
Route::get('/register/consultant', [HomeConsultantsController::class, 'create'])->name('consultant.register');
Route::post('/register/consultant', [HomeConsultantsController::class, 'store'])->name('consultant.register.store');
Route::post('/consultants/{consultant}/appointments', [HomeConsultantsController::class, 'bookAppointment'])->name('front.consultants.appointment');

Route::get('/register/agents', [HomeAgentController::class, 'create'])->name('front.agents.register');
Route::post('/register/agents', [HomeAgentController::class, 'store'])->name('front.agents.register.store');
Route::get('/agent/advertising', [HomeAgentController::class, 'advertising'])->name('front.agent.advertising');

Route::get('/register/professionals', [HomeProfessionalController::class, 'create'])->name('professionals.register');
Route::post('/register/professionals', [HomeProfessionalController::class, 'store'])->name('front.professionals.register.store');

Route::post('/user/properties/houses', [UserListingController::class, 'store'])->name('user.properties.houses.store');
Route::post('/user/properties/lands', [UserListingController::class, 'storeLand'])->name('user.properties.land.store');
Route::post('/user/properties/arch', [UserListingController::class, 'storeArch'])->name('user.properties.arch.store');

Route::get('/property/rent', [HomeController::class, 'rent'])->name('front.rent.homes');
Route::get('/property/rent/lands', [HomeController::class, 'rentLands'])->name('front.rent.lands');
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

Route::resource('advertisements', AdvertisementController::class)->only(['index', 'create', 'store', 'show']);
Route::post('/advertisements/{advertisement}/click', [AdvertisementController::class, 'recordClick'])->name('advertisements.click');

Route::prefix('request-consultant')->name('consultant.')->group(function () {

    Route::get('/',              [ConsultantBookingController::class, 'step1'])->name('step1');
    Route::post('/service',      [ConsultantBookingController::class, 'step1Post'])->name('step1.post');

    Route::get('/province',      [ConsultantBookingController::class, 'step2'])->name('step2');
    Route::post('/province',     [ConsultantBookingController::class, 'step2Post'])->name('step2.post');

    Route::get('/district',      [ConsultantBookingController::class, 'step3'])->name('step3');
    Route::post('/district',     [ConsultantBookingController::class, 'step3Post'])->name('step3.post');

    Route::get('/consultants',   [ConsultantBookingController::class, 'step4'])->name('step4');
    Route::post('/consultants',  [ConsultantBookingController::class, 'step4Post'])->name('step4.post');

    Route::get('/details',       [ConsultantBookingController::class, 'step5'])->name('step5');
    Route::post('/details',      [ConsultantBookingController::class, 'step5Post'])->name('step5.post');

    Route::get('/payment',       [ConsultantBookingController::class, 'step6'])->name('step6');
    Route::post('/payment',      [ConsultantBookingController::class, 'step6Post'])->name('step6.post');

    Route::get('/confirmed',     [ConsultantBookingController::class, 'confirmed'])->name('confirmed');
});

Route::middleware('auth')->group(function () {
    Route::get('profile',          [ProfileController::class, 'show'])->name('profile.show');
    Route::put('profile',          [ProfileController::class, 'update'])->name('profile.update');
    Route::put('profile/password', [ProfileController::class, 'updatePassword'])->name('profile.password');
    Route::delete('profile',         [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware(['auth'])
    ->prefix('admin')
    ->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');
        Route::get('/create/properties', [PropertyController::class, 'create'])->name('admin.property.create');
        Route::get('/properties/pending', [PropertyController::class, 'index'])->name('admin.properties.pending');
        Route::post('/properties/{property}/approve', [PropertyController::class, 'approve'])->name('admin.properties.approve');
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
        Route::post('agents/{agent}/reset-password',[AgentController::class, 'resetPassword'])->name('agents.reset-password')->middleware('permission:edit');
        Route::patch('agents/{agent}/verify',       [AgentController::class, 'verifyAgent'])->name('agents.verify')->middleware('permission:edit');

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

        // ── Professionals ─────────────────────────────────────────────────────
        Route::get('professionals',              [ProfessionalController::class, 'index'])->name('professionals.index')->middleware('permission:review');
        Route::get('professionals/create',       [ProfessionalController::class, 'create'])->name('professionals.create')->middleware('permission:add');
        Route::post('professionals',             [ProfessionalController::class, 'store'])->name('professionals.store')->middleware('permission:add');
        Route::get('professionals/{professional}',       [ProfessionalController::class, 'show'])->name('professionals.show')->middleware('permission:review');
        Route::get('professionals/{professional}/edit',  [ProfessionalController::class, 'edit'])->name('professionals.edit')->middleware('permission:edit');
        Route::put('professionals/{professional}',       [ProfessionalController::class, 'update'])->name('professionals.update')->middleware('permission:edit');
        Route::delete('professionals/{professional}',    [ProfessionalController::class, 'destroy'])->name('professionals.destroy')->middleware('permission:delete');
        Route::post('professionals/{professional}/reset-password',   [ProfessionalController::class, 'resetPassword'])->name('professionals.reset-password')->middleware('permission:edit');
        Route::patch('professionals/{professional}/toggle-verify',   [ProfessionalController::class, 'toggleVerify'])->name('professionals.toggle-verify')->middleware('permission:edit');

        // ── Tenders ───────────────────────────────────────────────────────────
        Route::get('tenders',            [TenderController::class, 'index'])->name('tenders.index')->middleware('permission:review');
        Route::get('tenders/create',     [TenderController::class, 'create'])->name('tenders.create')->middleware('permission:add');
        Route::post('tenders',           [TenderController::class, 'store'])->name('tenders.store')->middleware('permission:add');
        Route::get('tenders/{tender}',   [TenderController::class, 'show'])->name('tenders.show')->middleware('permission:review');
        Route::get('tenders/{tender}/edit', [TenderController::class, 'edit'])->name('tenders.edit')->middleware('permission:edit');
        Route::put('tenders/{tender}',      [TenderController::class, 'update'])->name('tenders.update')->middleware('permission:edit');
        Route::delete('tenders/{tender}',   [TenderController::class, 'destroy'])->name('tenders.destroy')->middleware('permission:delete');
        Route::patch('tenders/{tender}/toggle', [TenderController::class, 'toggleStatus'])->name('tenders.toggle')->middleware('permission:edit');

        // ── Architectural Designs ─────────────────────────────────────────────
        Route::get('design-categories',                  [ArchitecturalDesignController::class, 'designCategoryIndex'])->name('design-categories.index')->middleware('permission:review');
        Route::post('design-categories',                 [ArchitecturalDesignController::class, 'designCategoryStore'])->name('design-categories.store')->middleware('permission:add');
        Route::put('design-categories/{design_category}',[ArchitecturalDesignController::class, 'designCategoryUpdate'])->name('design-categories.update')->middleware('permission:edit');
        Route::delete('design-categories/{design_category}',[ArchitecturalDesignController::class, 'designCategoryDestroy'])->name('design-categories.destroy')->middleware('permission:delete');

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

        // ── News Ads ──────────────────────────────────────────────────────────
        Route::get('ads',             [NewsAdsController::class, 'adsIndex'])->name('ads.index')->middleware('permission:review');
        Route::get('ads/create',      [NewsAdsController::class, 'adsCreate'])->name('ads.create')->middleware('permission:add');
        Route::post('ads',            [NewsAdsController::class, 'adsStore'])->name('ads.store')->middleware('permission:add');
        Route::get('ads/{ad}',        [NewsAdsController::class, 'adsShow'])->name('ads.show')->middleware('permission:review');
        Route::get('ads/{ad}/edit',   [NewsAdsController::class, 'adsEdit'])->name('ads.edit')->middleware('permission:edit');
        Route::put('ads/{ad}',        [NewsAdsController::class, 'adsUpdate'])->name('ads.update')->middleware('permission:edit');
        Route::delete('ads/{ad}',     [NewsAdsController::class, 'adsDestroy'])->name('ads.destroy')->middleware('permission:delete');

        // ── Announcements ─────────────────────────────────────────────────────
        Route::get('announcements',                     [AnnouncementController::class, 'index'])->name('announcements.index')->middleware('permission:review');
        Route::get('announcements/create',              [AnnouncementController::class, 'create'])->name('announcements.create')->middleware('permission:add');
        Route::post('announcements',                    [AnnouncementController::class, 'store'])->name('announcements.store')->middleware('permission:add');
        Route::get('announcements-trash',               [AnnouncementController::class, 'trashed'])->name('announcements.trashed')->middleware('permission:review');
        Route::get('announcements/{announcement}',      [AnnouncementController::class, 'show'])->name('announcements.show')->middleware('permission:review');
        Route::get('announcements/{announcement}/edit', [AnnouncementController::class, 'edit'])->name('announcements.edit')->middleware('permission:edit');
        Route::put('announcements/{announcement}',      [AnnouncementController::class, 'update'])->name('announcements.update')->middleware('permission:edit');
        Route::delete('announcements/{announcement}',   [AnnouncementController::class, 'destroy'])->name('announcements.destroy')->middleware('permission:delete');
        Route::patch('announcements/{announcement}/status',  [AnnouncementController::class, 'updateStatus'])->name('announcements.status')->middleware('permission:edit');
        Route::patch('announcements/{id}/restore',           [AnnouncementController::class, 'restore'])->name('announcements.restore')->middleware('permission:edit');
        Route::delete('announcements/{id}/force-delete',     [AnnouncementController::class, 'forceDelete'])->name('announcements.force-delete')->middleware('permission:delete');

        // ── Services ──────────────────────────────────────────────────────────
        Route::get('service-categories',                    [ServiceCategoryController::class, 'index'])->name('service-categories.index')->middleware('permission:review');
        Route::get('service-categories/create',             [ServiceCategoryController::class, 'create'])->name('service-categories.create')->middleware('permission:add');
        Route::post('service-categories',                   [ServiceCategoryController::class, 'store'])->name('service-categories.store')->middleware('permission:add');
        Route::get('service-categories/{service_category}/edit',   [ServiceCategoryController::class, 'edit'])->name('service-categories.edit')->middleware('permission:edit');
        Route::put('service-categories/{service_category}',        [ServiceCategoryController::class, 'update'])->name('service-categories.update')->middleware('permission:edit');
        Route::delete('service-categories/{service_category}',     [ServiceCategoryController::class, 'destroy'])->name('service-categories.destroy')->middleware('permission:delete');

        Route::get('service-subcategories',                         [ServiceSubCategoryController::class, 'index'])->name('service-subcategories.index')->middleware('permission:review');
        Route::get('service-subcategories/create',                  [ServiceSubCategoryController::class, 'create'])->name('service-subcategories.create')->middleware('permission:add');
        Route::post('service-subcategories',                        [ServiceSubCategoryController::class, 'store'])->name('service-subcategories.store')->middleware('permission:add');
        Route::get('service-subcategories/{service_subcategory}/edit',  [ServiceSubCategoryController::class, 'edit'])->name('service-subcategories.edit')->middleware('permission:edit');
        Route::put('service-subcategories/{service_subcategory}',       [ServiceSubCategoryController::class, 'update'])->name('service-subcategories.update')->middleware('permission:edit');
        Route::delete('service-subcategories/{service_subcategory}',    [ServiceSubCategoryController::class, 'destroy'])->name('service-subcategories.destroy')->middleware('permission:delete');

        Route::get('services',           [ServiceController::class, 'index'])->name('services.index')->middleware('permission:review');
        Route::get('services/create',    [ServiceController::class, 'create'])->name('services.create')->middleware('permission:add');
        Route::post('services',          [ServiceController::class, 'store'])->name('services.store')->middleware('permission:add');
        Route::get('services/{service}/edit',  [ServiceController::class, 'edit'])->name('services.edit')->middleware('permission:edit');
        Route::put('services/{service}',       [ServiceController::class, 'update'])->name('services.update')->middleware('permission:edit');
        Route::delete('services/{service}',    [ServiceController::class, 'destroy'])->name('services.destroy')->middleware('permission:delete');

        // ── Consultants ───────────────────────────────────────────────────────
        Route::get('consultants',            [ConsultantController::class, 'index'])->name('consultants.index')->middleware('permission:review');
        Route::get('consultants/create',     [ConsultantController::class, 'create'])->name('consultants.create')->middleware('permission:add');
        Route::post('consultants',           [ConsultantController::class, 'store'])->name('consultants.store')->middleware('permission:add');
        Route::get('consultants/{consultant}',       [ConsultantController::class, 'show'])->name('consultants.show')->middleware('permission:review');
        Route::get('consultants/{consultant}/edit',  [ConsultantController::class, 'edit'])->name('consultants.edit')->middleware('permission:edit');
        Route::put('consultants/{consultant}',       [ConsultantController::class, 'update'])->name('consultants.update')->middleware('permission:edit');
        Route::delete('consultants/{consultant}',    [ConsultantController::class, 'destroy'])->name('consultants.destroy')->middleware('permission:delete');
        Route::post('consultants/{consultant}/reset-password', [ConsultantController::class, 'resetPassword'])->name('consultants.reset-password')->middleware('permission:edit');
        Route::patch('consultants/{consultant}/verify',        [ConsultantController::class, 'activateConsultant'])->name('consultants.verify')->middleware('permission:edit');

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

        // ── Partners ──────────────────────────────────────────────────────────
        Route::get('partners',               [PartnersController::class, 'index'])->name('partners.index')->middleware('permission:review');
        Route::post('partners',              [PartnersController::class, 'store'])->name('partners.store')->middleware('permission:add');
        Route::put('partners/{partner}',     [PartnersController::class, 'update'])->name('partners.update')->middleware('permission:edit');
        Route::delete('partners/{partner}',  [PartnersController::class, 'destroy'])->name('partners.destroy')->middleware('permission:delete');

        // ── Facilities ────────────────────────────────────────────────────────
        Route::get('facilities',               [FacilityController::class, 'index'])->name('facilities.index')->middleware('permission:review');
        Route::post('facilities',              [FacilityController::class, 'store'])->name('facilities.store')->middleware('permission:add');
        Route::put('facilities/{facility}',    [FacilityController::class, 'update'])->name('facilities.update')->middleware('permission:edit');
        Route::delete('facilities/{facility}', [FacilityController::class, 'destroy'])->name('facilities.destroy')->middleware('permission:delete');

        // ── Blogs ─────────────────────────────────────────────────────────────
        Route::get('blogs',            [BlogController::class, 'index'])->name('blogs.index')->middleware('permission:review');
        Route::get('blogs/create',     [BlogController::class, 'create'])->name('blogs.create')->middleware('permission:add');
        Route::post('blogs',           [BlogController::class, 'store'])->name('blogs.store')->middleware('permission:add');
        Route::get('blogs/{blog}',     [BlogController::class, 'show'])->name('blogs.show')->middleware('permission:review');
        Route::get('blogs/{blog}/edit',[BlogController::class, 'edit'])->name('blogs.edit')->middleware('permission:edit');
        Route::put('blogs/{blog}',     [BlogController::class, 'update'])->name('blogs.update')->middleware('permission:edit');
        Route::delete('blogs/{blog}',  [BlogController::class, 'destroy'])->name('blogs.destroy')->middleware('permission:delete');
        Route::patch('blogs/{blog}/toggle', [BlogController::class, 'togglePublish'])->name('blogs.toggle')->middleware('permission:edit');

        Route::get('blog-categories',              [BlogCategoryController::class, 'index'])->name('blog-categories.index')->middleware('permission:review');
        Route::get('blog-categories/create',       [BlogCategoryController::class, 'create'])->name('blog-categories.create')->middleware('permission:add');
        Route::post('blog-categories',             [BlogCategoryController::class, 'store'])->name('blog-categories.store')->middleware('permission:add');
        Route::get('blog-categories/{blog_category}',       [BlogCategoryController::class, 'show'])->name('blog-categories.show')->middleware('permission:review');
        Route::get('blog-categories/{blog_category}/edit',  [BlogCategoryController::class, 'edit'])->name('blog-categories.edit')->middleware('permission:edit');
        Route::put('blog-categories/{blog_category}',       [BlogCategoryController::class, 'update'])->name('blog-categories.update')->middleware('permission:edit');
        Route::delete('blog-categories/{blog_category}',    [BlogCategoryController::class, 'destroy'])->name('blog-categories.destroy')->middleware('permission:delete');

        // ── Commissions ───────────────────────────────────────────────────────
        Route::get('commissions',                        [CommissionController::class, 'index'])->name('commissions.index')->middleware('permission:review');
        Route::get('commissions/{commission}',           [CommissionController::class, 'show'])->name('commissions.show')->middleware('permission:review');
        Route::delete('commissions/{commission}',        [CommissionController::class, 'destroy'])->name('commissions.destroy')->middleware('permission:delete');
        Route::patch('commissions/{commission}/approve', [CommissionController::class, 'approve'])->name('commissions.approve')->middleware('permission:edit');
        Route::patch('commissions/{commission}/pay',     [CommissionController::class, 'markPaid'])->name('commissions.pay')->middleware('permission:edit');

        // ── Activity Logs ─────────────────────────────────────────────────────
        Route::get('activity-logs',         [ActivityLogController::class, 'index'])->name('activity-logs.index')->middleware('permission:review');
        Route::get('activity-logs/export',  [ActivityLogController::class, 'export'])->name('activity-logs.export')->middleware('permission:review');

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

        Route::get('commission-tiers',           [ConsultantCommissionTierController::class, 'index'])->name('commission-tiers.index')->middleware('permission:review');
        Route::get('commission-tiers/create',    [ConsultantCommissionTierController::class, 'create'])->name('commission-tiers.create')->middleware('permission:add');
        Route::post('commission-tiers',          [ConsultantCommissionTierController::class, 'store'])->name('commission-tiers.store')->middleware('permission:add');
        Route::get('commission-tiers/{commission_tier}',       [ConsultantCommissionTierController::class, 'show'])->name('commission-tiers.show')->middleware('permission:review');
        Route::get('commission-tiers/{commission_tier}/edit',  [ConsultantCommissionTierController::class, 'edit'])->name('commission-tiers.edit')->middleware('permission:edit');
        Route::put('commission-tiers/{commission_tier}',       [ConsultantCommissionTierController::class, 'update'])->name('commission-tiers.update')->middleware('permission:edit');
        Route::delete('commission-tiers/{commission_tier}',    [ConsultantCommissionTierController::class, 'destroy'])->name('commission-tiers.destroy')->middleware('permission:delete');

        Route::get('agent-levels',           [AgentLevelController::class, 'index'])->name('agent-levels.index')->middleware('permission:review');
        Route::get('agent-levels/create',    [AgentLevelController::class, 'create'])->name('agent-levels.create')->middleware('permission:add');
        Route::post('agent-levels',          [AgentLevelController::class, 'store'])->name('agent-levels.store')->middleware('permission:add');
        Route::get('agent-levels/{agent_level}',       [AgentLevelController::class, 'show'])->name('agent-levels.show')->middleware('permission:review');
        Route::get('agent-levels/{agent_level}/edit',  [AgentLevelController::class, 'edit'])->name('agent-levels.edit')->middleware('permission:edit');
        Route::put('agent-levels/{agent_level}',       [AgentLevelController::class, 'update'])->name('agent-levels.update')->middleware('permission:edit');
        Route::delete('agent-levels/{agent_level}',    [AgentLevelController::class, 'destroy'])->name('agent-levels.destroy')->middleware('permission:delete');

        Route::get('duration-discounts',           [DurationDiscountController::class, 'index'])->name('duration-discounts.index')->middleware('permission:review');
        Route::get('duration-discounts/create',    [DurationDiscountController::class, 'create'])->name('duration-discounts.create')->middleware('permission:add');
        Route::post('duration-discounts',          [DurationDiscountController::class, 'store'])->name('duration-discounts.store')->middleware('permission:add');
        Route::get('duration-discounts/{duration_discount}',       [DurationDiscountController::class, 'show'])->name('duration-discounts.show')->middleware('permission:review');
        Route::get('duration-discounts/{duration_discount}/edit',  [DurationDiscountController::class, 'edit'])->name('duration-discounts.edit')->middleware('permission:edit');
        Route::put('duration-discounts/{duration_discount}',       [DurationDiscountController::class, 'update'])->name('duration-discounts.update')->middleware('permission:edit');
        Route::delete('duration-discounts/{duration_discount}',    [DurationDiscountController::class, 'destroy'])->name('duration-discounts.destroy')->middleware('permission:delete');

        // ── Advertisements ────────────────────────────────────────────────────
        Route::get('advertisements',                   [App\Http\Controllers\Admin\AdvertisementController::class, 'index'])->name('advertisements.index')->middleware('permission:review');
        Route::get('advertisements/create',            [App\Http\Controllers\Admin\AdvertisementController::class, 'create'])->name('advertisements.create')->middleware('permission:add');
        Route::post('advertisements',                  [App\Http\Controllers\Admin\AdvertisementController::class, 'store'])->name('advertisements.store')->middleware('permission:add');
        Route::get('advertisements/{advertisement}',         [App\Http\Controllers\Admin\AdvertisementController::class, 'show'])->name('advertisements.show')->middleware('permission:review');
        Route::get('advertisements/{advertisement}/edit',    [App\Http\Controllers\Admin\AdvertisementController::class, 'edit'])->name('advertisements.edit')->middleware('permission:edit');
        Route::put('advertisements/{advertisement}',         [App\Http\Controllers\Admin\AdvertisementController::class, 'update'])->name('advertisements.update')->middleware('permission:edit');
        Route::delete('advertisements/{advertisement}',      [App\Http\Controllers\Admin\AdvertisementController::class, 'destroy'])->name('advertisements.destroy')->middleware('permission:delete');
        Route::post('advertisements/{advertisement}/approve',     [App\Http\Controllers\Admin\AdvertisementController::class, 'approve'])->name('advertisements.approve')->middleware('permission:edit');
        Route::post('advertisements/{advertisement}/reject',      [App\Http\Controllers\Admin\AdvertisementController::class, 'reject'])->name('advertisements.reject')->middleware('permission:edit');
        Route::post('advertisements/{advertisement}/pause',       [App\Http\Controllers\Admin\AdvertisementController::class, 'pause'])->name('advertisements.pause')->middleware('permission:edit');
        Route::post('advertisements/{advertisement}/reactivate',  [App\Http\Controllers\Admin\AdvertisementController::class, 'reactivate'])->name('advertisements.reactivate')->middleware('permission:edit');
        Route::post('advertisements/{advertisement}/mark-paid',   [App\Http\Controllers\Admin\AdvertisementController::class, 'markPaid'])->name('advertisements.markPaid')->middleware('permission:edit');
        Route::post('advertisements/{advertisement}/mark-unpaid', [App\Http\Controllers\Admin\AdvertisementController::class, 'markUnpaid'])->name('advertisements.markUnpaid')->middleware('permission:edit');
    });


// =============================================================================
// ADMIN — Tasks (auth + role:admin,staff)
// =============================================================================

Route::middleware(['auth', 'role:admin,staff'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {

        // Static routes FIRST — must precede /{task} wildcard
        Route::get('tasks',              [TaskController::class, 'index'])->name('tasks.index')->middleware('permission:review');
        Route::get('tasks/create',       [TaskController::class, 'create'])->name('tasks.create')->middleware('permission:add');
        Route::get('tasks/submissions',  [TaskController::class, 'allSubmissions'])->name('tasks.submissions.index')->middleware('permission:review');
        Route::post('tasks/bulk',        [TaskController::class, 'bulk'])->name('tasks.bulk')->middleware('permission:edit');
        Route::post('tasks',             [TaskController::class, 'store'])->name('tasks.store')->middleware('permission:add');

        // Dynamic {task} routes AFTER all static prefixes
        Route::get('tasks/{task}',      [TaskController::class, 'show'])->name('tasks.show')->middleware('permission:review');
        Route::get('tasks/{task}/edit', [TaskController::class, 'edit'])->name('tasks.edit')->middleware('permission:edit');
        Route::put('tasks/{task}',      [TaskController::class, 'update'])->name('tasks.update')->middleware('permission:edit');
        Route::delete('tasks/{task}',   [TaskController::class, 'destroy'])->name('tasks.destroy')->middleware('permission:delete');
        Route::patch('tasks/{task}/status',   [TaskController::class, 'updateStatus'])->name('tasks.status')->middleware('permission:edit');
        Route::patch('tasks/{task}/complete', [TaskController::class, 'complete'])->name('tasks.complete')->middleware('permission:edit');
        Route::get('tasks/{task}/submissions',[TaskController::class, 'submissions'])->name('tasks.submissions')->middleware('permission:review');

        // Submissions (no {task} in path — safe anywhere)
        Route::patch('submissions/{submission}/approve', [TaskController::class, 'approveSubmission'])->name('tasks.submissions.approve')->middleware('permission:edit');
        Route::patch('submissions/{submission}/reject',  [TaskController::class, 'rejectSubmission'])->name('tasks.submissions.reject')->middleware('permission:edit');

        // Documents
        Route::get('documents/{document}/download', [TaskController::class, 'downloadDocument'])->name('documents.download')->middleware('permission:review');
    });


// =============================================================================
// ADMIN — Bookings (auth)
// =============================================================================

Route::middleware(['auth'])
    ->prefix('admin/bookings')
    ->name('admin.bookings.')
    ->group(function () {

        Route::get('/',                          [BookingAdminController::class, 'index'])->name('index')->middleware('permission:review');
        Route::get('/{booking}',                 [BookingAdminController::class, 'show'])->name('show')->middleware('permission:review');
        Route::post('/{booking}/confirm',        [BookingAdminController::class, 'confirm'])->name('confirm')->middleware('permission:edit');
        Route::post('/{booking}/reject',         [BookingAdminController::class, 'reject'])->name('reject')->middleware('permission:edit');
        Route::post('/{booking}/mark-completed', [BookingAdminController::class, 'markCompleted'])->name('mark-completed')->middleware('permission:edit');
        Route::delete('/{booking}/delete',       [BookingAdminController::class, 'destroy'])->name('destroy')->middleware('permission:delete');
    });


// =============================================================================
// ADMIN — Job Listings (auth)
// =============================================================================

Route::middleware(['auth'])
    ->prefix('admin/job-listings')
    ->name('admin.job-listings.')
    ->group(function () {

        // Static routes FIRST
        Route::get('/',              [AdminJobListingController::class, 'index'])->name('index')->middleware('permission:review');
        Route::get('/create',        [AdminJobListingController::class, 'create'])->name('create')->middleware('permission:add');
        Route::post('/post',         [AdminJobListingController::class, 'store'])->name('store')->middleware('permission:add');
        Route::post('/price-preview',[AdminJobListingController::class, 'pricePreview'])->name('price-preview')->middleware('permission:review');
        Route::get('/edit/{job}',    [AdminJobListingController::class, 'edit'])->name('edit')->middleware('permission:edit');
        Route::put('/post/{job}',    [AdminJobListingController::class, 'update'])->name('update')->middleware('permission:edit');

        // Dynamic {job} routes
        Route::get('/{job}/payment',  [AdminJobListingController::class, 'payment'])->name('payment')->middleware('permission:review');
        Route::post('/{job}/payment', [AdminJobListingController::class, 'confirmPayment'])->name('payment.confirm')->middleware('permission:edit');

        // {jobListing} action routes
        Route::get('/job-listings/{jobListing}',               [AdminJobListingController::class, 'show'])->name('show')->middleware('permission:review');
        Route::post('/job-listings/{jobListing}/activate',     [AdminJobListingController::class, 'activate'])->name('activate')->middleware('permission:edit');
        Route::post('/job-listings/{jobListing}/reject',       [AdminJobListingController::class, 'reject'])->name('reject')->middleware('permission:edit');
        Route::post('/job-listings/{jobListing}/expire',       [AdminJobListingController::class, 'expire'])->name('expire')->middleware('permission:edit');
        Route::delete('/job-listings/{jobListing}',            [AdminJobListingController::class, 'destroy'])->name('destroy')->middleware('permission:delete');
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

Route::get('/subcategories/{category}', [ServiceController::class, 'getSubcategories'])->name('services.subcategories');

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
        Route::post('/agent/lands/{lands}/images/upload',  [AgentLandController::class, 'uploadImages'])->name('agent.properties.lands.images.upload');
        Route::get('/agent/lands/{lands}/images/download', [AgentLandController::class, 'downloadImages'])->name('agent.properties.lands.images.download');
        Route::delete('/agent/lands/{lands}/images/{image}', [AgentLandController::class, 'deleteImage'])->name('agent.properties.lands.images.delete');

        Route::get('/agents', [AgentController::class, 'index'])->name('agents.agents.index');
        Route::get('/agents/create', [AgentController::class, 'create'])->name('agents.agents.create');
        Route::post('/agents', [AgentController::class, 'store'])->name('agents.agents.store');
        Route::get('/agents/{agent}', [AgentController::class, 'show'])->name('agents.agents.show');

        Route::get('/professionals', [ProfessionalController::class, 'index'])->name('agents.professionals.index');
        Route::get('/professionals/create', [ProfessionalController::class, 'create'])->name('agents.professionals.create');
        Route::post('/professionals', [ProfessionalController::class, 'store'])->name('agents.professionals.store');
        Route::get('/professionals/{professional}', [ProfessionalController::class, 'show'])->name('agents.professionals.show');

        Route::get('/tenders/create', [TenderController::class, 'create'])->name('agents.tenders.create');
        Route::post('/tenders', [TenderController::class, 'store'])->name('agents.tenders.store');
        Route::get('/tenders', [TenderController::class, 'index'])->name('agents.tenders.index');
        Route::get('/tenders/{tender}', [TenderController::class, 'show'])->name('agents.tenders.show');
        Route::get('/tenders/{tender}/edit', [TenderController::class, 'edit'])->name('agents.tenders.edit');
        Route::put('/tenders/{tender}', [TenderController::class, 'update'])->name('agents.tenders.update');
        Route::delete('/tenders/{tender}', [TenderController::class, 'destroy'])->name('agents.tenders.destroy');

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

        Route::get('ads', [NewsAdsController::class, 'adsIndex'])->name('agents.ads.index');
        Route::get('ads/create', [NewsAdsController::class, 'adsCreate'])->name('agents.ads.create');
        Route::post('ads', [NewsAdsController::class, 'adsStore'])->name('agents.ads.store');
        Route::get('ads/{ad}/edit', [NewsAdsController::class, 'adsEdit'])->name('agents.ads.edit');
        Route::get('ads/{ad}', [NewsAdsController::class, 'adsSow'])->name('agents.ads.show');
        Route::put('ads/{ad}', [NewsAdsController::class, 'adsUpdate'])->name('agents.ads.update');
        Route::delete('ads/{ad}', [NewsAdsController::class, 'adsDestroy'])->name('agents.ads.destroy');

        Route::get('announcements', [NewsAdsController::class, 'announceIndex'])->name('agents.announcements.index');
        Route::get('announcements/create', [NewsAdsController::class, 'announceCreate'])->name('agents.announcements.create');
        Route::post('announcements', [NewsAdsController::class, 'announceStore'])->name('agents.announcements.store');
        Route::get('announcements/{announcement}', [NewsAdsController::class, 'announceSow'])->name('agents.announcements.show');
        Route::get('announcements/{announcement}/edit', [NewsAdsController::class, 'announceEdit'])->name('agents.announcements.edit');
        Route::put('announcements/{announcement}', [NewsAdsController::class, 'announceUpdate'])->name('agents.announcements.update');
        Route::delete('announcements/{announcement}', [NewsAdsController::class, 'announceDestroy'])->name('agents.announcements.destroy');



        Route::get('/services', [AgentProfileController::class, 'indexServices'])->name('agents.services.index');
        Route::get('/services/edit', [AgentProfileController::class, 'editServices'])->name('agents.services.edit');
        Route::post('/services', [AgentProfileController::class, 'updateServices'])->name('agents.services.update');

        Route::get('/consultants', [ConsultantController::class, 'index'])->name('agents.consultants.index');
        Route::get('/consultants/create', [ConsultantController::class, 'create'])->name('agents.consultants.create');
        Route::post('/consultants', [ConsultantController::class, 'store'])->name('agents.consultants.store');
        Route::get('consultants/{consultant}/edit', [ConsultantController::class, 'edit'])->name('agents.consultants.edit');
        Route::get('/consultants/{consultant}', [ConsultantController::class, 'show'])->name('agents.consultants.show');
        Route::delete('consultants/{consultant}', [ConsultantController::class, 'destroy'])->name('agents.consultants.destroy');
    });



Route::prefix('payment')->name('payment.')->middleware(['auth'])->group(function () {

    // Show payment details + method selector
    Route::get('/{reference}',           [PaymentController::class, 'show'])->name('show');

    // Submit payment method & phone, trigger gateway push
    Route::post('/{reference}/initiate', [PaymentController::class, 'initiate'])->name('initiate');

    // Waiting / polling page
    Route::get('/{reference}/pending',   [PaymentController::class, 'pending'])->name('pending');

    // AJAX status poll  →  returns JSON { status, redirectUrl }
    Route::get('/{reference}/status',    [PaymentController::class, 'status'])->name('status');

    Route::post('/{reference}/confirm', [PaymentController::class, 'confirm'])->name('confirm');

    // Success receipt page
    Route::get('/{reference}/success',   [PaymentController::class, 'success'])->name('success');
});

// ── Webhook: no auth, but verify signature inside the controller ──────────
Route::post('/payment/callback', [PaymentController::class, 'callback'])
    ->name('payment.callback')
    ->withoutMiddleware(['auth', 'verified']);


Route::get('/run-storage-link', function () {
    Artisan::call('storage:link');
    return 'Storage link created!';
});

Route::get('/run-migration', function () {
    Artisan::call('migrate');

    return 'Database migrated successfully!';
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

// ── Authenticated user flow ──────────────────────────────────────────────────
Route::resource('terra/advertisements', AdvertisementController::class)->only(['index', 'create', 'store', 'show']);
Route::get('advertisements/{advertisement}/payment',  [AdvertisementController::class, 'payment'])->name('advertisements.payment');
Route::post('advertisements/{advertisement}/payment', [AdvertisementController::class, 'submitPayment'])->name('advertisements.submit-payment');


Route::middleware(['auth'])->group(function () {

    // Dashboard home
    // Route::get('/users/dashboard', [UserDashboardController::class, 'index'])
    //     ->name('users.dashboard.index');
    Route::get('/users/dashboard', [UsersDashboardController::class, 'index'])->name('users.dashboard.index');

    Route::get('/users/tasks', [UsersTasksController::class, 'index'])->name('users.tasks.index');
    // Submit a task with file upload
    Route::post('/users/dashboard/submit-task', [UsersTasksController::class, 'submitTask'])
        ->name('tasks.submit');

    // Task detail
    Route::get('/tasks/{task}', [UsersTasksController::class, 'showTask'])
        ->name('tasks.show');

    // Secure document download
    Route::get('/documents/{document}/download', [UsersTasksController::class, 'downloadDocument'])
        ->name('documents.download');

    Route::get('users/bookings/', [ConsultantBookingController::class, 'index'])
        ->name('consultant.bookings.index');
    Route::patch('consultant/bookings/{booking}/status', [ConsultantBookingController::class, 'updateStatus'])
        ->name('consultant.bookings.updateStatus');

    Route::get('/clients', [UsersClientController::class, 'index'])->name('users.clients.index');
    Route::get('/clients/{client}', [UsersClientController::class, 'show'])->name('users.clients.show');

    Route::get('/calendar',              [ConsultantCalendarController::class, 'index'])->name('calendar.index');
    Route::post('/calendar/toggle',      [ConsultantCalendarController::class, 'toggleUnavailable'])->name('calendar.toggle');
    Route::get('/calendar/export',       [ConsultantCalendarController::class, 'exportIcal'])->name('calendar.export');

    Route::get('/users/earnings', [EarningController::class, 'index'])
        ->name('users.earnings.index');
});

Route::middleware(['auth', 'role:consultant'])->prefix('consultant')->name('consultant.')->group(function () {
 
    Route::get('/profile/edit',  [\App\Http\Controllers\Users\ProfileController::class, 'edit'])
        ->name('profile.edit');
 
    Route::put('/profile',       [\App\Http\Controllers\Users\ProfileController::class, 'update'])
        ->name('profile.update');
 
    Route::post('/profile/verify-request', [\App\Http\Controllers\Users\ProfileController::class, 'verifyRequest'])
        ->name('profile.verify-request');
 
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

Route::prefix('professional')
    ->name('professional.')
    ->middleware(['auth'])
    ->group(function () {
 
        // ── Dashboard Overview ──────────────────────────────────────────
        Route::get('/dashboard', [ProfessionalDashboardController::class, 'index'])
            ->name('dashboard');
 
        // ── Profile ─────────────────────────────────────────────────────
        Route::get('/profile', [ProfessionalDashboardController::class, 'profile'])
            ->name('profile');
 
        // ── Architectural Designs ────────────────────────────────────────
        Route::prefix('architectural-designs')->name('architectural-designs.')->group(function () {
 
            Route::get('/',          [ProfessionalDashboardController::class, 'designsIndex'])  ->name('index');
            Route::get('/create',    [ProfessionalDashboardController::class, 'designsCreate']) ->name('create');
            Route::post('/',         [ProfessionalDashboardController::class, 'designsStore'])  ->name('store');
            Route::get('/{architecturalDesign}/show',  [ProfessionalDashboardController::class, 'designsShow'])   ->name('show');
            Route::get('/{architecturalDesign}/edit', [ProfessionalDashboardController::class, 'designsEdit'])   ->name('edit');
            Route::put('/{architecturalDesign}',  [ProfessionalDashboardController::class, 'designsUpdate']) ->name('update');
            Route::delete('/{architecturalDesign}', [ProfessionalDashboardController::class, 'designsDestroy'])->name('destroy');
        });
 
        // ── Orders (Inquiries from Users) ────────────────────────────────
        Route::prefix('orders')->name('orders.')->group(function () {
 
            Route::get('/',            [ProfessionalDashboardController::class, 'ordersIndex'])        ->name('index');
            Route::get('/{order}',     [ProfessionalDashboardController::class, 'ordersShow'])         ->name('show');
            Route::patch('/{order}/status', [ProfessionalDashboardController::class, 'ordersUpdateStatus'])->name('update-status');
        });
    });
    
require __DIR__ . '/auth.php';
