<x-app>

    <div class="request-dashboard">
        <h1 class="request-dashboard-title page-title">Nova solicitação</h1>
        <span class="request-dashboard-subtitle">O que você deseja solicitar?</span>

        <div class="request-dashboard-requests">

            <div class="request-dashboard-requests-item">
                <h2 class="request-dashboard-requests-item-title">Produtos</h2>
                <p class="request-dashboard-requests-item-subtitle">Compra de produtos em geral.</p>
                <p class="request-dashboard-requests-item-description">Exemplo: Lista de material de escritório, lista de material de limpeza, materiais de copa e cozinha, maquinário, equipamentos, etc.</p>
                <a class="request-dashboard-requests-item-btn bg-product-color" href="{{ route('request.product.register') }}">Solicitação de produto</a>
            </div>

            <div class="request-dashboard-requests-item">
                <h2 class="request-dashboard-requests-item-title">Serviços</h2>
                <p class="request-dashboard-requests-item-subtitle">Contratação de serviços sem contrato vinculado e/ou serviços pontuais.</p>
                <p class="request-dashboard-requests-item-description">Exemplo: contratações de limpeza para vidros, consultoria única, etc.</p>
                <a class="request-dashboard-requests-item-btn bg-service-color" href="{{ route('request.service.register') }}" >Solicitação de serviço</a>
            </div>

            <div class="request-dashboard-requests-item">
                <h2 class="request-dashboard-requests-item-title">Contratos</h2>
                <p class="request-dashboard-requests-item-subtitle">Contratos de serviços ou produtos com vigência determinada ou indeterminada.</p>
                <p class="request-dashboard-requests-item-description">Exemplo: serviço de limpeza diária, vale alimentação, manutenção regular de ar condicionados, etc.</p>
                <a class="request-dashboard-requests-item-btn bg-contract-color" href="{{ route('request.contract.register') }}" >Solicitação de contrato</a>
            </div>

        </div>
    </div>

</x-app>
