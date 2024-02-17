<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Category;

class Product extends Model
{
    use HasFactory;


    protected $table = 'products';
    public $timestamps = true;

    protected $fillable = ['sku', 'name', 'price', 'description', 'stock'];

    public function categories()
    {
        return $this->belongsToMany(Category::class);
    }
}
