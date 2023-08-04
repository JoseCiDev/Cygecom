
@props([
    'supplierIndex',
    'productIndex',
    'productCategories',
    'product' => null,
    'isCopy' => false
])


<div class="product-row" style="padding:0px; background-color:rgb(223, 223, 223);">
    <div class="row" style="padding-top:15px;">
        <div class="col-sm-1" style="margin-top: 23px; margin-left:10px; width:5.3%;" disabled>
            <button type="button" class="btn btn-icon btn-danger delete-product"><i
                    class="fa fa-trash-o"></i></button>
        </div>
        <input type="hidden" name="purchase_request_products[{{ $supplierIndex }}][products][{{ $productIndex }}][id]"
            value="{{ $isCopy ? null : $product?->id}}">
        {{-- CATEGORIA PRODUTO --}}
        <div class="col-sm-5" style="margin-left:-10px;">
            <div class="form-group">
                <label for="product-category" class="control-label">
                    Categoria do produto
                </label>
                <select
                    name="purchase_request_products[{{ $supplierIndex }}][products][{{ $productIndex }}][product_category_id]"
                    class='select2-me' style="width:100%;"
                    data-placeholder="Escolha uma categoria para este produto">
                    <option value=""></option>
                    @foreach ($productCategories as $productCategory)
                        @php
                            $categoryWithDescription = $productCategory->name . ' - ' . $productCategory->description;
                            $categoryOption = $productCategory->description ? $categoryWithDescription : $productCategory->name;
                        @endphp
                        <option value={{ $productCategory->id }}
                            @if (isset($product))
                                @selected($productCategory->id === $product->product_category_id)
                            @endif>
                            {{ $categoryOption }} </option>
                    @endforeach
                </select>
            </div>
        </div>
        {{-- NOME / DESCRIÇÃO --}}
        <div class="col-sm-6">
            <div class="form-group">
                <label class="control-label">
                    Nome/Descrição
                </label>
                <input class="form-control" type="text" placeholder=""
                    name="purchase_request_products[{{ $supplierIndex }}][products][{{ $productIndex }}][name]"
                    value="{{ $product->name ?? null }}">
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-1" style="width:5.3%;"></div>
        <div class="col-sm-2">
            <div class="form-group" style="margin-top:-10px">
                <label for="qtd" class="control-label">Quantidade</label>
                <input name="purchase_request_products[{{ $supplierIndex }}][products][{{ $productIndex }}][quantity]"
                    type="number" placeholder="00" class="form-control"
                    value="{{ $product->quantity ?? null }}">
            </div>
        </div>
        {{-- COR --}}
        <div class="col-sm-2">
            <div class="form-group" style="margin-top:-10px">
                <label for="" class="control-label">Cor</label>
                <input type="text"
                    name="purchase_request_products[{{ $supplierIndex }}][products][{{ $productIndex}}][color]"
                    class="form-control" value="{{ $product->color ?? null }}">
            </div>
        </div>
        {{-- TAMANHO --}}
        <div class="col-sm-3">
            <div class="form-group" style="margin-top:-10px">
                <label for="" class="control-label">Tamanho</label>
                <input type="text"
                    name="purchase_request_products[{{ $supplierIndex }}][products][{{ $productIndex }}][size]"
                    class="form-control" value="{{ $product->size ?? null }}">
            </div>
        </div>
        <div class="col-sm-4">
            <div class="form-group" style="margin-top:-10px">
                <label for="" class="control-label">Modelo</label>
                <input type="text"
                    name="purchase_request_products[{{ $supplierIndex }}][products][{{ $productIndex }}][model]"
                    class="form-control" value="{{ $product->model ?? null }}">
            </div>
        </div>
    </div>
    <hr>
</div>
