<?php

namespace App\Http\Controllers;

use App\Enums\PurchaseRequestStatus;
use App\Models\{Company, CostCenter, PurchaseRequest};
use App\Providers\{PurchaseRequestService, ValidatorService};
use Exception;
use Illuminate\Http\{RedirectResponse, Request};

class ContractController extends Controller
{
    private $validatorService;

    private $purchaseRequestService;

    public function __construct(ValidatorService $validatorService, PurchaseRequestService $purchaseRequestService)
    {
        $this->validatorService       = $validatorService;
        $this->purchaseRequestService = $purchaseRequestService;
    }

    public function registerContract(Request $request): RedirectResponse
    {
        $route      = 'requests';
        $routeParam = [];
        $data       = $request->all();

        $validator = $this->validatorService->purchaseRequest($data);

        if ($validator->fails()) {
            return back()->withErrors($validator->errors()->getMessages())->withInput();
        }

        try {
            $purchaseRequest = $this->purchaseRequestService->registerContractRequest($data);
            $route           = 'request.edit';
            $routeParam      = ["type" => $purchaseRequest->type, "id" => $purchaseRequest->id];
        } catch (Exception $error) {
            return redirect()->back()->withInput()->withErrors(['Não foi possível fazer o registro no banco de dados.', $error->getMessage()]);
        }

        session()->flash('success', "Solicitação de contrato criada com sucesso!");

        return redirect()->route($route, $routeParam);
    }

    public function contractForm(int $purchaseRequestIdToCopy = null)
    {
        $companies   = Company::all();
        $costCenters = CostCenter::all();

        $params = [
            "companies"   => $companies,
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
        $route     = 'request.edit';
        $data      = $request->all();
        $validator = $this->validatorService->purchaseRequest($data);

        if ($validator->fails()) {
            return back()->withErrors($validator->errors()->getMessages())->withInput();
        }

        try {
            $isAdmin         = auth()->user()->profile->name === 'admin';
            $purchaseRequest = auth()->user()->purchaseRequest->find($id);
            $isAuthorized    = ($isAdmin || $purchaseRequest !== null) && $purchaseRequest->deleted_at === null;

            if ($isAuthorized) {
                $this->purchaseRequestService->updateContractRequest($id, $data);
            } else {
                throw new Exception('Não foi possível acessar essa solicitação.');
            }
        } catch (Exception $error) {
            return redirect()->back()->withInput()->withErrors(['Não foi possível atualizar o registro no banco de dados.', $error->getMessage()]);
        }

        session()->flash('success', "Solicitação de contrato atualizada com sucesso!");

        return redirect()->route($route, ['type' => $purchaseRequest->type, 'id' => $id]);
    }

    public function contractDetails(int $id)
    {
        $allRequestStatus = PurchaseRequestStatus::cases();

        try {
            $purchaseRequest = PurchaseRequest::find($id);
            $isOwnPurchaseRequest = (bool)auth()->user()->purchaseRequest->find($id);

            $isAdmin = auth()->user()->profile->name === 'admin';
            $isSuprimHkm = auth()->user()->profile->name === 'suprimentos_hkm';
            $isSuprimInp = auth()->user()->profile->name === 'suprimentos_inp';

            $isDeletedRequest = $purchaseRequest->deleted_at !== null;

            $existSuppliesUserId = (bool)$purchaseRequest->supplies_user_id;
            $existSuppliesMarkedAt = (bool)$purchaseRequest->responsibility_marked_at;
            $alreadyExistSuppliesUser = $existSuppliesUserId && $existSuppliesMarkedAt;

            $isAuthorized = ($isAdmin || $isSuprimHkm || $isSuprimInp) && !$isDeletedRequest && !$alreadyExistSuppliesUser && !$isOwnPurchaseRequest;
            if ($isAuthorized) {
                $data = ['supplies_user_id' => auth()->user()->id, 'responsibility_marked_at' => now()];
                $this->purchaseRequestService->updatePurchaseRequest($id, $data, true);
            }

            $contract = $this->purchaseRequestService->purchaseRequestById($id);
            if (!$contract) {
                return throw new Exception('Não foi possível acessar essa solicitação.');
            }
            return view('components.supplies.contract-content.contract-details', ['contract' => $contract, 'allRequestStatus' => $allRequestStatus]);
        } catch (Exception $error) {
            return redirect()->back()->withInput()->withErrors([$error->getMessage()]);
        }
    }
}
