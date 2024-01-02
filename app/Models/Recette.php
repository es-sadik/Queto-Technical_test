<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Recette extends Model
{
    use HasFactory;

    public function produits()
    {
        return $this->belongsToMany(Produit::class, 'produits_recettes')
            ->withPivot('quantite_utilisee');
    }
}
