<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\OrderController;

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

    /**
     * Añadir un producto a un carrito
     */
    Route::post('/carts/{cartId}/add/{productId}/{qty}', [CartController::class, 'addItemToCart']);

    /**
     * Eliminar un producto a un carrito
     */
    Route::post('/carts/{cartId}/remove/{productId}', [CartController::class, 'removeItemFromCart']);

    /**
     * Crea un pedido respecto un carrito
     */
    Route::post('/carts/{cartId}/checkout', [OrderController::class, 'generateOrder']);

    /**
     * Obtener un pedido por su ID
     */
    Route::get('/orders/{orderId}', [OrderController::class, 'getOrder']);

    /**
     * Finalizar pedido
     */
    Route::post('/orders/{orderId}/complete', [OrderController::class, 'completeOrder']);
});





Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
