<?php

namespace Database\Seeders\Inserts;

use App\Models\ProductCategory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Database\Seeders\Inserts\Data\ProductCategoriesToInsert;

class InsertOnProductCategories extends Seeder
{
    public function run(): void
    {
        $newProductCategories = ProductCategoriesToInsert::getArray();

        DB::transaction(function () use ($newProductCategories) {
            foreach ($newProductCategories as $newCategory) {
                ProductCategory::updateOrCreate(['id' => $newCategory['id']], $newCategory);
            }
        });
    }
}
