<?php

namespace App\Http\Controllers;

use App\Enums\PurchaseRequestStatus;
use App\Providers\{UserService, PurchaseRequestService};
use App\Services\{ReportService, PersonService};
use Carbon\Carbon;
use Illuminate\Http\{Request, JsonResponse};
use Illuminate\View\View;
use Exception;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    public function __construct(
        private PurchaseRequestService $purchaseRequestService,
        private ReportService $reportService,
        private UserService $userService,
        private PersonService $personService
    ) {
    }

    public function requestsIndex(): View
    {
        $requestingUsers = $this->reportService->getRequistingUsers();
        return view('components.reports.requests', ['requestingUsers' => $requestingUsers]);
    }

    public function productivityIndex(): View
    {
        $requestingUsers = $this->reportService->productivityRequestingUsers()->get();
        $suppliesUsers = $this->userService->getSuppliesUsers()->get();

        $allStatus = PurchaseRequestStatus::cases();
        $requestsStatusCounter = [];
        foreach ($allStatus as $status) {
            if ($status->value === PurchaseRequestStatus::RASCUNHO->value) {
                continue;
            }

            $requestsStatusCounter[PurchaseRequestStatus::tryFrom($status->value)->label()] = $this->purchaseRequestService->allPurchaseRequests()->where('status', $status->value)->count();
        }

        $params = [
            'requestingUsers' => $requestingUsers,
            'requestsStatusCounter' => $requestsStatusCounter,
            'suppliesUsers' => $suppliesUsers
        ];

        return view('components.reports.productivity', $params);
    }

    public function requestsIndexJson(Request $request): JsonResponse
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
            $query = $this->purchaseRequestService->allPurchaseRequests();

            if (empty($searchValue)) {
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
            }

            $query->select('purchase_requests.*', DB::raw('COALESCE(services.price, contracts.amount, products.amount) AS total_amount'))
                ->leftJoin('contracts', 'contracts.purchase_request_id', '=', 'purchase_requests.id')
                ->leftJoin('products', 'products.purchase_request_id', '=', 'purchase_requests.id')
                ->leftJoin('services', 'services.purchase_request_id', '=', 'purchase_requests.id');

            $orderValue = $this->reportService->orderByMapped($query, $orderColumnIndex);
            $query->orderBy($orderValue, $orderDirection);

            if (!empty($searchValue)) {
                $query = $this->reportService->searchValueQuery($query, $searchValue);
            }

            $query->whereNull('purchase_requests.deleted_at')->where('purchase_requests.status', "!=", PurchaseRequestStatus::RASCUNHO->value);

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

    public function productivityIndexJson(Request $request): JsonResponse
    {
        $draw = (int) $request->query('draw', 1);
        $start = (int) $request->query('start', 0);
        $length = (int) $request->query('length', 10);
        $orderColumnIndex = (int) $request->query('order', [0 => ['column' => 0]])[0]['column'];
        $orderDirection = (string) $request->query('order', [0 => ['dir' => 'asc']])[0]['dir'];
        $status = (string) $request->query('status', "pendente");
        $requestType = (string) $request->query('request-type', false);
        $requestingUsersIds = (string) $request->query('requesting-users-ids', false);
        $costCenterIds = (string) $request->query('cost-center-ids', false);
        $dateSince = (string) $request->query('date-since', false);
        $dateUntil = (string) $request->query('date-until', now());
        $isSuppliesContract = $request->query('is-supplies-contract', null);
        $desiredDate = $request->query('desired-date', null);
        $suppliesUsers = $request->query('supplies-users', null);
        $currentPage = ($start / $length) + 1;
        $isAll = $length === -1;

        try {
            $query = $this->purchaseRequestService->allPurchaseRequests();

            $query->where('purchase_requests.status', "!=", PurchaseRequestStatus::RASCUNHO->value);

            $query = $this->reportService->whereInLogDate($query, $dateSince, $dateUntil);

            $query = $this->reportService->whereInRequistingUserQuery($query, $requestingUsersIds);

            if ($isSuppliesContract !== null) {
                $query->where('purchase_requests.is_supplies_contract', $isSuppliesContract);
            }

            if ($costCenterIds) {
                $query = $this->reportService->whereInCostCenterQuery($query, $costCenterIds);
            }

            if ($requestType) {
                $query = $this->reportService->whereInRequestTypeQuery($query, $requestType);
            }

            if ($status) {
                $query = $this->reportService->whereInStatusQuery($query, $status);
            }

            if ($desiredDate) {
                $query->where('purchase_requests.desired_date', $desiredDate);
            }

            if ($suppliesUsers) {
                $query->where('purchase_requests.supplies_user_id', $suppliesUsers);
            }

            $orderValue = $this->reportService->productivityOrder($query, $orderColumnIndex);
            $query->orderBy($orderValue, $orderDirection);

            $statusQuery = clone ($query);
            $suppliesUsersQuery = clone ($query);
            $chartData = [
                'status' => $statusQuery->get()->groupBy('status')->map(function ($group) {
                    return [
                        'label' => $group->first()->status->label(),
                        'count' => $group->count(),
                    ];
                }),
                'suppliesUserRequests' => $suppliesUsersQuery->where('status', PurchaseRequestStatus::FINALIZADA->value)->get()
                    ->groupBy('supplies_user_id')
                    ->map(function (Collection $item, int $suppliesUserId) {
                        return [
                            'userId' => $suppliesUserId,
                            'name' => $this->personService->byUserId($suppliesUserId)->pluck('name')->first(),
                            'requestsQtdFinish' => $item->count(),
                        ];
                    }),
            ];

            $countQuery = clone ($query);
            $requestsByUsersQtd = $countQuery->where('is_supplies_contract', false)->count();

            $days = Carbon::parse($dateUntil)->diffInDays(Carbon::parse($dateSince));
            $finishedRequestsQuery = clone ($query);
            $finishedRequests = $finishedRequestsQuery->where('status', PurchaseRequestStatus::FINALIZADA->value)->count();

            $requests = $isAll ? $query->get() : $query->paginate($length, ['*'], 'page', $currentPage);
        } catch (Exception $error) {
            return response()->json(['error' => 'Não foi possível buscar as solicitações. Por favor, tente novamente mais tarde.' . $error], 500);
        }

        return response()->json([
            'data' => $isAll ? $requests->toArray() : $requests->items(),
            'draw' => $draw,
            'recordsTotal' => $isAll ? $requests->count() : $requests->total(),
            'recordsFiltered' => $isAll ? $requests->count() : $requests->total(),
            'chartData' => $chartData,
            'requestsByUsersQtd' => $requestsByUsersQtd,
            'days' => $days,
            'finishedRequests' => $finishedRequests
        ], 200);
    }
}
