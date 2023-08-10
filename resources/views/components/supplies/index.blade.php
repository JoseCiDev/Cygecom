@php
    $currentProfile = auth()->user()->profile->name;
    
    $productQtdByProfile = [
        'admin' => $productQtd, 
        'suprimentos_hkm' => $productsFromHkm->count(), 
        'suprimentos_inp' => $productsFromInp->count()
    ];
    
    $serviceQtdByProfile = [
        'admin' => $serviceQtd, 
        'suprimentos_hkm' => $servicesFromHkm->count(), 
        'suprimentos_inp' => $servicesFromInp->count()
    ];
    
    $contractQtdByProfile = [
        'admin' => $contractQtd, 
        'suprimentos_hkm' => $contractsFromHkm->count(), 
        'suprimentos_inp' => $contractsFromInp->count()
    ];
@endphp
<x-app>
    <x-slot name="title">
        <h1>Dashboard de suprimentos</h1>
    </x-slot>
    <div class="row">
        <div class="col-md-12 text-center">
            <div class="card">
                <div class="card-body">
                    <h2>Bem-vindo ao dashboard de suprimentos!</h2>
                    <p>Este é o portal de gerenciamento de compras do grupo Essentia!</p>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-12">
            <div class="box">
                <div class="box-title"> <h3> <i class="fa fa-bars"></i> Tipos de solicitações </h3></div>
                <div class="box-content">
                    <div class="row">
                        <div class="pricing-tables">
                            <ul class="pricing col-sm-4">
                                <li class="head">
                                    <div class="name" style="background-color: #339933"><i class="fa fa-tags"></i> Solicitações de produtos</div>
                                    <div class="price" style="background-color: #33993368">

                                        {{$productQtdByProfile[$currentProfile]}}
                                        <span>solicitações existentes</span>

                                        @if ($currentProfile === 'admin')
                                            <a href="{{route('supplies.product')}}" class="btn btn-grey-4" data-cy="btn-all-products">Todas solicitações</a>
                                        @endif

                                        @if ($currentProfile === 'admin' || $currentProfile === 'suprimentos_hkm')
                                            <a href="{{route('supplies.product', ['suppliesGroup' => 'hkm'])}}" class="btn btn-grey-4" data-cy="btn-hkm-products">Ver solicitações {{$currentProfile === 'admin' ? 'HKM' : ''}} <i class="fa fa-external-link"></i></a>
                                        @endif
                                        
                                        @if ($currentProfile === 'admin' || $currentProfile === 'suprimentos_inp')
                                            <a href="{{route('supplies.product', ['suppliesGroup' => 'inp'])}}" class="btn btn-grey-4" data-cy="btn-inp-products">Ver solicitações {{$currentProfile === 'admin' ? 'INP' : ''}} <i class="fa fa-external-link"></i></a>
                                        @endif

                                    </div>
                                </li>
                                @if ($currentProfile === 'admin')
                                    <li>Solicitações para INP/Noorskin/Oasis: <strong>{{$productsFromInp->count()}}</strong></li>
                                    <li>Solicitações para farmácias e demais empresas: <strong>{{$productsFromHkm->count()}}</strong></li>
                                @endif
                                <li>Qtd. de COMEX: <strong>{{$productComexQtd}}</strong></li>
                                <li>Qtd. desejadas p/ hoje: <strong>{{$productDesiredTodayQtd}}</strong></li>
                            </ul>
                            <ul class="pricing green col-sm-4">
                                <li class="head">
                                    <div class="name" style="background-color: #111111"><i class="fa fa-briefcase"></i> Solicitações de serviços</div>
                                    <div class="price" style="background-color: #11111159">

                                        {{$serviceQtdByProfile[$currentProfile]}}
                                        <span>solicitações existentes</span>

                                        @if ($currentProfile === 'admin')
                                            <a href="{{route('supplies.service')}}" class="btn btn-grey-4" data-cy="btn-all-services">Todas solicitações</a>
                                        @endif

                                        @if ($currentProfile === 'admin' || $currentProfile === 'suprimentos_hkm')
                                            <a href="{{route('supplies.service', ['suppliesGroup' => 'hkm'])}}" class="btn btn-grey-4" data-cy="btn-hkm-services">Ver solicitações {{ $currentProfile === 'admin' ? 'HKM' : ''}} <i class="fa fa-external-link"></i></a>
                                        @endif

                                        @if ($currentProfile === 'admin' || $currentProfile === 'suprimentos_inp')
                                            <a href="{{route('supplies.service', ['suppliesGroup' => 'inp'])}}" class="btn btn-grey-4" data-cy="btn-inp-services">Ver solicitações {{ $currentProfile === 'admin' ? 'INP' : ''}} <i class="fa fa-external-link"></i></a>
                                        @endif
                                    </div>
                                </li>
                                @if ($currentProfile === 'admin')
                                    <li>Solicitações para INP/Noorskin/Oasis <strong>{{$servicesFromInp->count()}}</strong></li>
                                    <li>Solicitações para farmácias e demais empresas: <strong>{{$servicesFromHkm->count()}}</strong></li>
                                @endif
                                <li>Qtd. de COMEX: <strong>{{$serviceComexQtd}}</strong></li>
                                <li>Qtd. desejadas p/ hoje: <strong>{{$serviceDesiredTodayQtd}}</strong></li>
                            </ul>
                            <ul class="pricing red col-sm-4">
                                <li class="head">
                                    <div class="name" style="background-color: #62a7e7;"><i class="glyphicon glyphicon-list-alt"></i> Solicitações de contratos</div>
                                    <div class="price" style="background-color: #62a7e75c;">

                                        {{$contractQtdByProfile[$currentProfile]}}
                                        <span>solicitações existentes</span>

                                        @if ($currentProfile === 'admin')
                                            <a href="{{route('supplies.contract')}}" class="btn btn-grey-4" data-cy="btn-all-contracts">Todas solicitações</a>
                                        @endif

                                        @if ($currentProfile === 'admin' || $currentProfile === 'suprimentos_hkm')
                                            <a href="{{route('supplies.contract', ['suppliesGroup' => 'hkm'])}}" class="btn btn-grey-4" data-cy="btn-hkm-contracts">Ver solicitações {{$currentProfile === 'admin' ? 'HKM' : ''}} <i class="fa fa-external-link"></i></a>
                                        @endif

                                        @if ($currentProfile === 'admin' || $currentProfile === 'suprimentos_inp')
                                            <a href="{{route('supplies.contract', ['suppliesGroup' => 'inp'])}}" class="btn btn-grey-4" data-cy="btn-inp-contracts">Ver solicitações {{$currentProfile === 'admin' ? 'INP' : ''}} <i class="fa fa-external-link"></i></a>
                                        @endif
                                    </div>
                                </li>
                                @if ($currentProfile === 'admin')
                                    <li>Solicitações para INP/Noorskin/Oasis: <strong>{{$contractsFromInp->count()}}</strong></li>
                                    <li>Solicitações para farmácias e demais empresas: <strong>{{$contractsFromHkm->count()}}</strong></li>
                                @endif
                                <li>Qtd. de COMEX: <strong>{{$contractComexQtd}}</strong></li>
                                <li>Qtd. desejadas p/ hoje: <strong>{{$contractDesiredTodayQtd}}</strong></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</x-app>
