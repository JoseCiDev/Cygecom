<?php

namespace App\Http\Controllers;

use App\Providers\ProductService;

class ProductController extends Controller
{
    public function index(ProductService $productService)
    {
        $products = $productService->getProductsWithRelations();
        return view('products', ['products' => $products]);
    }
}
