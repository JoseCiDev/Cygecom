<?php

namespace App\Http\Controllers;

use App\Enums\PurchaseRequestStatus;
use App\Models\{Company, CostCenter, PurchaseRequest};
use App\Providers\{EmailService, PurchaseRequestService, ValidatorService};
use Exception;
use Illuminate\Http\{RedirectResponse, Request};
use Symfony\Component\Mailer\Exception\TransportException;

class ServiceController extends Controller
{
    public function __construct(
        private ValidatorService $validatorService,
        private PurchaseRequestService $purchaseRequestService,
        private EmailService $emailService
    ) {
    }

    public function registerService(Request $request): RedirectResponse
    {
        $route = 'requests';
        $routeParam = [];
        $data = $request->all();

        $validator = $this->validatorService->purchaseRequest($data);

        if ($validator->fails()) {
            return back()->withErrors($validator->errors()->getMessages())->withInput();
        }

        try {
            $purchaseRequest = $this->purchaseRequestService->registerServiceRequest($data);
            $route = 'request.edit';
            $routeParam = ["type" => $purchaseRequest->type, "id" => $purchaseRequest->id];
        } catch (Exception $error) {
            return redirect()->back()->withInput()->withErrors(['Não foi possível fazer o registro no banco de dados.', $error->getMessage()]);
        }

        session()->flash('success', "Solicitação de serviço criada com sucesso!");

        return redirect()->route($route, $routeParam);
    }

    public function serviceForm(int $purchaseRequestIdToCopy = null)
    {
        $companies   = Company::all();
        $costCenters = CostCenter::all();
        $params      = ["companies" => $companies, "costCenters" => $costCenters];
        $isAdmin     = auth()->user()->profile->name === 'admin';

        try {
            if ($purchaseRequestIdToCopy) {
                if (!$isAdmin) {
                    $isAuthorized = auth()->user()->purchaseRequest->where('id', $purchaseRequestIdToCopy)->whereNull('deleted_at')->first();

                    if (!$isAuthorized) {
                        throw new Exception('Acesso não autorizado para essa solicitação de serviço.');
                    }
                }
            }
            $params['purchaseRequestIdToCopy'] = $purchaseRequestIdToCopy;

            return view('components.purchase-request.service', $params);
        } catch (Exception $error) {
            return redirect()->back()->withInput()->withErrors([$error->getMessage()]);
        }
    }

    public function updateService(Request $request, int $id): RedirectResponse
    {
        $route = 'request.edit';
        $data = $request->all();
        $validator = $this->validatorService->purchaseRequest($data);

        if ($validator->fails()) {
            return back()->withErrors($validator->errors()->getMessages())->withInput();
        }

        try {
            $isAdmin = auth()->user()->profile->name === 'admin';
            $isOwnPurchaseRequest = (bool)auth()->user()->purchaseRequest->find($id);
            if (!$isOwnPurchaseRequest && !$isAdmin) {
                throw new Exception('Não autorizado. Não foi possível acessar essa solicitação.');
            }

            $purchaseRequest = PurchaseRequest::find($id);
            $isDeleted = $purchaseRequest->deleted_at !== null;

            $isAuthorized = ($isAdmin || $purchaseRequest) && !$isDeleted;
            if (!$isAuthorized) {
                throw new Exception('Não foi possível acessar essa solicitação.');
            }

            $this->purchaseRequestService->updateServiceRequest($id, $data);
        } catch (Exception $error) {
            return redirect()->back()->withInput()->withErrors(['Não foi possível atualizar o registro no banco de dados.', $error->getMessage()]);
        }

        session()->flash('success', "Solicitação de serviço atualizada com sucesso!");

        return redirect()->route($route, ['type' => $purchaseRequest->type, 'id' => $id]);
    }

    public function serviceDetails(int $id)
    {
        $allRequestStatus = PurchaseRequestStatus::cases();

        $purchaseRequest = PurchaseRequest::find($id);

        if (!$purchaseRequest || $purchaseRequest->deleted_at !== null) {
            throw new Exception('Não foi possível acessar essa solicitação.');
        }

        if ($this->isAuthorizedToUpdate($purchaseRequest)) {
            $data = ['supplies_user_id' => auth()->user()->id, 'responsibility_marked_at' => now()];
            $this->purchaseRequestService->updatePurchaseRequest($id, $data, true);

            try {
                $this->emailService->sendResponsibleAssignedEmail($purchaseRequest);
            } catch (TransportException $transportException) {
                // Tratar erro de envio de email aqui, se necessário.
            }
        }

        $service = $this->purchaseRequestService->purchaseRequestById($id);

        if (!$service) {
            return throw new Exception('Não foi possível acessar essa solicitação.');
        }

        return view('components.supplies.service-content.service-details', ['service' => $service, 'allRequestStatus' => $allRequestStatus]);
    }

    private function isAuthorizedToUpdate(PurchaseRequest $purchaseRequest): bool
    {
        $allowedProfiles = ['admin', 'suprimentos_hkm', 'suprimentos_inp'];
        $userProfile = auth()->user()->profile->name;

        $existSuppliesUserId = (bool) $purchaseRequest->supplies_user_id;
        $existSuppliesMarkedAt = (bool) $purchaseRequest->responsibility_marked_at;

        return in_array($userProfile, $allowedProfiles) && !$existSuppliesUserId && !$existSuppliesMarkedAt && !auth()->user()->purchaseRequest->contains($purchaseRequest);
    }
}
