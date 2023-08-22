@php
    use App\Enums\PurchaseRequestStatus;
@endphp

<div class="row">
    <div class="col-sm-12">
        <div class="box box-color box-bordered">

            <div class="box-content nopadding">

                <div class="row">
                    <div class="col-md-12">
                       <form action="{{ route('supplies.service')}}" method="GET" class="form-status-filter">
                            <button class="btn btn-primary btn-small" id="status-filter-btn" type="submit">Filtrar status</button>
                            @if ($suppliesGroup)
                                <input type="hidden" name="suppliesGroup" value="{{ $suppliesGroup->value }}">
                            @endif
                            @foreach (PurchaseRequestStatus::cases() as $statusCase)
                                @php
                                    $statusDefaultFilter = $statusCase !== PurchaseRequestStatus::FINALIZADA && $statusCase !== PurchaseRequestStatus::CANCELADA;
                                    $isChecked = count($status) ? collect($status)->contains($statusCase) : $statusDefaultFilter;
                                @endphp
                                
                                @if ($statusCase !== PurchaseRequestStatus::RASCUNHO)
                                    <label class="checkbox-label">
                                        <input type="checkbox" name="status[]" class="status-checkbox" value="{{ $statusCase->value }}" @checked($isChecked)>
                                        {{ $statusCase->label() }}
                                    </label>
                                @endif

                            @endforeach
                       </form>
                    </div>
                </div>

                <table class="table table-hover table-nomargin table-bordered dataTable" data-column_filter_dateformat="dd-mm-yy" 
                    data-nosort="0" data-checkall="all">
                    <thead>
                        <tr>
                            <th>Nº</th>

                            <th>Solicitante</th>
                            <th>Responsável</th>
                            <th>Status</th>
                            <th>Fornecedor</th>
                            <th class="hidden-1280">Qualif. fornecedor</th>

                            <th class="hidden-1024">Condição de pgto.</th>
                            <th class="hidden-1024">Valor total</th>
                            <th class="hidden-1024">Progresso</th>
                            <th>Contratação por</th>

                            <th class="hidden-1440">Grupo de custo</th>
                            <th class="hidden-1440">Data desejada</th>

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
                                $amount = $service->service->price;
                                $amountFormated = $amount !== null ? number_format($amount, 2, ',', '.') : '---';
                            @endphp
                            <tr>
                                <td>{{$service->id}}</td>
                                <td>{{$service->user->person->name}}</td>
                                <td>{{$service->suppliesUser?->person->name ?? '---'}}</td>
                                <td>{{$service->status->label()}}</td>
                                <td>{{$service->service->Supplier?->cpf_cnpj ?? '---'}}</td>
                                <td class="hidden-1280">{{$service->service->Supplier?->qualification->label() ?? '---'}}</td>

                                <td class="hidden-1024">{{$service->service->paymentInfo?->payment_terms?->label() ?? '---' }}</td>
                                <td class="hidden-1024">R$ {{$amountFormated}}</td>
                                <td class="hidden-1024">{{$service->service->already_provided ? 'Executado' : 'Não executado'}}</td>
                                <td>{{$service->is_supplies_contract ? 'Suprimentos' : 'Solicitante'}}</td>
                                <td class="hidden-1440">{{$concatenatedGroups}}</td>
                                <td class="hidden-1440">{{ \Carbon\Carbon::parse($service->desired_date)->format('d/m/Y') }}</td>
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
                                    @php 
                                        $existSuppliesUser = (bool) $service->suppliesUser?->person->name;
                                        $existResponsibility = (bool) $service->responsibility_marked_at;
                                        $isOwnUserRequest = $service->user->id === auth()->user()->id;
                                        $isToShow = !$existSuppliesUser && !$existResponsibility && !$isOwnUserRequest 
                                    @endphp
                                    <a
                                        href="{{route('supplies.service.detail', ['id' => $service->id])}}"
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
