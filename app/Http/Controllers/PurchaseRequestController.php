<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\{RedirectResponse, Request};
use Illuminate\Support\Facades\Gate;
use App\Enums\{PurchaseRequestStatus, PurchaseRequestType};
use App\Models\{PurchaseRequestFile, PurchaseRequest};
use App\Providers\{EmailService, PurchaseRequestService};

class PurchaseRequestController extends Controller
{
    public function __construct(private PurchaseRequestService $purchaseRequestService, private EmailService $emailService)
    {
    }

    public function index(Request $request)
    {
        $statusData = $request->input('status');
        $purchaseRequests = $this->purchaseRequestService->purchaseRequests()
            ->whereNotIn('status', PurchaseRequestStatus::FINALIZADA)
            ->whereNotIn('status', PurchaseRequestStatus::CANCELADA);

        if ($statusData) {
            $filteredRequests = $this->purchaseRequestService->requestsByStatus($statusData)->get();
            $params = [
                'purchaseRequests' => $filteredRequests,
                'selectedStatus' => $statusData
            ];
        } else {
            $params['purchaseRequests'] = $purchaseRequests;
        }

        return view('components.purchase-request.index', $params);
    }

    public function indexOwn(Request $request)
    {
        $statusData = $request->input('status');
        $userRequests = $this->purchaseRequestService->purchaseRequestsByUser()
            ->whereNotIn('status', PurchaseRequestStatus::FINALIZADA)
            ->whereNotIn('status', PurchaseRequestStatus::CANCELADA);

        if ($statusData) {
            $filteredRequests = $this->purchaseRequestService->purchaseRequestsByUserWithStatus($statusData);
            $params = [
                'purchaseRequests' => $filteredRequests,
                'selectedStatus' => $statusData
            ];
        } else {
            $params['purchaseRequests'] = $userRequests;
        }

        return view('components.purchase-request.index', $params);
    }


    public function dashboard()
    {
        return view('components.purchase-request.form-list');
    }

    public function edit(PurchaseRequestType $type, int $id)
    {
        $isAdmin = Gate::allows('admin');

        try {
            $purchaseRequest = PurchaseRequest::find($id);

            if ($isAdmin) {
                return view('components.purchase-request.edit', ["type" => $type, "id" => $id]);
            }
            $isOwnPurchaseRequest = (bool) auth()->user()->purchaseRequest->find($id);
            if (!$isOwnPurchaseRequest) {
                throw new Exception('Desculpe, não é autorizado acessar solicitações de outros usuários.');
            }

            return view('components.purchase-request.edit', ["type" => $type, "id" => $purchaseRequest->id]);
        } catch (Exception $error) {
            return redirect()->back()->withInput()->withErrors([$error->getMessage()]);
        }
    }

    public function destroy(int $id): RedirectResponse
    {
        $route = 'requests';

        try {
            $isAdmin = Gate::allows('admin');
            $purchaseRequest = auth()->user()->purchaseRequest->find($id);
            $isDeleted = $purchaseRequest?->deleted_at !== null;
            $isAuthorized = ($isAdmin || $purchaseRequest) && !$isDeleted;

            if (!$isAuthorized) {
                throw new Exception('Não autorizado. Não foi possível excluir essa solicitação.');
            }

            $this->purchaseRequestService->deletePurchaseRequest($id);
            $route = 'requests.index.own';

            session()->flash('success', "Solicitação deletada com sucesso!");

            return redirect()->route($route);
        } catch (Exception $error) {
            return redirect()->back()->withInput()->withErrors(['Não foi possível deletar o registro no banco de dados.', $error->getMessage()]);
        }
    }

    public function uploadSuppliesFilesAPI(Request $request)
    {
        $isSupplies = true;
        $purchaseRequestId = $request->input('purchase_request_id');
        $files = $request->file('arquivos');
        $purchaseRequestType = PurchaseRequestType::tryFrom($request->purchaseRequestType);

        if (collect($files)->count()) {
            foreach ($files as $file) {
                $originalNames[] = $file->getClientOriginalName();
            }

            $this->purchaseRequestService->uploadFilesToS3($files, $purchaseRequestType, $purchaseRequestId, $originalNames, $isSupplies);
        }

        return response()->json(['message' => 'Anexos atualizados com sucesso']);
    }

    public function fileDelete(int $id)
    {
        try {
            $model = PurchaseRequestFile::findOrFail($id);
            $model->update(['deleted_at' => now(), 'deleted_by' => auth()->user()->id]);
            return response()->json(['success' => true]);
        } catch (Exception $e) {
            return response()->json(['success' => false, 'error' => $e->getMessage()]);
        }
    }

    public function showAPI(int $id)
    {
        $request = $this->purchaseRequestService->purchaseRequestById($id);

        return response()->json([
            'request' => $request
        ], 200);
    }
}
