<?php

namespace App\Http\Controllers;

use App\Models\{Company, CostCenter};
use App\Providers\ValidatorService;

/**
 * @abstract rotas TESTE
 */
class OrderRequestController extends Controller
{
    //private $OrderRequestService;
    private $validatorService;

    public function __construct(ValidatorService $validatorService)
    {
        $this->validatorService = $validatorService;
    }

    // first page - list all orders requests
    public function index()
    {
        return view('components.order-request.index');
    }

    public function showRegistrationForm()
    {
        $companies   = Company::all();
        $costCenters = CostCenter::all();

        return view('components.order-request.register', compact('companies', 'costCenters'));
    }
}
