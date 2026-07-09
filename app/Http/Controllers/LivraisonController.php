<?php

namespace App\Http\Controllers;

use App\Models\Livraison;
use Illuminate\Http\Request;

class LivraisonController extends Controller
{
    public function index()
    {
        return Livraison::with('commande', 'livreur')->get();
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'num_livraison' => 'required|integer|unique:livraisons,num_livraison',
            'commande_id' => 'required|exists:commandes,id|unique:livraisons,commande_id',
            'livreur_id' => 'required|exists:users,id',
            'date_livraison' => 'nullable|date',
            'statut' => 'required|string',
            'adresse' => 'required|string',
        ]);

        $livraison = Livraison::create($validated);

        return redirect('/admin/dashboard')->with('success', 'Livraison créée avec succès.');
    }

    public function show(string $id)
    {
        return Livraison::with('commande', 'livreur')->findOrFail($id);
    }

    public function update(Request $request, string $id)
    {
        $livraison = Livraison::findOrFail($id);

        $validated = $request->validate([
            'num_livraison' => 'sometimes|integer|unique:livraisons,num_livraison,' . $livraison->id,
            'commande_id' => 'sometimes|exists:commandes,id',
            'livreur_id' => 'sometimes|exists:users,id',
            'date_livraison' => 'nullable|date',
            'statut' => 'sometimes|string',
            'adresse' => 'sometimes|string',
        ]);

        $livraison->update($validated);

        return response()->json($livraison);
    }

    public function destroy(string $id)
    {
        $livraison = Livraison::findOrFail($id);
        $livraison->delete();

        return response()->json(['message' => 'Livraison supprimée']);
    }

    public function livraisonsLivreur($id)
    {
        return Livraison::where('livreur_id', $id)
            ->with('commande')
            ->get();
    }

    public function marquerLivree($id)
    {
        $livraison = Livraison::findOrFail($id);

        $livraison->statut = 'Livrée';
        $livraison->save();

        return response()->json([
            'message' => 'Livraison marquée comme livrée',
            'livraison' => $livraison
        ]);
    }

    public function changerStatut(Request $request, $id)
    {
        $request->validate([
            'statut' => 'required|in:En préparation,En cours,Livrée',
        ]);

        $livraison = Livraison::findOrFail($id);

        $livraison->statut = $request->statut;
        $livraison->save();

        return response()->json([
            'message' => 'Statut mis à jour',
            'livraison' => $livraison
        ]);
    }
}