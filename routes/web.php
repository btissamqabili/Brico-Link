<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

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