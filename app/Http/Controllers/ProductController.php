<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\CostCenter;
use App\Providers\{PurchaseRequestService, ValidatorService};
use Exception;
use Illuminate\Http\{RedirectResponse, Request};

class ProductController extends Controller
{
    private $validatorService;

    private $purchaseRequestService;

    public function __construct(ValidatorService $validatorService, PurchaseRequestService $purchaseRequestService)
    {
        $this->validatorService    = $validatorService;
        $this->purchaseRequestService = $purchaseRequestService;
    }

    public function registerProduct(Request $request): RedirectResponse
    {
        $route   = 'requests';
        $routeParam = [];
        $data    = $request->all();

        $validator = $this->validatorService->purchaseRequest($data);
        if ($validator->fails()) {
            return back()->withErrors($validator->errors()->getMessages())->withInput();
        }

        try {
            $purchaseRequest = $this->purchaseRequestService->registerProductRequest($data);
            $route = 'request.edit';
            $routeParam = ["type" => $purchaseRequest->type, "id" => $purchaseRequest->id];
        } catch (Exception $error) {
            return redirect()->back()->withInput()->withErrors(['Não foi possível fazer o registro no banco de dados.', $error->getMessage()]);
        }

        session()->flash('success', "Solicitação de produto(s) criada com sucesso!");

        return redirect()->route($route, $routeParam);
    }

    public function productForm(int $purchaseRequestIdToCopy = null)
    {
        $companies   = Company::all();
        $costCenters = CostCenter::all();
        $params      = ["companies" => $companies, "costCenters" => $costCenters];
        $isAdmin     = auth()->user()->profile->is_admin;

        try {
            if ($purchaseRequestIdToCopy) {
                if (!$isAdmin) {
                    $isAuthorized = auth()->user()->purchaseRequest->where('id', $purchaseRequestIdToCopy)->whereNull('deleted_at')->first();

                    if (!$isAuthorized) {
                        return throw new Exception('Acesso não autorizado para essa solicitação de compra.');
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
        $route      = 'request.edit';
        $data       = $request->all();
        $validator  = $this->validatorService->purchaseRequest($data);

        if ($validator->fails()) {
            return back()->withErrors($validator->errors()->getMessages())->withInput();
        }

        try {
            $isAdmin      = auth()->user()->profile->is_admin;
            $purchaseRequest = auth()->user()->purchaseRequest->find($id);
            $isAuthorized = ($isAdmin || $purchaseRequest !== null) && $purchaseRequest->deleted_at === null;

            if ($isAuthorized) {
                $this->purchaseRequestService->updateProductRequest($id, $data);
            } else {
                return throw new Exception('Não foi possível acessar essa solicitação.');
            }
        } catch (Exception $error) {
            return redirect()->back()->withInput()->withErrors(['Não foi possível atualizar o registro no banco de dados.', $error->getMessage()]);
        }

        session()->flash('success', "Solicitação de produto(s) atualizado com sucesso!");

        return redirect()->route($route, ['type' => $purchaseRequest->type, 'id' => $id]);
    }

    public function productDetails(int $id)
    {
        try {
            $product = $this->purchaseRequestService->purchaseRequestById($id);
            if (!$product) {
                return throw new Exception('Não foi possível acessar essa solicitação.');
            }
            return view('components.supplies.product-content.product-details', ['product' => $product]);
        } catch (Exception $error) {
            return redirect()->back()->withInput()->withErrors([$error->getMessage()]);
        }
    }
}
