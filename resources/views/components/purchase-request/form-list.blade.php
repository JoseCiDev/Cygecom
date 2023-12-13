<x-app>

    <div class="request-dashboard">
        <h1 class="request-dashboard-title page-title">Nova solicitação</h1>
        <span class="request-dashboard-subtitle">O que você deseja solicitar?</span>

        <div class="request-dashboard-requests">

            @can('get.requests.product.create')
                <div class="request-dashboard-requests-item">
                    <h2 class="request-dashboard-requests-item-title">Produtos</h2>
                    <p class="request-dashboard-requests-item-subtitle">Compra de produtos em geral.</p>
                    <p class="request-dashboard-requests-item-description">Exemplo: Lista de material de escritório, lista de material de limpeza, materiais de copa e cozinha,
                        maquinário, equipamentos, etc.</p>
                    <a class="request-dashboard-requests-item-btn bg-product-color" href="{{ route('requests.product.create') }}">Solicitar produto</a>
                </div>
            @endcan

            @can('get.requests.service.create')
                <div class="request-dashboard-requests-item">
                    <h2 class="request-dashboard-requests-item-title">Serviços pontuais</h2>
                    <p class="request-dashboard-requests-item-subtitle">Contratação de serviços pontuais.</p>
                    <p class="request-dashboard-requests-item-description">Exemplo: contratações de limpeza para vidros, consultoria única, etc.</p>
                    <a class="request-dashboard-requests-item-btn bg-service-color" href="{{ route('requests.service.create') }}">Solicitar serviço pontual</a>
                </div>
            @endcan

            @can('get.requests.contract.create')
                <div class="request-dashboard-requests-item">
                    <h2 class="request-dashboard-requests-item-title">Serviços recorrentes</h2>
                    <p class="request-dashboard-requests-item-subtitle">Contratação de serviços recorrentes com vigência determinada ou indeterminada.</p>
                    <p class="request-dashboard-requests-item-description">Exemplo: serviço de limpeza diária, vale alimentação, manutenção regular de ar condicionados, etc.</p>
                    <a class="request-dashboard-requests-item-btn bg-contract-color" href="{{ route('requests.contract.create') }}">Solicitar serviço recorrente</a>
                </div>
            @endcan

        </div>
    </div>

</x-app>
