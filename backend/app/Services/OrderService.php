<?php

namespace App\Services;

use App\Models\Cart;
use App\Models\Product;
use App\Models\Order;

class OrderService
{
    /**
     * Obtener la información de un pedido en concreto.
     *
     * @param int $cartId ID del carrito
     * @return \App\Models\Order|null 
     */
    public function getOrder($orderId)
    {

        try {
            $order = Order::with('cart.products')->find($orderId);
            if (!$order) {
                return response()->json(['message' => 'Pedido no encontrado'], 404);
            }

            return response()->json(['message' => 'Pedido obtenido con éxito', 'order' => $order], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Error al obtener el pedido'], 400);
        }
    }

    /**
     * Generar un pedido a partir de un carrito.
     *
     * @param int $cartId ID del carrito
     * @return \App\Models\Order|null 
     */
    public function generateOrder($cartId)
    {
        try {
            $cart = Cart::find($cartId);
            if (!$cart) {
                return response()->json(['message' => 'Carrito no encontrado'], 404);
            }

            //antes de crear un pedido, se comprueba que no exista ya un pedido relacionado a ese carrito, para reciclarlo y no crear pedidos de más
            $order = Order::where('cart_id', $cartId)->first();

            if (!$order) {
                $order = new Order();
            }

            $order->cart_id = $cartId;
            $order->paid = false;
            $order->payment_method = Order::CREDIT_CARD; // Por defecto , esto debe ser dinámico dependiendo de lo que ha elegido el cliente en la vista de ckeckou
            $order->save();

            $products = $cart->products()->get();


            return response()->json(['message' => 'Pedido generado con éxito', 'order' => $order, 'products' => $products], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Error al generar el pedido', 'msg' => $e->getMessage()], 400);
        }
    }


    /**
     * Devuelve todos los métodos de pago como array asociativo.
     *
     * @return array
     */
    public static function methodsPayment()
    {
        return [
            Order::CREDIT_CARD,
            Order::PAYPAL,
            Order::BIZUM,
            Order::TRANSFER,
        ];
    }
}
