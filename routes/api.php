<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CommandeController;
use App\Http\Controllers\LivraisonController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;

Route::apiResource('users', UserController::class);
Route::apiResource('commandes', CommandeController::class);
Route::apiResource('livraisons', LivraisonController::class);
Route::get('/test', function () {
return 'API OK';
});
Route::post('/login', [AuthController::class, 'login']);
Route::get('/livreurs', [UserController::class, 'livreurs']);
Route::get('/livreur/{id}/livraisons', [LivraisonController::class, 'livraisonsLivreur']);
Route::put('/livraisons/{id}/statut', [LivraisonController::class, 'changerStatut']);
Route::put('/livraisons/{id}/livree', [LivraisonController::class, 'marquerLivree']);
Route::get('/dashboard', [DashboardController::class, 'stats']);
Route::put('/users/{id}/password', [UserController::class, 'updatePassword']);
