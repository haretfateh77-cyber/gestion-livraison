<?php

namespace App\Http\Controllers;

use App\Mail\LivraisonAffectee;
use App\Models\Livraison;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\Rule;

class LivraisonController extends Controller
{
    /**
     * Afficher toutes les livraisons.
     */
    public function index()
    {
        return Livraison::with('commande', 'livreur')->get();
    }

    /**
     * Créer une livraison.
     */
    public function store(Request $request)
    {
        $validated = $request->validate(
            [
                'commande_id' => [
                    'required',
                    'exists:commandes,id',
                    'unique:livraisons,commande_id',
                ],

                'statut' => [
                    'required',
                    'string',
                ],

                'adresse' => [
                    'required',
                    'string',
                ],
            ],
            [
                'commande_id.required' =>
                    'Veuillez sélectionner une commande.',

                'commande_id.unique' =>
                    'Cette commande possède déjà une livraison. Une commande ne peut avoir qu’une seule livraison.',

                'commande_id.exists' =>
                    'La commande sélectionnée n’existe pas.',

                'adresse.required' =>
                    'L’adresse de livraison est obligatoire.',
            ]
        );

        /*
        |--------------------------------------------------------------------------
        | Recherche automatique d'un livreur disponible
        |--------------------------------------------------------------------------
        */

        $livreur = User::where('role', 'livreur')
            ->whereDoesntHave('livraisons', function ($query) {
                $query->whereIn('statut', [
                    'En préparation',
                    'En cours'
                ]);
            })
            ->first();

        /*
        |--------------------------------------------------------------------------
        | Vérifier qu'un livreur est disponible
        |--------------------------------------------------------------------------
        */

        if (!$livreur) {
            return back()
                ->withErrors([
                    'livreur_id' =>
                        'Aucun livreur n’est disponible actuellement.'
                ])
                ->withInput();
        }

        /*
        |--------------------------------------------------------------------------
        | Génération automatique de la date
        |--------------------------------------------------------------------------
        */

        $validated['date_livraison'] = now()->toDateString();

        /*
        |--------------------------------------------------------------------------
        | Attribution automatique du livreur
        |--------------------------------------------------------------------------
        */

        $validated['livreur_id'] = $livreur->id;

        /*
        |--------------------------------------------------------------------------
        | Création de la livraison
        |--------------------------------------------------------------------------
        */

        $livraison = Livraison::create($validated);

        /*
        |--------------------------------------------------------------------------
        | Charger les relations nécessaires au mail
        |--------------------------------------------------------------------------
        */

        $livraison->load('commande', 'livreur');

        /*
        |--------------------------------------------------------------------------
        | Envoyer le mail au livreur
        |--------------------------------------------------------------------------
        */

        Mail::to($livreur->email)
            ->send(new LivraisonAffectee($livraison));

        /*
        |--------------------------------------------------------------------------
        | Retour vers le tableau de bord
        |--------------------------------------------------------------------------
        */

        return redirect()
            ->route('admin.dashboard')
            ->with(
                'success',
                'Livraison créée avec succès. Le livreur a été attribué automatiquement et un mail lui a été envoyé.'
            );
    }

    /**
     * Afficher une livraison.
     */
    public function show(string $id)
    {
        return Livraison::with('commande', 'livreur')
            ->findOrFail($id);
    }

    /**
     * Modifier une livraison.
     *
     * Le numéro et la date ne peuvent pas être modifiés.
     */
    public function update(Request $request, string $id)
    {
        $livraison = Livraison::findOrFail($id);

        $validated = $request->validate(
            [
                'commande_id' => [
                    'sometimes',
                    'exists:commandes,id',
                    Rule::unique('livraisons', 'commande_id')
                        ->ignore($livraison->id),
                ],

                'statut' => [
                    'sometimes',
                    'string',
                ],

                'adresse' => [
                    'sometimes',
                    'string',
                ],
            ],
            [
                'commande_id.unique' =>
                    'Cette commande possède déjà une livraison. Une commande ne peut avoir qu’une seule livraison.',

                'commande_id.exists' =>
                    'La commande sélectionnée n’existe pas.',
            ]
        );

        $livraison->update($validated);

        return response()->json($livraison);
    }

    /**
     * Supprimer une livraison.
     *
     * Une livraison déjà livrée ne peut pas être supprimée.
     */
    public function destroy(string $id)
    {
        $livraison = Livraison::findOrFail($id);

        if ($livraison->statut === 'Livrée') {
            return response()->json([
                'message' =>
                    'Impossible de supprimer une livraison déjà livrée.'
            ], 400);
        }

        $livraison->delete();

        return response()->json([
            'message' => 'Livraison supprimée avec succès.'
        ]);
    }

    /**
     * Récupérer les livraisons d'un livreur.
     */
    public function livraisonsLivreur($id)
    {
        return Livraison::where('livreur_id', $id)
            ->with('commande')
            ->get();
    }

    /**
     * Marquer une livraison comme livrée.
     *
     * Seul le livreur auquel la livraison est assignée peut la marquer comme livrée.
     */
    public function marquerLivree($id)
    {
        $livraison = Livraison::findOrFail($id);

        if ($livraison->livreur_id !== Auth::id()) {
            return response()->json([
                'message' => 'Non autorisé.'
            ], 403);
        }

        $livraison->statut = 'Livrée';
        $livraison->save();

        return response()->json([
            'message' => 'Livraison marquée comme livrée.',
            'livraison' => $livraison
        ]);
    }

    /**
     * Modifier le statut d'une livraison.
     */
    public function changerStatut(Request $request, $id)
    {
        $request->validate([
            'statut' => [
                'required',
                'in:En préparation,En cours,Livrée',
            ],
        ]);

        $livraison = Livraison::findOrFail($id);

        $livraison->statut = $request->statut;
        $livraison->save();

        return response()->json([
            'message' => 'Statut mis à jour.',
            'livraison' => $livraison
        ]);
    }
}
 
