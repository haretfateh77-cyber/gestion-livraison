<?php

namespace App\Imports;

use App\Models\Commande;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class CommandesImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        return new Commande([
            'date_commande' => $row['date_commande'],
            'montant'       => $row['montant'],
            'statut'        => $row['statut'] ?? 'en_attente',
        ]);
    }
}