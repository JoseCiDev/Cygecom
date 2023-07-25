<div class="row">
    <div class="col-sm-12">
        <div class="box box-color box-bordered">

            <div class="box-title">
                <div class="row">
                    <div class="col-md-6">
                        <h3 class="pull-left">Solicitações de Contratos</h3>
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
                            <th class="col-xs-2">
                                <select id="filterStatus" class="form-control">
                                    <option data-href={{route(request()->route()->getName(), ['suppliesGroup'=> $suppliesGroup])}}>Status</option>
                                    @foreach (\App\Enums\PurchaseRequestStatus::cases() as $statusCase)
                                        <option data-href={{route(request()->route()->getName(), ['suppliesGroup'=> $suppliesGroup, 'status' => $statusCase->value])}} 
                                            value="{{ $statusCase->value }}" @selected($statusCase->value === $status?->value)>
                                            {{ $statusCase->label() }}
                                        </option>
                                    @endforeach
                                </select>
                            </th>
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
                        @foreach ($contracts as $contract)
                            @php 
                                $groups = $contract->CostCenterApportionment->pluck('costCenter.Company.group')->unique(); 
                                $concatenatedGroups = $groups->map(function ($item) {
                                        return $item->label(); 
                                    })->implode(', ');
                            @endphp
                            <tr>
                                <td>{{$contract->id}}</td>
                                <td>{{$contract->user->person->name}}</td>
                                <td>{{$contract->SuppliesUser?->Person->name ?? '---'}}</td>
                                <td>{{$contract->responsibility_marked_at ? \Carbon\Carbon::parse($contract->responsibility_marked_at)->format('d/m/Y h:m:s') : '---'}}</td>
                                <td>{{$contract->status->label()}}</td>
                                <td>{{$contract->contract->Supplier?->cpf_cnpj ?? '---'}}</td>
                                <td>{{$contract->contract->Supplier?->qualification->label() ?? '---'}}</td>

                                <td>{{$contract->contract->is_prepaid ? 'Pgto. Antecipado' : 'Pgto. pós-pago'}}</td>
                                <td>{{$contract->contract->already_provided ? 'Executado' : 'Não executado'}}</td>
                                <td>{{$contract->is_supplies_quote ? 'Suprimentos' : 'Solicitante'}}</td>
                                <td>{{$concatenatedGroups}}</td>

                                <td>{{ \Carbon\Carbon::parse($contract->desired_date)->format('d/m/Y') }}</td>
                                <td>{{ \Carbon\Carbon::parse($contract->updated_at)->format('d/m/Y h:m:s') }}</td>

                                <td class="text-center" style="white-space: nowrap;">
                                    <button 
                                        data-modal-name="{{ 'Analisando Solicitação de Contrato - ID ' . $contract->id }}"
                                        data-id="{{ $contract->id }}"
                                        data-request="{{json_encode($contract)}}"
                                        rel="tooltip"
                                        title="Analisar"
                                        class="btn btn-primary"
                                        data-toggle="modal"
                                        data-target="#modal-supplies"
                                    >
                                        <i class="fa fa-search"></i> Analisar
                                    </button>
                                    @php $isToShow = !(bool)$contract->SuppliesUser?->Person->name &&  !(bool)$contract->responsibility_marked_at @endphp
                                    <a href="{{route('supplies.contract.detail', ['id' => $contract->id])}}"
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

<script src="{{asset('js/supplies/modal-confirm-supplies-responsability.js')}}"></script>
<script src="{{asset('js/supplies/redirect-route-by-request-status.js')}}"></script>
