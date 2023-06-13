<x-app>
    <x-slot name="title">
        <h1>Novo Fornecedor</h1>
    </x-slot>

    <div class="row">
        <div class="col-sm-12">
            <div class="box box-color box-bordered">

                <div class="box-title">
                    <div class="row">
                        <div class="col-md-6">
                            <h3 class="pull-left">Cadastrar novo</h3>
                        </div>
                    </div>
                </div>

                <div class="box-content">
                    <x-SupplierForm />
                
                    <span>(<span style="color:red"><strong>*</strong></span>) É obrigatório</span>
                </div>
            </div>
        </div>
    </div>

</x-app>
