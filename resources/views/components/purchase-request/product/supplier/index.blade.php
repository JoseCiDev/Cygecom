
@props([
    'supplierIndex' => 0,
    'productCategories' => collect(),
    'suppliers' => collect(),
    'supplierId' => null,
    'products' => null,
    'isCopy' => false
])


<div class="box box-color box-bordered supplier-block">
    <div class="box-title">
        <h3 class="supplier-title"><i class="glyphicon glyphicon-briefcase"></i>FORNECEDOR</h3>
        <div class="actions">
            <button class="btn btn-mini delete-supplier"> <i class="fa fa-times"></i> </button>
            <a class="btn btn-mini content-slideUp">
                <i class="fa fa-angle-down"></i>
            </a>
        </div>
    </div>
    <div class="box-content">
        <div class="col-sm-12">
            <div class="row">
                <div class="col-sm-5">
                    <div class="form-group">
                        <label class="control-label">
                            Fornecedor (CNPJ - RAZÃO SOCIAL)</label>
                        <select name="purchase_request_products[{{ $supplierIndex }}][supplier_id]" class='select2-me select-supplier'
                            data-placeholder="Informe um fornecedor ou cadastre um novo" style="width:100%;">
                            <option value=""></option>
                            @foreach ($suppliers as $supplier)
                                @php 
                                    $isSelected = $supplier->id === $supplierId;
                                    $cnpj = $supplier->cpf_cnpj ?? 'CNPJ indefinido'
                                @endphp
                                <option value="{{ $supplier->id }}" @selected($isSelected)>
                                    {{ "$cnpj  - $supplier->corporate_name" }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>

            <div class="col-sm-12 product-container">
                <div class="box-title"
                    style="background-color:rgba(129, 129, 129, 0.531); border: 1px solid rgb(158, 158, 158); ">
                    <h3 style="color:rgb(46, 46, 46)"> <i class="glyphicon glyphicon-tag"></i> Produtos
                    </h3>
                </div>
                <div class="box-content nopadding"
                    style="background-color:rgba(244, 244, 244, 0.531); border: 1px solid rgb(179, 179, 179); border-top: 0px; ">

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

                    <button type="button"
                        style="background-color:rgba(162, 162, 162, 0.531); color:rgb(46, 46, 46); margin:10px;"
                        class="btn btn-success add-product-btn">
                        <i class="glyphicon glyphicon-plus"></i>
                        Adicionar produto
                    </button>
                </div>
            </div>

        </div>
    </div>
</div>


