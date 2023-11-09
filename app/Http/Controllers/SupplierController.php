<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use App\Providers\{SupplierService, ValidatorService};

class SupplierController extends Controller
{

    public function __construct(
        private ValidatorService $validatorService,
        private SupplierService $supplierService
    ) {
    }

    public function index(): View
    {
        return view('components.supplier.index');
    }

    public function indexAPI(): RedirectResponse|JsonResponse
    {
        $draw = (int) request()->query('draw', 1);
        $start = (int) request()->query('start', 0);
        $length = (int) request()->query('length', 10);
        $searchValue = request()->query('search')['value'];
        $currentPage = ($start / $length) + 1;

        try {
            $query = $this->supplierService->getSuppliers();

            if (!empty($searchValue)) {
                $query->where(function ($query) use ($searchValue) {
                    $query->where('cpf_cnpj', 'like', "%{$searchValue}%")
                        ->orWhere('corporate_name', 'like', "%{$searchValue}%")
                        ->orWhere('name', 'like', "%{$searchValue}%")
                        ->orWhere('supplier_indication', 'like', "%{$searchValue}%")
                        ->orWhere('market_type', 'like', "%{$searchValue}%")
                        ->orWhere('qualification', '=', "{$searchValue}");
                });
            }

            $suppliersQuery = $query->orderBy('created_at', 'desc')->paginate($length, ['*'], 'page', $currentPage);
        } catch (Exception $error) {
            return response()->json(['error' => 'Não foi possível buscar os fornecedores. Por favor, tente novamente mais tarde.'], 500);
        }

        return response()->json([
            'data' => $suppliersQuery->items(),
            'draw' => $draw,
            'recordsTotal' => $suppliersQuery->total(),
            'recordsFiltered' => $suppliersQuery->total(),
        ], 200);
    }

    public function supplier(int $id): RedirectResponse|View
    {
        $supplier = $this->supplierService->getSupplierById($id);

        if (!$supplier) {
            return redirect('suppliers')->withErrors("Não possível acessar fornecedor com ID: $id")->withInput();
        }

        $params = [
            'supplier' => $supplier,
            'id' => $id,
        ];

        return view('components.supplier.edit', $params);
    }

    public function showRegistrationForm(): View
    {
        return view('components.supplier.form');
    }

    public function register(Request $request): RedirectResponse
    {
        $data = $request->all();
        $cnpj = $request->cpf_cnpj;

        $data['cpf_cnpj'] = $cnpj ? preg_replace('/[^0-9]/', '', $cnpj) : null;

        $validator = $this->validatorService->supplier($data, $cnpj);

        if ($validator->fails()) {
            return back()->withErrors($validator->errors()->getMessages())->withInput();
        }

        try {
            $this->supplierService->registerSupplier($data);
        } catch (Exception $error) {
            return redirect()->back()->withInput()->withErrors(['Não foi possível fazer o registro no banco de dados.', $error->getMessage()]);
        }

        session()->flash('success', "Fornecedor cadastrado com sucesso!");

        return redirect()->route('suppliers');
    }

    public function registerAPI(Request $request): RedirectResponse|JsonResponse
    {
        $data = $request->all();
        $cnpj = $request->cpf_cnpj;

        $data['cpf_cnpj'] = $cnpj ? preg_replace('/[^0-9]/', '', $cnpj) : null;

        $validator = $this->validatorService->supplier($data, $cnpj);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 422);
        }

        try {
            $supplier = $this->supplierService->registerSupplier($data);
        } catch (Exception $error) {
            return response()->json(['error' => 'Não foi possível fazer o registro no banco de dados.'], 500);
        }

        return response()->json([
            'message' => 'Fornecedor cadastrado com sucesso!',
            'cpf_cnpj' => isset($data['cpf_cnpj']) ? $data['cpf_cnpj'] : 'CNPJ indefinido',
            'id' => $supplier->id,
            'corporate_name' => $supplier->corporate_name,
            'representative' => $supplier->representative,
            'email' => $supplier->email,
            'phone_number' => $supplier->phone->number,
        ], 200);
    }

    public function update(Request $request, int $id): RedirectResponse
    {
        $data = $request->all();

        if (!isset($data['cpf_cnpj'])) {
            $data['cpf_cnpj'] = null;
        } else {
            $data['cpf_cnpj'] = preg_replace('/[^0-9]/', '', $data['cpf_cnpj']);
        }

        $data['updated_by'] = auth()->user()->id;

        $validator = $this->validatorService->supplierUpdate($data);

        if ($validator->fails()) {
            return back()->withErrors($validator->errors()->getMessages())->withInput();
        }

        try {
            $this->supplierService->updateSupplier($data, $id);
        } catch (Exception $error) {
            return redirect()->back()->withInput()->withErrors(['Não foi possível atualizar o registro no banco de dados.', $error->getMessage()]);
        }

        session()->flash('success', "Fornecedor atualizado com sucesso!");

        return redirect()->route('supplier', ['id' => $id]);
    }

    public function delete(int $id): RedirectResponse
    {
        try {
            $this->supplierService->deleteSupplier($id);
        } catch (Exception $error) {
            return redirect()->back()->withInput()->withErrors(['Não foi deletar o registro no banco de dados.', $error->getMessage()]);
        }

        session()->flash('success', "Fornecedor deletado com sucesso!");

        return redirect()->route('suppliers');
    }
}
