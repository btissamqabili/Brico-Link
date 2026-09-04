<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\MissionController;
use App\Http\Controllers\PrestataireMissionController;
Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return match (auth()->user()->role) {
        'client' => view('dashboard.client'),
        'prestataire' => view('dashboard.prestataire'),
        'admin' => view('dashboard.admin'),
    };
})->middleware(['auth', 'verified'])->name('dashboard');
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

/*
|--------------------------------------------------------------------------
| Test des rôles
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'role:client'])->get('/client', function () {
    return 'Espace Client';
});

Route::middleware(['auth', 'role:prestataire'])->get('/prestataire', function () {
    return 'Espace Prestataire';
});

Route::middleware(['auth', 'role:admin'])->get('/admin', function () {
    return 'Espace Admin';
});

require __DIR__.'/auth.php';
Route::middleware(['auth', 'role:prestataire'])->group(function () {
    Route::get('/services', [ServiceController::class, 'index'])
        ->name('services.index');

    Route::get('/services/create', [ServiceController::class, 'create'])
        ->name('services.create');

    Route::post('/services', [ServiceController::class, 'store'])
        ->name('services.store');
        Route::get('/services/{service}/edit', [ServiceController::class, 'edit'])
    ->name('services.edit');

Route::put('/services/{service}', [ServiceController::class, 'update'])
    ->name('services.update');
    Route::delete('/services/{service}', [ServiceController::class, 'destroy'])
    ->name('services.destroy');
});
Route::middleware(['auth', 'role:client'])->group(function () {

    Route::get('/missions', [MissionController::class, 'index'])
        ->name('missions.index');

    Route::get('/missions/create', [MissionController::class, 'create'])
        ->name('missions.create');

    Route::post('/missions', [MissionController::class, 'store'])
        ->name('missions.store');

    Route::get('/missions/{mission}/edit', [MissionController::class, 'edit'])
        ->name('missions.edit');

    Route::put('/missions/{mission}', [MissionController::class, 'update'])
        ->name('missions.update');

    Route::delete('/missions/{mission}', [MissionController::class, 'destroy'])
        ->name('missions.destroy');
});
Route::middleware(['auth', 'role:prestataire'])->group(function () {
    Route::get('/missions-disponibles', [PrestataireMissionController::class, 'index'])
        ->name('prestataire.missions.index');
        Route::get('/missions-disponibles/{mission}', [PrestataireMissionController::class, 'show'])
    ->name('prestataire.missions.show');
});