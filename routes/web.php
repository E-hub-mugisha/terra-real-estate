<?php

use App\Http\Controllers\Admin\ArchitecturalDesignController;
use App\Http\Controllers\Admin\ConsultantController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\NewsAdsController;
use App\Http\Controllers\Admin\Properties\HouseController;
use App\Http\Controllers\Admin\Properties\LandController;
use App\Http\Controllers\Admin\ServiceCategoryController;
use App\Http\Controllers\Admin\ServiceController;
use App\Http\Controllers\Admin\ServiceSubCategoryController;
use App\Http\Controllers\Admin\TenderController;
use App\Http\Controllers\Admin\Users\AgentController;
use App\Http\Controllers\Admin\Users\ProfessionalController;
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
Route::get('/properties/{district}', function ($district) {
    $houses = \App\Models\House::where('state', $district)->where('status', 'for_sale')->get();

    $lands = \App\Models\Land::where('district', $district)->where('status', 'available')->get();

    return view('properties.by-district', compact('district', 'houses', 'lands'));
})->name('properties.by.district');

Route::prefix('designs')->group(function () {
    Route::get('/', [MarketplaceController::class, 'index'])->name('front.buy.design'); // Marketplace listing
    Route::get('/{slug}', [MarketplaceController::class, 'show'])->name('front.buy.design.show'); // Design details page
    Route::get('/purchase/{slug}', [MarketplaceController::class, 'purchase'])->name('front.buy.design.purchase'); // Purchase page
    Route::post('/inquiry', [MarketplaceController::class, 'sendInquiry'])->name('front.buy.design.inquiry');
    Route::get('download/{slug}', [MarketplaceController::class, 'download'])->name('front.buy.design.download');
});

Route::get('/ads', [AnAdsController::class, 'showAds'])->name('front.ads.index');
Route::get('/announcements', [AnAdsController::class, 'showAnnouncements'])->name('front.announcements.index');

Route::get('/services/{category:slug}', [HomeServiceController::class, 'category'])
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

Route::get('/dashboard', function () {
    return view('dashboard');
})
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

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

        Route::get('/admin/land', [LandController::class, 'index'])->name('admin.properties.land.index');
        Route::get('/lands/create', [LandController::class, 'create'])->name('admin.properties.lands.create');
        Route::post('/lands', [LandController::class, 'store'])->name('admin.properties.lands.store');
        Route::get('/lands/{land}', [LandController::class, 'show'])->name('admin.properties.lands.show');

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
    });
require __DIR__ . '/auth.php';
