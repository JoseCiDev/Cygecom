<?php

namespace App\Http\Controllers;

use App\Enums\PurchaseRequestStatus;
use App\Providers\PurchaseRequestService;
use App\Services\ReportService;
use Illuminate\Http\{Request, JsonResponse};
use Illuminate\View\View;
use Exception;

class ReportController extends Controller
{
    public function __construct(private PurchaseRequestService $purchaseRequestService, private ReportService $reportService)
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
        $searchValue = (string) $request->query('search', ['value' => null])['value'];
        $orderColumnIndex = (int) $request->query('order', [0 => ['column' => 0]])[0]['column'];
        $orderDirection = (string) $request->query('order', [0 => ['dir' => 'asc']])[0]['dir'];
        $status = (string) $request->query('status', false);
        $requestType = (string) $request->query('request-type', false);
        $requestingUsersIds = (string) $request->query('requesting-users-ids', false);
        $costCenterIds = (string) $request->query('cost-center-ids', false);
        $dateSince = (string) $request->query('date-since', false);
        $dateUntil = (string) $request->query('date-until', now());
        $ownRequests = (string) $request->query('own-requests', true);
        $currentPage = ($start / $length) + 1;
        $isAll = $length === -1;

        try {
            $query = $this->purchaseRequestService->allPurchaseRequests()
                ->whereNull('deleted_at')
                ->where('status', "!=", PurchaseRequestStatus::RASCUNHO->value);

            $query = $this->reportService->whereInLogDate($query, $dateSince, $dateUntil);

            $query = $this->reportService->whereInRequistingUserQuery($query, $requestingUsersIds, $ownRequests);

            if ($costCenterIds) {
                $query = $this->reportService->whereInCostCenterQuery($query, $costCenterIds);
            }

            if ($requestType) {
                $query = $this->reportService->whereInRequestTypeQuery($query, $requestType);
            }

            if ($status) {
                $query = $this->reportService->whereInStatusQuery($query, $status);
            }

            $query = $this->reportService->orderByMapped($query, $orderColumnIndex, $orderDirection);

            if (!empty($searchValue)) {
                $query = $this->reportService->searchValueQuery($query, $searchValue);
            }

            $requests = $isAll ? $query->get() : $query->paginate($length, ['*'], 'page', $currentPage);
        } catch (Exception $error) {
            return response()->json(['error' => 'Não foi possível buscar as solicitações. Por favor, tente novamente mais tarde.' . $error], 500);
        }

        return response()->json([
            'data' => $isAll ? $requests->toArray() : $requests->items(),
            'draw' => $draw,
            'recordsTotal' => $isAll ? $requests->count() : $requests->total(),
            'recordsFiltered' => $isAll ? $requests->count() : $requests->total(),
        ], 200);
    }
}
