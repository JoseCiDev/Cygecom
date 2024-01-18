@php
    $currentProfile = auth()->user()->profile->name;
@endphp

<x-app>

    <div class="supplies-dashboard">
        <h1 class="supplies-dashboard-title page-title">Dashboard de suprimentos | Solicitações pendentes</h1>

        <div class="supplies-dashboard-requests">
            <div class="supplies-dashboard-requests-item border-product">
                <h2 class="supplies-dashboard-requests-item-title bg-product-color">Solicitações de produtos</h2>
                <div class="supplies-dashboard-requests-item-info">
                    <div class="supplies-dashboard-requests-item-info-top">
                        <p class="supplies-dashboard-requests-item-info-top-price">
                            <span
                                class="supplies-dashboard-requests-item-info-top-price-value text-product-color">{{ $productsTotal }}</span>
                            solicitações pendentes no total
                        </p>
                        <div class="supplies-dashboard-requests-item-info-top-btns">
                            <a href="{{ route('supplies.product') }}"
                                class="supplies-dashboard-requests-item-info-top-btns-btn" data-cy="btn-all-products">
                                Ver todas
                            </a>
                        </div>
                    </div>
                    <div class="supplies-dashboard-requests-item-info-bottom">

                        <div class="supplies-dashboard-requests-item-info-comex-desired-date">
                            <div class="supplies-dashboard-requests-item-info-bottom-row">
                                <span class="supplies-dashboard-requests-item-info-bottom-row-text-qtd">
                                    {{ $productDesiredTodayQtd }}
                                </span>
                                <p class="supplies-dashboard-requests-item-info-bottom-row-text">
                                    desejadas para hoje
                                </p>
                            </div>
                            <div class="supplies-dashboard-requests-item-info-bottom-row">
                                <span class="supplies-dashboard-requests-item-info-bottom-row-text-qtd">
                                    {{ $productComexQtd }}
                                </span>
                                <p class="supplies-dashboard-requests-item-info-bottom-row-text">
                                    COMEX
                                </p>
                            </div>
                        </div>

                        @foreach ($productsQtdByCompany as $company => $qtd)
                            @php
                                if ($qtd === 0) {
                                    continue;
                                }
                            @endphp
                            <div class="supplies-dashboard-requests-item-info-bottom-row">
                                <span class="supplies-dashboard-requests-item-info-bottom-row-text-qtd">
                                    {{ $qtd }}
                                </span>
                                <p class="supplies-dashboard-requests-item-info-bottom-row-text">
                                    {{ $company }}
                                </p>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <div class="supplies-dashboard-requests-item border-service">
                <h2 class="supplies-dashboard-requests-item-title bg-service-color">Solicitações de serviços pontuais
                </h2>
                <div class="supplies-dashboard-requests-item-info">
                    <div class="supplies-dashboard-requests-item-info-top">
                        <p class="supplies-dashboard-requests-item-info-top-price">
                            <span
                                class="supplies-dashboard-requests-item-info-top-price-value text-service-color">{{ $servicesTotal }}</span>
                            solicitações pendentes no total
                        </p>
                        <div class="supplies-dashboard-requests-item-info-top-btns">
                            <a href="{{ route('supplies.service') }}"
                                class="supplies-dashboard-requests-item-info-top-btns-btn" data-cy="btn-all-services">
                                Ver todas
                            </a>
                        </div>
                    </div>
                    <div class="supplies-dashboard-requests-item-info-bottom">
                        <div class="supplies-dashboard-requests-item-info-comex-desired-date">
                            <div class="supplies-dashboard-requests-item-info-bottom-row">
                                <span class="supplies-dashboard-requests-item-info-bottom-row-text-qtd">
                                    {{ $serviceDesiredTodayQtd }}
                                </span>
                                <p class="supplies-dashboard-requests-item-info-bottom-row-text">
                                    desejadas para hoje
                                </p>
                            </div>
                            <div class="supplies-dashboard-requests-item-info-bottom-row">
                                <span class="supplies-dashboard-requests-item-info-bottom-row-text-qtd">
                                    {{ $serviceComexQtd }}
                                </span>
                                <p class="supplies-dashboard-requests-item-info-bottom-row-text">
                                    COMEX
                                </p>
                            </div>
                        </div>
                        @foreach ($servicesQtdByCompany as $company => $qtd)
                            @php
                                if ($qtd === 0) {
                                    continue;
                                }
                            @endphp
                            <div class="supplies-dashboard-requests-item-info-bottom-row">
                                <span class="supplies-dashboard-requests-item-info-bottom-row-text-qtd">
                                    {{ $qtd }}
                                </span>
                                <p class="supplies-dashboard-requests-item-info-bottom-row-text">
                                    {{ $company }}
                                </p>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <div class="supplies-dashboard-requests-item border-contract">
                <h2 class="supplies-dashboard-requests-item-title bg-contract-color">Solicitações de serviços
                    recorrentes</h2>
                <div class="supplies-dashboard-requests-item-info">
                    <div class="supplies-dashboard-requests-item-info-top">
                        <p class="supplies-dashboard-requests-item-info-top-price">
                            <span
                                class="supplies-dashboard-requests-item-info-top-price-value text-contract-color">{{ $contractsTotal }}</span>
                            solicitações pendentes no total
                        </p>
                        <div class="supplies-dashboard-requests-item-info-top-btns">
                            <a href="{{ route('supplies.contract') }}"
                                class="supplies-dashboard-requests-item-info-top-btns-btn" data-cy="btn-all-contracts">
                                Ver todas
                            </a>
                        </div>
                    </div>
                    <div class="supplies-dashboard-requests-item-info-bottom">
                        <div class="supplies-dashboard-requests-item-info-comex-desired-date">
                            <div class="supplies-dashboard-requests-item-info-bottom-row">
                                <span class="supplies-dashboard-requests-item-info-bottom-row-text-qtd">
                                    {{ $contractDesiredTodayQtd }}
                                </span>
                                <p class="supplies-dashboard-requests-item-info-bottom-row-text">
                                    desejadas para hoje
                                </p>
                            </div>
                            <div class="supplies-dashboard-requests-item-info-bottom-row">
                                <span class="supplies-dashboard-requests-item-info-bottom-row-text-qtd">
                                    {{ $contractComexQtd }}
                                </span>
                                <p class="supplies-dashboard-requests-item-info-bottom-row-text">
                                    COMEX
                                </p>
                            </div>
                        </div>
                        @foreach ($contractQtdByCompany as $company => $qtd)
                            @php
                                if ($qtd === 0) {
                                    continue;
                                }
                            @endphp
                            <div class="supplies-dashboard-requests-item-info-bottom-row">
                                <span class="supplies-dashboard-requests-item-info-bottom-row-text-qtd">
                                    {{ $qtd }}
                                </span>
                                <p class="supplies-dashboard-requests-item-info-bottom-row-text">
                                    {{ $company }}
                                </p>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>

</x-app>
