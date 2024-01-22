
@props([
    'supplierIndex' => 0,
    'productCategories' => collect(),
    'suppliers' => collect(),
    'supplierId' => null,
    'products' => null,
    'isCopy' => false
])

@push('styles')
    <style>
        .supplier-block{
            border-bottom: 3px solid var(--grey-primary-color);
            height: 100%;
            margin: 20px;
        }

        .select-supplier-container{
            display: flex;
            gap: 15px;
            justify-content: space-between;
        }
        .select-supplier-container .delete-supplier{
            width: 325px;
            display: flex;
            align-items: center;
            justify-content: space-around;
        }

        .select-supplier-container .delete-supplier.disabled-button{
           opacity: 0;
        }

    </style>
@endpush

<div class="supplier-block">

    <div class="row">
        <div class="col-sm-12">
            <div class="form-group">
                <label class="regular-text"> Fornecedor (CNPJ - Razão social)</label>
                <div class="select-supplier-container">
                    <select name="purchase_request_products[{{ $supplierIndex }}][supplier_id]" class='select2-me select-supplier'
                        data-placeholder="Informe um fornecedor ou cadastre um novo" style="width:100%;">
                        <option value="">Informe um fornecedor ou cadastre um novo</option>
                        @foreach ($suppliers as $supplier)
                            @php
                                $isSelected = $supplier->id === $supplierId;
                                $cnpj = $supplier->cpf_cnpj ? preg_replace('/(\d{2})(\d{3})(\d{3})(\d{4})(\d{2})/', '$1.$2.$3/$4-$5', $supplier->cpf_cnpj) : 'CNPJ indefinido';
                            @endphp
                            <option value="{{ $supplier->id }}" @selected($isSelected)>
                                {{ "$cnpj  - $supplier->corporate_name" }}
                            </option>
                        @endforeach
                    </select>
                    <a class="btn btn-danger btn-secondary btn-mini delete-supplier">Apagar fornecedor e produto(s) <i class="fa-solid fa-trash"></i></a>
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-2">
        <div class="col-sm-12 product-container">
            <label class="regular-text"> Produtos </label>
            <div class="box-content nopadding" style="background-color:rgba(244, 244, 244, 0.531); border: 1px solid rgb(179, 179, 179);">

                @php $productIndex = 0 @endphp
                @if ($products)
                    @foreach($products as $product)
                        <x-purchase-request.product.product
                            :productCategories="$productCategories"
                            :product="$product"
                            :productIndex="$productIndex"
                            :supplierIndex="$supplierIndex"
                            :isCopy="$isCopy"
                        />
                        @php $productIndex++; @endphp
                    @endforeach
                @else
                    <x-purchase-request.product.product
                        :productCategories="$productCategories"
                        :productIndex="$productIndex"
                        :supplierIndex="$supplierIndex"
                    />
                @endif

                <button type="button" style="margin:10px;" class="btn btn-secondary btn-small add-product-btn">
                    <i class="glyphicon glyphicon-plus"></i>
                    Adicionar produto
                </button>
            </div>
        </div>
    </div>

</div>


