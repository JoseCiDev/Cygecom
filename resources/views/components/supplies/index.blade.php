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
                                    <div class="price">
                                        {{ $productQtd  ?? '---'}} <span>solicitações existentes</span>
                                        @if (auth()->user()->profile->name === 'admin')
                                            <a href="{{route('supplies.product')}}" class="btn btn-grey-4">Todos de produtos</a>
                                        @endif
                                        @if (auth()->user()->profile->name === 'admin' || auth()->user()->profile->name === 'suprimentos_hkm')
                                            <a href="{{route('supplies.product', ['filter' => 'hkm'])}}" class="btn btn-grey-4">Produtos HKM</a>
                                        @endif
                                        @if (auth()->user()->profile->name === 'admin' || auth()->user()->profile->name === 'suprimentos_inp')
                                            <a href="{{route('supplies.product', ['filter' => 'inp'])}}" class="btn btn-grey-4">Produtos INP</a>
                                        @endif
                                    </div>
                                </li>
                                <li>Qtd. de solicitações para INP: <strong>{{$productsFromInp->count()}}</strong></li>
                                <li>Qtd. de solicitações para HKM: <strong>{{$productsFromHkm->count()}}</strong></li>
                                <li>Qtd. de contratações do tipo suprimentos: <strong>{{$productAcquiredBySuppliesQtd}}</strong></li>
                                <li>Qtd. de COMEX: <strong>{{$productComexQtd}}</strong></li>
                                <li>Qtd. desejadas p/ hoje: <strong>{{$productDesiredTodayQtd}}</strong></li>
                            </ul>
                            <ul class="pricing green col-sm-4">
                                <li class="head">
                                    <div class="name" style="background-color: #111111"><i class="fa fa-briefcase"></i> Solicitações de serviços</div>
                                    <div class="price">
                                        {{ $serviceQtd  ?? '---'}} <span>solicitações existentes</span>
                                        @if (auth()->user()->profile->name === 'admin')
                                            <a href="{{route('supplies.service')}}" class="btn btn-grey-4">Todos serviços</a>
                                        @endif
                                        @if (auth()->user()->profile->name === 'admin' || auth()->user()->profile->name === 'suprimentos_hkm')
                                            <a href="{{route('supplies.service', ['filter' => 'hkm'])}}" class="btn btn-grey-4">Serviços HKM</a>
                                        @endif
                                        @if (auth()->user()->profile->name === 'admin' || auth()->user()->profile->name === 'suprimentos_inp')
                                            <a href="{{route('supplies.service', ['filter' => 'inp'])}}" class="btn btn-grey-4">Serviços INP</a>
                                        @endif
                                    </div>
                                </li>
                                <li>Qtd. de solicitações para INP: <strong>{{$servicesFromInp->count()}}</strong></li>
                                <li>Qtd. de solicitações para HKM: <strong>{{$servicesFromHkm->count()}}</strong></li>
                                <li>Qtd. de contratações do tipo suprimentos: <strong>{{$serviceAcquiredBySuppliesQtd}}</strong></li>
                                <li>Qtd. de COMEX: <strong>{{$serviceComexQtd}}</strong></li>
                                <li>Qtd. desejadas p/ hoje: <strong>{{$serviceDesiredTodayQtd}}</strong></li>
                            </ul>
                            <ul class="pricing red col-sm-4">
                                <li class="head">
                                    <div class="name" style="background-color: #62a7e7"><i class="glyphicon glyphicon-list-alt"></i> Solicitações de contratos</div>
                                    <div class="price">
                                        {{ $contractQtd  ?? '---'}} <span>solicitações existentes</span>
                                        @if (auth()->user()->profile->name === 'admin')
                                            <a href="{{route('supplies.contract')}}" class="btn btn-grey-4">Todos de contratos</a>
                                        @endif
                                        @if (auth()->user()->profile->name === 'admin' || auth()->user()->profile->name === 'suprimentos_hkm')
                                            <a href="{{route('supplies.contract', ['filter' => 'hkm'])}}" class="btn btn-grey-4">Contratos HKM</a>
                                        @endif
                                        @if (auth()->user()->profile->name === 'admin' || auth()->user()->profile->name === 'suprimentos_inp')
                                            <a href="{{route('supplies.contract', ['filter' => 'inp'])}}" class="btn btn-grey-4">Contratos INP</a>
                                        @endif
                                    </div>
                                </li>
                                <li>Qtd. de solicitações para INP: <strong>{{$contractsFromInp->count()}}</strong></li>
                                <li>Qtd. de solicitações para HKM: <strong>{{$contractsFromHkm->count()}}</strong></li>
                                <li>Qtd. de contratações do tipo suprimentos: <strong>{{$contractAcquiredBySuppliesQtd}}</strong></li>
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
