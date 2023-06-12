<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\CostCenter;
use App\Providers\QuoteRequestService;
use App\Providers\ValidatorService;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class QuoteRequestController extends Controller
{
    private $validatorService;
    private $quoteRequestService;

    public function __construct(ValidatorService $validatorService, QuoteRequestService $quoteRequestService)
    {
        $this->validatorService = $validatorService;
        $this->quoteRequestService = $quoteRequestService;
    }

    public function index()
    {
        $quoteRequests = $this->quoteRequestService->quoteRequests();
        return view('components.quote-request.index', ["quoteRequests" => $quoteRequests]);
    }

    public function ownRequests()
    {
        $quoteRequests = $this->quoteRequestService->quoteRequestsByUser();
        return view('components.quote-request.index', ["quoteRequests" => $quoteRequests]);
    }

    public function form(int $quoteRequestIdToCopy = null)
    {
        $companies   = Company::all();
        $costCenters = CostCenter::all();
        $params = ["companies" => $companies, "costCenters" => $costCenters];
        $isAdmin = auth()->user()->profile->isAdmin;

        try {
            if ($quoteRequestIdToCopy) {
                if (!$isAdmin) {
                    $isAuthorized = auth()->user()->quoteRequest->where('id', $quoteRequestIdToCopy)->whereNull('deleted_at')->first();
                    if (!$isAuthorized) return throw new Exception('Acesso não autorizado para essa solicitação de compra.');
                }
                $params['quoteRequestIdToCopy'] = $quoteRequestIdToCopy;
            }
            return view('components.quote-request.register', $params);
        } catch (Exception $error) {
            return redirect()->back()->withInput()->withErrors([$error->getMessage()]);
        }
    }

    public function edit(int $id)
    {
        $isAdmin = auth()->user()->profile->isAdmin;

        try {
            if ($isAdmin) {
                return view('components.quote-request.edit', ["id" => $id]);
            } else {
                $quoteRequest = auth()->user()->quoteRequest->find($id);

                if ($quoteRequest === null) {
                    return throw new Exception('Não foi possível acessar essa solicitação.');
                }

                return view('components.quote-request.edit', ["id" => $quoteRequest->id]);
            }
        } catch (Exception $error) {
            return redirect()->back()->withInput()->withErrors([$error->getMessage()]);
        }
    }

    public function register(Request $request): RedirectResponse
    {
        $route = 'requests';
        $isAdmin = auth()->user()->profile->isAdmin;
        $data = $request->all();

        $validator = $this->validatorService->quoteRequest($data);

        if ($validator->fails()) {
            return back()->withErrors($validator->errors()->getMessages())->withInput();
        }

        try {
            $this->quoteRequestService->registerQuoteRequest($data);
        } catch (Exception $error) {
            return redirect()->back()->withInput()->withErrors(['Não foi possível fazer o registro no banco de dados.', $error->getMessage()]);
        }

        session()->flash('success', "Solicitação de compra criada com sucesso!");

        if (!$isAdmin) {
            $route = 'requests.own';
        }
        return redirect()->route($route);
    }

    public function update(Request $request, int $id): RedirectResponse
    {
        $route = 'request.edit';
        $isSaveAndQuote = (bool)$request->get('isSaveAndQuote');
        $data = $request->all();
        $validator = $this->validatorService->quoteRequest($data);

        if ($validator->fails()) {
            return back()->withErrors($validator->errors()->getMessages())->withInput();
        }

        try {
            $isAdmin = auth()->user()->profile->isAdmin;
            $quoteRequest = auth()->user()->quoteRequest->find($id);
            $isAuthorized = ($isAdmin || $quoteRequest !== null) && $quoteRequest->deleted_at === null;
            if ($isAuthorized) {
                $this->quoteRequestService->updateQuoteRequest($id, $data);
            } else {
                return throw new Exception('Não foi possível acessar essa solicitação.');
            }
        } catch (Exception $error) {
            return redirect()->back()->withInput()->withErrors(['Não foi possível atualizar o registro no banco de dados.', $error->getMessage()]);
        }

        if ($isSaveAndQuote) {
            $route = 'quotations';
        }

        session()->flash('success', "Solicitação de compra atualizado com sucesso!");
        return redirect()->route($route, ['id' => $id]);
    }

    public function delete(int $id): RedirectResponse
    {
        $route = 'requests';
        try {
            $isAdmin = auth()->user()->profile->isAdmin;
            $quoteRequest = auth()->user()->quoteRequest->find($id);
            $isAuthorized = ($isAdmin || $quoteRequest !== null) && $quoteRequest->deleted_at === null;
            if ($isAuthorized) {
                $this->quoteRequestService->deleteQuoteRequest($id);
                $route = 'requests.own';
            } else {
                return throw new Exception('Não foi possível acessar essa solicitação.');
            }

            session()->flash('success', "Solicitação de compra deletada com sucesso!");
            return redirect()->route($route);
        } catch (Exception $error) {
            return redirect()->back()->withInput()->withErrors(['Não foi deletar o registro no banco de dados.', $error->getMessage()]);
        }
    }
}
