@php
    use App\Enums\{PurchaseRequestStatus, PurchaseRequestType};
    $currentRoute = Route::currentRouteName();
@endphp

<x-app>
    <x-modals.delete />
    <x-toast />

    <div class="row">
        <div class="col-sm-12">
            <div class="box box-color box-bordered">
                <div class="row" style="margin: 0 0 30px">
                    <div class="col-md-6" style="padding: 0">
                        <h1 class="page-title">Solicitações de Compra/Serviço</h1>
                    </div>
                    <div class="col-md-6" style="padding: 0">
                        <a data-cy="btn-nova-solicitacao" href="{{ route('requests.dashboard') }}" class="btn btn-primary btn-large pull-right">Nova Solicitação</a>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <form action="{{ route($currentRoute) }}" method="GET" class="form-status-filter">
                            <button class="btn btn-primary btn-small" id="status-filter-btn" type="submit">Filtrar
                                status</button>

                            @foreach (PurchaseRequestStatus::cases() as $statusCase)
                                @php
                                    $statusDefaultFilter = $statusCase !== PurchaseRequestStatus::FINALIZADA && $statusCase !== PurchaseRequestStatus::CANCELADA;
                                    $isChecked = isset($selectedStatus) ? in_array($statusCase->value, $selectedStatus) : $statusDefaultFilter;
                                @endphp

                                <label class="checkbox-label secondary-text">
                                    <input type="checkbox" name="status[]" class="status-checkbox" value="{{ $statusCase->value }}" @checked($isChecked)>
                                    {{ $statusCase->label() }}
                                </label>
                            @endforeach

                        </form>
                    </div>
                </div>


                <div class="row">
                    <div class="col-md-12">
                        <div class="box-content nopadding regular-text">

                            <table id="table-supplies-list" style="width:100%" class="table table-hover table-nomargin table-bordered" data-column_filter_dateformat="dd-mm-yy"
                                data-nosort="0" data-checkall="all">
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
                                        <th></th>
                                        <th></th>
                                    </tr>
                                    <tr>
                                        <th class="noColvis">Nº</th>
                                        <th>Contratação por</th>
                                        <th style="max-width: 200px">Motivo</th>

                                        <th>Tipo</th>
                                        <th>Nome do serviço</th>
                                        <th>Fornecedor(es)</th>
                                        <th>Status</th>
                                        <th>Responsável</th>
                                        <th>Data desejada</th>
                                        <th>Atualizado em</th>
                                        <th>Valor total</th>
                                        <th class="noColvis ignore-search">Ações</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($purchaseRequests as $index => $purchaseRequest)
                                        @php
                                            $isDraft = $purchaseRequest->status->value === PurchaseRequestStatus::RASCUNHO->value;
                                            $supplier = null;
                                            $msg = '';
                                            $name = '---';

                                            $requestType = $purchaseRequest->type->value;
                                            if ($requestType === PurchaseRequestType::PRODUCT->value) {
                                                $countSuppliers = count($purchaseRequest?->purchaseRequestProduct?->groupBy('supplier_id'));
                                                if ($countSuppliers > 1) {
                                                    $msg = ' (+' . ($countSuppliers - 1) . ')';
                                                }

                                                $supplier = $purchaseRequest?->purchaseRequestProduct->first()->supplier ?? null;
                                            } else {
                                                $supplier = $purchaseRequest[$requestType]->supplier ?? null;
                                                $name = $purchaseRequest[$requestType]->name ?? '---';
                                            }

                                            $cnpj = $supplier?->cpf_cnpj ? preg_replace('/(\d{2})(\d{3})(\d{3})(\d{4})(\d{2})/', '$1.$2.$3/$4-$5', $supplier->cpf_cnpj) : 'CNPJ indefinido';
                                            $amount = $purchaseRequest[$requestType]?->amount ?? $purchaseRequest[$requestType]?->price;
                                            $formatedAmount = $amount ? number_format($amount, 2, ',', '.') : '---';
                                        @endphp
                                        <tr>
                                            <td style="min-width: 90px;">{{ $purchaseRequest->id }}</td>
                                            <td>{{ $purchaseRequest->is_supplies_contract ? 'Suprimentos' : 'Área Solicitante' }}</td>
                                            <td style="max-width: 200px" class="column-text-limit">{{ $purchaseRequest->reason }}</td>
                                            <td>{{ $purchaseRequest->type->label() }}</td>
                                            <td>{{ $name }}</td>
                                            <td style="min-width: 200px">{{ $supplier?->corporate_name ? $supplier?->corporate_name . ' - ' . $cnpj . ' ' . $msg : '---' }}</td>
                                            <td>{{ $purchaseRequest->status->label() }}</td>
                                            <td>{{ $purchaseRequest->suppliesUser?->person?->name ?? '---' }}</td>
                                            <td>
                                                <span hidden> {{ \Carbon\Carbon::parse($purchaseRequest->desired_date)->format('Y-m-d H:i:s') }}</span>
                                                {{ \Carbon\Carbon::parse($purchaseRequest->desired_date)->format('d/m/Y') }}
                                            </td>
                                            <td>
                                                <span hidden> {{ \Carbon\Carbon::parse($purchaseRequest->updated_at)->format('Y-m-d H:i:s') }}</span>
                                                {{ $purchaseRequest->updated_at->formatCustom('d/m/Y H:i:s') }}
                                            </td>
                                            <td>
                                                {{-- str_pad para ordenação por string no dataTables --}}
                                                <span hidden>{{ str_pad($amount, 10, '0', STR_PAD_LEFT) }}</span>
                                                R$ {{ $formatedAmount }}
                                            </td>

                                            {{-- BTN AÇÕES --}}
                                            <td style="white-space: nowrap;">
                                                <a href="{{ route('requests.edit', ['type' => $purchaseRequest->type, 'id' => $purchaseRequest->id]) }}" class="btn"
                                                    rel="tooltip" title="{{ $isDraft ? 'Editar' : 'Visualizar' }}" data-cy="btn-edit-request-{{ $index }}">
                                                    @if ($isDraft)
                                                        <i class="fa fa-edit"></i>
                                                    @else
                                                        <i class="fa fa-eye"></i>
                                                    @endif
                                                </a>
                                                @php
                                                    $endpoint = $purchaseRequest->type->value;
                                                    $route = "requests.$endpoint.create";
                                                @endphp
                                                <a href="{{ route($route, ['id' => $purchaseRequest->id]) }}" rel="tooltip" title="Copiar" class="btn"
                                                    data-cy="btn-copy-request-{{ $index }}">
                                                    <i class="fa fa fa-copy"></i>
                                                </a>
                                                @if ($purchaseRequest->status->value === PurchaseRequestStatus::RASCUNHO->value && Gate::allows('delete.api.requests.destroy'))
                                                    <button data-route="api.requests.destroy" data-name="{{ 'Solicitação de compra - Nº ' . $purchaseRequest->id }}"
                                                        data-id="{{ $purchaseRequest->id }}" rel="tooltip" title="Excluir" class="btn" data-bs-toggle="modal"
                                                        data-bs-target="#modal-delete" data-cy="btn-delete-request-{{ $index }}">
                                                        <i class="fa-solid fa-trash"></i>
                                                    </button>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script type="module" src="{{ asset('js/utils/dataTables-column-search.js') }}"></script>

</x-app>
