<?php

namespace App\Http\Controllers;

use App\Models\Commande;
use App\Models\Livraison;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        // Statistiques
        $commandesTotales = Commande::count();

        $livraisonsTotales = Livraison::count();

        $enCoursLivraison = Livraison::where('statut', 'En cours')->count();

        $livraisonsLivrees = Livraison::where('statut', 'Livrée')->count();
        
        $pourcentageLivraisons = $livraisonsTotales > 0
    ? round(($livraisonsLivrees / $livraisonsTotales) * 100)
    : 0;
        
        // Les 3 dernières livraisons
        $livraisonsRecentes = Livraison::latest()
            ->take(3)
            ->get();


        // Livreurs réellement disponibles
        //
        // Un livreur est disponible s'il n'a aucune livraison
        // actuellement "En préparation" ou "En cours".
        $livreurs = User::where('role', 'livreur')
            ->whereDoesntHave('livraisons', function ($query) {
                $query->whereIn('statut', [
                    'En préparation',
                    'En cours'
                ]);
            })
            ->get();


        // Les 5 dernières commandes
        $commandes = Commande::latest()
            ->take(5)
            ->get();


        return view('admin.dashboard', compact(
            'commandesTotales',
            'livraisonsTotales',
            'enCoursLivraison',
            'livraisonsLivrees',
             'pourcentageLivraisons',
            'livraisonsRecentes',
            'livreurs',
            'commandes'
        ));
    }

    /**
     * Statistiques du tableau de bord — API (Flutter).
     *
     * Même logique métier que index(), mais réponse JSON au lieu
     * d'une vue Blade, pour être consommée par l'application mobile.
     */
    public function stats()
    {
        $commandesTotales = Commande::count();

        $livraisonsTotales = Livraison::count();

        $enCoursLivraison = Livraison::where('statut', 'En cours')->count();

        $livraisonsLivrees = Livraison::where('statut', 'Livrée')->count();

        $pourcentageLivraisons = $livraisonsTotales > 0
            ? round(($livraisonsLivrees / $livraisonsTotales) * 100)
            : 0;

        $livraisonsRecentes = Livraison::with('commande', 'livreur')
            ->latest()
            ->take(3)
            ->get();

        $livreurs = User::where('role', 'livreur')
            ->whereDoesntHave('livraisons', function ($query) {
                $query->whereIn('statut', [
                    'En préparation',
                    'En cours'
                ]);
            })
            ->get();

        $commandes = Commande::latest()
            ->take(5)
            ->get();

        return response()->json([
            'commandes_totales' => $commandesTotales,
            'livraisons_totales' => $livraisonsTotales,
            'en_cours_livraison' => $enCoursLivraison,
            'livraisons_livrees' => $livraisonsLivrees,
            'pourcentage_livraisons' => $pourcentageLivraisons,
            'livraisons_recentes' => $livraisonsRecentes,
            'livreurs_disponibles' => $livreurs,
            'commandes_recentes' => $commandes,
        ]);
    }
}