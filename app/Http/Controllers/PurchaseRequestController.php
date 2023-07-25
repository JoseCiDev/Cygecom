<?php

namespace App\Http\Controllers;

use App\Enums\PurchaseRequestType;
use App\Models\PurchaseRequest;
use App\Providers\PurchaseRequestService;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class PurchaseRequestController extends Controller
{
    private $purchaseRequestService;

    public function __construct(PurchaseRequestService $purchaseRequestService)
    {
        $this->purchaseRequestService = $purchaseRequestService;
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
            $isAdmin         = auth()->user()->profile->name === 'admin';
            $purchaseRequest = auth()->user()->purchaseRequest->find($id);
            $isAuthorized    = ($isAdmin || $purchaseRequest !== null) && $purchaseRequest->deleted_at === null;

            if ($isAuthorized) {
                $this->purchaseRequestService->deletePurchaseRequest($id);
                $route = 'requests.own';
            } else {
                throw new Exception('Não foi possível acessar essa solicitação.');
            }

            session()->flash('success', "Solicitação deletada com sucesso!");

            return redirect()->route($route);
        } catch (Exception $error) {
            return redirect()->back()->withInput()->withErrors(['Não foi deletar o registro no banco de dados.', $error->getMessage()]);
        }
    }

    public function updateStatusFromSupplies(Request $request, int $id): RedirectResponse
    {
        $data = $request->all();

        try {
            $purchaseRequest = PurchaseRequest::find($id);

            if (!$purchaseRequest) {
                throw new Exception('Não foi possível acessar essa solicitação.');
            }

            $isAdmin = auth()->user()->profile->name === 'admin';
            $isSuprimHkm = auth()->user()->profile->name === 'suprimentos_hkm';
            $isSuprimInp = auth()->user()->profile->name === 'suprimentos_inp';
            $isDeletedRequest = $purchaseRequest->deleted_at !== null;

            $isAuthorized = ($isAdmin || $isSuprimHkm || $isSuprimInp) && !$isDeletedRequest;
            if ($isAuthorized) {
                $this->purchaseRequestService->updatePurchaseRequest($id, $data, true);
            } else {
                throw new Exception('Não autorizado. Não foi possível acessar essa solicitação.');
            }
        } catch (Exception $error) {
            return redirect()->back()->withInput()->withErrors(['Não foi possível atualizar o registro no banco de dados.', $error->getMessage()]);
        }

        session()->flash('success', "Solicitação de serviço atualizada com sucesso!");

        return back();
    }
}
