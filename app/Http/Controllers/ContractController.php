<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Support\Facades\{DB, Route, Gate};
use Illuminate\Http\{RedirectResponse, Request};
use App\Enums\PurchaseRequestStatus;
use App\Http\Requests\Contract\UpdateContractRequest;
use App\Models\{Company, CostCenter, PurchaseRequest, PurchaseRequestFile};
use App\Providers\{EmailService, PurchaseRequestService, ValidatorService};

class ContractController extends Controller
{
    public function __construct(
        private ValidatorService $validatorService,
        private PurchaseRequestService $purchaseRequestService,
        private EmailService $emailService
    ) {
    }

    public function store(Request $request): RedirectResponse
    {
        $route      = 'requests.index';
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
            $route           = 'requests.edit';
            $routeParams      = ["type" => $purchaseRequest->type, "id" => $purchaseRequest->id];

            $msg = "Solicitação de serviço recorrente nº $purchaseRequest->id  criada com sucesso!";

            // MUDAR
            if ($action === 'submit-request') {
                $purchaseRequest->update(['status' => 'pendente']);
                $msg = "Solicitação de serviço recorrente nº $purchaseRequest->id criada e enviada ao setor de suprimentos responsável!";
            }

            $route = 'requests.index.own';
        } catch (Exception $error) {
            $msg = 'Não foi possível fazer o registro no banco de dados.';
            return redirect()->back()->withInput()->withErrors([$msg, $error->getMessage()]);
        }

        session()->flash('success', $msg);

        return redirect()->route($route, $routeParams);
    }

    public function create(int $purchaseRequestIdToCopy = null)
    {
        $companies = Company::all();
        $costCenters = CostCenter::all();

        $params = [
            "companies" => $companies,
            "costCenters" => $costCenters,
        ];

        $isAdmin = Gate::allows('admin');

        try {
            if ($purchaseRequestIdToCopy) {
                if (!$isAdmin) {
                    $isAuthorized = auth()->user()->purchaseRequest->where('id', $purchaseRequestIdToCopy)->whereNull('deleted_at')->first();

                    if (!$isAuthorized) {
                        throw new Exception('Acesso não autorizado para essa solicitação de serviço recorrente.');
                    }
                }
            }
            $params['purchaseRequestIdToCopy'] = $purchaseRequestIdToCopy;

            return view('components.purchase-request.contract', $params);
        } catch (Exception $error) {
            return redirect()->back()->withInput()->withErrors([$error->getMessage()]);
        }
    }

    /**
     * @param UpdateContractRequest $request
     * @param int $id
     * @return RedirectResponse
     */
    public function update(UpdateContractRequest $request, int $id): RedirectResponse
    {
        $route = 'requests.index.own';
        $data = $request->all();
        $action = $request->input('action');

        $files = $request->file('arquivos');
        $currentUser = auth()->user();
        $isSuppliesUpdate = Route::currentRouteName() === "supplies.contract.update";

        try {
            $msg = "Solicitação de serviço recorrente atualizada com sucesso!";

            $isAdmin = Gate::allows('admin');

            $purchaseRequest = PurchaseRequest::find($id);
            $isDeleted = $purchaseRequest->deleted_at !== null;
            $isDraft = $purchaseRequest->status->value === PurchaseRequestStatus::RASCUNHO->value;

            $msg = "Solicitação de contrato nº $purchaseRequest->id atualizada com sucesso!";

            $isOwnRequest = $purchaseRequest->user_id === $currentUser->id;
            $isAuthorized = ($isAdmin || $purchaseRequest) && !$isDeleted && ($isOwnRequest || $isSuppliesUpdate);

            if (!$isAuthorized) {
                throw new Exception('Ação não permitida pelo sistema!');
            }
            // MUDAR
            DB::beginTransaction();

            $purchaseRequest = $this->purchaseRequestService->updateContractRequest($id, $data, $isSuppliesUpdate, $files);

            if ($action === 'submit-request') {
                $purchaseRequest->update(['status' => 'pendente']);
                $msg = "Solicitação de serviço recorrente nº $purchaseRequest->id enviada ao setor de suprimentos responsável!";
            }

            DB::commit();
        } catch (Exception $error) {
            DB::rollBack();
            $msg = 'Não foi possível atualizar o registro no banco de dados.';
            return redirect()->back()->withInput()->withErrors([$msg, $error->getMessage()]);
        }

        $isSuppliesRoute = Route::getCurrentRoute()->action['prefix'] === '/supplies';

        if (!$isDraft && $isSuppliesRoute) {
            $msg = 'Valor total da solicitação atualizado com sucesso!';
            session()->flash('success', $msg);
            return back();
        }

        session()->flash('success', $msg);

        return redirect()->route($route);
    }

    public function show(int $id)
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

        return view('supplies.contract.details', compact('contract', 'allRequestStatus', 'files'));
    }

    private function isAuthorizedToUpdate(PurchaseRequest $purchaseRequest): bool
    {
        $allowedProfiles = Gate::any(['admin', 'suprimentos_hkm', 'suprimentos_inp']);

        $existSuppliesUserId = (bool) $purchaseRequest->supplies_user_id;
        $existSuppliesMarkedAt = (bool) $purchaseRequest->responsibility_marked_at;

        return $allowedProfiles && !$existSuppliesUserId && !$existSuppliesMarkedAt && !auth()->user()->purchaseRequest->contains($purchaseRequest);
    }
}
