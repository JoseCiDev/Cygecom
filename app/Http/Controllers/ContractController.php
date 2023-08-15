<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Support\Facades\DB;
use App\Models\PurchaseRequestFile;
use App\Enums\PurchaseRequestStatus;
use Illuminate\Http\{RedirectResponse, Request};
use App\Models\{Company, CostCenter, PurchaseRequest};
use App\Providers\{EmailService, PurchaseRequestService, ValidatorService};

class ContractController extends Controller
{
    public function __construct(
        private ValidatorService $validatorService,
        private PurchaseRequestService $purchaseRequestService,
        private EmailService $emailService
    ) {
    }

    public function registerContract(Request $request): RedirectResponse
    {
        $route      = 'requests';
        $data       = $request->all();
        $files       = $request->file('arquivos');
        $routeParams = [];
        $data = $request->all();

        // captura o botão submit clicado (se for submit_request update status);
        $action = $request->input('action');

        $validator = $this->validatorService->purchaseRequest($data);

        if ($validator->fails()) {
            return back()->withErrors($validator->errors()->getMessages())->withInput();
        }

        try {
            $purchaseRequest = $this->purchaseRequestService->registerContractRequest($data, $files);
            $route           = 'request.edit';
            $routeParams      = ["type" => $purchaseRequest->type, "id" => $purchaseRequest->id];
            $msg = "Solicitação de contrato criada com sucesso!";

            // MUDAR
            if ($action === 'submit-request') {
                $purchaseRequest->update(['status' => 'pendente']);
                $msg = "Solicitação de contrato nº $purchaseRequest->id criada e enviada ao setor de suprimentos responsável!";
            }

            $route = 'requests.own';
        } catch (Exception $error) {
            $msg = 'Não foi possível fazer o registro no banco de dados.';
            return redirect()->back()->withInput()->withErrors([$msg, $error->getMessage()]);
        }

        session()->flash('success', $msg);

        return redirect()->route($route, $routeParams);
    }

    public function contractForm(int $purchaseRequestIdToCopy = null)
    {
        $companies = Company::all();
        $costCenters = CostCenter::all();

        $params = [
            "companies" => $companies,
            "costCenters" => $costCenters,
        ];

        $isAdmin = auth()->user()->profile->name === 'admin';

        try {
            if ($purchaseRequestIdToCopy) {
                if (!$isAdmin) {
                    $isAuthorized = auth()->user()->purchaseRequest->where('id', $purchaseRequestIdToCopy)->whereNull('deleted_at')->first();

                    if (!$isAuthorized) {
                        throw new Exception('Acesso não autorizado para essa solicitação de contrato.');
                    }
                }
            }
            $params['purchaseRequestIdToCopy'] = $purchaseRequestIdToCopy;

            return view('components.purchase-request.contract', $params);
        } catch (Exception $error) {
            return redirect()->back()->withInput()->withErrors([$error->getMessage()]);
        }
    }

    public function updateContract(Request $request, int $id): RedirectResponse
    {
        $route = 'requests.own';
        $data = $request->all();
        $action = $request->input('action');

        $validator = $this->validatorService->purchaseRequest($data);
        $files = $request->file('arquivos');

        if ($validator->fails()) {
            return back()->withErrors($validator->errors()->getMessages())->withInput();
        }

        try {
            $msg = "Solicitação de contrato atualizada com sucesso!";

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
            // MUDAR
            DB::beginTransaction();

            $this->purchaseRequestService->updateContractRequest($id, $data, $files);

            if ($action === 'submit-request') {
                $purchaseRequest->update(['status' => 'pendente']);
                $msg = "Solicitação de contrato enviada ao setor de suprimentos responsável!";
            }

            DB::commit();
        } catch (Exception $error) {
            DB::rollBack();
            $msg = 'Não foi possível atualizar o registro no banco de dados.';
            return redirect()->back()->withInput()->withErrors([$msg, $error->getMessage()]);
        }

        session()->flash('success', $msg);

        return redirect()->route($route);
    }

    public function details(int $id)
    {
        $allRequestStatus = PurchaseRequestStatus::cases();

        $purchaseRequest = $this->purchaseRequestService->purchaseRequestById($id);

        if (!$purchaseRequest || $purchaseRequest->deleted_at !== null) {
            throw new Exception('Não foi possível acessar essa solicitação.');
        }

        if ($this->isAuthorizedToUpdate($purchaseRequest)) {
            $data = ['supplies_user_id' => auth()->user()->id, 'responsibility_marked_at' => now()];
            $purchaseRequestUpdated = $this->purchaseRequestService->updatePurchaseRequest($id, $data, true);
        }

        $contract = $this->purchaseRequestService->purchaseRequestById($id);

        $files = PurchaseRequestFile::where('purchase_request_id', $id)->whereNull('deleted_at')->get();

        if (!$contract) {
            return throw new Exception('Não foi possível acessar essa solicitação.');
        }

        return view('components.supplies.contract.details', compact('contract', 'allRequestStatus', 'files'));
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
