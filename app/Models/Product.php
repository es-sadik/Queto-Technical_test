<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = ['libelle'];

    public function stocks()
    {
        return $this->hasMany(Stock::class);
    }

    public function recettes()
    {
        return $this->belongsToMany(Recette::class, 'produits_recettes')
            ->withPivot('quantite_utilisee');
    }

}
