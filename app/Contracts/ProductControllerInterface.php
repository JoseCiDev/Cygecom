<?php

namespace App\Contracts;

use App\Providers\{ProductService, ValidatorService};
use Illuminate\Http\Request;

interface ProductControllerInterface
{
    public function __construct(ProductService $productService, ValidatorService $validatorService);
    public function index();

    public function form();

    public function product(int $id);

    public function register(Request $request);

    public function update(Request $request, int $id);

    public function delete(int $id);
}
