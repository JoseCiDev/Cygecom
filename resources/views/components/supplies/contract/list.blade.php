@php
    use App\Enums\PurchaseRequestStatus;
@endphp

<div class="row">
    <div class="col-sm-12">
        <div class="box box-color box-bordered">

            <div class="box-content nopadding regular-text">

                <div class="row">
                    <div class="col-md-12">
                       <form action="{{ route('supplies.contract')}}" method="GET" class="form-status-filter">
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
                                    <label class="checkbox-label secondary-text">
                                        <input type="checkbox" name="status[]" class="status-checkbox" value="{{ $statusCase->value }}" @checked($isChecked)>
                                        {{ $statusCase->label() }}
                                    </label>
                                @endif

                            @endforeach
                       </form>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <p>Encontrado {{$contracts->count()}} registro(s).</p>
                    </div>
                </div>

                <table class="table table-hover table-nomargin table-bordered dataTable" data-column_filter_dateformat="dd-mm-yy" data-nosort="0" data-checkall="all">
                    <thead>
                        <tr>
                            <th>Nº</th>
                            <th>Solicitante</th>
                            <th>Responsável</th>
                            <th>Status</th>
                            <th>Fornecedor</th>
                            <th>Condição de pgto.</th>
                            <th class="hidden-1024">Contratação por</th>
                            <th class="hidden-1280">CNPJ</th>
                            <th class="hidden-1440">Data desejada</th>
                            <th>Ord. compra</th>
                            <th>Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($contracts as $index => $contract)
                            @php
                                $companies = $contract->CostCenterApportionment->pluck('costCenter.Company')->unique();

                                $amount = $contract->contract->amount;
                                $amountFormated = $amount !== null ? number_format($amount, 2, ',', '.') : '---';

                                $suppliers = $contract->contract->supplier;
                                $modalData = [
                                    'request' => $contract,
                                    'suppliers' => $suppliers
                                ];
                            @endphp
                            <tr>
                                <td>{{$contract->id}}</td>
                                <td>{{$contract->user->person->name}}</td>
                                <td>{{$contract->suppliesUser?->person->name ?? '---'}}</td>
                                <td>{{$contract->status->label()}}</td>
                                <td>{{$contract->contract->supplier?->cpf_cnpj ?? '---'}}</td>
                                <td>{{$contract->contract->paymentInfo?->payment_terms?->label() ?? '---'}}</td>
                                <td class="hidden-1024">{{$contract->is_supplies_contract ? 'Suprimentos' : 'Solicitante'}}</td>
                                <td class="hidden-1280">
                                    <div class="tag-list">
                                        @forelse ($companies as $company)
                                            @php
                                                $cnpj = $company->cnpj ? preg_replace('/(\d{2})(\d{3})(\d{3})(\d{4})(\d{2})/', '$1.$2.$3/$4-$5', $company->cnpj) : 'CNPJ indefinido';
                                                $concat = $company->name . ' - ' . $cnpj;
                                            @endphp
                                            <span class="tag-list-item">{{ $concat }}</span>
                                        @empty
                                            ---
                                        @endforelse
                                    </div>
                                </td>

                                <td class="hidden-1440">{{ \Carbon\Carbon::parse($contract->desired_date)->format('d/m/Y') }}</td>
                                <td>{{ $contract->purchase_order ?? '---' }}</td>

                                <td class="text-center" style="white-space: nowrap;">
                                    <button
                                        data-modal-name="{{ 'Analisando solicitação de serviço recorrente - Nº ' . $contract->id }}"
                                        data-id="{{ $contract->id }}"
                                        data-request="{{json_encode($modalData)}}"
                                        rel="tooltip"
                                        title="Analisar"
                                        class="btn"
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
