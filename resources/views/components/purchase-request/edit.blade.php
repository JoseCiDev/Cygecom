@php
    use App\Enums\PurchaseRequestType;
@endphp

<x-app>
    <x-slot name="title">
        <h1>Solicitação de {{ $type->label() }}</h1>
    </x-slot>

    <div class="row">
        <div class="col-sm-12">
            @if ($type ===  PurchaseRequestType::SERVICE)
                <x-PurchaseRequestFormService :id="$id" :files="$files"/>
            @elseif ($type === PurchaseRequestType::PRODUCT)
                <x-PurchaseRequestFormProduct :id="$id" />
            @elseif ($type === PurchaseRequestType::CONTRACT)
                <x-PurchaseRequestFormContract :id="$id" />
            @endif
        </div>
    </div>

</x-app>
