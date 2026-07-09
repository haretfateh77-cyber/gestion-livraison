<?php

namespace App\Http\Controllers;

use App\Models\Commande;
use App\Models\Livraison;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        $commandesTotales = Commande::count();
        $livraisonsTotales = Livraison::count();
        $enCoursLivraison = Livraison::where('statut', 'En cours')->count();
        $livraisonsLivrees = Livraison::where('statut', 'Livrée')->count();

        $livraisonsRecentes = Livraison::latest()->take(3)->get();
        $livreurs = User::where('role', 'livreur')->get();
        $commandes = Commande::latest()->take(5)->get();

        return view('admin.dashboard', compact(
            'commandesTotales',
            'livraisonsTotales',
            'enCoursLivraison',
            'livraisonsLivrees',
            'livraisonsRecentes',
            'livreurs',
            'commandes'
        ));
    }
}