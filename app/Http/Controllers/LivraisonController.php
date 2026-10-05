<?php

namespace App\Http\Controllers;

use App\Mail\LivraisonAffectee;
use App\Models\Livraison;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\Rule;

/**
 * Gère les livraisons : création avec attribution automatique d'un livreur,
 * consultation, modification, suppression et mise à jour du statut.
 * Utilisé par l'espace administrateur (web) et par l'API de l'application mobile.
 */
class LivraisonController extends Controller
{
    /**
     * Afficher toutes les livraisons, avec leur commande et leur livreur.
     */
    public function index()
    {
        return Livraison::with('commande', 'livreur')->get();
    }

    /**
     * Créer une livraison et l'attribuer automatiquement à un livreur disponible.
     */
    public function store(Request $request)
    {
        // Validation côté serveur : une commande ne peut avoir qu'une seule livraison (règle unique)
        $validated = $request->validate(
            [
                'commande_id' => ['required', 'exists:commandes,id', 'unique:livraisons,commande_id'],
                'statut'      => ['required', 'string'],
                'adresse'     => ['required', 'string'],
            ],
            [
                'commande_id.required' => 'Veuillez sélectionner une commande.',
                'commande_id.unique'   => 'Cette commande possède déjà une livraison. Une commande ne peut avoir qu’une seule livraison.',
                'commande_id.exists'   => 'La commande sélectionnée n’existe pas.',
                'adresse.required'     => 'L’adresse de livraison est obligatoire.',
            ]
        );

        // Recherche d'un livreur disponible : aucune livraison "En préparation" ou "En cours"
        $livreur = User::where('role', 'livreur')
            ->whereDoesntHave('livraisons', function ($query) {
                $query->whereIn('statut', ['En préparation', 'En cours']);
            })
            ->first();

        // Aucun livreur disponible : on ne crée pas la livraison et on garde la saisie
        if (!$livreur) {
            return back()
                ->withErrors(['livreur_id' => 'Aucun livreur n’est disponible actuellement.'])
                ->withInput();
        }

        // Date du jour et livreur attribués automatiquement
        $validated['date_livraison'] = now()->toDateString();
        $validated['livreur_id'] = $livreur->id;

        $livraison = Livraison::create($validated);

        // La commande associée prend le même statut que sa livraison
        $livraison->commande->update(['statut' => $livraison->statut]);

        // Notification par e-mail au livreur (relations chargées pour le contenu du mail)
        $livraison->load('commande', 'livreur');
        Mail::to($livreur->email)->send(new LivraisonAffectee($livraison));

        return redirect()
            ->route('admin.dashboard')
            ->with('success', 'Livraison créée avec succès. Le livreur a été attribué automatiquement et un mail lui a été envoyé.');
    }

    /**
     * Afficher une livraison.
     */
    public function show(string $id)
    {
        return Livraison::with('commande', 'livreur')->findOrFail($id);
    }

    /**
     * Modifier une livraison (seuls les champs envoyés sont modifiés).
     */
    public function update(Request $request, string $id)
    {
        $livraison = Livraison::findOrFail($id);

        $validated = $request->validate(
            [
                // On ignore la livraison actuelle pour la règle d'unicité
                'commande_id' => [
                    'sometimes',
                    'exists:commandes,id',
                    Rule::unique('livraisons', 'commande_id')->ignore($livraison->id),
                ],
                'statut'  => ['sometimes', 'string'],
                'adresse' => ['sometimes', 'string'],
            ],
            [
                'commande_id.unique' => 'Cette commande possède déjà une livraison. Une commande ne peut avoir qu’une seule livraison.',
                'commande_id.exists' => 'La commande sélectionnée n’existe pas.',
            ]
        );

        $livraison->update($validated);

        // La commande associée prend le même statut que sa livraison
        $livraison->commande->update(['statut' => $livraison->statut]);

        return response()->json($livraison);
    }

    /**
     * Supprimer une livraison.
     * Une livraison déjà livrée ne peut pas être supprimée, pour garder l'historique.
     */
    public function destroy(string $id)
    {
        $livraison = Livraison::findOrFail($id);

        if ($livraison->statut === 'Livrée') {
            return response()->json(['message' => 'Impossible de supprimer une livraison déjà livrée.'], 400);
        }

        $livraison->delete();

        return response()->json(['message' => 'Livraison supprimée avec succès.']);
    }

    /**
     * Récupérer les livraisons d'un livreur.
     * Un livreur ne peut voir que ses propres livraisons ; l'administrateur peut tout voir.
     */
    public function livraisonsLivreur($id)
    {
        // CORRECTION SÉCURITÉ : empêche un livreur de lire les livraisons d'un collègue
        if (Auth::user()->role !== 'admin' && (int) $id !== Auth::id()) {
            return response()->json(['message' => 'Non autorisé.'], 403);
        }

        return Livraison::where('livreur_id', $id)
            ->with('commande')
            ->get();
    }

    /**
     * Marquer une livraison comme livrée.
     * Seul le livreur auquel la livraison est assignée peut le faire (vérification de propriété).
     */
    public function marquerLivree($id)
    {
        $livraison = Livraison::findOrFail($id);

        if ($livraison->livreur_id !== Auth::id()) {
            return response()->json(['message' => 'Non autorisé.'], 403);
        }

        $livraison->statut = 'Livrée';
        $livraison->save();

        // La commande associée passe aussi à "Livrée"
        $livraison->commande->update(['statut' => 'Livrée']);

        return response()->json([
            'message'   => 'Livraison marquée comme livrée.',
            'livraison' => $livraison,
        ]);
    }

    /**
     * Modifier le statut d'une livraison.
     * Autorisé pour l'administrateur, ou pour le livreur à qui la livraison est assignée.
     */
    public function changerStatut(Request $request, $id)
    {
        $request->validate([
            'statut' => ['required', 'in:En préparation,En cours,Livrée'],
        ]);

        $livraison = Livraison::findOrFail($id);

        // CORRECTION SÉCURITÉ : vérification de propriété, comme dans marquerLivree()
        if (Auth::user()->role !== 'admin' && $livraison->livreur_id !== Auth::id()) {
            return response()->json(['message' => 'Non autorisé.'], 403);
        }

        $livraison->statut = $request->statut;
        $livraison->save();

        // La commande associée prend le même statut que sa livraison
        $livraison->commande->update(['statut' => $livraison->statut]);

        return response()->json([
            'message'   => 'Statut mis à jour.',
            'livraison' => $livraison,
        ]);
    }
}