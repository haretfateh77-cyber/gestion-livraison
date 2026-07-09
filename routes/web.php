<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;

Route::get('/', function () {
    return redirect('/login');
});

Route::get('/dashboard', function () {
    return redirect('/admin/dashboard');
})->middleware('auth')->name('dashboard');

Route::middleware(['auth', 'role:admin'])->group(function () {

    Route::get('/admin/dashboard', [DashboardController::class, 'index'])
        ->name('admin.dashboard');

    Route::get('/admin/commandes', function () {
        return view('admin.commandes');
    })->name('admin.commandes');

    Route::get('/admin/livraisons', function () {
        return view('admin.livraisons');
    })->name('admin.livraisons');

    Route::get('/admin/profil', function () {
        return view('admin.profil');
    })->name('admin.profil');

    Route::get('/admin/utilisateurs', [UserController::class, 'index'])
        ->name('admin.utilisateurs');

    Route::post('/admin/utilisateurs', [UserController::class, 'store'])
        ->name('admin.utilisateurs.store');

    Route::put('/admin/utilisateurs/{user}', [UserController::class, 'update'])
        ->name('admin.utilisateurs.update');

    Route::delete('/admin/utilisateurs/{user}', [UserController::class, 'destroy'])
        ->name('admin.utilisateurs.destroy');
});

Route::middleware(['auth', 'role:livreur'])->group(function () {

    Route::get('/livreur', function () {
        return view('livreur');
    })->name('livreur');

    Route::get('/livreur/profil', function () {
        return view('profil');
    })->name('livreur.profil');
});

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
| Politique de confidentialité
|--------------------------------------------------------------------------
*/

Route::view('/rgpd', 'rgpd')->name('rgpd');

require __DIR__.'/auth.php';

require __DIR__.'/auth.php';