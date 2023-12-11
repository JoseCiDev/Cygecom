@php
    use App\Enums\PurchaseRequestStatus;
@endphp

@push('styles')
    <style>
        input.search-button {
            padding: 3px;
        }
    </style>
@endpush

<x-app>
    <x-modals.delete />
    <x-modals.supplies />

    <div class="row" style="margin-bottom: 15px">
        <div class="col-md-12 text-left">
            <h1 class="page-title">Solicitações de serviços recorrentes</h1>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-12">
            <div class="box box-color box-bordered">

                <div class="box-content nopadding regular-text">

                    <x-SuppliesFilters :status="$status" />

                    <div class="row">
                        <div class="col-md-12">
                            <p>Encontrado {{ $requests->count() }} registro(s).</p>
                        </div>
                    </div>

                    <table id="table-supplies-list" class="table table-hover table-nomargin table-striped table-bordered" data-column_filter_dateformat="dd-mm-yy" data-nosort="0"
                        data-checkall="all" style="width:100%">
                        <thead>
                            <tr class="search-bar">
                                <th></th>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th></th>
                            </tr>
                            <tr>
                                <th class="noColvis">Nº</th>
                                <th>Solicitante</th>
                                <th>Responsável</th>
                                <th>Status</th>
                                <th>Fornecedor</th>
                                <th>Contratação por</th>
                                <th>Empresa</th>
                                <th>Data desejada</th>
                                <th>Ord. compra</th>
                                <th class="noColvis ignore-search">Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($requests as $index => $contract)
                                @php
                                    $companies = $contract->CostCenterApportionment->pluck('costCenter.Company')->unique();

                                    $amount = $contract->contract->amount;
                                    $amountFormated = $amount !== null ? number_format($amount, 2, ',', '.') : '---';

                                    $suppliers = $contract->contract->supplier;
                                    $modalData = [
                                        'request' => $contract,
                                        'suppliers' => $suppliers,
                                    ];
                                @endphp
                                <tr>
                                    <td style="min-width: 90px;">{{ $contract->id }}</td>
                                    <td>{{ $contract->user->person->name }}</td>
                                    <td>{{ $contract->suppliesUser?->person->name ?? '---' }}</td>
                                    <td>{{ $contract->status->label() }}</td>
                                    <td>
                                        <div class="tag-list">
                                            @php
                                                $formattedCnpj = preg_replace('/(\d{2})(\d{3})(\d{3})(\d{4})(\d{2})/', '$1.$2.$3/$4-$5', $suppliers?->cpf_cnpj);
                                                $fullSupplier = $suppliers?->corporate_name . ' - ' . $formattedCnpj;
                                            @endphp
                                            @if ($suppliers)
                                                <span class="tag-list-item">{{ $fullSupplier }}</span>
                                                <!-- APENAS PARA PODER BUSCAR PELO CNPJ SEM FORMATAÇÃO-->
                                                <span style="display: none">{{ $suppliers?->cpf_cnpj }}</span>
                                            @else
                                                ---
                                            @endif
                                        </div>
                                    </td>
                                    <td class="hidden-1024">{{ $contract->is_supplies_contract ? 'Suprimentos' : 'Solicitante' }}</td>
                                    <td class="hidden-1280">
                                        <div class="tag-list">
                                            @forelse ($companies as $company)
                                                @php
                                                    $formattedCnpj = $company->cnpj ? preg_replace('/(\d{2})(\d{3})(\d{3})(\d{4})(\d{2})/', '$1.$2.$3/$4-$5', $company->cnpj) : 'CNPJ indefinido';
                                                    $fullCompany = $company->name . ' - ' . $formattedCnpj;
                                                @endphp
                                                <span class="tag-list-item">{{ $fullCompany }}</span>
                                                <!-- APENAS PARA PODER BUSCAR PELO CNPJ SEM FORMATAÇÃO-->
                                                <span style="display: none">{{ $company->cnpj }}</span>
                                            @empty
                                                ---
                                            @endforelse
                                        </div>
                                    </td>

                                    <td class="hidden-1440">
                                        <span hidden> {{ \Carbon\Carbon::parse($contract->desired_date)->format('Y-m-d H:i:s') }}</span>
                                        {{ \Carbon\Carbon::parse($contract->desired_date)->format('d/m/Y') }}
                                    </td>

                                    @php
                                        $showPurchaseOrder = isset($contract->purchase_order) && $contract->status === PurchaseRequestStatus::FINALIZADA;
                                    @endphp
                                    <td>{{ $showPurchaseOrder ? $contract?->purchase_order : '---' }}</td>

                                    <td class="text-center" style="white-space: nowrap;">
                                        <button data-modal-name="{{ 'Analisando solicitação de serviço recorrente - Nº ' . $contract->id }}" data-id="{{ $contract->id }}"
                                            data-request="{{ json_encode($modalData) }}" rel="tooltip" title="Analisar" class="btn" data-bs-toggle="modal"
                                            data-bs-target="#modal-supplies" data-cy="btn-analisar-{{ $index }}">
                                            <i class="fa fa-search"></i>
                                        </button>
                                        @php
                                            $existSuppliesUser = (bool) $contract->suppliesUser;
                                            $existResponsibility = (bool) $contract->responsibility_marked_at;
                                            $isOwnUserRequest = $contract->user->id === auth()->user()->id;
                                            $isToShow = !$existSuppliesUser && !$existResponsibility && !$isOwnUserRequest;
                                        @endphp
                                        <a href="{{ route('supplies.contract.show', ['id' => $contract->id]) }}" class="btn btn-link openDetail" rel="tooltip" title="Abrir"
                                            data-is-to-show="{{ $isToShow ? 'true' : 'false' }}" data-cy="btn-open-details-{{ $index }}">
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
        <script type="module" src="{{ asset('js/supplies/modal-confirm-supplies-responsability.js') }}"></script>
        <script type="module" src="{{ asset('js/utils/dataTables-column-search.js') }}"></script>
    @endpush

</x-app>
