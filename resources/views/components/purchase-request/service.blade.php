<x-app>
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
