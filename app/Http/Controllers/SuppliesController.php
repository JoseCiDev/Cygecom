<?php

namespace App\Http\Controllers;

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

        $purchaseRequests = $this->purchaseRequestService
            ->allPurchaseRequests()
            ->whereNull('deleted_at')
            ->whereNotIn('status', $excludedStatus)->get();

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
            $status = collect(PurchaseRequestStatus::cases())
                ->pluck('value')->filter(fn ($status) => !collect([
                    PurchaseRequestStatus::RASCUNHO->value,
                    PurchaseRequestStatus::FINALIZADA->value,
                    PurchaseRequestStatus::CANCELADA->value
                ])->contains($status));
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
