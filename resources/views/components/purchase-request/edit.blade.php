@php
    use App\Enums\PurchaseRequestType;
@endphp

<x-app>
    <x-slot name="title">
        <h1>Editar solicitação</h1>
    </x-slot>

    <div class="alert alert-info alert-dismissable">
        <button type="button" class="close" data-dismiss="alert">&times;</button>
        Formulário para preenchimento das informações necessárias para abrir uma requisição de compra. Para cada CNPJ, é possível cadastrar vários produtos de uma mesma categoria. É preciso também informar a quantidade de cada produto. Se preferir, pode ser inserido um link de sugestão de produto.
    </div>
    <div class="row">
        <div class="col-sm-12">
            @if ($type ===  PurchaseRequestType::SERVICE)
                <x-PurchaseRequestFormService :id="$id" />
            @elseif ($type === PurchaseRequestType::PRODUCT)
                <x-PurchaseRequestFormProduct :id="$id" />
            @elseif ($type === PurchaseRequestType::CONTRACT)
                <x-PurchaseRequestFormContract :id="$id" />
            @endif
        </div>
    </div>

</x-app>
