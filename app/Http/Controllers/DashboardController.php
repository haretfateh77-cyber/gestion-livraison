<?php

namespace App\Http\Controllers;

use App\Models\Commande;
use App\Models\Livraison;
use App\Models\User;

/**
 * Tableau de bord administrateur : statistiques, livraisons récentes,
 * livreurs disponibles et formulaire de création rapide d'une livraison.
 */
class DashboardController extends Controller
{
    /**
     * Tableau de bord administrateur — version web (vue Blade).
     */
    public function index()
    {
        // Statistiques
        $commandesTotales  = Commande::count();
        $livraisonsTotales = Livraison::count();
        $enCoursLivraison  = Livraison::where('statut', 'En cours')->count();
        $livraisonsLivrees = Livraison::where('statut', 'Livrée')->count();

        $pourcentageLivraisons = $livraisonsTotales > 0
            ? round(($livraisonsLivrees / $livraisonsTotales) * 100)
            : 0;

        // Les 3 dernières livraisons
        $livraisonsRecentes = Livraison::latest()->take(3)->get();

        // Livreurs disponibles : aucune livraison "En préparation" ou "En cours"
        $livreurs = User::where('role', 'livreur')
            ->whereDoesntHave('livraisons', function ($query) {
                $query->whereIn('statut', ['En préparation', 'En cours']);
            })
            ->get();

        // Les 5 dernières commandes (affichage)
        $commandes = Commande::latest()->take(5)->get();

        // Commandes proposées dans le formulaire de création d'une livraison :
        // uniquement celles qui n'ont pas encore de livraison
        $commandesDisponibles = Commande::doesntHave('livraison')->latest()->get();

        return view('admin.dashboard', compact(
            'commandesTotales',
            'livraisonsTotales',
            'enCoursLivraison',
            'livraisonsLivrees',
            'pourcentageLivraisons',
            'livraisonsRecentes',
            'livreurs',
            'commandes',
            'commandesDisponibles'
        ));
    }

    /**
     * Statistiques du tableau de bord — version API (application Flutter).
     * Même logique que index(), mais réponse en JSON.
     */
    public function stats()
    {
        $commandesTotales  = Commande::count();
        $livraisonsTotales = Livraison::count();
        $enCoursLivraison  = Livraison::where('statut', 'En cours')->count();
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
                $query->whereIn('statut', ['En préparation', 'En cours']);
            })
            ->get();

        $commandes = Commande::latest()->take(5)->get();

        // Commandes sans livraison, pour le formulaire de création côté mobile
        $commandesDisponibles = Commande::doesntHave('livraison')->latest()->get();

        return response()->json([
            'commandes_totales'      => $commandesTotales,
            'livraisons_totales'     => $livraisonsTotales,
            'en_cours_livraison'     => $enCoursLivraison,
            'livraisons_livrees'     => $livraisonsLivrees,
            'pourcentage_livraisons' => $pourcentageLivraisons,
            'livraisons_recentes'    => $livraisonsRecentes,
            'livreurs_disponibles'   => $livreurs,
            'commandes_recentes'     => $commandes,
            'commandes_disponibles'  => $commandesDisponibles,
        ]);
    }
}