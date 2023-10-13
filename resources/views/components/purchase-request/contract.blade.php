<x-app>

    <div class="row">
        <div class="col-sm-12">

                @php($purchaseRequestId = $purchaseRequestIdToCopy ?? null)
                <x-PurchaseRequestFormContract :id="$purchaseRequestId" isCopy />
            </div>
        </div>
    </div>

</x-app>
