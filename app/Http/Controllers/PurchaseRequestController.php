<?php

namespace App\Http\Controllers;

use App\Enums\PurchaseRequestType;
use App\Models\PurchaseRequestFile;
use App\Models\PurchaseRequest;
use App\Providers\EmailService;
use App\Providers\PurchaseRequestService;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class PurchaseRequestController extends Controller
{
    public function __construct(private PurchaseRequestService $purchaseRequestService, private EmailService $emailService)
    {
    }

    public function index()
    {
        $purchaseRequests = $this->purchaseRequestService->purchaseRequests();

        return view('components.purchase-request.index', ["purchaseRequests" => $purchaseRequests]);
    }

    public function ownRequests()
    {
        $purchaseRequests = $this->purchaseRequestService->purchaseRequestsByUser();

        return view('components.purchase-request.index', ["purchaseRequests" => $purchaseRequests]);
    }

    public function formList()
    {
        return view('components.purchase-request.form-list');
    }

    public function edit(PurchaseRequestType $type, int $id)
    {
        $isAdmin = auth()->user()->profile->name === 'admin';

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

    public function delete(int $id): RedirectResponse
    {
        $route = 'requests';

        try {
            $isAdmin = auth()->user()->profile->name === 'admin';
            $purchaseRequest = auth()->user()->purchaseRequest->find($id);
            $isDeleted = $purchaseRequest?->deleted_at !== null;
            $isAuthorized = ($isAdmin || $purchaseRequest) && !$isDeleted;

            if (!$isAuthorized) {
                throw new Exception('Não autorizado. Não foi possível excluir essa solicitação.');
            }

            $this->purchaseRequestService->deletePurchaseRequest($id);
            $route = 'requests.own';

            session()->flash('success', "Solicitação deletada com sucesso!");

            return redirect()->route($route);
        } catch (Exception $error) {
            return redirect()->back()->withInput()->withErrors(['Não foi possível deletar o registro no banco de dados.', $error->getMessage()]);
        }
    }

    public function updateStatusFromSupplies(Request $request, int $id): RedirectResponse
    {
        $data = $request->all();
        try {
            $purchaseRequest = $this->validatePurchaseRequest($id);

            $this->authorizePurchaseRequest($purchaseRequest);

            $purchaseRequest = $this->purchaseRequestService->updatePurchaseRequest($id, $data, true);
        } catch (Exception $error) {
            return redirect()->back()->withInput()->withErrors(['Não foi possível atualizar o registro no banco de dados.', $error->getMessage()]);
        }

        session()->flash('success', "Solicitação de serviço atualizada com sucesso!");

        return back();
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

            $this->purchaseRequestService->uploadFilesToS3($files,  $purchaseRequestType,  $purchaseRequestId, $originalNames, $isSupplies);
        }

        return response()->json(['message' => 'Anexos atualizados com sucesso']);
    }

    private function validatePurchaseRequest(int $id): PurchaseRequest
    {
        $purchaseRequest = PurchaseRequest::find($id);
        if (!$purchaseRequest || $purchaseRequest->deleted_at !== null) {
            throw new Exception('Não foi possível encontrar essa solicitação.');
        }
        return $purchaseRequest;
    }

    private function authorizePurchaseRequest(PurchaseRequest $purchaseRequest): void
    {
        $allowedProfiles = ['admin', 'suprimentos_hkm', 'suprimentos_inp'];
        $isAllowedProfile = in_array(auth()->user()->profile->name, $allowedProfiles);
        $isOwnPurchaseRequest = auth()->user()->purchaseRequest->find($purchaseRequest->id);

        if (!$isAllowedProfile || $isOwnPurchaseRequest) {
            throw new Exception('Não autorizado.');
        }
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
}
