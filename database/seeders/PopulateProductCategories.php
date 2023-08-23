<?php

namespace Database\Seeders;

use App\Models\ProductCategory;
use App\Models\ProductSuggestion;
use App\Models\PurchaseRequestProduct;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PopulateProductCategories extends Seeder
{
    public function run(): void
    {
        $categories = require __DIR__ . '/PopulateProductCategories/data/categories.php';

        DB::transaction(function () use ($categories) {
            $categoryNames = array_column($categories, 'name');

            // Atualiza relações com product_suggestions e purchase_request_products para apontar para o ID de categoria default;
            $defaultCategory = ProductCategory::where('name', 'Outros Tipos de Produto')->first();
            if ($defaultCategory) {
                ProductSuggestion::whereIn('product_category_id', function ($query) use ($categoryNames) {
                    $query->select('id')->from('product_categories')->whereNotIn('name', $categoryNames);
                })->update(['product_category_id' => $defaultCategory->id]);

                PurchaseRequestProduct::whereIn('product_category_id', function ($query) use ($categoryNames) {
                    $query->select('id')->from('product_categories')->whereNotIn('name', $categoryNames);
                })->update(['product_category_id' => $defaultCategory->id]);
            }

            ProductCategory::whereNotIn('name', $categoryNames)->delete();

            foreach ($categories as $category) {
                ProductCategory::updateOrCreate(
                    ['name' => $category['name']],
                    ['description' => $category['description']]
                );
            }
        });
    }
}
