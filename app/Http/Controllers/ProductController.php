<?php

namespace App\Http\Controllers;

use App\Contracts\ProductControllerInterface;
use App\Providers\{ProductService, ValidatorService};
use Exception;
use Illuminate\Http\Request;

class ProductController extends Controller implements ProductControllerInterface
{
    private $productService;

    private $validatorService;

    public function __construct(ProductService $productService, ValidatorService $validatorService)
    {
        $this->productService   = $productService;
        $this->validatorService = $validatorService;
    }

    public function index()
    {
        $products = $this->productService->getProductsWithRelations();

        return view('products.products-list', ['products' => $products]);
    }

    public function form()
    {
        $categories = $this->productService->getCategories();

        return view('products.product-register', ['categories' => $categories]);
    }

    public function product(int $id)
    {
        $product    = $this->productService->firstProductWithRelations($id);
        $categories = $this->productService->getCategories();

        return view('products.product', ['product' => $product, 'categories' => $categories]);
    }

    public function register(Request $request)
    {
        $data      = $request->all();
        $validator = $this->validatorService->productValidator($data);

        if ($validator->fails()) {
            return back()
                ->withErrors($validator->errors()
                ->getMessages())
                ->withInput();
        }

        try {
            $this->productService->registerProduct($data);
        } catch (Exception $error) {
            return redirect()
                ->back()
                ->withInput()
                ->withErrors(['Não foi possível fazer o registro no banco de dados.', $error->getMessage()]);
        }

        session()->flash('success', "Produto cadastrado com sucesso!");

        return redirect()->route('products');
    }

    public function update(Request $request, int $id)
    {
        $data               = $request->all();
        $data['updated_by'] = auth()->user()->id;
        $validator          = $this->validatorService->productValidator($data);

        if ($validator->fails()) {
            return back()
                ->withErrors($validator->errors()->getMessages())
                ->withInput();
        }

        try {
            $this->productService->updateProduct($data, $id);
        } catch (Exception $error) {
            return redirect()
                ->back()
                ->withInput()
                ->withErrors(['Não foi possível atualizar o registro no banco de dados.', $error->getMessage()]);
        }

        session()->flash('success', "Produto atualizado com sucesso!");

        return redirect()->route('product', ['id' => $id]);
    }

    public function delete($id)
    {
        try {
            $this->productService->deleteProduct($id);
        } catch (Exception $error) {
            return redirect()->back()->withInput()->withErrors(['Não foi deletar o registro no banco de dados.', $error->getMessage()]);
        }

        session()->flash('success', "Produto deletado com sucesso!");

        return redirect()->route('products');
    }
}
