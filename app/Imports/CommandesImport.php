<?php

namespace App\Imports;

use App\Models\Commande;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

/**
 * Import des commandes depuis un fichier Excel ou CSV.
 */
class CommandesImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        // Évite les doublons : on ignore la ligne si une commande identique existe déjà
        $existe = Commande::where('date_commande', $row['date_commande'])
            ->where('montant', $row['montant'])
            ->exists();

        if ($existe) {
            return null;
        }

        return new Commande([
            'date_commande' => $row['date_commande'],
            'montant'       => $row['montant'],
            'statut'        => $row['statut'] ?? 'en_attente',
        ]);
    }
}