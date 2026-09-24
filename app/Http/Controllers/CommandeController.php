<?php

namespace App\Http\Controllers;

use App\Models\Commande;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\CommandesImport;

class CommandeController extends Controller
{
    public function index()
    {
        return Commande::with('livraison')->get();
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'montant' => 'required|numeric',
            'statut' => 'required|string',
        ]);

        // Date générée automatiquement
        $validated['date_commande'] = now()->toDateString();

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

        if ($commande->statut === 'Livrée' || $commande->livraison) {
            return response()->json([
                'message' => 'Impossible de supprimer une commande livrée ou associée à une livraison.'
            ], 400);
        }

        $commande->delete();

        return response()->json([
            'message' => 'Commande supprimée'
        ]);
    }

    /**
     * Importer des commandes depuis un fichier Excel
     */
    public function import(Request $request)
    {
        $request->validate([
            'fichier' => 'required|file|mimes:xlsx,xls,csv|max:5120',
        ]);

        Excel::import(
            new CommandesImport,
            $request->file('fichier')
        );

        return redirect()
            ->route('admin.commandes')
            ->with('success', 'Les commandes ont été importées avec succès.');
    }
}