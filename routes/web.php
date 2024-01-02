<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\ProductController ;
use App\Http\Controllers\StockController ;
use App\Http\Controllers\RecettesController ;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('produits/create', [ProductController::class,'create']);

Route::post('/addProductInStock',[StockController::class ,'addProductInStock'] )->name('addProductInStock');
Route::get('/getProductsInStock',[StockController::class ,'getProductsInStock'] ) ;

Route::get('/recettes/getRecettesPossibles',[RecettesController::class ,'getRecettesPossibles'] ) ;
Route::post('/recettes/validerRecette',[RecettesController::class ,'validerRecette'] ) ;

