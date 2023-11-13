@php
    use App\Enums\{PurchaseRequestStatus, PurchaseRequestType};
    $currentRoute = Route::currentRouteName();
@endphp
<x-app>
    <x-modals.delete />

    <div class="row">
        <div class="col-sm-12">
            <div class="box box-color box-bordered">
                <div class="row" style="margin: 0 0 30px">
                    <div class="col-md-6" style="padding: 0">
                        <h1 class="page-title">Solicitações de Compra/Serviço</h1>
                    </div>
                    <div class="col-md-6" style="padding: 0">
                        <a data-cy="btn-nova-solicitacao" href="{{ route('request.links') }}"
                            class="btn btn-primary btn-large pull-right">Nova Solicitação</a>
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
                                    <input type="checkbox" name="status[]" class="status-checkbox"
                                        value="{{ $statusCase->value }}" @checked($isChecked)>
                                    {{ $statusCase->label() }}
                                </label>
                            @endforeach

                        </form>
                    </div>
                </div>


                <div class="row">
                    <div class="col-md-12">
                        <div class="box-content nopadding regular-text">

                            <table style="width:100%" class="table table-hover table-nomargin table-bordered dataTable"
                                data-column_filter_dateformat="dd-mm-yy" data-nosort="0" data-checkall="all">
                                <thead>
                                    <tr>
                                        <th class="noColvis">Nº</th>
                                        <th>Contratação por</th>
                                        <th>Tipo</th>
                                        <th>Nome do serviço</th>
                                        <th>Fornecedor(es)</th>
                                        <th>Status</th>
                                        <th>Responsável</th>
                                        <th>Data desejada</th>
                                        <th>Atualizado em</th>
                                        <th class="noColvis">Ações</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($purchaseRequests as $index => $purchaseRequest)
                                        @php
                                            $isDraft = $purchaseRequest->status->value === PurchaseRequestStatus::RASCUNHO->value;
                                            $supplier = null;
                                            $msg = '';
                                            $name = '---';
                                            if ($purchaseRequest->type === PurchaseRequestType::SERVICE) {
                                                $supplier = $purchaseRequest->service->supplier ?? null;
                                                $name = $purchaseRequest->service->name ?? '---';
                                            } elseif ($purchaseRequest->type === PurchaseRequestType::CONTRACT) {
                                                $supplier = $purchaseRequest->contract->supplier ?? null;
                                                $name = $purchaseRequest->contract->name ?? '---';
                                            } else  {
                                                $countSuppliers = count($purchaseRequest?->purchaseRequestProduct?->groupBy('supplier_id'));

                                                if ($countSuppliers > 1) {
                                                    $msg = ' (+' . ($countSuppliers - 1) . ')';
                                                }
                                                $supplier = $purchaseRequest?->purchaseRequestProduct->first()->supplier ?? null;
                                            }
                                        @endphp
                                        <tr>
                                            <td>{{$purchaseRequest->id}}</td>
                                            <td class="hidden-1280">{{$purchaseRequest->is_supplies_contract ? 'Suprimentos' : 'Área Solicitante'}}</td>
                                            <td>{{$purchaseRequest->type->label()}}</td>
                                            <td>{{$name}}</td>
                                            <td>{{$supplier?->corporate_name . $msg}}</td>
                                            <td>{{$purchaseRequest->status->label()}}</td>
                                            <td>{{$purchaseRequest->suppliesUser?->person?->name ?? '---'}}</td>
                                            <td>{{ \Carbon\Carbon::parse($purchaseRequest->desired_date)->format('d/m/Y') }}</td>
                                            <td class="hidden-1440">{{ $purchaseRequest->updated_at->formatCustom('d/m/Y H:i:s')  }}</td>

                                            {{-- BTN AÇÕES --}}
                                            <td style="white-space: nowrap;">
                                                <a href="{{ route('request.edit', ['type' => $purchaseRequest->type, 'id' => $purchaseRequest->id]) }}"
                                                    class="btn" rel="tooltip"
                                                    title="{{ $isDraft ? 'Editar' : 'Visualizar' }}"
                                                    data-cy="btn-edit-request-{{ $index }}">
                                                    @if ($isDraft)
                                                        <i class="fa fa-edit"></i>
                                                    @else
                                                        <i class="fa fa-eye"></i>
                                                    @endif
                                                </a>
                                                @php
                                                    $endpoint = $purchaseRequest->type->value;
                                                    $route = "request.$endpoint.register";
                                                @endphp
                                                <a href="{{ route($route, ['id' => $purchaseRequest->id]) }}"
                                                    rel="tooltip" title="Copiar" class="btn"
                                                    data-cy="btn-copy-request-{{ $index }}">
                                                    <i class="fa fa fa-copy"></i>
                                                </a>
                                                @if ($purchaseRequest->status->value === PurchaseRequestStatus::RASCUNHO->value)
                                                    <button data-route="purchaseRequests"
                                                        data-name="{{ 'Solicitação de compra - Nº ' . $purchaseRequest->id }}"
                                                        data-id="{{ $purchaseRequest->id }}" rel="tooltip"
                                                        title="Excluir" class="btn" data-bs-toggle="modal"
                                                        data-bs-target="#modal-delete"
                                                        data-cy="btn-delete-request-{{ $index }}">
                                                        <i class="fa fa-times"></i>
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

</x-app>
