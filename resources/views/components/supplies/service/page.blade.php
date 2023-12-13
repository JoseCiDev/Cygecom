<x-app>
    <x-modals.delete />

    <div class="row" style="margin-bottom: 15px">
        <div class="col-md-12 text-left">
            <h1 class="page-title">Solicitações de serviços pontuais</h1>
        </div>
    </div>

    <x-SuppliesServiceList :suppliesGroup="$suppliesGroup" :status="$status" />

</x-app>
