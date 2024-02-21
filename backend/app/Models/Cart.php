<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Database\Factories\CartFactory;


class Cart extends Model
{
    protected $fillable = ['session_id', 'done'];
    public $timestamps = true;


    protected static function factory()
    {
        return CartFactory::new();
    }

    /**
     * Obtener los productos asociados al carrito.
     */

    public function products()
    {
        return $this->belongsToMany(Product::class)->withPivot('quantity');
    }

    /**
     * Obtener el pedido asociado al carrito.
     */
    public function order()
    {
        return $this->hasOne(Order::class);
    }
}
