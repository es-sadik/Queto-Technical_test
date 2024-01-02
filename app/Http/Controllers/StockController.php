<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Stock ;
use Carbon\Carbon;


class StockController extends Controller
{

    public function addProductInStock(Request $request)
    {

        // Valider les données du formulaire

        $today = Carbon::today()->toDateString();

        $validatedData = $request->validate([
            'product' => 'required|exists:products,id',
            'quantity' => 'required|numeric|min:1',
            'expiration_date' => [
                'required',
                'date',
                'after:' . $today
            ],
        ]);

        // Enregistrer le produit dans le stock
        $product = new  Stock;

        $product->product_id = $validatedData['product'] ;
        $product->quantity = $validatedData['quantity'];
        $product->expiration_date = $validatedData['expiration_date'];
        $product->save();

        return  response()->json($product) ;

    }

    
    public function getProductsInStock()
    {
        // Récupérer la liste des produits en stock depuis la base de données
        $today = Carbon::today();

        $productsInStock = DB::table('products')
        ->join('stocks', 'products.id', '=', 'stocks.product_id')
        ->where('stocks.quantity', '>', 0)
        ->where('stocks.expiration_date', '>', $today)
        ->get();

        return response()->json($productsInStock);
    }
}
