<?php

namespace App\Http\Controllers;

use App\Models\{Company, CostCenter};
use App\Providers\{PurchaseRequestService, ValidatorService};
use Exception;
use Illuminate\Http\{RedirectResponse, Request};

class ContractController extends Controller
{
    public function __construct(
        private ValidatorService $validatorService,
        private PurchaseRequestService $purchaseRequestService
    ){}

    public function registerContract(Request $request): RedirectResponse
    {
        $routeParams = [];
        $data       = $request->all();

        $validator = $this->validatorService->purchaseRequest($data);

        if ($validator->fails()) {
            return back()->withErrors($validator->errors()->getMessages())->withInput();
        }

        try {
            $this->purchaseRequestService->registerContractRequest($data);
            $route           = 'requests.own';
        } catch (Exception $error) {
            return redirect()->back()->withInput()->withErrors(['Não foi possível fazer o registro no banco de dados.', $error->getMessage()]);
        }

        session()->flash('success', "Solicitação de contrato criada com sucesso!");

        return redirect()->route($route, $routeParams);
    }

    public function contractForm(int $purchaseRequestIdToCopy = null)
    {
        $companies   = Company::all();
        $costCenters = CostCenter::all();

        $params = [
            "companies"   => $companies,
            "costCenters" => $costCenters,
        ];

        $isAdmin = auth()->user()->profile->is_admin;

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
            $isAdmin         = auth()->user()->profile->is_admin;
            $purchaseRequest = auth()->user()->purchaseRequest->find($id);
            $isAuthorized    = ($isAdmin || $purchaseRequest !== null) && $purchaseRequest->deleted_at === null;
            $route     = 'requests.own';

            if ($isAuthorized) {
                $this->purchaseRequestService->updateContractRequest($id, $data);
            } else {
                throw new Exception('Não foi possível acessar essa solicitação.');
            }
        } catch (Exception $error) {
            return redirect()->back()->withInput()->withErrors(['Não foi possível atualizar o registro no banco de dados.', $error->getMessage()]);
        }

        session()->flash('success', "Solicitação de contrato atualizada com sucesso!");

        return redirect()->route($route);
    }

    public function contractDetails(int $id)
    {
        try {
            $contract = $this->purchaseRequestService->purchaseRequestById($id);
            if (!$contract) {
                return throw new Exception('Não foi possível acessar essa solicitação.');
            }
            return view('components.supplies.contract-content.contract-details', ['contract' => $contract]);
        } catch (Exception $error) {
            return redirect()->back()->withInput()->withErrors([$error->getMessage()]);
        }
    }
}
