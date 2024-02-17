<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

use App\Models\Product;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {

        $productData = ['sku' => 'PROD001', 'name' => 'Waterfall', 'price' => 19.99, 'description' => 'Cuida hasta el último detalle en cada entrenamiento. Lograr un rendimiento óptimo va mucho más allá de tus propias fuerzas. Controla al máximo los factores externos para llegar tan lejos como te lo propongas. La nueva botella de Siroko de 600ml ha sido fabricada en acero inoxidable por sus extraordinarias propiedades.Es mucho más ligera y resistente que los materiales tradicionales, conserva mejor la temperatura fría o caliente gracias a su aislamiento de doble pared, puedes utilizarla tantas veces como quieras y está libre de BPA o cualquier otro agente químico. Dispone de tapón de rosca con agarre y sellado de silicona para que no pierdas ni una gota de tu bebida preferida. También cuenta con mezclador extraíble y tratamiento exterior para lavavajillas. Maneja a tu gusto todo lo que dependa de ti.', 'stock' => 20];
        $product = Product::create($productData);
        $product->categories()->attach(9);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
        Product::truncate();
    }
};
