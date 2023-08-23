<x-app>
    <x-slot name="title">
        <h1>Solicitação de Serviço</h1>
    </x-slot>

    <div class="row">
        <div class="col-sm-12">
            @php
                $purchaseRequestId = $purchaseRequestIdToCopy ?? null;
                $isCopy = isset($purchaseRequestIdToCopy);
            @endphp
            <x-PurchaseRequestFormService :id="$purchaseRequestId" :isCopy="$isCopy" />
        </div>
    </div>
</x-app>
