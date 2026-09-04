<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\MissionController;
use App\Http\Controllers\PrestataireMissionController;
use App\Http\Controllers\OffreController;
use Illuminate\Support\Facades\Route;


/*
|--------------------------------------------------------------------------
| Public
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return view('welcome');
});


/*
|--------------------------------------------------------------------------
| Dashboard
|--------------------------------------------------------------------------
*/

Route::get('/dashboard', function () {
    return match (auth()->user()->role) {
        'client' => view('dashboard.client'),
        'prestataire' => view('dashboard.prestataire'),
        'admin' => view('dashboard.admin'),
    };
})->middleware(['auth', 'verified'])->name('dashboard');


/*
|--------------------------------------------------------------------------
| Profile
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->group(function () {

    Route::get('/profile', [ProfileController::class, 'edit'])
        ->name('profile.edit');

    Route::patch('/profile', [ProfileController::class, 'update'])
        ->name('profile.update');

    Route::delete('/profile', [ProfileController::class, 'destroy'])
        ->name('profile.destroy');
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


/*
|--------------------------------------------------------------------------
| Routes Client
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'role:client'])->group(function () {

    // Missions
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

    // Voir les offres reçues
    Route::get('/missions/{mission}/offres', [MissionController::class, 'offres'])
        ->name('missions.offres');

    // Accepter une offre
    Route::patch('/offres/{offre}/accept', [OffreController::class, 'accept'])
        ->name('offres.accept');

    // Refuser une offre
    Route::patch('/offres/{offre}/refuse', [OffreController::class, 'refuse'])
        ->name('offres.refuse');
});


/*
|--------------------------------------------------------------------------
| Routes Prestataire
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'role:prestataire'])->group(function () {

    // Services
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


    // Missions disponibles
    Route::get('/missions-disponibles', [PrestataireMissionController::class, 'index'])
        ->name('prestataire.missions.index');

    Route::get('/missions-disponibles/{mission}', [PrestataireMissionController::class, 'show'])
        ->name('prestataire.missions.show');

    // Envoyer une offre
    Route::post('/missions-disponibles/{mission}/offres', [OffreController::class, 'store'])
        ->name('offres.store');
});


/*
|--------------------------------------------------------------------------
| Authentication
|--------------------------------------------------------------------------
*/

require __DIR__ . '/auth.php';