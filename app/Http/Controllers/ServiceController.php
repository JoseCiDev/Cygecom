<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Support\Facades\DB;
use App\Models\PurchaseRequestFile;
use App\Enums\PurchaseRequestStatus;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\{RedirectResponse, Request};
use App\Models\{Company, CostCenter, PurchaseRequest};
use App\Providers\{EmailService, PurchaseRequestService, ValidatorService};

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
        $data       = $request->all();
        $files       = $request->file('arquivos');

        // captura o botão submit clicado (se for submit_request update status);
        $action = $request->input('action');
        $validator = $this->validatorService->purchaseRequest($data);

        if ($validator->fails()) {
            return back()->withErrors($validator->errors()->getMessages())->withInput();
        }

        try {
            // MUDAR
            DB::beginTransaction();

            $purchaseRequest = $this->purchaseRequestService->registerServiceRequest($data, $files);

            $msg = "Solicitação de serviço nº $purchaseRequest->id  criada com sucesso!";

            if ($action === 'submit-request') {
                $purchaseRequest->update(['status' => 'pendente']);
                $msg = "Solicitação de serviço nº $purchaseRequest->id criada e enviada ao setor de suprimentos responsável!";
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

        $validator = $this->validatorService->purchaseRequestUpdate($data);
        $files = $request->file('arquivos');

        $isSuppliesUpdate = Route::currentRouteName() === "supplies.request.service.update";

        if ($validator->fails()) {
            return back()->withErrors($validator->errors()->getMessages())->withInput();
        }

        try {
            $isAdmin = auth()->user()->profile->name === 'admin';

            $purchaseRequest = PurchaseRequest::find($id);
            $isDeleted = $purchaseRequest->deleted_at !== null;
            $isDraft = $purchaseRequest->status->value === PurchaseRequestStatus::RASCUNHO->value;

            $msg = "Solicitação de serviço nº $purchaseRequest->id atualizada com sucesso!";

            $isAuthorized = ($isAdmin || $purchaseRequest) && !$isDeleted;

            if (!$isAuthorized) {
                throw new Exception('Não foi possível acessar essa solicitação.');
            }

            // MUDAR
            DB::beginTransaction();

            $purchaseRequest = $this->purchaseRequestService->updateServiceRequest($id, $data, $isSuppliesUpdate, $files);

            if ($action === 'submit-request') {
                $purchaseRequest->update(['status' => PurchaseRequestStatus::PENDENTE->value]);
                $msg = "Solicitação de serviço nº $purchaseRequest->id  enviada ao setor de suprimentos responsável!";
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

        $service = $this->purchaseRequestService->purchaseRequestById($id);

        $files = PurchaseRequestFile::where('purchase_request_id', $id)->whereNull('deleted_at')->get();

        if (!$service) {
            return throw new Exception('Não foi possível acessar essa solicitação.');
        }

        return view('components.supplies.service.details', compact('service', 'allRequestStatus', 'files'));
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
