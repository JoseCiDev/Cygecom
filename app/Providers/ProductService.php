<?php

namespace App\Providers;

use App\Contracts\ProductServiceInterface;
use App\Models\Product;
use App\Models\ProductCategorie;
use Carbon\Carbon;
use Illuminate\Support\ServiceProvider;

class ProductService extends ServiceProvider implements ProductServiceInterface
{
    public function getProducts()
    {
        return Product::whereNull('deleted_at')->get();
    }

    /**
     * @return mixed Retorna produtos com categoria
     */
    public function getProductsWithRelations()
    {
        return Product::with(['categorie'])->whereNull('deleted_at')->get();
    }

    /**
     * @return mixed Retorna produtos com categoria e último usuário que atualizou
     */
    public function firstProductWithRelations(int $id)
    {
        return Product::with(['categorie', 'updaterUser', 'updaterUser.person'])->where('id', $id)->whereNull('deleted_at')->first();
    }

    public function getCategories()
    {
        return ProductCategorie::all();
    }

    public function registerProduct(array $data)
    {
        return Product::create($data);
    }

    public function updateProduct(array $data, int $id)
    {
        $product = Product::find($id);
        $product->fill($data);
        $product->save();
    }

    public function deleteProduct(int $id)
    {
        $product = Product::find($id);
        $product->deleted_at = Carbon::now();
        $product->deleted_by = auth()->user()->id;
        $product->save();
    }
}
