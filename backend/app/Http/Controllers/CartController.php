<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\CartService;


class CartController extends Controller
{
    protected $cartService;

    public function __construct(CartService $cartService)
    {
        $this->cartService = $cartService;
    }


    public function getCart(Request $request, $cartId)
    {
        $cart = $this->cartService->getCart($cartId);

        if (!$cart) {
            return response()->json(['message' => 'Cart not found'], 404);
        }

        return response()->json(['cart' => $cart], 200);
    }


    public function getProductsCart(Request $request, $cartId)
    {
        $products = $this->cartService->getProductsCart($cartId);
        if (!$products) {
            return response()->json(['message' => 'Cart not found'], 404);
        }

        return response()->json(['products' => $products], 200);
    }


    public function addItemToCart($idCart, $idProduct, $qty = 1)
    {
        return $this->cartService->addItemToCart($idCart, $idProduct, $qty);
    }


    public function removeItemFromCart($idCart, $idProduct)
    {
        return $this->cartService->removeItemFromCart($idCart, $idProduct);
    }
}
