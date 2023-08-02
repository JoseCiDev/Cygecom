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
                                <a data-cy="btn-cadastrar-novo" href="{{ route('supplier.form') }}" class="btn pull-right btn-large" style="margin-right: 15px">Cadastrar novo</a>
                            </div>
                        </div>
                    </div>

                    <div class="box-content nopadding">

                        <table
                            class="table table-hover table-nomargin table-bordered dataTable"
                            data-nosort="0" data-checkall="all">
                            <thead>
                                <tr>
                                    <th >CNPJ</th>
                                    <th >Razão Social</th>
                                    <th >Nome Fantasia</th>
                                    <th >Indicação</th>
                                    <th >Mercado</th>
                                    <th >Situação</th>
                                    <th >Ações</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($suppliers as $index => $supplier)
                                @php
                                    $formattedCnpj = preg_replace('/(\d{2})(\d{3})(\d{3})(\d{4})(\d{2})/', '$1.$2.$3/$4-$5', $supplier->cpf_cnpj);
                                @endphp
                                <tr>
                                    <td>{{$formattedCnpj}}</td>
                                    <td>{{$supplier->corporate_name}}</td>
                                    <td>{{$supplier->name ?? '---'}}</td>
                                    <td>{{$supplier->supplier_indication}}</td>
                                    <td>{{$supplier->market_type}}</td>
                                    <td>{{$supplier->qualification->label()}}</td>
                                    <td align="center">
                                        <a href="{{route('supplier', ['id' => $supplier->id])}}" class="btn" rel="tooltip" title="Editar" data-cy="btn-edit-supplier-{{$index}}"><i class="fa fa-edit"></i></a>
                                        <button data-route="supplier" data-name="{{$supplier->corporate_name}}" data-id="{{$supplier->id}}" rel="tooltip" title="Excluir"
                                                class="btn" data-toggle="modal" data-target="#modal" data-cy="btn-modal-delete-supplier" ><i class="fa fa-times"></i>
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
