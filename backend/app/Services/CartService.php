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
}
