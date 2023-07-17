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
                                    <div class="name">Solicitações de produtos</div>
                                    <div class="price">
                                        {{ $productQtd  ?? '---'}} <span>solicitações existentes</span>
                                        <a href="{{route('supplies.product')}}" class="btn btn-grey-4">Ir para produtos</a>
                                    </div>
                                </li>
                                <li>Qtd. de contratações do tipo suprimentos: <strong>{{$productAcquiredBySuppliesQtd}}</strong></li>
                                <li>Qtd. de COMEX: <strong>{{$productComexQtd}}</strong></li>
                                <li>Qtd. desejadas p/ hoje: <strong>{{$productDesiredTodayQtd}}</strong></li>
                            </ul>
                            <ul class="pricing green col-sm-4">
                                <li class="head">
                                    <div class="name">Solicitações de serviços</div>
                                    <div class="price">
                                        {{ $serviceQtd  ?? '---'}} <span>solicitações existentes</span>
                                        <a href="{{route('supplies.service')}}" class="btn btn-grey-4">Ir para serviços</a>
                                    </div>
                                </li>
                                <li>Qtd. de contratações do tipo suprimentos: <strong>{{$serviceAcquiredBySuppliesQtd}}</strong></li>
                                <li>Qtd. de COMEX: <strong>{{$serviceComexQtd}}</strong></li>
                                <li>Qtd. desejadas p/ hoje: <strong>{{$serviceDesiredTodayQtd}}</strong></li>
                            </ul>
                            <ul class="pricing red col-sm-4">
                                <li class="head">
                                    <div class="name">Solicitações de contratos</div>
                                    <div class="price">
                                        {{ $contractQtd  ?? '---'}} <span>solicitações existentes</span>
                                        <a href="{{route('supplies.contract')}}" class="btn btn-grey-4">Ir para contratos</a>
                                    </div>
                                </li>
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
