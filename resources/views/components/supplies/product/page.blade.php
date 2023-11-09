<x-app>
    <x-modals.delete />
    <x-modals.supplies/>

    <div class="row" style="margin-bottom: 15px">
        <div class="col-md-12 text-left">
            <h1 class="page-title">Solicitações de produtos</h1>
        </div>
    </div>

    <x-SuppliesProductList :suppliesGroup="$suppliesGroup" :status="$status" />

</x-app>
