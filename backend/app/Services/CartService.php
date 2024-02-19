<?php

namespace App\Services;

use App\Models\Cart;
use App\Models\Product;

class CartService
{
    /**
     * Obtener la información del carrito con los productos asociados.
     *
     * @param int $cartId ID del carrito
     * @return \App\Models\Cart|null Carrito con los productos asociados o null si no se encuentra el carrito
     */
    public function getCart($cartId)
    {
        $cart = Cart::with('products.categories')->find($cartId);
        if (!$cart) {
            return null;
        }

        return $cart;
    }

    /**
     * Obtener los productos asociados a un carrito.
     *
     * @param int $cartId ID del carrito
     * @return \Illuminate\Database\Eloquent\Collection|null Colección de productos asociados al carrito o null si no se encuentra el carrito
     */

    public function getProductsCart($cartId)
    {
        $cart = Cart::find($cartId);
        if (!$cart) {
            return null;
        }

        return $cart->products()->with('categories')->get();
    }

    /**     
     * Comprueba si ya existe un carrito activo (no completado) para la sesión actual.
     * Si existe, devuelve el carrito existente. Si no existe, crea un nuevo carrito
     * y lo devuelve.
     *
     * @return \App\Models\Cart Carrito nuevo o el ya relacionado con esa sesión.
     */
    public function createCart()
    {
        // Obtener el ID de la sesión actual
        $sessionId = Session::getId();

        $cart = $this->findActiveCart($sessionId);

        if ($cart) {
            return $cart;
        }

        return $this->createNewCart($sessionId);
    }


    /**
     * Busca un carrito activo para la sesión actual.
     *
     * @param string $sessionId El ID de la sesión actual.
     * @return \App\Models\Cart|null El carrito activo o null si no se encuentra.
     */
    protected function findActiveCart($sessionId)
    {
        return Cart::where('session_id', $sessionId)->where('done', 0)->first();
    }

    /**
     * Crea un nuevo carrito para la sesión actual.
     *
     * @param string $sessionId El ID de la sesión actual.
     * @return \App\Models\Cart El nuevo carrito creado.
     */
    protected function createNewCart($sessionId)
    {
        return Cart::create([
            'session_id' => $sessionId,
            'done' => 0,
        ]);
    }


    /**
     *  Contar productos en total que hay en un carrito
     *
     * @param \App\Models\Cart $cart El carrito  del que se quieren contar los productos.
     * @return int Total de productos
     */
    public function countProducts(Cart $cart)
    {
        return $cart->products()->sum('quantity');
    }

    /**
     *  Añadir un producto a un carrito
     * @param int $cart_id El ID del carrito al que se quiere añadir el producto.
     * @param int $product_id El ID del producto que se quiere añadir al carrito.
     * @return \Illuminate\Http\JsonResponse
     */


    public function addItemToCart($cart_id, $product_id, $qty = 1)
    {

        try {
            $cart = Cart::findOrFail($cart_id);
        } catch (ModelNotFoundException $exception) {
            return response()->json([
                'message' => 'Cart not found'
            ], 404);
        }

        try {
            $product = Product::findOrFail($product_id);
        } catch (ModelNotFoundException $exception) {
            return response()->json([
                'message' => 'Product not found'
            ], 404);
        }

        // antes de agregar al carrito el producto, se comprueba si ya tiene ese producto en el carrito para que en vez de meter la fila entera,
        //solo actualize la cantidad
        $existingProduct = $cart->products()->find($product_id);

        if ($existingProduct) {
            $existingProduct->pivot->quantity += $qty;
            $existingProduct->pivot->save();
        } else {
            // Si el producto no está en el carrito, agregarlo con la cantidad especificada
            $cart->products()->attach($product, ['quantity' => $qty]);
        }


        return response()->json([
            'message' => 'Producto añadido al carrito con éxito',
            'cart' => $cart
        ], 200);
    }

    /**
     *  Eliminar un producto de un carrito
     * @param int $cart_id El ID del carrito del que se quiere eliminar el producto.
     * @param int $product_id El ID del producto que se quiere eliminar del carrito.
     * @return \Illuminate\Http\JsonResponse
     */
    public function removeItemFromCart($cart_id, $product_id)
    {
        try {
            $cart = Cart::findOrFail($cart_id);
        } catch (ModelNotFoundException $exception) {
            return response()->json([
                'message' => 'Cart not found'
            ], 404);
        }

        try {
            $product = Product::findOrFail($product_id);
        } catch (ModelNotFoundException $exception) {
            return response()->json([
                'message' => 'Product not found'
            ], 404);
        }

        $existingProduct = $cart->products()->find($product_id);
        if ($existingProduct) {
            $cart->products()->detach($product_id);
        }

        return response()->json([
            'message' => 'Producto eliminado con éxito del carrito',
            'cart' => $cart
        ], 200);
    }
}
