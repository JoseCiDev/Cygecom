<?php

namespace App\Contracts;

use App\Providers\ValidatorService;
use App\Services\QuotationService;
use Illuminate\Http\Request;

interface QuotationControllerInterface
{
    public function __construct(QuotationService $quotationService, ValidatorService $validatorService);
    public function index();
    public function showRegistrationForm();
    public function register(Request $request);
}
