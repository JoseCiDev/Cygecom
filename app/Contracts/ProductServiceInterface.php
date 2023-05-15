<?php

namespace App\Contracts;

interface ProductServiceInterface
{
    public function getProducts();

    public function getProductsWithRelations();

    public function firstProductWithRelations(int $id);

    public function getCategories();

    public function registerProduct(array $data);

    public function updateProduct(array $data, int $id);

    public function deleteProduct(int $id);
}
