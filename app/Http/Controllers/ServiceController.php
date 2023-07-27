<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Support\Facades\DB;
use App\Enums\PurchaseRequestStatus;
use Illuminate\Http\{RedirectResponse, Request};
use App\Models\{Company, CostCenter, PurchaseRequest};
use App\Providers\{PurchaseRequestService, ValidatorService};

class ServiceController extends Controller
{
    public function __construct(
        private ValidatorService $validatorService,
        private PurchaseRequestService $purchaseRequestService
    ){}

    public function registerService(Request $request): RedirectResponse
    {
        $routeParam = [];
        $data       = $request->all();

        // captura o botão submit clicado (se for submit_request update status);
        $action = $request->input('action');
        $validator = $this->validatorService->purchaseRequest($data);

        if ($validator->fails()) {
            return back()->withErrors($validator->errors()->getMessages())->withInput();
        }

        try {
            $msg = "Solicitação de serviço criada com sucesso!";
            // MUDAR
            DB::beginTransaction();

            $purchaseRequest = $this->purchaseRequestService->registerServiceRequest($data);

            if ($action === 'submit-request') {
                $purchaseRequest->update(['status' => 'pendente']);
                $msg = "Solicitação de serviço criada e enviada ao setor de suprimentos responsável!";
            }

            DB::commit();

            $route           = 'requests.own';
        } catch (Exception $error) {
            $msg = 'Não foi possível fazer o registro no banco de dados.';
            DB::rollBack();
            return redirect()->back()->withInput()->withErrors([$msg, $error->getMessage()]);
        }

        session()->flash('success', $msg);

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
        $route = 'requests.own';
        $data = $request->all();
        $action = $request->input('action');

        $validator = $this->validatorService->purchaseRequest($data);

        if ($validator->fails()) {
            return back()->withErrors($validator->errors()->getMessages())->withInput();
        }

        try {
            $msg = "Solicitação de serviço atualizada com sucesso!";

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

            $this->purchaseRequestService->updateServiceRequest($id, $data);

            if ($action === 'submit-request') {
                $purchaseRequest->update(['status' => 'pendente']);
                $msg = "Solicitação de serviço enviada ao setor de suprimentos responsável!";
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

    public function serviceDetails(int $id)
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

            $service = $this->purchaseRequestService->purchaseRequestById($id);
            if (!$service) {
                return throw new Exception('Não foi possível acessar essa solicitação.');
            }
            return view('components.supplies.service-content.service-details', ['service' => $service, 'allRequestStatus' => $allRequestStatus]);
        } catch (Exception $error) {
            return redirect()->back()->withInput()->withErrors([$error->getMessage()]);
        }
    }
}
