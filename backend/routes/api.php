<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CartController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/


Route::middleware('auth.apikey')->group(function () {
    /**
     * Obtener todos los productos.
     */
    Route::get('products', [ProductController::class, 'index']);
    /**
     * Obtener un producto específico por su ID.
     */
    Route::get('products/{id}', [ProductController::class, 'show']);

    /**
     * Obtener  toda la info de un carrito por su ID
     */
    Route::get('/carts/{cartId}', [CartController::class, 'getCart']);

    /**
     * Obtener productos de un carrito por su ID
     */
    Route::get('/carts/{cartId}/products', [CartController::class, 'getProductsCart']);
});





Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
