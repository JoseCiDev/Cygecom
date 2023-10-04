<x-app>
    <div class="row">
        <div class="col-sm-12">
            @php
                $purchaseRequestId = $purchaseRequestIdToCopy ?? null;
                $isCopy = isset($purchaseRequestIdToCopy);
            @endphp

            <x-PurchaseRequestFormProduct :id="$purchaseRequestId" :isCopy="$isCopy" />
        </div>
    </div>
</x-app>
