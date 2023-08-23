<?php

namespace Database\Seeders;

use App\Models\ProductCategory;
use App\Models\ProductSuggestion;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PopulateProductSuggestions extends Seeder
{
    public function run(): void
    {
        DB::transaction(function () {
            $this->insertProductSuggestions('Material de Limpeza e Copa', 'PopulateProductSuggestions/data/material_limpeza_copa.php');
            $this->insertProductSuggestions('Material de escritório', 'PopulateProductSuggestions/data/material_escritorio.php');
            $this->insertProductSuggestions('Material Utilizado na Produção/Lab', 'PopulateProductSuggestions/data/material_producao_lab.php');
        });
    }

    private function insertProductSuggestions($categoryName, $dataFile): void
    {
        $category = ProductCategory::where('name', $categoryName)->first();

        if ($category) {
            $productSuggestions = require __DIR__ . '/' . $dataFile;

            foreach ($productSuggestions as $productSuggestion) {
                $data = array_merge($productSuggestion, ['product_category_id' => $category->id]);
                ProductSuggestion::create($data);
            }
        }
    }
}
