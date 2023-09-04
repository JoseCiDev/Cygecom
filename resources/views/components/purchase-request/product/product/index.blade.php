@props([
    'supplierIndex' => 0,
    'productIndex' => 0,
    'productCategories' => collect(),
    'product' => null,
    'isCopy' => false
])


<div class="product-row" style="padding: 10px 0; border-bottom: 1px solid rgb(179, 179, 179)">
    <div class="row" style="padding: 15px 20px 0 20px;">
        <input type="hidden" name="purchase_request_products[{{ $supplierIndex }}][products][{{ $productIndex }}][id]"
            data-cy="purchase_request_products[{{ $supplierIndex }}][products][{{ $productIndex }}][id]"
            value="{{ $isCopy ? null : $product?->id}}" class="product-id">
        {{-- CATEGORIA PRODUTO --}}
        <div class="col-sm-5">
            <div class="form-group">
                <label for="product-category" class="regular-text">Categoria do produto</label>
                <select data-rule-required="true"
                    name="purchase_request_products[{{ $supplierIndex }}][products][{{ $productIndex }}][product_category_id]"
                    data-cy="purchase_request_products[{{ $supplierIndex }}][products][{{ $productIndex }}][product_category_id]"
                    class='select2-me product-category' style="width:100%;" data-placeholder="Escolha uma categoria para este produto">
                    <option value=""></option>
                    @foreach ($productCategories->sortBy('name') as $productCategory)
                        @php
                            $categoryWithDescription = $productCategory->name . ' - ' . $productCategory->description;
                            $categoryOption = $productCategory->description ? $categoryWithDescription : $productCategory->name;
                        @endphp
                        <option value={{ $productCategory->id }}
                            @selected(isset($product) && $productCategory->id === $product->product_category_id)>
                            {{ $categoryOption }} </option>
                    @endforeach
                </select>
            </div>
        </div>
        {{-- NOME / DESCRIÇÃO --}}
        <div class="col-sm-6">
            <div class="form-group">
                <label class="regular-text">Nome/Descrição</label>
                <input class="form-control product-description" type="text" placeholder="" data-rule-required="true" maxlength="250"
                    name="purchase_request_products[{{ $supplierIndex }}][products][{{ $productIndex }}][name]"
                    data-cy="purchase_request_products[{{ $supplierIndex }}][products][{{ $productIndex }}][name]" value="{{ $product->name ?? null }}">
                <ul class="product-suggestion-autocomplete" data-cy="product-suggestion-autocomplete" style="display: none;"></ul>
            </div>
        </div>
        <div class="col-sm-1" style="margin-top: 23px; width:5.3%;" disabled>
            <button type="button" class="btn btn-icon btn-danger delete-product" data-cy="delete-product"><i  class="fa fa-trash-o"></i></button>
        </div>
    </div>
    <div class="row" style="padding: 0 20px 15px 20px">
        <div class="col-sm-2">
            <div class="form-group" style="margin-top:-10px">
                <label for="qtd" class="regular-text">Quantidade</label>
                <input min="1" max="10000" step="1" data-rule-required="true" type="text" class="form-control product-quantity" value="{{ $product->quantity ?? null }}"
                        name="purchase_request_products[{{ $supplierIndex }}][products][{{ $productIndex }}][quantity]"
                        data-cy="purchase_request_products[{{ $supplierIndex }}][products][{{ $productIndex }}][quantity]">
            </div>
        </div>
        {{-- COR --}}
        <div class="col-sm-2">
            <div class="form-group" style="margin-top:-10px">
                <label for="" class="regular-text">Cor</label>
                <input type="text" name="purchase_request_products[{{ $supplierIndex }}][products][{{ $productIndex}}][color]"
                    data-cy="purchase_request_products[{{ $supplierIndex }}][products][{{ $productIndex}}][color]"
                    class="form-control product-color" value="{{ $product->color ?? null }}">
            </div>
        </div>
        {{-- TAMANHO --}}
        <div class="col-sm-3">
            <div class="form-group" style="margin-top:-10px">
                <label for="" class="regular-text">Tamanho</label>
                <input type="text" data-cy="purchase_request_products[{{ $supplierIndex }}][products][{{ $productIndex }}][size]"
                    name="purchase_request_products[{{ $supplierIndex }}][products][{{ $productIndex }}][size]"
                    class="form-control product-size" value="{{ $product->size ?? null }}">
            </div>
        </div>
        <div class="col-sm-4">
            <div class="form-group" style="margin-top:-10px">
                <label for="" class="regular-text">Modelo</label>
                <input type="text" data-cy="purchase_request_products[{{ $supplierIndex }}][products][{{ $productIndex }}][model]"
                    name="purchase_request_products[{{ $supplierIndex }}][products][{{ $productIndex }}][model]"
                    class="form-control product-model" value="{{ $product->model ?? null }}">
            </div>
        </div>
    </div>
</div>
