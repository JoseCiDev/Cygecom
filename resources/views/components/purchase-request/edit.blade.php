<x-app>
    <x-slot name="title">
        <h1>Editar solicitação</h1>
    </x-slot>
    
    <div class="alert alert-info alert-dismissable">
        <button type="button" class="close" data-dismiss="alert">&times;</button>
        Formulário para preenchimento das informações necessárias para abrir uma requisição de compra. Para cada CNPJ, é possível cadastrar vários produtos de uma mesma categoria. É preciso também informar a quantidade de cada produto. Se preferir, pode ser inserido um link de sugestão de produto.
    </div>
    <div class="row">
        <div class="col-sm-12">
            <div class="box box-color box-bordered colored">
                @if ($type->label() === "Serviço")
                    <x-PurchaseRequestFormService :id="$id" />
                @elseif ($type->label() === "Produto")
                    <x-PurchaseRequestFormProduct :id="$id" />
                @elseif ($type->label() === "Contrato")
                    <x-PurchaseRequestFormContract :id="$id" />
                @endif
            </div>
        </div>
    </div>

</x-app>