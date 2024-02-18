<?php

namespace App\Services;

use App\Models\Product;

class ProductService
{
    /**
     * Obtiene todos los productos con sus categorías.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     * @throws \Exception
     */
    public function getAllProducts()
    {
        try {
            // obtener todos los productos con sus categorías
            return Product::with('categories:name')->get();
        } catch (\Exception $e) {
            // poder ver el error
            throw new \Exception("Error al obtener todos los productos: " . $e->getMessage());
        }
    }


    /**
     * Obtiene un producto por su ID.
     *
     * @param int $productId
     * @return \App\Models\Product
     * @throws \Exception
     */
    public function getProductById($productId)
    {
        try {
            return Product::with('categories:name')->findOrFail($productId);
        } catch (\Exception $e) {
            throw new \Exception("Error al obtener el producto: " . $e->getMessage());
        }
    }
}
