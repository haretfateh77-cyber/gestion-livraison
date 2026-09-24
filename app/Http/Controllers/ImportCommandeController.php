<?php

namespace App\Http\Controllers;

use App\Models\Commande;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\CommandesImport;

class ImportCommandeController extends Controller
{
    public function import(Request $request)
    {
        $request->validate([
            'fichier' => [
                'required',
                'file',
                'mimes:xlsx,xls,csv,txt',
                'max:5120',
            ],
        ], [
            'fichier.required' => 'Veuillez sélectionner un fichier.',
            'fichier.file' => 'Le fichier sélectionné est invalide.',
            'fichier.mimes' => 'Le fichier doit être au format Excel ou CSV.',
            'fichier.max' => 'Le fichier ne doit pas dépasser 5 Mo.',
        ]);

        try {

            Excel::import(
                new CommandesImport,
                $request->file('fichier')
            );

            return back()->with(
                'success',
                'Les commandes ont été importées avec succès.'
            );

        } catch (\Exception $e) {

            return back()->withErrors([
                'fichier' => 'Erreur lors de l’importation : ' . $e->getMessage()
            ]);
        }
    }
}