<?php

namespace App\Http\Controllers;

use App\Enums\CompanyGroup;
use App\Enums\PurchaseRequestType;
use App\Providers\PurchaseRequestService;
use App\Providers\SupplierService;

class SuppliesController extends Controller
{
    public function __construct(private PurchaseRequestService $purchaseRequestService, private SupplierService $supplierService)
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
            return $item->type->value;
        });

        $contracts = $typesGrouped->get(PurchaseRequestType::CONTRACT->value, collect());
        $services = $typesGrouped->get(PurchaseRequestType::SERVICE->value, collect());
        $products = $typesGrouped->get(PurchaseRequestType::PRODUCT->value, collect());

        $today = \Carbon\Carbon::today()->format('Y-m-d');

        $params = [
            'purchaseRequests' => $purchaseRequests,
            'contractQtd' => $contracts->count(),
            'serviceQtd' => $services->count(),
            'productQtd' => $products->count(),
            'contractAcquiredBySuppliesQtd' => $contracts->where('is_supplies_contract', true)->count(),
            'serviceAcquiredBySuppliesQtd' => $services->where('is_supplies_contract', true)->count(),
            'productAcquiredBySuppliesQtd' => $products->where('is_supplies_contract', true)->count(),
            'contractComexQtd' => $contracts->where('is_comex', true)->count(),
            'serviceComexQtd' => $services->where('is_comex', true)->count(),
            'productComexQtd' => $products->where('is_comex', true)->count(),
            'contractDesiredTodayQtd' => $contracts->where('desired_date', $today)->count(),
            'serviceDesiredTodayQtd' => $services->where('desired_date', $today)->count(),
            'productDesiredTodayQtd' => $products->where('desired_date', $today)->count(),

            'productsFromInp' => $this->supplierService->filterRequestByCompanyGroup($products, CompanyGroup::INP),
            'productsFromHkm' => $this->supplierService->filterRequestByCompanyGroup($products, CompanyGroup::HKM),

            'servicesFromInp' => $this->supplierService->filterRequestByCompanyGroup($services, CompanyGroup::INP),
            'servicesFromHkm' => $this->supplierService->filterRequestByCompanyGroup($services, CompanyGroup::HKM),

            'contractsFromInp' => $this->supplierService->filterRequestByCompanyGroup($contracts, CompanyGroup::INP),
            'contractsFromHkm' => $this->supplierService->filterRequestByCompanyGroup($contracts, CompanyGroup::HKM),
        ];
        return view('components.supplies.index', $params);
    }

    public function product(string $suppliesGroup = null)
    {
        if ($suppliesGroup !== null) {
            try {
                $suppliesGroup = CompanyGroup::from($suppliesGroup);
            } catch (\ValueError $error) {
                return redirect()->back()->withInput()->withErrors("$suppliesGroup não é um parâmetro válido.");
            }
        }

        return view('components.supplies.product', ['suppliesGroup' => $suppliesGroup]);
    }

    public function service(string $suppliesGroup = null)
    {
        if ($suppliesGroup !== null) {
            try {
                $suppliesGroup = CompanyGroup::from($suppliesGroup);
            } catch (\ValueError $error) {
                return redirect()->back()->withInput()->withErrors("$suppliesGroup não é um parâmetro válido.");
            }
        }

        return view('components.supplies.service', ['suppliesGroup' => $suppliesGroup]);
    }

    public function contract(string $suppliesGroup = null)
    {
        if ($suppliesGroup !== null) {
            try {
                $suppliesGroup = CompanyGroup::from($suppliesGroup);
            } catch (\ValueError $error) {
                return redirect()->back()->withInput()->withErrors("$suppliesGroup não é um parâmetro válido.");
            }
        }

        return view('components.supplies.contract', ['suppliesGroup' => $suppliesGroup]);
    }
}
