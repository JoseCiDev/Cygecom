<?php

namespace App\Providers;

use App\Models\Product;
use Illuminate\Support\ServiceProvider;

class ProductService extends ServiceProvider
{
    public function getProducts()
    {
        return Product::all();
    }

    public function getProductsWithRelations()
    {
        return Product::with(['categorie'])->get();
    }
}
