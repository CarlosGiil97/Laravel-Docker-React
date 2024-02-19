<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    protected $fillable = ['session_id', 'done'];
    public $timestamps = true;

    /**
     * Obtener los productos asociados al carrito.
     */

    public function products()
    {
        return $this->belongsToMany(Product::class)->withPivot('quantity');
    }
}
