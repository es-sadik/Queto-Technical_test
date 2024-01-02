<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product ;

class ProductController extends Controller
{

    //
    public function create()
    {
        // Charger la liste de produits depuis la base de données
        $produits = Product::all();

        return view('create', compact('produits'));
    }

    
}
