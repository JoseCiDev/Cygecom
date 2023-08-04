<x-app>
    <x-slot name="title">
        <h1>Nova Solicitação</h1>
    </x-slot>


    <div class="box">
        <div class="box-title">
            <h3>
                O que você deseja solicitar?
            </h3>
        </div>
        <div class="box-content">
            <div class="col-sm-12" style="display:flex; margin-top: 20px; justify-content:center; gap: 50px">
                <div class="col-sm-3 products" style="display:flex; flex-direction:column; align-items:center">
                    <p class="text-center">
                        Compra de produtos no geral. Exemplo: Material de escritório, limpeza, copa e cozinha, máquinário, equipamentos, etc.
                    </p>
                    <a data-cy="btn-products" href="{{ route('request.product.register') }}"
                        class="btn btn-success btn-large btn-products"
                    >
                        PRODUTOS
                    </a>
                </div>
                <div class="col-sm-3 services" style="display:flex; flex-direction:column; align-items:center">
                    <p class="text-center">
                        Contratação de Serviços, sem contrato vinculado. Exemplo: Contratação de uma limpeza no vidro, contratação de consultoria única, etc.
                    </p>
                    <a data-cy="btn-services" href="{{ route('request.service.register') }}" class="btn btn-inverse btn-large btn-services">SERVIÇOS</a>
                </div>
                <div class="col-sm-3 contracts" style="display:flex; flex-direction:column; align-items:center">
                    <p class="text-center">
                        Produto ou Serviço, que tenha um contrato vinculado. Exemplo: Serviço de limpeza diária, Vale Alimentação, Manutenção do ar condicionado, etc.
                    </p>
                    <a data-cy="btn-contracts" href="{{ route('request.contract.register') }}" class="btn btn-info btn-large btn-contracts">CONTRATOS</a>
                </div>
            </div>
        </div>
    </div>

</x-app>
