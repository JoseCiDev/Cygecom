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
                <div class="col-sm-4 products" style="display:flex; flex-direction:column; align-items:center">
                    <p class="text-center">
                        Lista de produtos que precisam ser adquiridos ou solicitados a suprimentos. Por exemplo:
                        compra de materiais de escritório.
                    </p>
                    <a data-cy="btn-products" href="{{ route('request.product.register') }}" class="btn btn-success btn-large btn-products" >
                        PRODUTOS
                    </a>
                </div>
                <div class="col-sm-4 services" style="display:flex; flex-direction:column; align-items:center">
                    <p class="text-center">
                        Serviços pontuais, prestados uma vez e com pagamento único ou parcelado. Por exemplo:
                        conserto de ar condicionado.
                    </p>
                    <a data-cy="btn-services" href="{{ route('request.service.register') }}" class="btn btn-inverse btn-large btn-services">SERVIÇOS</a>
                </div>
                <div class="col-sm-4 contracts" style="display:flex; flex-direction:column; align-items:center">
                    <p class="text-center">
                        Contratos de serviçoes prestados com recorrência, que possam ter parcelas fixas
                        ou variáveis. Exemplo: consultorias e softwares.
                    </p>
                    <a data-cy="btn-contracts" href="{{ route('request.contract.register') }}" class="btn btn-info btn-large btn-contracts">CONTRATOS</a>
                </div>
            </div>
        </div>
    </div>

</x-app>
