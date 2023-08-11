<?php

namespace App\Http\Controllers;

use App\Enums\CompanyGroup;
use App\Enums\PurchaseRequestStatus;
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
        $currentProfile = auth()->user()->profile->name;
        $purchaseRequests = $this->purchaseRequestService->allPurchaseRequests()->whereNull('deleted_at')->whereNotIn('status', ['rascunho'])->get();

        $typesGrouped = $purchaseRequests->groupBy(function ($item) {
            return $item->type->value;
        });

        $products = $typesGrouped->get(PurchaseRequestType::PRODUCT->value, collect());
        $services = $typesGrouped->get(PurchaseRequestType::SERVICE->value, collect());
        $contracts = $typesGrouped->get(PurchaseRequestType::CONTRACT->value, collect());

        $today = \Carbon\Carbon::today()->format('Y-m-d');

        $productsFromInp = $this->supplierService->filterRequestByCompanyGroup($products, CompanyGroup::INP);
        $productsFromHkm = $this->supplierService->filterRequestByCompanyGroup($products, CompanyGroup::HKM);

        $servicesFromInp = $this->supplierService->filterRequestByCompanyGroup($services, CompanyGroup::INP);
        $servicesFromHkm = $this->supplierService->filterRequestByCompanyGroup($services, CompanyGroup::HKM);

        $contractsFromInp = $this->supplierService->filterRequestByCompanyGroup($contracts, CompanyGroup::INP);
        $contractsFromHkm = $this->supplierService->filterRequestByCompanyGroup($contracts, CompanyGroup::HKM);

        $params = [
            'purchaseRequests' => $purchaseRequests,
            'productQtd' => $products->count(),
            'serviceQtd' => $services->count(),
            'contractQtd' => $contracts->count(),
            'productsFromInp' => $productsFromInp,
            'productsFromHkm' => $productsFromHkm,
            'servicesFromInp' => $servicesFromInp,
            'servicesFromHkm' => $servicesFromHkm,
            'contractsFromInp' => $contractsFromInp,
            'contractsFromHkm' => $contractsFromHkm,
        ];

        if ($currentProfile === 'admin') {
            $params = array_merge($params, $this->getComexAndDesiredTodayCounts($products, $services, $contracts, $today));
        } elseif ($currentProfile === 'suprimentos_hkm') {
            $params = array_merge($params, $this->getComexAndDesiredTodayCounts($productsFromHkm, $servicesFromHkm, $contractsFromHkm, $today));
        } elseif ($currentProfile === 'suprimentos_inp') {
            $params = array_merge($params, $this->getComexAndDesiredTodayCounts($productsFromInp, $servicesFromInp, $contractsFromInp, $today));
        }

        return view('components.supplies.index', $params);
    }

    public function product()
    {
        $queryStatus = request()->query('status');
        $querySuppliesGroup = request()->query('suppliesGroup');

        try {
            $status = $queryStatus ? PurchaseRequestStatus::from($queryStatus) : null;
            $suppliesGroup = $querySuppliesGroup ? CompanyGroup::from($querySuppliesGroup) : null;
        } catch (\ValueError $error) {
            return redirect()->back()->withInput()->withErrors("Parâmetro(s) inválido(s).");
        }

        return view('components.supplies.product.page', ['suppliesGroup' => $suppliesGroup, "status" => $status]);
    }

    public function service()
    {
        $queryStatus = request()->query('status');
        $querySuppliesGroup = request()->query('suppliesGroup');

        try {
            $status = $queryStatus ? PurchaseRequestStatus::from($queryStatus) : null;
            $suppliesGroup = $querySuppliesGroup ? CompanyGroup::from($querySuppliesGroup) : null;
        } catch (\ValueError $error) {
            return redirect()->back()->withInput()->withErrors("Parâmetro(s) inválido(s).");
        }

        return view('components.supplies.service.page', ['suppliesGroup' => $suppliesGroup, "status" => $status]);
    }

    public function contract()
    {
        $queryStatus = request()->query('status');
        $querySuppliesGroup = request()->query('suppliesGroup');

        try {
            $status = $queryStatus ? PurchaseRequestStatus::from($queryStatus) : null;
            $suppliesGroup = $querySuppliesGroup ? CompanyGroup::from($querySuppliesGroup) : null;
        } catch (\ValueError $error) {
            return redirect()->back()->withInput()->withErrors("Parâmetro(s) inválido(s).");
        }

        return view('components.supplies.contract.page', ['suppliesGroup' => $suppliesGroup, "status" => $status]);
    }

    private function getComexAndDesiredTodayCounts($products, $services, $contracts, $today)
    {
        return [
            'productComexQtd' => $products->where('is_comex', true)->count(),
            'serviceComexQtd' => $services->where('is_comex', true)->count(),
            'contractComexQtd' => $contracts->where('is_comex', true)->count(),
            'productDesiredTodayQtd' => $products->where('desired_date', $today)->count(),
            'serviceDesiredTodayQtd' => $services->where('desired_date', $today)->count(),
            'contractDesiredTodayQtd' => $contracts->where('desired_date', $today)->count(),
        ];
    }
}
