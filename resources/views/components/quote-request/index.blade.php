<x-app>
    <x-slot name="title">
        <h1>Solicitações de Compra/Serviço</h1>
    </x-slot>
    <x-modalDelete/>

    <div class="row">
        <div class="col-sm-12">
            <div class="box box-color box-bordered">

                <div class="box-title">
                    <div class="row">
                        <div class="col-md-6">
                            <h3 class="pull-left">Todas as solicitações</h3>
                        </div>
                        <div class="col-md-6">
                            <a href="{{ route('requests.new') }}" class="btn pull-right btn-large" style="margin-right: 15px">Nova Solicitação</a>
                        </div>
                    </div>
                </div>

                <div class="box-content nopadding">

                    <table
                        class="table table-hover table-nomargin table-bordered dataTable"
                        data-column_filter_dateformat="dd-mm-yy" data-nosort="0" data-checkall="all">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Solicitante</th>
                                <th>Tipo de cotação</th>
                                <th>Tipo de solicitação</th>
                                <th>Status</th>
                                <th>Data desejada</th>
                                <th>Atualizado em</th>
                                <th>Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($quoteRequests as $quoteRequest)
                            <tr>
                                <td>{{$quoteRequest->id}}</td>
                                <td>{{$quoteRequest->user->person->name}}</td>
                                <td>{{$quoteRequest->is_supplies_quote ? 'Suprimentos' : 'Pessoal'}}</td>
                                <td>{{$quoteRequest->is_service ? 'Serviço' : 'Produto'}}</td>
                                <td>{{$quoteRequest->status}}</td>
                                <td>{{$quoteRequest->desired_date}}</td>
                                <td>{{$quoteRequest->updated_at}}</td>

                                {{-- BTN AÇÕES --}}
                                <td style="white-space: nowrap;">
                                    <a href="{{route('request.edit', ['id' => $quoteRequest->id])}}"
                                        class="btn"
                                        rel="tooltip"
                                        title="Editar"
                                    >
                                        <i class="fa fa-edit"></i>
                                    </a>
                                    <a href="{{route('request.register', ['id' => $quoteRequest->id])}}"
                                        rel="tooltip"
                                        title="Copiar"
                                        class="btn"
                                    >
                                        <i class="fa fa fa-copy"></i>
                                    </a>
                                    <button data-route="quoteRequests"
                                        data-name="{{'Solicitação de compra - ID ' . $quoteRequest->id}}"
                                        data-id="{{$quoteRequest->id}}"
                                        rel="tooltip"
                                        title="Excluir"
                                        class="btn"
                                        data-toggle="modal"
                                        data-target="#modal"
                                    >
                                        <i class="fa fa-times"></i>
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
