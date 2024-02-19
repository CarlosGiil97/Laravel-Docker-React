<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{

    // Posibles constantes métodos de pago
    const CREDIT_CARD = 'Tarjeta de crédito';
    const PAYPAL = 'Paypal';
    const BIZUM = 'Bizum';
    const TRANSFER = 'Transferencia';


    use HasFactory;

    protected $fillable = [
        'cart_id',
        'paid',
        'payment_method',
    ];

    public $timestamps = true;

    /*
    * Obtener del carrito que proviene ese pedido
    */

    public function cart()
    {
        return $this->belongsTo(Cart::class);
    }
}
