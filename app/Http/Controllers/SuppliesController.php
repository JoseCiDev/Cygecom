<?php

namespace App\Http\Controllers;

use App\Providers\PurchaseRequestService;

class SuppliesController extends Controller
{
    public function __construct(private PurchaseRequestService $purchaseRequestService)
    {
        $this->middleware('auth');
    }

    /**
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $purchaseRequests = $this->purchaseRequestService->purchaseRequests();

        $typesGrouped = $purchaseRequests->groupBy(function ($item) {
            return $item->type->label();
        });

        $contractQtd = $typesGrouped->get('Contrato', collect())->count();
        $serviceQtd = $typesGrouped->get('Serviço', collect())->count();
        $productQtd = $typesGrouped->get('Produto', collect())->count();

        $contractAcquiredBySuppliesQtd = $typesGrouped->get('Contrato', collect())->where('is_supplies_contract', true)->count();
        $serviceAcquiredBySuppliesQtd = $typesGrouped->get('Serviço', collect())->where('is_supplies_contract', true)->count();
        $productAcquiredBySuppliesQtd = $typesGrouped->get('Produto', collect())->where('is_supplies_contract', true)->count();

        $contractComexQtd = $typesGrouped->get('Contrato', collect())->where('is_comex', true)->count();
        $serviceComexQtd = $typesGrouped->get('Serviço', collect())->where('is_comex', true)->count();
        $productComexQtd = $typesGrouped->get('Produto', collect())->where('is_comex', true)->count();

        $params = [
            'purchaseRequests' => $purchaseRequests,
            'contractQtd' => $contractQtd,
            'serviceQtd' => $serviceQtd,
            'productQtd' => $productQtd,
            'contractAcquiredBySuppliesQtd' => $contractAcquiredBySuppliesQtd,
            'serviceAcquiredBySuppliesQtd' => $serviceAcquiredBySuppliesQtd,
            'productAcquiredBySuppliesQtd' => $productAcquiredBySuppliesQtd,
            'contractComexQtd' => $contractComexQtd,
            'serviceComexQtd' => $serviceComexQtd,
            'productComexQtd' => $productComexQtd
        ];
        return view('components.supplies.index', $params);
    }

    public function product()
    {
        return view('components.supplies.product');
    }

    public function service()
    {
        return view('components.supplies.service');
    }

    public function contract()
    {
        return view('components.supplies.contract');
    }
}
