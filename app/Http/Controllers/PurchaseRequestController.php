<?php

namespace App\Http\Controllers;

use App\Enums\PurchaseRequestStatus;
use App\Enums\PurchaseRequestType;
use App\Models\PurchaseRequestFile;
use App\Models\PurchaseRequest;
use App\Providers\EmailService;
use App\Providers\PurchaseRequestService;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Symfony\Component\Mailer\Exception\TransportException;

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
            $purchaseRequest = auth()->user()->purchaseRequest->find($id);
            $purchaseRequestFiles = PurchaseRequestFile::where(["purchase_request_id" => $purchaseRequest->id, "deleted_at" => null])->get();

            if ($isAdmin) {
                return view('components.purchase-request.edit', ["type" => $type, "id" => $id, "files" => $purchaseRequestFiles]);
            }

            $purchaseRequest = auth()->user()->purchaseRequest->find($id);

            if (collect($purchaseRequest)->isEmpty()) {
                throw new Exception('Não foi possível acessar essa solicitação.');
            }


            return view('components.purchase-request.edit', ["type" => $type, "id" => $purchaseRequest->id, "files" => $purchaseRequestFiles]);
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
        $sendEmail = true;
        $data = $request->all();
        try {
            $purchaseRequest = $this->validatePurchaseRequest($id);

            $this->authorizePurchaseRequest($purchaseRequest);

            $purchaseRequest = $this->purchaseRequestService->updatePurchaseRequest($id, $data, true);

            $approver = $purchaseRequest->user->approver;
            $isPendingStatus = $purchaseRequest->status->value === PurchaseRequestStatus::PENDENTE->value;
            $mailFailed = false;

            try {
                if ($approver && $sendEmail && $isPendingStatus) {
                    $this->emailService->sendPendingApprovalEmail($purchaseRequest, $approver);
                }

                if ($sendEmail) {
                    $this->emailService->sendStatusUpdatedEmail($purchaseRequest);
                }
            } catch (TransportException $transportException) {
                $mailFailed = true;
            }
        } catch (Exception $error) {
            return redirect()->back()->withInput()->withErrors(['Não foi possível atualizar o registro no banco de dados.', $error->getMessage()]);
        }

        session()->flash('success', "Solicitação de serviço atualizada com sucesso!");

        if ($mailFailed) {
            return back()->withInput()->withErrors('Desculpe, estamos com problemas no envio de e-mail. Não foi possível enviar a notificação. ');
        }

        return back();
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
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'error' => $e->getMessage()]);
        }
    }
}
