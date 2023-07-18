<x-app>

    <x-slot name="title">
        <h1>Solicitação de Contrato</h1>
    </x-slot>

    <div class="row">
        <div class="col-sm-12">

                @php($purchaseRequestId = $purchaseRequestIdToCopy ?? null)

                <x-PurchaseRequestFormContract :id="$purchaseRequestId" :isCopy="!$purchaseRequestId" />
            </div>
        </div>
    </div>

</x-app>
