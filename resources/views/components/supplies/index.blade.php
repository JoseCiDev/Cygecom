<x-app>
    <x-slot name="title">
        <h1>Página de suprimentos</h1>
    </x-slot>
    <div class="row">
        <div class="col-md-12 text-center">
            <div class="card">
                <div class="card-body">
                    <h2>Bem-vindo a tela de suprimentos!</h2>
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
                                <li>Contratadação do tipo suprimentos: {{$productAcquiredBySuppliesQtd}}</li>
                                <li>Quantidade de COMEX: {{$productComexQtd}}</li>
                                <li>Unlimited Traffic</li>
                                <li>Lorem ipsum dolor.</li>
                                <li>Odio, fugit, nesciunt!</li>
                            </ul>
                            <ul class="pricing green col-sm-4">
                                <li class="head">
                                    <div class="name">Solicitações de serviços</div>
                                    <div class="price">
                                        {{ $serviceQtd  ?? '---'}} <span>solicitações existentes</span>
                                        <a href="{{route('supplies.service')}}" class="btn btn-grey-4">Ir para serviços</a>
                                    </div>
                                </li>
                                <li>Contratadação do tipo suprimentos: {{$serviceAcquiredBySuppliesQtd}}</li>
                                <li>Quantidade de COMEX: {{$serviceComexQtd}}</li>
                                <li>Unlimited Traffic</li>
                                <li>Lorem ipsum dolor.</li>
                                <li>Odio, fugit, nesciunt!</li>
                            </ul>
                            <ul class="pricing red col-sm-4">
                                <li class="head">
                                    <div class="name">Solicitações de contratos</div>
                                    <div class="price">
                                        {{ $contractQtd  ?? '---'}} <span>solicitações existentes</span>
                                        <a href="{{route('supplies.contract')}}" class="btn btn-grey-4">Ir para contratos</a>
                                    </div>
                                </li>
                                <li>Contratadação do tipo suprimentos: {{$contractAcquiredBySuppliesQtd}}</li>
                                <li>Quantidade de COMEX: {{$contractComexQtd}}</li>
                                <li>Unlimited Traffic</li>
                                <li>Lorem ipsum dolor.</li>
                                <li>Odio, fugit, nesciunt!</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</x-app>
