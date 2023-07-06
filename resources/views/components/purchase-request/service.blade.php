<x-app>
    <x-slot name="title">
        <h1>Nova Solicitação de Serviço</h1>
    </x-slot>
    
    <div class="alert alert-info alert-dismissable">
        <button type="button" class="close" data-dismiss="alert">&times;</button>
        Formulário para preenchimento das informações necessárias para abrir uma requisição de compra. Para cada CNPJ, é possível cadastrar vários produtos de uma mesma categoria. É preciso também informar a quantidade de cada produto. Se preferir, pode ser inserido um link de sugestão de produto.
    </div>

    <div class="row">
        <div class="col-sm-12">
            <div class="box box-color box-bordered colored">
                <a class="btn btn-primary" href="{{route('request.product.register')}}">Produto</a>
                <a class="btn btn-primary" href="{{route('request.service.register')}}">Serviço</a>
                <a class="btn btn-primary" href="{{route('request.contract.register')}}">Contrato</a>
                @php
                    $purchaseRequestId = isset($purchaseRequestIdToCopy) ? $purchaseRequestIdToCopy : null;
                    $isCopy = isset($purchaseRequestIdToCopy) ? true : false;
                @endphp

                <x-PurchaseRequestFormService :id="$purchaseRequestId" :isCopy="$isCopy" />
            </div>
        </div>
    </div>
</x-app>
