@props([
    'supplier' => null,
    'purchaseRequests' => null,
])

<div class="alert alert-info">
    <h4>ATENÇÃO!</h4>
    <p>Este fornecedor está com situação "Em análise". Abaixo consta a lista de solicitações relacionadas a este
        fornecedor.
    </p>
</div>

@php
    use App\Enums\{PurchaseRequestStatus, PurchaseRequestType};
    session(['supplier_id' => $supplier->id]);
    $supplierId = session('supplier_id');
@endphp

<div class="row">
    <div class="col-md-12">
        <div class="box-content nopadding regular-text">
            <table class="table table-hover table-nomargin table-striped" id="table-striped" style="width:100%" data-column_filter_dateformat="dd-mm-yy" data-nosort="0"
                data-checkall="all">
                <thead>
                    <tr>
                        <th>Nº</th>
                        <th class="col-sm-2 hidden-1280">Contratação por</th>
                        <th class="col-sm-1">Tipo</th>
                        <th class="col-sm-3">Nome do serviço</th>
                        <th class="col-sm-2">Status</th>
                        <th class="col-sm-2">Data desejada</th>
                        <th class="col-sm-2 hidden-1440">Atualizado em</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($purchaseRequests as $index => $request)
                        @php
                            $purchaseRequest = $request?->purchaseRequest ?? null;

                            if ($purchaseRequest?->status === PurchaseRequestStatus::RASCUNHO) {
                                continue;
                            }

                            $name = '---';
                            if ($purchaseRequest?->type === PurchaseRequestType::SERVICE) {
                                $name = $purchaseRequest?->service?->name ?? '---';
                                $route = 'supplies.service.show';
                            } elseif ($purchaseRequest?->type === PurchaseRequestType::CONTRACT) {
                                $name = $purchaseRequest?->contract?->name ?? '---';
                                $route = 'supplier.contract.show';
                            } elseif ($purchaseRequest?->type === PurchaseRequestType::PRODUCT) {
                                $route = 'supplier.product.show';
                            }
                        @endphp
                        <tr>
                            <td>{{ $purchaseRequest?->id }}</td>
                            <td class="hidden-1280">
                                {{ $purchaseRequest?->is_supplies_contract ? 'Suprimentos' : 'Área Solicitante' }}</td>
                            <td>{{ $purchaseRequest?->type?->label() }}</td>
                            <td>{{ $name }}</td>
                            <td>{{ $purchaseRequest?->status?->label() }}</td>
                            <td>{{ \Carbon\Carbon::parse($purchaseRequest?->desired_date)->format('d/m/Y') }}</td>
                            <td class="hidden-1440">{{ $purchaseRequest?->updated_at->formatCustom('d/m/Y H:i:s') }}</td>

                            {{-- BTN AÇÕES --}}
                            <td style="white-space: nowrap;">
                                <a href="{{ route($route, ['id' => $purchaseRequest->id]) }}" class="btn btn-small btn-secondary" rel="tooltip" target="_blank" title="Abrir"
                                    data-cy="btn-open-supplier-request-details-{{ $index }}">
                                    Acessar detalhes <i class="fa fa-share"></i>
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

@push('scripts')
    <script type="module">
        $(() => {
            const table = $('#table-striped').DataTable({
                ordering: false,
                paging: false,
                info: false,
                searching: false,
                bLengthChange: false,
                language: {
                    emptyTable: "Nenhuma solicitação encontrada.",
                },
            });
        });
    </script>
@endpush
