@php
    use App\Enums\PurchaseRequestType;
@endphp

<x-app>

    <div class="row">
        <div class="col-sm-12">
            @if ($type ===  PurchaseRequestType::SERVICE)
                <x-PurchaseRequestFormService :id="$id"/>
            @elseif ($type === PurchaseRequestType::PRODUCT)
                <x-PurchaseRequestFormProduct :id="$id"/>
            @elseif ($type === PurchaseRequestType::CONTRACT)
                <x-PurchaseRequestFormContract :id="$id"/>
            @endif
        </div>
    </div>

</x-app>
