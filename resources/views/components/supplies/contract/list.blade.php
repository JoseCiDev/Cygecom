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
                            <th>Nº</th>
                            <th>Solicitante</th>
                            <th>Responsável</th>
                            <th class="hidden-1440">Responsável em</th>
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
                            <th>Condição de pgto.</th>
                            <th class="hidden-1024">Contratação por</th>
                            <th class="hidden-1440">Grupo de custo</th>
                            <th class="hidden-1440">Data desejada</th>
                            <th class="hidden-1440">Atualizado em</th>
                            <th>Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($contracts as $index => $contract)
                            @php
                                $groups = $contract->CostCenterApportionment->pluck('costCenter.Company.group')->unique();
                                $concatenatedGroups = $groups->map(function ($item) {
                                        return $item->label();
                                    })->implode(', ');
                            @endphp
                            <tr>
                                <td>{{$contract->id}}</td>
                                <td>{{$contract->user->person->name}}</td>
                                <td>{{$contract->suppliesUser?->person->name ?? '---'}}</td>
                                <td class="hidden-1440">{{$contract->responsibility_marked_at ? \Carbon\Carbon::parse($contract->responsibility_marked_at)->format('d/m/Y h:m:s') : '---'}}</td>
                                <td>{{$contract->status->label()}}</td>
                                <td>{{$contract->contract->supplier?->cpf_cnpj ?? '---'}}</td>
                                <td class="hidden-1280">{{$contract->contract->supplier?->qualification->label() ?? '---'}}</td>

                                <td>{{$contract->contract->paymentInfo?->payment_terms?->label() ?? '---'}}</td>
                                <td class="hidden-1024">{{$contract->is_supplies_contract ? 'Suprimentos' : 'Solicitante'}}</td>
                                <td class="hidden-1440">{{$concatenatedGroups}}</td>

                                <td class="hidden-1440">{{ \Carbon\Carbon::parse($contract->desired_date)->format('d/m/Y') }}</td>
                                <td class="hidden-1440">{{ \Carbon\Carbon::parse($contract->updated_at)->format('d/m/Y h:m:s') }}</td>

                                <td class="text-center" style="white-space: nowrap;">
                                    <button
                                        data-modal-name="{{ 'Analisando Solicitação de Contrato - Nº ' . $contract->id }}"
                                        data-id="{{ $contract->id }}"
                                        data-request="{{json_encode($contract)}}"
                                        rel="tooltip"
                                        title="Analisar"
                                        class="btn btn-primary"
                                        data-toggle="modal"
                                        data-target="#modal-supplies"
                                        data-cy="btn-analisar-{{$index}}"
                                    >
                                        <i class="fa fa-search"></i>
                                    </button>
                                    @php 
                                        $existSuppliesUser = (bool) $contract->suppliesUser;
                                        $existResponsibility = (bool) $contract->responsibility_marked_at;
                                        $isOwnUserRequest = $contract->user->id === auth()->user()->id;
                                        $isToShow = !$existSuppliesUser && !$existResponsibility && !$isOwnUserRequest;
                                    @endphp
                                    <a href="{{route('supplies.contract.detail', ['id' => $contract->id])}}"
                                        class="btn btn-link openDetail"
                                        rel="tooltip"
                                        title="Abrir"
                                        data-is-to-show="{{$isToShow ? 'true' : 'false'}}"
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
