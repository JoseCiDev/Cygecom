<x-app>
    <x-ModalDelete/>
    <x-ModalSupplies/>

    <div class="row" style="margin-bottom: 15px">
        <div class="col-md-12 text-left">
            <h1 class="page-title">Solicitações de contratos</h1>
        </div>
    </div>

    <x-SuppliesContractList :suppliesGroup="$suppliesGroup" :status="$status"/>

</x-app>
