<?php

namespace App\Http\Controllers;

use App\Models\Commande;
use Illuminate\Http\Request;

class CommandeController extends Controller
{
    public function index()
    {
        return Commande::with('livraison')->get();
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'num_commande' => 'required|integer|unique:commandes,num_commande',
            'date_commande' => 'required|date',
            'montant' => 'required|numeric',
            'statut' => 'required|string',
        ]);

        $commande = Commande::create($validated);

        return response()->json($commande, 201);
    }

    public function show(string $id)
    {
        return Commande::with('livraison')->findOrFail($id);
    }

    public function update(Request $request, string $id)
    {
        $commande = Commande::findOrFail($id);

        $validated = $request->validate([
            'num_commande' => 'sometimes|integer|unique:commandes,num_commande,' . $commande->id,
            'date_commande' => 'sometimes|date',
            'montant' => 'sometimes|numeric',
            'statut' => 'sometimes|string',
        ]);

        $commande->update($validated);

        return response()->json($commande);
    }

    public function destroy(string $id)
    {
        $commande = Commande::findOrFail($id);

        if ($commande->livraison) {
            return response()->json([
                'message' => 'Impossible de supprimer cette commande car une livraison y est associée.'
            ], 400);
        }

        $commande->delete();

        return response()->json([
            'message' => 'Commande supprimée'
        ]);
    }
}