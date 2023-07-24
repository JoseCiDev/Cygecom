<x-app>
    <x-slot name="title">
        <h1>Página de suprimentos</h1>
    </x-slot>
    
    <x-ModalDelete/>
    <x-ModalSupplies/>

    <div class="row">
        <div class="col-md-12 text-center">
            <div class="card">
                <div class="card-body">
                    <h2>Bem-vindo a tela de suprimentos!</h2>
                    <p>Este é o portal de gerenciamento de compras do grupo Essentia!</p>
                </div>
            </div>
        </div>
    </div>
    
    <x-SuppliesProductList :suppliesGroup="$suppliesGroup" />

</x-app>
