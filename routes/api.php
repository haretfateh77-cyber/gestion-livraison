<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CommandeController;
use App\Http\Controllers\LivraisonController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AuthController as ApiAuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\MessageController;

Route::get('/test', function () {
    return 'API OK';
});

Route::post('/login', [ApiAuthController::class, 'login']);

// Routes protégées : nécessitent d'être authentifié (token Sanctum valide)
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user', [ApiAuthController::class, 'me']);
    Route::post('/logout', [ApiAuthController::class, 'logout']);

    Route::apiResource('commandes', CommandeController::class);

    // Utilisateurs (admin + livreurs) — méthodes API dédiées,
    // distinctes de celles utilisées par l'interface web (admin/utilisateurs)
    Route::get('/users', [UserController::class, 'indexApi']);
    Route::post('/users', [UserController::class, 'storeApi']);
    Route::put('/users/{user}', [UserController::class, 'updateApi']);
    Route::delete('/users/{user}', [UserController::class, 'destroyApi']);

    Route::get('/livreurs', [UserController::class, 'livreurs']);
    Route::get('/dashboard', [DashboardController::class, 'stats']);
    Route::put('/profil/mot-de-passe', [UserController::class, 'updatePasswordApi']);

    // Messages (admin) — reçus des livreurs
    Route::get('/messages', [MessageController::class, 'indexApi']);
    Route::get('/messages/{message}', [MessageController::class, 'showApi']);

    // Contacter l'administrateur (livreur)
    Route::post('/messages', [MessageController::class, 'storeApi']);

    // Livraisons : create, update, delete, consultation détaillée
    Route::apiResource('livraisons', LivraisonController::class);

    // Un livreur ne peut consulter/modifier que ses propres livraisons
    // (vérification supplémentaire faite dans le contrôleur via Auth::id())
    Route::get('/livreur/{id}/livraisons', [LivraisonController::class, 'livraisonsLivreur']);
    Route::put('/livraisons/{id}/statut', [LivraisonController::class, 'changerStatut']);
    Route::put('/livraisons/{id}/livree', [LivraisonController::class, 'marquerLivree']);
});