<?php

namespace App\Http\Controllers\Quotation;

use App\Contracts\QuotationControllerInterface;
use App\Http\Controllers\Controller;
use App\Models\{CostCenter, Product, ProductCategorie, Supplier};
use App\Providers\ValidatorService;
use App\Services\QuotationService;
use Exception;
use Illuminate\Http\{RedirectResponse, Request};

class QuotationController extends Controller implements QuotationControllerInterface
{
    private $quotationService;

    private $validatorService;

    public function __construct(QuotationService $quotationService, ValidatorService $validatorService)
    {
        $this->quotationService = $quotationService;
        $this->validatorService = $validatorService;
    }

    public function index()
    {
        $quotations = $this->quotationService->getAllPurchaseQuotes();

        return view('components.quote.index', compact('quotations'));
    }

    public function showRegistrationForm()
    {
        $costCenters = CostCenter::with('company')->get();
        $products    = Product::with('categorie')->whereNull('deleted_at')->get();
        $suppliers   = Supplier::whereNull('deleted_at')->get();
        $categories  = ProductCategorie::whereNull('deleted_at')->get();

        return view('components.quote.register', compact('costCenters', 'products', 'suppliers', 'categories'));
    }

    public function register(Request $request): RedirectResponse
    {
        $data = $request->all();

        try {
            $this->quotationService->registerQuotation($data);
        } catch (Exception $error) {
            return redirect()
                ->back()
                ->withInput()
                ->withErrors([
                    'Não foi possível fazer o registro no banco de dados.', $error->getMessage(),
                ]);
        }
        session()->flash('success', "Produto cadastrado com sucesso!");

        return redirect()->route('products');
    }
}
