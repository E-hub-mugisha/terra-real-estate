<?php

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\Properties\HouseController;
use App\Http\Controllers\Admin\Properties\LandController;
use App\Http\Controllers\Admin\TenderController;
use App\Http\Controllers\Admin\Users\AgentController;
use App\Http\Controllers\Admin\Users\ProfessionalController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PropertyController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// routes/web.php
Route::middleware(['auth'])->group(function () {
    Route::resource('properties', PropertyController::class);
});

// routes/web.php
Route::middleware(['auth'])->prefix('admin')->group(function () {

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');
    Route::get('/create/properties', [PropertyController::class, 'create'])->name('admin.property.create');
    Route::get('/properties/pending', [PropertyController::class, 'index'])->name('admin.properties.pending');
    Route::post('/properties/{property}/approve', [PropertyController::class, 'approve'])->name('admin.properties.approve');
});

Route::middleware(['auth'])->group(function () {
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
});
require __DIR__ . '/auth.php';
