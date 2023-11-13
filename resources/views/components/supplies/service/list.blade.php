@php
    use App\Enums\PurchaseRequestStatus;
@endphp

<div class="row">
    <div class="col-sm-12">
        <div class="box box-color box-bordered">

            <div class="box-content nopadding regular-text">

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
                        <p>Encontrado {{$services->count()}} registro(s).</p>
                    </div>
                </div>

                <table class="table table-hover table-nomargin table-bordered dataTable" data-column_filter_dateformat="dd-mm-yy"
                    style="width:100%" data-nosort="0" data-checkall="all">
                    <thead>
                        <tr>
                            <th class="noColvis">Nº</th>
                            <th>Solicitante</th>
                            <th>Responsável</th>
                            <th>Status</th>
                            <th class="col-sm-3">Fornecedor</th>
                            <th>Condição de pgto.</th>
                            <th>Contratação por</th>
                            <th>CNPJ</th>
                            <th>Data desejada</th>
                            <th>Ord. compra</th>
                            <th class="noColvis">Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($services as $index => $service)
                            @php
                                $companies = $service->CostCenterApportionment->pluck('costCenter.Company')->unique();

                                $amount = $service->service->price;
                                $amountFormated = $amount !== null ? number_format($amount, 2, ',', '.') : '---';

                                $suppliers = $service->service->supplier;
                                $modalData = [
                                    'request' => $service,
                                    'suppliers' => $suppliers
                                ];
                            @endphp
                            <tr>
                                <td>{{$service->id}}</td>
                                <td>{{$service->user->person->name}}</td>
                                <td>{{$service->suppliesUser?->person->name ?? '---'}}</td>
                                <td>{{$service->status->label()}}</td>
                                <td>{{$service->service->Supplier?->cpf_cnpj ?? '---'}}</td>
                                <td>{{$service->service->paymentInfo?->payment_terms?->label() ?? '---' }}</td>
                                <td>{{$service->is_supplies_contract ? 'Suprimentos' : 'Solicitante'}}</td>

                                <td class="hidden-1280">
                                    <div class="tag-list">
                                        @forelse ($companies as $company)
                                            @php
                                                $cnpj = $company->cnpj ? preg_replace('/(\d{2})(\d{3})(\d{3})(\d{4})(\d{2})/', '$1.$2.$3/$4-$5', $company->cnpj) : 'CNPJ indefinido';
                                                $concat = $company->name . ' - ' . $cnpj;
                                            @endphp
                                            <span class="tag-list-item">{{ $concat }}</span>
                                            <!-- APENAS PARA PODER BUSCAR PELO CNPJ SEM FORMATAÇÃO-->
                                            <span style="display: none">{{ $company->cnpj }}</span>
                                        @empty
                                            ---
                                        @endforelse
                                    </div>
                                </td>

                                <td class="hidden-1440">{{ \Carbon\Carbon::parse($service->desired_date)->format('d/m/Y') }}</td>
                                <td>{{ $service->purchase_order ?? '---' }}</td>
                                <td class="text-center" style="white-space: nowrap;">
                                    <button
                                        data-modal-name="{{ 'Analisando Solicitação de Serviço - Nº ' . $service->id }}"
                                        data-id="{{ $service->id }}"
                                        data-request="{{json_encode($modalData)}}"
                                        rel="tooltip"
                                        title="Analisar"
                                        class="btn"
                                        data-bs-toggle="modal"
                                        data-bs-target="#modal-supplies"
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

@push('scripts')
    <script type="module" src="{{asset('js/supplies/modal-confirm-supplies-responsability.js')}}"></script>
@endpush
