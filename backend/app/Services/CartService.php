<?php

namespace App\Services;

use App\Models\Cart;

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
}
