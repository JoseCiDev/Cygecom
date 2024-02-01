<?php

namespace App\Http\Controllers;

use App\Models\Company;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Database\Eloquent\Collection;
use App\Enums\{PurchaseRequestType, PurchaseRequestStatus, CompanyGroup};
use App\Providers\{SupplierService, PurchaseRequestService};
use App\Http\Requests\Supplies\SuppliesParamsRequest;
use Illuminate\Support\Facades\Gate;

class SuppliesController extends Controller
{
    public function __construct(
        private PurchaseRequestService $purchaseRequestService,
        private SupplierService $supplierService
    ) {
    }

    /**
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(): View
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

        return view('supplies.index', $params);
    }

    public function productIndex(SuppliesParamsRequest $request): View
    {
        $params = $this->getRequestsParams($request, PurchaseRequestType::PRODUCT);

        return view('supplies.product.page', $params);
    }

    public function serviceIndex(SuppliesParamsRequest $request): View
    {
        $params = $this->getRequestsParams($request, PurchaseRequestType::SERVICE);

        return view('supplies.service.page', $params);
    }

    public function contractIndex(SuppliesParamsRequest $request): View
    {
        $params = $this->getRequestsParams($request, PurchaseRequestType::CONTRACT);

        return view('supplies.contract.page', $params);
    }

    /**
     * Contabiliza quantos comex e datas desejadas existem para cada tipo de solicitação
     * @param Collection $products
     * @param Collection $services
     * @param Collection $contracts
     */
    private function getComexAndDesiredTodayCounts($products, $services, $contracts, $today): array
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

    /**
     * Cria e retorna os parâmetros para view da solicitação do tipo escolhido
     * @param SuppliesParamsRequest $request
     * @param PurchaseRequestType $requestType
     * @return array parâmetros da solcitação
     */
    private function getRequestsParams(SuppliesParamsRequest $request, PurchaseRequestType $requestType): array
    {
        $status = collect($request->get('status'));

        if ($status->isEmpty()) {
            $status = collect([PurchaseRequestStatus::PENDENTE->value]);
        }

        $requests = $this->purchaseRequestService->requestsByStatus($status->toArray())
            ->whereNotIn('status', [PurchaseRequestStatus::RASCUNHO->value]);

        if (!Gate::allows('admin')) {
            $requests->whereHas('costCenterApportionment', fn ($query) => $query->whereHas(
                'costCenter',
                fn ($query) => $query->whereIn('id', auth()->user()->suppliesCostCenters->pluck('id'))
            ));
        }

        $requests->where('type', $requestType);

        $params = [
            'status' => $status,
            'requests' => $requests->get()
        ];

        return $params;
    }
}
