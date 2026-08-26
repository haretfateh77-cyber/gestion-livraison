<?php

namespace App\Http\Controllers;

use App\Models\Livraison;
use Illuminate\Http\Request;
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
            'num_livraison' => [
                'required',
                'integer',
                'unique:livraisons,num_livraison',
            ],

            'commande_id' => [
                'required',
                'exists:commandes,id',
                'unique:livraisons,commande_id',
            ],

            'livreur_id' => [
                'required',
                'exists:users,id',
            ],

            'date_livraison' => [
                'nullable',
                'date',
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
            'commande_id.unique' =>
                'Cette commande possède déjà une livraison. Une commande ne peut avoir qu’une seule livraison.',

            'commande_id.exists' =>
                'La commande sélectionnée n’existe pas.',

            'num_livraison.unique' =>
                'Ce numéro de livraison existe déjà.',

            'livreur_id.exists' =>
                'Le livreur sélectionné n’existe pas.',

            'adresse.required' =>
                'L’adresse de livraison est obligatoire.',
        ]
    );

    Livraison::create($validated);

    return redirect()
        ->route('admin.dashboard')
        ->with('success', 'Livraison créée avec succès.');
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
     */
    public function update(Request $request, string $id)
    {
        $livraison = Livraison::findOrFail($id);

        $validated = $request->validate(
            [
                'num_livraison' => [
                    'sometimes',
                    'integer',
                    Rule::unique('livraisons', 'num_livraison')
                        ->ignore($livraison->id),
                ],

                'commande_id' => [
                    'sometimes',
                    'exists:commandes,id',
                    Rule::unique('livraisons', 'commande_id')
                        ->ignore($livraison->id),
                ],

                'livreur_id' => [
                    'sometimes',
                    'exists:users,id',
                ],

                'date_livraison' => [
                    'nullable',
                    'date',
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

                'num_livraison.unique' =>
                    'Ce numéro de livraison existe déjà.',
            ]
        );

        $livraison->update($validated);

        return response()->json($livraison);
    }

    /**
     * Supprimer une livraison.
     */
    public function destroy(string $id)
    {
        $livraison = Livraison::findOrFail($id);

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
     */
    public function marquerLivree($id)
    {
        $livraison = Livraison::findOrFail($id);

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