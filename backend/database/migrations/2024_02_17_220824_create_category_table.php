<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\Category;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->timestamps();
        });

        Category::insert([
            ['name' => 'Entrenamiento en casa'],
            ['name' => 'Entrenamiento de fuerza'],
            ['name' => 'Entrenamiento de resistencia'],
            ['name' => 'Cardio'],
            ['name' => 'Nutrición'],
            ['name' => 'Suplementos'],
            ['name' => 'Ropa deportiva'],
            ['name' => 'Calzado deportivo'],
            ['name' => 'Accesorios de fitness'],
            ['name' => 'Equipamiento para gimnasio'],
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('category');
    }
};
