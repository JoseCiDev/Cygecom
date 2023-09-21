<?php

namespace App\Http\Controllers;

use App\Models\{Service, Product, Person, Contract};
use App\Providers\PurchaseRequestService;
use Illuminate\Http\{Request, JsonResponse};
use Illuminate\View\View;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Exception;

class ReportController extends Controller
{
    public function __construct(private PurchaseRequestService $purchaseRequestService)
    {
    }

    public function indexView(): View
    {
        return view('reports');
    }

    public function indexJson(Request $request): JsonResponse
    {
        $draw = (int) $request->query('draw', 1);
        $start = (int) $request->query('start', 0);
        $length = (int) $request->query('length', 10);
        $searchValue = $request->query('search')['value'];
        $orderColumnIndex = (int) $request->query('order')[0]['column'];
        $orderDirection = $request->query('order')[0]['dir'];
        $currentPage = ($start / $length) + 1;

        try {
            $query = $this->purchaseRequestService->allPurchaseRequests()->whereNull('deleted_at');

            $orderColumnMappings = [
                0 => 'id',
                1 => 'type',
                2 => 'responsibility_marked_at',
                3 => Person::select('name')->whereColumn('people.id', '=', 'purchase_requests.user_id'),
                4 => 'status',
                5 => Person::select('name')->whereColumn('people.id', '=', 'purchase_requests.supplies_user_id'),
                10 => Product::select('amount')->whereColumn('products.purchase_request_id', '=', 'purchase_requests.id')
                    ->union(Service::select('price')->whereColumn('services.purchase_request_id', '=', 'purchase_requests.id'))
                    ->union(Contract::select('amount')->whereColumn('contracts.purchase_request_id', '=', 'purchase_requests.id'))
            ];

            $orderColumn = $orderColumnMappings[$orderColumnIndex] ?? false;

            if ($orderColumn) {
                $query->orderBy($orderColumn, $orderDirection);
            }

            if (!empty($searchValue)) {
                $query = $this->searchValueQuery($query, $searchValue);
            }

            $requests = $query->paginate($length, ['*'], 'page', $currentPage);
        } catch (Exception $error) {
            return response()->json(['error' => 'Não foi possível buscar os fornecedores. Por favor, tente novamente mais tarde.' . $error], 500);
        }

        return response()->json([
            'data' => $requests->items(),
            'draw' => $draw,
            'recordsTotal' => $requests->total(),
            'recordsFiltered' => $requests->total(),
        ], 200);
    }

    private function searchValueQuery($query, string $searchValue): Builder
    {
        return $query
            ->where('id', 'like', "%{$searchValue}%")
            ->orWhereHas('user', function ($query) use ($searchValue) {
                $query->whereHas('person', function ($query) use ($searchValue) {
                    $query->where('name', 'like', "%{$searchValue}%");
                });
            })
            ->orWhereHas('suppliesUser', function ($query) use ($searchValue) {
                $query->whereHas('person', function ($query) use ($searchValue) {
                    $query->where('name', 'like', "%{$searchValue}%");
                });
            })
            ->orWhereHas('costCenterApportionment', function ($query) use ($searchValue) {
                $query->whereHas('costCenter', function ($query) use ($searchValue) {
                    $query->where('name', 'like', "%{$searchValue}%");
                });
            })
            ->orWhereHas('costCenterApportionment', function ($query) use ($searchValue) {
                $query->whereHas('costCenter', function ($query) use ($searchValue) {
                    $query->where('name', 'like', "%{$searchValue}%");
                });
            })
            ->orWhereHas('product', function ($query) use ($searchValue) {
                $query->where('amount', 'like', "%{$searchValue}%");
            })
            ->orWhereHas('purchaseRequestProduct', function ($query) use ($searchValue) {
                $query->whereHas('supplier', function ($query) use ($searchValue) {
                    $query->where('corporate_name', 'like', "%{$searchValue}%");
                });
            })
            ->orWhereHas('service', function ($query) use ($searchValue) {
                $query->where('price', 'like', "%{$searchValue}%")
                    ->orWhereHas('supplier', function ($query) use ($searchValue) {
                        $query->where('corporate_name', 'like', "%{$searchValue}%");
                    });
            })
            ->orWhereHas('contract', function ($query) use ($searchValue) {
                $query->where('amount', 'like', "%{$searchValue}%")
                    ->orWhereHas('supplier', function ($query) use ($searchValue) {
                        $query->where('corporate_name', 'like', "%{$searchValue}%");
                    });
            });
    }
}
