<x-app>
    <x-modals.delete />
    <x-modals.supplies/>

    <div class="row" style="margin-bottom: 15px">
        <div class="col-md-12 text-left">
            <h1 class="page-title">Solicitações de serviços recorrentes</h1>
        </div>
    </div>

    <x-SuppliesContractList :suppliesGroup="$suppliesGroup" :status="$status"/>

</x-app>
