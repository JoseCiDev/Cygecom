<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Support\Facades\DB;
use App\Enums\PurchaseRequestStatus;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\{RedirectResponse, Request};
use App\Models\{Company, CostCenter, PurchaseRequest, PurchaseRequestFile};
use App\Providers\{EmailService, PurchaseRequestService, ValidatorService};

class ProductController extends Controller
{
    public function __construct(
        private ValidatorService $validatorService,
        private PurchaseRequestService $purchaseRequestService,
        private EmailService $emailService
    ) {
    }

    public function registerProduct(Request $request): RedirectResponse
    {
        $route = 'requests.own';
        $data       = $request->all();
        // captura o botão submit clicado (se for submit_request update status);
        $action = $request->input('action');
        $files       = $request->file('arquivos');

        $validator = $this->validatorService->purchaseRequest($data);

        if ($validator->fails()) {
            return back()->withErrors($validator->errors()->getMessages())->withInput();
        }

        try {
            DB::beginTransaction();
            $purchaseRequest = $this->purchaseRequestService->registerProductRequest($data, $files);

            $msg = "Solicitação de produto nº $purchaseRequest->id criada com sucesso!";

            if ($action === 'submit-request') {
                $purchaseRequest->update(['status' => 'pendente']);
                $msg = "Solicitação de produto nº $purchaseRequest->id criada e enviada ao setor de suprimentos responsável!";
            }

            DB::commit();
        } catch (Exception $error) {
            $msg = 'Não foi possível fazer o registro no banco de dados.';
            DB::rollBack();
            return redirect()->back()->withInput()->withErrors([$msg, $error->getMessage()]);
        }

        session()->flash('success', $msg);

        return redirect()->route($route);
    }

    public function productForm(int $purchaseRequestIdToCopy = null)
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
                        throw new Exception('Acesso não autorizado para essa solicitação de compra.');
                    }
                }
            }
            $params['purchaseRequestIdToCopy'] = $purchaseRequestIdToCopy;

            return view('components.purchase-request.product', $params);
        } catch (Exception $error) {
            return redirect()->back()->withInput()->withErrors([$error->getMessage()]);
        }
    }

    public function updateProduct(Request $request, int $id): RedirectResponse
    {
        $route     = 'request.own';
        $data      = $request->all();
        $action = $request->input('action');

        $validator = $this->validatorService->purchaseRequestUpdate($data);

        $files = $request->file('arquivos');
        $isSuppliesUpdate = Route::currentRouteName() === "supplies.request.product.update";
        $currentUser = auth()->user();


        if ($validator->fails()) {
            return back()->withErrors($validator->errors()->getMessages())->withInput();
        }

        try {
            $isAdmin = $currentUser->profile->name === 'admin';

            $purchaseRequest = PurchaseRequest::find($id);
            $isDeleted = $purchaseRequest->deleted_at !== null;
            $isDraft = $purchaseRequest->status->value === PurchaseRequestStatus::RASCUNHO->value;

            $msg = "Solicitação de produto nº $purchaseRequest->id atualizada com sucesso!";

            $isOwnRequest = $purchaseRequest->user_id === $currentUser->id;
            $isAuthorized = ($isAdmin || $purchaseRequest) && !$isDeleted && $isOwnRequest;

            if (!$isAuthorized) {
                throw new Exception('Ação não permitida pelo sistema!');
            }

            DB::beginTransaction();

            $purchaseRequest = $this->purchaseRequestService->updateProductRequest($id, $data,$isSuppliesUpdate, $files);

            if ($action === 'submit-request') {
                $purchaseRequest->update(['status' => 'pendente']);
                $msg = "Solicitação de produto nº $purchaseRequest->id enviada ao setor de suprimentos responsável!";
            }

            if ($action === 'submit-request') {
                $purchaseRequest->update(['status' => 'pendente']);
                $msg = "Solicitação de produto nº $purchaseRequest->id enviada ao setor de suprimentos responsável!";
            }
            DB::commit();

            $route = 'requests.own';
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
            $data = [
                'supplies_user_id' => auth()->user()->id,
                'responsibility_marked_at' => now()
            ];
            $purchaseRequestUpdated = $this->purchaseRequestService->updatePurchaseRequest($id, $data, true);
        }

        $product = $this->purchaseRequestService->purchaseRequestById($id);

        $files = PurchaseRequestFile::where('purchase_request_id', $id)->whereNull('deleted_at')->get();

        if (!$product) {
            return throw new Exception('Não foi possível acessar essa solicitação.');
        }

        return view('components.supplies.product.details', compact('product', 'allRequestStatus', 'files'));
    }

    private function isAuthorizedToUpdate(PurchaseRequest $purchaseRequest): bool
    {
        $allowedProfiles = ['admin', 'suprimentos_hkm', 'suprimentos_inp'];
        $userProfile = auth()->user()->profile->name;
        $existSuppliesUserId = (bool) $purchaseRequest->supplies_user_id;
        $existSuppliesMarkedAt = (bool) $purchaseRequest->responsibility_marked_at;
        $userContainsPurchaseRequest = auth()->user()->purchaseRequest->contains($purchaseRequest);

        if ($userContainsPurchaseRequest || $existSuppliesUserId || $existSuppliesMarkedAt) {
            return false;
        }

        return in_array($userProfile, $allowedProfiles);
    }
}
