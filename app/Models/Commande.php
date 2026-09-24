<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Commande extends Model
{
    use HasFactory;

    protected $fillable = [
        'date_commande',
        'montant',
        'statut',
    ];

    public function livraison()
    {
        return $this->hasOne(Livraison::class);
    }
}

