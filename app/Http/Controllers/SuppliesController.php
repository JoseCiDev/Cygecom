<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Enums\{PurchaseRequestType, PurchaseRequestStatus, CompanyGroup};
use App\Providers\{SupplierService, PurchaseRequestService};
use Illuminate\Database\Eloquent\Collection;
use Illuminate\View\View;

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

        $params = array_merge($params, $this->getComexAndDesiredTodayCounts($products, $services, $contracts, $today));

        return view('components.supplies.index', $params);
    }

    public function product(): View
    {
        $params = $this->getRequestsParams(request(), PurchaseRequestType::PRODUCT);

        return view('components.supplies.product.page', $params);
    }

    public function service(): View
    {
        $params = $this->getRequestsParams(request(), PurchaseRequestType::SERVICE);

        return view('components.supplies.service.page', $params);
    }

    public function contract(): View
    {
        $params = $this->getRequestsParams(request(), PurchaseRequestType::CONTRACT);

        return view('components.supplies.contract.page', $params);
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
     * @param Request $request
     * @param PurchaseRequestType $requestType
     * @return array parâmetros da solcitação
     */
    private function getRequestsParams(Request $request, PurchaseRequestType $requestType): array
    {
        $statusData = collect($request->get('status'));
        $status = $statusData->map(fn ($el) => PurchaseRequestStatus::tryFrom($el));

        if ($status->isNotEmpty()) {
            $purchaseRequests = $this->purchaseRequestService->requestsByStatus($status->toArray())
                ->whereNotIn('status', [PurchaseRequestStatus::RASCUNHO->value])->get();
        } else {
            $purchaseRequests = $this->purchaseRequestService->allPurchaseRequests()
                ->whereNotIn('status', [
                    PurchaseRequestStatus::RASCUNHO->value,
                    PurchaseRequestStatus::FINALIZADA->value,
                    PurchaseRequestStatus::CANCELADA->value
                ])->whereNull('deleted_at')->get();
        }

        $requests = $purchaseRequests->filter(function ($item) use ($requestType) {
            $validType = $item->type->value === $requestType->value;

            if ($validType) {
                return $item;
            }
        });

        $params = [
            'status' => $status,
            'requests' => $requests
        ];

        return $params;
    }
}
