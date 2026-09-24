<?php

use Illuminate\Support\Facades\Route;
use App\Models\Commande;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\LivraisonController;
use App\Http\Controllers\CommandeController;
use App\Http\Controllers\ImportCommandeController;


/*
|--------------------------------------------------------------------------
| Page d'accueil
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return view('home');
})->name('home');


/*
|--------------------------------------------------------------------------
| Dashboard général
|--------------------------------------------------------------------------
*/

Route::get('/dashboard', function () {
    return redirect('/admin/dashboard');
})->middleware('auth')->name('dashboard');


/*
|--------------------------------------------------------------------------
| Routes administrateur
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'role:admin'])->group(function () {

    // Dashboard administrateur
    Route::get('/admin/dashboard', [DashboardController::class, 'index'])
        ->name('admin.dashboard');

    // Création d'une livraison
    Route::post('/livraisons', [LivraisonController::class, 'store'])
        ->name('admin.livraisons.store');

    // Commandes
    Route::get('/admin/commandes', function () {
        $commandes = Commande::with('livraison')->latest()->get();

        return view('admin.commandes', compact('commandes'));
    })->name('admin.commandes');
    Route::post('/admin/commandes/import', [CommandeController::class, 'import'])
    ->name('admin.commandes.import');

    // Livraisons
    Route::get('/admin/livraisons', function () {
        return view('admin.livraisons');
    })->name('admin.livraisons');

    // Profil administrateur
    Route::get('/admin/profil', function () {
        return view('admin.profil');
    })->name('admin.profil');

    // Modification du mot de passe administrateur
    Route::post('/admin/profil/mot-de-passe', [ProfileController::class, 'updateAdminPassword'])
        ->name('admin.profil.password');

    // Gestion des utilisateurs / livreurs
    Route::get('/admin/utilisateurs', [UserController::class, 'index'])
        ->name('admin.utilisateurs');

    Route::post('/admin/utilisateurs', [UserController::class, 'store'])
        ->name('admin.utilisateurs.store');

    Route::put('/admin/utilisateurs/{user}', [UserController::class, 'update'])
        ->name('admin.utilisateurs.update');

    Route::delete('/admin/utilisateurs/{user}', [UserController::class, 'destroy'])
        ->name('admin.utilisateurs.destroy');

    // Messages
    Route::get('/admin/messages', [MessageController::class, 'index'])
        ->name('admin.messages.index');

    Route::get('/admin/messages/{message}', [MessageController::class, 'show'])
        ->name('admin.messages.show');
});

/*
|--------------------------------------------------------------------------
| Routes livreur
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'role:livreur'])->group(function () {

    // Tableau de bord livreur
    Route::get('/livreur', function () {
        return view('livreur');
    })->name('livreur');

    // Page Mes livraisons
    Route::get('/livreur/livraisons', function () {
        return view('livreur.livraisons');
    })->name('livreur.livraisons');

    // Profil livreur
    Route::get('/livreur/profil', function () {
        return view('profil');
    })->name('livreur.profil');

    // Modification du mot de passe
    Route::post('/livreur/profil/mot-de-passe', [UserController::class, 'updatePassword'])
        ->name('livreur.profil.password');

    // Contacter l'administrateur
    Route::get('/livreur/contact-admin', [MessageController::class, 'create'])
        ->name('livreur.messages.create');

    Route::post('/livreur/contact-admin', [MessageController::class, 'store'])
        ->name('livreur.messages.store');
});



/*
|--------------------------------------------------------------------------
| Routes communes aux utilisateurs connectés
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->group(function () {

    // Profil
    Route::get('/profile', [ProfileController::class, 'edit'])
        ->name('profile.edit');

    Route::patch('/profile', [ProfileController::class, 'update'])
        ->name('profile.update');

    Route::delete('/profile', [ProfileController::class, 'destroy'])
        ->name('profile.destroy');

    // Notifications
    Route::get('/notifications', [NotificationController::class, 'index'])
        ->name('notifications.index');

    Route::patch('/notifications/{notification}/lire', [NotificationController::class, 'lire'])
        ->name('notifications.lire');

    Route::patch('/notifications-tout-lire', [NotificationController::class, 'toutLire'])
        ->name('notifications.tout-lire');
});


/*
|--------------------------------------------------------------------------
| Politique de confidentialité
|--------------------------------------------------------------------------
*/

Route::view('/rgpd', 'rgpd')
    ->name('rgpd');


/*
|--------------------------------------------------------------------------
| Authentification
|--------------------------------------------------------------------------
*/

require __DIR__.'/auth.php';

Route::get('/mentions_legales', function () {
    return view('mentions_legales');
})->name('mentions.legales');