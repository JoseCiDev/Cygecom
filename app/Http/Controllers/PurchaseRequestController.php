<?php

namespace App\Http\Controllers;

use App\Enums\PurchaseRequestType;
use App\Models\PurchaseRequestFile;
use App\Providers\PurchaseRequestService;
use Exception;
use Illuminate\Http\RedirectResponse;

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
            $purchaseRequest = auth()->user()->purchaseRequest->find($id);
            $purchaseRequestFiles = PurchaseRequestFile::where(["purchase_request_id" => $purchaseRequest->id, "deleted_at" => null])->get();

            if ($isAdmin) {
                return view('components.purchase-request.edit', ["type" => $type, "id" => $id, "files" => $purchaseRequestFiles]);
            }

            $purchaseRequest = auth()->user()->purchaseRequest->find($id);

            if (collect($purchaseRequest)->isEmpty()) {
                throw new Exception('Não foi possível acessar essa solicitação.');
            }


            return view('components.purchase-request.edit', ["type" => $type, "id" => $purchaseRequest->id, "files" => $purchaseRequestFiles]);
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

    public function fileDelete(int $id)
    {
        try {
            $model = PurchaseRequestFile::findOrFail($id);
            $model->update(['deleted_at' => now(), 'deleted_by' => auth()->user()->id]);
            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'error' => $e->getMessage()]);
        }
    }
}
