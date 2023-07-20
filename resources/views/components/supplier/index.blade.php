<x-app>
    <x-slot name="title">
        <h1>Fornecedores</h1>
    </x-slot>

    <x-modalDelete/>

        <div class="row">
            <div class="col-sm-12">
                <div class="box box-color box-bordered">

                    <div class="box-title">
                        <div class="row">
                            <div class="col-md-6">
                                <h3 class="pull-left">Todos os fornecedores</h3>
                            </div>
                            <div class="col-md-6">
                                <a href="{{ route('supplier.form') }}" class="btn pull-right btn-large" style="margin-right: 15px">Cadastrar novo</a>
                            </div>
                        </div>
                    </div>

                    <div class="box-content nopadding">

                        <table
                            class="table table-hover table-nomargin table-bordered dataTable"
                            data-nosort="0" data-checkall="all">
                            <thead>
                                <tr>
                                    <th class="col-md-1">CNPJ/CPF</th>
                                    <th class="col-md-1">Razão Social</th>
                                    <th class="col-md-2">Nome Fantasia</th>
                                    <th class="col-md-2">Indicação</th>
                                    <th class="col-md-1">Mercado</th>
                                    <th class='col-md-1'>Situação</th>
                                    <th class='col-md-1' >Ações</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($suppliers as $supplier)
                                <tr>
                                    <td>{{$supplier->cpf_cnpj}}</td>
                                    <td>{{$supplier->corporate_name}}</td>
                                    <td>{{$supplier->name ?? '---'}}</td>
                                    <td>
                                        <strong>
                                            @if ($supplier->supplier_indication === "M") Matéria-Prima
                                            @elseif ($supplier->supplier_indication === "S") Serviço
                                            @else Ambos    
                                            @endif
                                        </strong>
                                    </td>
                                    <td><strong>{{$supplier->market_type}}</strong></td>
                                    <td>{{$supplier->qualification->label()}}</td>
                                    <td align="center">
                                        <a href="{{route('supplier', ['id' => $supplier->id])}}" class="btn" rel="tooltip" title="Editar"><i class="fa fa-edit"></i></a>
                                        <button data-route="supplier" data-name="{{$supplier->corporate_name}}" data-id="{{$supplier->id}}" rel="tooltip" title="Excluir"
                                                class="btn" data-toggle="modal" data-target="#modal"  ><i class="fa fa-times"></i>
                                        </button>
                                    </td>
                                </tr>
                                @endforeach
                        </table>
                    </div>
                </div>
            </div>
        </div>

</x-app>
