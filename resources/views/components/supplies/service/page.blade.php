<x-app>
    <x-ModalDelete/>
    <x-ModalSupplies/>

    <div class="row" style="margin-bottom: 15px">
        <div class="col-md-12 text-left">
            <h2>Solicitações de serviços</h2>
        </div>
    </div>
    
    <x-SuppliesServiceList :suppliesGroup="$suppliesGroup" :status="$status" />

</x-app>
