<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class GetProductsTest extends TestCase
{
    /**
     * Test para comprobar que se obtienen todos los productos.
     *
     * @return void
     */
    public function testGetAllProducts()
    {
        $response = $this->withHeaders([
            'X-API-KEY' => env('API_KEY'),
        ])->get('/api/products');
        $response->assertStatus(200);
        $response->assertJsonStructure([
            '*' => [
                'id',
                'sku',
                'name',
                'price',
                'description',
                'stock',
                'active',
                'created_at',
                'updated_at',
                'categories',
            ],
        ]);
    }

    /**
     * Test para comprobar que se obtiene un producto por su ID.
     *
     * @return void
     * 
     */


    public function testGetProductById()
    {
        $productId = 1;
        $response = $this->withHeaders([
            'X-API-KEY' => env('API_KEY'),
        ])->get("/api/products/{$productId}");
        $response->assertStatus(200);
        $response->assertJsonStructure([
            'id',
            'sku',
            'name',
            'price',
            'description',
            'stock',
            'active',
            'created_at',
            'updated_at',
            'categories',
        ]);
    }
}
