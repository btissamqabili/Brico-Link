<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\CategorieController;
use App\Http\Controllers\ConversationController;
use App\Http\Controllers\EvaluationController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\MissionController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\OffreController;
use App\Http\Controllers\PrestataireController;
use App\Http\Controllers\PrestataireMissionController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ServiceController;
use Illuminate\Support\Facades\Route;

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
        'client' => view('dashboard.client', [
            'missions' => auth()->user()
                ->missions()
                ->latest()
                ->get(),
        ]),

        'prestataire' => view('dashboard.prestataire'),

        'admin' => app(AdminController::class)->dashboard(),

        default => abort(403),
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
| Conversations & Messages
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->group(function () {
    Route::get('/conversations', [ConversationController::class, 'index'])
        ->name('conversations.index');

    Route::post('/conversations/user/{user}', [ConversationController::class, 'store'])
        ->name('conversations.store');

    Route::get('/conversations/{conversation}', [ConversationController::class, 'show'])
        ->name('conversations.show');

    Route::post('/conversations/{conversation}/messages', [MessageController::class, 'store'])
        ->name('messages.store');
});

/*
|--------------------------------------------------------------------------
| Client
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

    Route::patch('/missions/{mission}/complete', [MissionController::class, 'complete'])
        ->name('missions.complete');

    // Offres reçues
    Route::get('/missions/{mission}/offres', [OffreController::class, 'recues'])
        ->name('missions.offres');

    Route::patch('/offres/{offre}/accept', [OffreController::class, 'accept'])
        ->name('offres.accept');

    Route::patch('/offres/{offre}/refuse', [OffreController::class, 'refuse'])
        ->name('offres.refuse');

    // Évaluation
    Route::post('/missions/{mission}/evaluation', [EvaluationController::class, 'store'])
        ->name('evaluations.store');

    // Profil prestataire
    Route::get('/prestataires/{id}', [PrestataireController::class, 'show'])
        ->name('prestataires.show');
});

/*
|--------------------------------------------------------------------------
| Prestataire
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

    // Offres
    Route::post('/missions-disponibles/{mission}/offres', [OffreController::class, 'store'])
        ->name('offres.store');
});

/*
|--------------------------------------------------------------------------
| Notifications
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->group(function () {
    Route::get('/notifications', [NotificationController::class, 'index'])
        ->name('notifications.index');

    Route::get('/notifications/read-all', [NotificationController::class, 'readAll'])
        ->name('notifications.readAll');

    Route::get('/notifications/{id}/read', [NotificationController::class, 'read'])
        ->name('notifications.read');
});

/*
|--------------------------------------------------------------------------
| Admin
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/admin', [AdminController::class, 'dashboard'])
        ->name('admin.dashboard');

    Route::get('/admin/evaluations', [AdminController::class, 'evaluations'])
        ->name('admin.evaluations.index');

    // Catégories
    Route::resource('categories', CategorieController::class)
        ->except(['show']);

    // Utilisateurs
    Route::get('/admin/users', [AdminController::class, 'users'])
        ->name('admin.users.index');

    Route::get('/admin/users/{user}', [AdminController::class, 'showUser'])
        ->name('admin.users.show');

    Route::delete('/admin/users/{user}', [AdminController::class, 'destroyUser'])
        ->name('admin.users.destroy');
});

/*
|--------------------------------------------------------------------------
| Authentication
|--------------------------------------------------------------------------
*/

require __DIR__ . '/auth.php';