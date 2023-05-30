<?php

namespace App\Http\Controllers;

use App\Providers\ValidatorService;

class QuoteController extends Controller
{
    private $validatorService;

    public function __construct(ValidatorService $validatorService)
    {
        $this->validatorService = $validatorService;
    }

    public function index()
    {
        return view('components.quote.index');
    }

    public function showRegistrationForm()
    {
        return view('components.quote.register');
    }
}
