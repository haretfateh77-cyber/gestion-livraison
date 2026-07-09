<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Livraison extends Model
{
    use HasFactory;

    protected $fillable = [
        'num_livraison',
        'commande_id',
        'livreur_id',
        'date_livraison',
        'statut',
        'adresse',
    ];

    public function commande()
    {
        return $this->belongsTo(Commande::class);
    }

    public function livreur()
    {
        return $this->belongsTo(User::class, 'livreur_id');
    }
}

