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
                            <th>ID</th>

                            <th>Solicitante</th>
                            <th>Responsável</th>
                            <th>Responsável em</th>

                            <th>Status</th>
                            <th>Fornecedor</th>
                            <th>Qualif. fornecedor</th>

                            <th>Tipo de quitação</th>
                            <th>Progresso</th>
                            <th>Contratação por</th>

                            <th>Grupo de custo</th>
                            <th>Data desejada</th>
                            <th>Atualizado em</th>

                            <th>Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($services as $service)
                            @php 
                                $groups = $service->CostCenterApportionment->pluck('costCenter.Company.group')->unique(); 
                                $concatenatedGroups = $groups->map(function ($item) {
                                        return $item->label(); 
                                    })->implode(', ');
                            @endphp
                            <tr>
                                <td>{{$service->id}}</td>
                                <td>{{$service->user->person->name}}</td>
                                <td>{{$service->SuppliesUser?->Person->name ?? '---'}}</td>
                                <td>{{$service->responsibility_marked_at ? \Carbon\Carbon::parse($service->responsibility_marked_at)->format('d/m/Y h:m:s') : '---'}}</td>
                                <td>{{$service->status->label()}}</td>
                                <td>{{$service->service->Supplier?->cpf_cnpj ?? '---'}}</td>
                                <td>{{$service->service->Supplier?->qualification->label() ?? '---'}}</td>
                                
                                <td>{{$service->service->is_prepaid ? 'Pgto. Antecipado' : 'Pgto. pós-pago'}}</td>
                                <td>{{$service->service->already_provided ? 'Executado' : 'Não executado'}}</td>
                                <td>{{$service->is_supplies_quote ? 'Suprimentos' : 'Solicitante'}}</td>
                                <td>{{$concatenatedGroups}}</td>
                                <td>{{ \Carbon\Carbon::parse($service->desired_date)->format('d/m/Y') }}</td>
                                <td>{{ \Carbon\Carbon::parse($service->updated_at)->format('d/m/Y h:m:s') }}</td>
                                <td class="text-center" style="white-space: nowrap;">
                                    <button 
                                        data-modal-name="{{ 'Analisando Solicitação de Serviço - ID ' . $service->id }}"
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
                                    @php $isToShow = !(bool)$service->SuppliesUser?->Person->name &&  !(bool)$service->responsibility_marked_at @endphp
                                    <a 
                                        href="{{route('supplies.service.detail', ['id' => $service->id])}}"
                                        class="btn btn-link openDetail"
                                        rel="tooltip"
                                        title="Abrir"
                                        isToShow="{{$isToShow ? 'true' : 'false'}}"
                                    >
                                        <i class="fa fa-external-link"></i> Abrir
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script src="{{asset('js/modal-confirm-supplies-responsability/modal-confirm-supplies-responsability.js')}}"></script>
