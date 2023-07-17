<div class="row">
    <div class="col-sm-12">
        <div class="box box-color box-bordered">

            <div class="box-title">
                <div class="row">
                    <div class="col-md-6">
                        <h3 class="pull-left">Solicitações de Serviços</h3>
                    </div>
                </div>
            </div>

            <div class="box-content nopadding">

                <table
                    class="table table-hover table-nomargin table-bordered dataTable"
                    data-column_filter_dateformat="dd-mm-yy" data-nosort="0" data-checkall="all">
                    <thead>
                        <tr>
                            <th class="col-sm-1">ID</th>
                            <th class="col-sm-1">Solicitante</th>
                            <th class="col-sm-1">Fornecedor</th>
                            <th class="col-sm-1">Tipo de quitação</th>
                            <th class="col-sm-1">Progresso</th>
                            <th class="col-sm-1">Contratação por</th>
                            <th class="col-sm-1">Data desejada</th>
                            <th class="col-sm-1">Atualizado em</th>
                            <th class="col-sm-1">Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($serviceList as $service)
                            <tr>
                                <td>{{$service->id}}</td>
                                <td>{{$service->user->person->name}}</td>
                                <td>{{$service->service->first()->Supplier->cpf_cnpj}}</td>
                                <td>{{$service->service->first()->is_prepaid ? 'Pgto. Antecipado' : 'Pgto. pós-pago'}}</td>
                                <td>{{$service->service->first()->already_provided ? 'Executado' : 'Não executado'}}</td>
                                <td>{{$service->is_supplies_quote ? 'Suprimentos' : 'Solicitante'}}</td>
                                <td>{{ \Carbon\Carbon::parse($service->desired_date)->format('d/m/Y') }}</td>
                                <td>{{ \Carbon\Carbon::parse($service->updated_at)->format('d/m/Y h:m:s') }}</td>
                                {{-- BTN AÇÕES --}}
                                <td class="text-center" style="white-space: nowrap;">
                                    <button 
                                        data-name="{{ 'Analisando Solicitação de Serviço - ID ' . $service->id }}"
                                        data-id="{{ $service->id }}"
                                        data-request="{{json_encode($service)}}"
                                        rel="tooltip"
                                        title="Analisar"
                                        class="btn btn-primary"
                                        data-toggle="modal"
                                        data-target="#modal-supplies"
                                    >
                                        <i class="fa fa-search"></i> Analisar
                                    </button>
                                    <a href="{{route('supplies.service.detail', ['id' => $service->id])}}"
                                        class="btn btn-link"
                                        rel="tooltip"
                                        title="Abrir"
                                    >
                                        <i class="fa fa-external-link"></i> Abrir
                                    </a>
                                    <a href="{{route('request.edit', ['type'=> $service->type, 'id' => $service->id])}}"
                                        class="btn"
                                        rel="tooltip"
                                        title="Editar"
                                    >
                                        <i class="fa fa-edit"></i>
                                    </a>
                                    @php
                                        $endpoint = $service->type->value;
                                        $route = "request.$endpoint.register";
                                    @endphp
                                    <a href="{{route($route, ['id' => $service->id])}}"
                                        rel="tooltip"
                                        title="Copiar"
                                        class="btn"
                                    >
                                        <i class="fa fa fa-copy"></i>
                                    </a>
                                    <button data-route="purchaseRequests"
                                        data-name="{{'Solicitação de compra - ID ' . $service->id}}"
                                        data-id="{{$service->id}}"
                                        rel="tooltip"
                                        title="Excluir"
                                        class="btn btn-danger"
                                        data-toggle="modal"
                                        data-target="#modal"
                                    >
                                        <i class="fa fa-times"></i>
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
