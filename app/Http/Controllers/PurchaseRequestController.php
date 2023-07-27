<?php

namespace App\Http\Controllers;

use App\Enums\PurchaseRequestStatus;
use App\Enums\PurchaseRequestType;
use App\Mail\GenericEmail;
use Illuminate\Support\Facades\Mail;
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
            if ($isAdmin) {
                return view('components.purchase-request.edit', ["type" => $type, "id" => $id]);
            }

            $purchaseRequest = auth()->user()->purchaseRequest->find($id);

            if (collect($purchaseRequest)->isEmpty()) {
                throw new Exception('Não foi possível acessar essa solicitação.');
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
        $sendEmail = true;
        $data = $request->all();
        try {
            $purchaseRequest = PurchaseRequest::find($id);
            $isDeletedRequest = $purchaseRequest->deleted_at !== null;
            $isOwnPurchaseRequest = auth()->user()->purchaseRequest->find($id);

            if (!$purchaseRequest || $isDeletedRequest) {
                throw new Exception('Não foi possível encontrar essa solicitação.');
            }

            $allowedProfiles = ['admin', 'suprimentos_hkm', 'suprimentos_inp'];
            $isAllowedProfile = in_array(auth()->user()->profile->name, $allowedProfiles);

            $isAuthorized = $isAllowedProfile && !$isOwnPurchaseRequest;
            if (!$isAuthorized) {
                throw new Exception('Não autorizado.');
            }

            $purchaseRequest = $this->purchaseRequestService->updatePurchaseRequest($id, $data, true);

            $approver = $purchaseRequest->user->approver;
            $isPendingStatus = $purchaseRequest->status->value === PurchaseRequestStatus::PENDENTE->value;
            if ($approver && $sendEmail && $isPendingStatus) {
                $this->emailService->sendPendingApprovalEmail($purchaseRequest, $approver);
            }

            if ($sendEmail) {
                $this->emailService->sendStatusUpdatedEmail($purchaseRequest);
            }
        } catch (Exception $error) {
            return redirect()->back()->withInput()->withErrors(['Não foi possível atualizar o registro no banco de dados.', $error->getMessage()]);
        }

        session()->flash('success', "Solicitação de serviço atualizada com sucesso!");

        return back();
    }
}
