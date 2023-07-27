<?php

namespace App\Http\Controllers;

use App\Models\Supplier;
use App\Providers\{SupplierService, ValidatorService};
use Exception;
use Illuminate\Http\Request;

class SupplierController extends Controller
{
    private $validatorService;

    private $supplierService;

    public function __construct(ValidatorService $validatorService, SupplierService $supplierService)
    {
        $this->validatorService = $validatorService;
        $this->supplierService  = $supplierService;
    }

    public function index()
    {
        $suppliers = Supplier::with('address', 'phone')->whereNull('deleted_at')->get();

        return view('components.supplier.index', ['suppliers' => $suppliers]);
    }

    public function supplier(int $id)
    {
        $supplier = $this->supplierService->getSupplierById($id);

        if (!$supplier) {
            return redirect('suppliers')->withErrors("Não possível acessar fornecedor com ID: $id")->withInput();
        }

        return view('components.supplier.edit', ['supplier' => $supplier, 'id' => $id]);
    }

    public function showRegistrationForm()
    {
        return view('components.supplier.form');
    }

    public function register(Request $request)
    {
        $data = $request->all();
        $validator = $this->validatorService->supplier($data);

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

    public function registerAPI(Request $request)
    {
        $data = $request->all();
        $validator = $this->validatorService->supplier($data);

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
            'cpf_cnpj' => $data['cpf_cnpj'],
            'id' => $supplier->id,
            'corporate_name' => $supplier->corporate_name
        ], 200);
    }

    public function update(Request $request, int $id)
    {
        $data               = $request->all();
        $data['updated_by'] = auth()->user()->id;

        $validator = $this->validatorService->supplier($data);

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

    public function delete(int $id)
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
