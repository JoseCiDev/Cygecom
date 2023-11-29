<x-app>

    <div class="supplies-dashboard">
        <h1 class="supplies-dashboard-title page-title">Dashboard de suprimentos</h1>

        <div class="supplies-dashboard-requests">
            <div class="supplies-dashboard-requests-item border-product">
                <h2 class="supplies-dashboard-requests-item-title bg-product-color">Solicitações de produtos</h2>
                <div class="supplies-dashboard-requests-item-info">
                    <div class="supplies-dashboard-requests-item-info-top">
                        <p class="supplies-dashboard-requests-item-info-top-price">
                            <span class="supplies-dashboard-requests-item-info-top-price-value text-product-color">{{ $productQtd }}</span>
                            solicitações no total
                        </p>
                        <div class="supplies-dashboard-requests-item-info-top-btns">
                            <a href="{{ route('supplies.product') }}" class="supplies-dashboard-requests-item-info-top-btns-btn" data-cy="btn-all-products">
                                Ver todas
                            </a>
                        </div>
                    </div>
                    <div class="supplies-dashboard-requests-item-info-bottom">
                        @can('admin')
                            <div class="supplies-dashboard-requests-item-info-bottom-row">
                                <span class="supplies-dashboard-requests-item-info-bottom-row-text-qtd">
                                    {{ $productsFromInp->count() }}
                                </span>
                                <p class="supplies-dashboard-requests-item-info-bottom-row-text">
                                    solicitações para INP/Noorskin/Oasis
                                </p>
                            </div>
                            <div class="supplies-dashboard-requests-item-info-bottom-row">
                                <span class="supplies-dashboard-requests-item-info-bottom-row-text-qtd">
                                    {{ $productsFromHkm->count() }}
                                </span>
                                <p class="supplies-dashboard-requests-item-info-bottom-row-text">
                                    solicitações para farmácias e demais empresas
                                </p>
                            </div>
                        @endcan
                        <div class="supplies-dashboard-requests-item-info-bottom-row">
                            <span class="supplies-dashboard-requests-item-info-bottom-row-text-qtd">
                                {{ $productComexQtd }}
                            </span>
                            <p class="supplies-dashboard-requests-item-info-bottom-row-text">
                                COMEX
                            </p>
                        </div>
                        <div class="supplies-dashboard-requests-item-info-bottom-row">
                            <span class="supplies-dashboard-requests-item-info-bottom-row-text-qtd">
                                {{ $productDesiredTodayQtd }}
                            </span>
                            <p class="supplies-dashboard-requests-item-info-bottom-row-text">
                                desejadas para hoje
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="supplies-dashboard-requests-item border-service">
                <h2 class="supplies-dashboard-requests-item-title bg-service-color">Solicitações de serviços pontuais</h2>
                <div class="supplies-dashboard-requests-item-info">
                    <div class="supplies-dashboard-requests-item-info-top">
                        <p class="supplies-dashboard-requests-item-info-top-price">
                            <span class="supplies-dashboard-requests-item-info-top-price-value text-service-color">{{ $serviceQtd }}</span>
                            solicitações no total
                        </p>
                        <div class="supplies-dashboard-requests-item-info-top-btns">
                            <a href="{{ route('supplies.service') }}" class="supplies-dashboard-requests-item-info-top-btns-btn" data-cy="btn-all-services">
                                Ver todas
                            </a>
                        </div>
                    </div>
                    <div class="supplies-dashboard-requests-item-info-bottom">
                        @can('admin')
                            <div class="supplies-dashboard-requests-item-info-bottom-row">
                                <span class="supplies-dashboard-requests-item-info-bottom-row-text-qtd">
                                    {{ $servicesFromInp->count() }}
                                </span>
                                <p class="supplies-dashboard-requests-item-info-bottom-row-text">
                                    solicitações para INP/Noorskin/Oasis
                                </p>
                            </div>
                            <div class="supplies-dashboard-requests-item-info-bottom-row">
                                <span class="supplies-dashboard-requests-item-info-bottom-row-text-qtd">
                                    {{ $servicesFromHkm->count() }}
                                </span>
                                <p class="supplies-dashboard-requests-item-info-bottom-row-text">
                                    solicitações para farmácias e demais empresas
                                </p>
                            </div>
                        @endcan
                        <div class="supplies-dashboard-requests-item-info-bottom-row">
                            <span class="supplies-dashboard-requests-item-info-bottom-row-text-qtd">
                                {{ $serviceComexQtd }}
                            </span>
                            <p class="supplies-dashboard-requests-item-info-bottom-row-text">
                                COMEX
                            </p>
                        </div>
                        <div class="supplies-dashboard-requests-item-info-bottom-row">
                            <span class="supplies-dashboard-requests-item-info-bottom-row-text-qtd">
                                {{ $serviceDesiredTodayQtd }}
                            </span>
                            <p class="supplies-dashboard-requests-item-info-bottom-row-text">
                                desejadas para hoje
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="supplies-dashboard-requests-item border-contract">
                <h2 class="supplies-dashboard-requests-item-title bg-contract-color">Solicitações de serviços recorrentes</h2>
                <div class="supplies-dashboard-requests-item-info">
                    <div class="supplies-dashboard-requests-item-info-top">
                        <p class="supplies-dashboard-requests-item-info-top-price">
                            <span class="supplies-dashboard-requests-item-info-top-price-value text-contract-color">{{ $contractQtd }}</span>
                            solicitações no total
                        </p>
                        <div class="supplies-dashboard-requests-item-info-top-btns">
                            <a href="{{ route('supplies.contract') }}" class="supplies-dashboard-requests-item-info-top-btns-btn" data-cy="btn-all-contracts">
                                Ver todas
                            </a>
                        </div>
                    </div>
                    <div class="supplies-dashboard-requests-item-info-bottom">
                        @can('admin')
                            <div class="supplies-dashboard-requests-item-info-bottom-row">
                                <span class="supplies-dashboard-requests-item-info-bottom-row-text-qtd">
                                    {{ $contractsFromInp->count() }}
                                </span>
                                <p class="supplies-dashboard-requests-item-info-bottom-row-text">
                                    solicitações para INP/Noorskin/Oasis
                                </p>
                            </div>
                            <div class="supplies-dashboard-requests-item-info-bottom-row">
                                <span class="supplies-dashboard-requests-item-info-bottom-row-text-qtd">
                                    {{ $contractsFromHkm->count() }}
                                </span>
                                <p class="supplies-dashboard-requests-item-info-bottom-row-text">
                                    solicitações para farmácias e demais empresas
                                </p>
                            </div>
                        @endcan
                        <div class="supplies-dashboard-requests-item-info-bottom-row">
                            <span class="supplies-dashboard-requests-item-info-bottom-row-text-qtd">
                                {{ $contractComexQtd }}
                            </span>
                            <p class="supplies-dashboard-requests-item-info-bottom-row-text">
                                COMEX
                            </p>
                        </div>
                        <div class="supplies-dashboard-requests-item-info-bottom-row">
                            <span class="supplies-dashboard-requests-item-info-bottom-row-text-qtd">
                                {{ $contractDesiredTodayQtd }}
                            </span>
                            <p class="supplies-dashboard-requests-item-info-bottom-row-text">
                                desejadas para hoje
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</x-app>
