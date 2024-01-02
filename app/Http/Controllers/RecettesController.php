<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Models\Stock ;
use App\Models\Recette ;



class RecettesController extends Controller
{
    public function getRecettesPossibles()
    {
        // Récupérer tous les produits en stock
        $produitsEnStock = Stock::all();

        // Récupérer toutes les recettes
        $recettes = Recette::all();

        $recettesPossibles = [];

        foreach ($recettes as $recette) {
            $recettePossible = true;
            $produitsManquants = [];

            // Vérifier si tous les produits nécessaires pour la recette sont en stock
            foreach ($recette->produits as $produit) {
                $quantiteEnStock = $produit->pivot->quantite_utilisee;

                if ($quantiteEnStock <= 0) {
                    $recettePossible = false;
                    $produitsManquants[] = $produit->nom;
                }
            }

            // Si la recette est possible, l'ajouter à la liste
            if ($recettePossible) {
                $recettesPossibles[] = [
                    'recette' => $recette->nom,
                    'produits_manquants' => [],
                ];
            } else {
                // Si la recette n'est pas possible, enregistrer les produits manquants
                $recettesPossibles[] = [
                    'recette' => $recette->nom,
                    'produits_manquants' => $produitsManquants,
                ];
            }
        }

        return response()->json($recettesPossibles);
    }

    public function validerRecette(Request $request)
    {
        // Récupérer les données de la requête
        $recetteId = $request->input('recette_id');

        // Récupérer la recette spécifiée
        $recette = Recette::findOrFail($recetteId);

        // Vérifier si tous les produits nécessaires pour la recette sont en stock
        foreach ($recette->produits as $produit) {
            $quantiteEnStock = $produit->pivot->quantite_utilisee;

            if ($quantiteEnStock <= 0) {
                // Retourner une réponse indiquant que la recette ne peut pas être validée
                return response()->json([
                    'message' => 'La recette ne peut pas être validée. Certains produits ne sont pas en stock.'
                ], 400);
            }
        }

        // Valider la recette en mettant à jour les stocks des produits
        foreach ($recette->produits as $produit) {
            $quantiteEnStock = $produit->pivot->quantite_utilisee;

            // Mettre à jour le stock du produit en retranchant la quantité utilisée
            $produit->update([
                'stock' => $produit->stock - $quantiteEnStock,
            ]);
        }

        // Retourner une réponse indiquant que la recette a été validée avec succès
        return response()->json([
            'message' => 'La recette a été validée avec succès. Les stocks ont été mis à jour.'
        ], 200);
    }
}
