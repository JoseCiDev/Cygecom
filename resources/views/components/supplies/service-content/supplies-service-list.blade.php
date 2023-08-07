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
                            <th>Nº</th>

                            <th>Solicitante</th>
                            <th>Responsável</th>
                            <th class="hidden-1280">Resp. em</th>
                            <th class="col-xs-2">
                                <select id="filterStatus" data-cy="filterStatus" class="form-control">
                                    <option data-href={{route(request()->route()->getName(), ['suppliesGroup'=> $suppliesGroup])}}>Status</option>
                                    @foreach (\App\Enums\PurchaseRequestStatus::cases() as $statusCase)
                                        @if ($statusCase->value !== \App\Enums\PurchaseRequestStatus::RASCUNHO->value);
                                            <option data-href={{route(request()->route()->getName(), ['suppliesGroup'=> $suppliesGroup, 'status' => $statusCase->value])}} 
                                                value="{{ $statusCase->value }}" @selected($statusCase->value === $status?->value)>
                                                {{ $statusCase->label() }}
                                            </option>
                                        @endif
                                    @endforeach
                                </select>
                            </th>
                            <th>Fornecedor</th>
                            <th class="hidden-1280">Qualif. fornecedor</th>

                            <th>Tipo de quitação</th>
                            <th>Progresso</th>
                            <th>Contratação por</th>

                            <th class="hidden-1440">Grupo de custo</th>
                            <th class="hidden-1440">Data desejada</th>
                            <th class="hidden-1440">Atualizado em</th>

                            <th>Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($services as $index => $service)
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
                                <td class="hidden-1280">{{$service->responsibility_marked_at ? \Carbon\Carbon::parse($service->responsibility_marked_at)->format('d/m/Y h:m:s') : '---'}}</td>
                                <td>{{$service->status->label()}}</td>
                                <td>{{$service->service->Supplier?->cpf_cnpj ?? '---'}}</td>
                                <td class="hidden-1280">{{$service->service->Supplier?->qualification->label() ?? '---'}}</td>
                                
                                <td>{{$service->service->is_prepaid ? 'Pgto. Antecipado' : 'Pgto. pós-pago'}}</td>
                                <td>{{$service->service->already_provided ? 'Executado' : 'Não executado'}}</td>
                                <td>{{$service->is_supplies_quote ? 'Suprimentos' : 'Solicitante'}}</td>
                                <td class="hidden-1440">{{$concatenatedGroups}}</td>
                                <td class="hidden-1440">{{ \Carbon\Carbon::parse($service->desired_date)->format('d/m/Y') }}</td>
                                <td class="hidden-1440">{{ \Carbon\Carbon::parse($service->updated_at)->format('d/m/Y h:m:s') }}</td>
                                <td class="text-center" style="white-space: nowrap;">
                                    <button 
                                        data-modal-name="{{ 'Analisando Solicitação de Serviço - Nº ' . $service->id }}"
                                        data-id="{{ $service->id }}"
                                        data-request="{{json_encode($service)}}"
                                        rel="tooltip"
                                        title="Analisar"
                                        class="btn btn-primary"
                                        data-toggle="modal"
                                        data-target="#modal-supplies"
                                        data-cy="btn-analisar-{{$index}}"
                                    >
                                        <i class="fa fa-search"></i>
                                    </button>
                                    @php $isToShow = !(bool)$service->SuppliesUser?->Person->name &&  !(bool)$service->responsibility_marked_at @endphp
                                    <a 
                                        href="{{route('supplies.service.detail', ['id' => $service->id])}}"
                                        class="btn btn-link openDetail"
                                        rel="tooltip"
                                        title="Abrir"
                                        isToShow="{{$isToShow ? 'true' : 'false'}}"
                                        data-cy="btn-open-details-{{$index}}"
                                    >
                                        <i class="fa fa-external-link"></i>
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

<script src="{{asset('js/supplies/modal-confirm-supplies-responsability.js')}}"></script>
<script src="{{asset('js/supplies/redirect-route-by-request-status.js')}}"></script>