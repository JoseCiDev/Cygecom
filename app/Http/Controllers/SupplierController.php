<?php

namespace App\Http\Controllers;

use App\Providers\ValidatorService;

class SupplierController extends Controller
{
    private $validatorService;

    public function __construct(ValidatorService $validatorService)
    {
        $this->validatorService = $validatorService;
    }

    // first page - list all orders requests
    public function index()
    {
        return view('components.supplier.index');
    }

    public function showRegistrationForm()
    {
        return view('components.supplier.register');
    }
}
