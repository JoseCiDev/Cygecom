<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Enums\CompanyGroup;
use Illuminate\Http\Request;
use App\Enums\PurchaseRequestType;
use App\Providers\SupplierService;
use App\Enums\PurchaseRequestStatus;
use App\Providers\PurchaseRequestService;

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
        $excludedStatus = [
            PurchaseRequestStatus::RASCUNHO,
            PurchaseRequestStatus::FINALIZADA,
            PurchaseRequestStatus::CANCELADA
        ];
        $purchaseRequestsGoupedByType = $this->purchaseRequestService->allPurchaseRequests()
            ->whereNull('deleted_at')
            ->whereNull('supplies_user_id')
            ->whereNotIn('status', $excludedStatus)
            ->get()
            ->groupBy(function ($item) {
                return $item->type->value;
            });

        $productRequests = $this->purchaseRequestService->getRequestsByCompany(PurchaseRequestType::PRODUCT, $purchaseRequestsGoupedByType);
        $serviceRequests = $this->purchaseRequestService->getRequestsByCompany(PurchaseRequestType::SERVICE, $purchaseRequestsGoupedByType);
        $contractRequests = $this->purchaseRequestService->getRequestsByCompany(PurchaseRequestType::CONTRACT, $purchaseRequestsGoupedByType);

        $params = [
            'productsQtdByCompany' => $productRequests['byCompany'],
            'productsTotal' => $productRequests['total'],
            'servicesQtdByCompany' => $serviceRequests['byCompany'],
            'servicesTotal' => $serviceRequests['total'],
            'contractQtdByCompany' => $contractRequests['byCompany'],
            'contractsTotal' => $contractRequests['total'],
        ];

        $products = $purchaseRequestsGoupedByType->get(PurchaseRequestType::PRODUCT->value, collect());
        $services = $purchaseRequestsGoupedByType->get(PurchaseRequestType::SERVICE->value, collect());
        $contracts = $purchaseRequestsGoupedByType->get(PurchaseRequestType::CONTRACT->value, collect());

        $today = \Carbon\Carbon::today()->format('Y-m-d');

        $params = array_merge($params, $this->getComexAndDesiredTodayCounts($products, $services, $contracts, $today));

        return view('components.supplies.index', $params);
    }

    public function product(Request $request)
    {
        $statusData = $request->input('status');
        $querySuppliesGroup = request()->query('suppliesGroup');

        $status = $statusData ? array_map(function ($item) {
            return PurchaseRequestStatus::tryFrom($item);
        }, $statusData) : [];

        try {
            $suppliesGroup = $querySuppliesGroup ? CompanyGroup::from($querySuppliesGroup) : null;
        } catch (\ValueError $error) {
            return redirect()->back()->withInput()->withErrors("Parâmetro(s) inválido(s).");
        }

        return view('components.supplies.product.page', ['suppliesGroup' => $suppliesGroup, "status" => $status]);
    }

    public function service(Request $request)
    {
        $statusData = $request->input('status');
        $querySuppliesGroup = request()->query('suppliesGroup');

        $status = $statusData ? array_map(function ($item) {
            return PurchaseRequestStatus::tryFrom($item);
        }, $statusData) : [];

        try {
            $suppliesGroup = $querySuppliesGroup ? CompanyGroup::from($querySuppliesGroup) : null;
        } catch (\ValueError $error) {
            return redirect()->back()->withInput()->withErrors("Parâmetro(s) inválido(s).");
        }

        return view('components.supplies.service.page', ['suppliesGroup' => $suppliesGroup, "status" => $status]);
    }

    public function contract(Request $request)
    {
        $statusData = $request->input('status');
        $querySuppliesGroup = request()->query('suppliesGroup');

        $status = $statusData ? array_map(function ($item) {
            return PurchaseRequestStatus::tryFrom($item);
        }, $statusData) : [];

        try {
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
