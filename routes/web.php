<?php

use App\Http\Controllers\Admin\ArchitecturalDesignController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\NewsAdsController;
use App\Http\Controllers\Admin\Properties\HouseController;
use App\Http\Controllers\Admin\Properties\LandController;
use App\Http\Controllers\Admin\TenderController;
use App\Http\Controllers\Admin\Users\AgentController;
use App\Http\Controllers\Admin\Users\ProfessionalController;
use App\Http\Controllers\Front\HomeController;
use App\Http\Controllers\Front\MarketplaceController;
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
        
    });
require __DIR__ . '/auth.php';
