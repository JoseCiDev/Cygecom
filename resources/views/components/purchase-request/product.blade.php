<x-app>
    <x-slot name="title">
        <h1>Nova Solicitação de Produto</h1>
    </x-slot>

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

                <x-PurchaseRequestFormProduct :id="$purchaseRequestId" :isCopy="$isCopy" />
            </div>
        </div>
    </div>
</x-app>
