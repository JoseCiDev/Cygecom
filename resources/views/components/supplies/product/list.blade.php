@php
    use App\Enums\PurchaseRequestStatus;
    use App\Models\PurchaseRequestProduct;
@endphp

@push('styles')
    <style>
        input.search-button {
            padding: 3px;
        }
    </style>
@endpush

<div class="row">
    <div class="col-sm-12">
        <div class="box box-color box-bordered">

            <div class="box-content nopadding regular-text">

                <div class="row">
                    <div class="col-md-12">
                        <form action="{{ route('supplies.product') }}" method="GET" class="form-status-filter">
                            <button class="btn btn-primary btn-small" id="status-filter-btn" type="submit">Filtrar
                                status</button>
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
                        <p>Encontrado {{ $products->count() }} registro(s).</p>
                    </div>
                </div>

                <table id="table-supplies-list" class="table table-hover table-nomargin table-striped table-bordered" style="width:100%" data-column_filter_dateformat="dd-mm-yy"
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
                            <th>Solicitante</th>
                            <th>Responsável</th>
                            <th>Categorias</th>
                            <th>Status</th>
                            <th>Fornecedor(es)</th>
                            <th>Contratação por</th>
                            <th>Empresa</th>
                            <th>Data desejada</th>
                            <th>Ord. compra</th>
                            <th>Valor total</th>
                            <th class="noColvis ignore-search">Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($products as $index => $product)
                            @php
                                $companies = $product->CostCenterApportionment->pluck('costCenter.Company')->unique();

                                $categories = $product->purchaseRequestProduct->groupBy('category.name')->keys();
                                $categoriesQtd = $categories->count();
                                $suppliers = $product->purchaseRequestProduct->pluck('supplier')->unique('id');
                                $modalData = [
                                    'request' => $product,
                                    'suppliers' => $suppliers,
                                ];

                                $amount = $product->product?->amount;
                                $formatedAmount = $amount ? number_format($amount, 2, ',', '.') : '---';
                            @endphp
                            <tr>
                                <td style="min-width: 90px;">{{ $product->id }}</td>
                                <td>{{ $product->user->person->name }}</td>
                                <td>{{ $product->suppliesUser?->person->name ?? '---' }}</td>
                                <td>
                                    <div class="tag-list">
                                        @forelse ($categories as $index => $category)
                                            <span class="tag-list-item">{{ $category }}</span>
                                        @empty
                                            ---
                                        @endforelse
                                    </div>
                                </td>
                                <td>{{ $product->status->label() }}</td>
                                <td>
                                    <div class="tag-list">
                                        @foreach ($suppliers as $index => $supplier)
                                            @php
                                                $cnpjFormatted = preg_replace('/(\d{2})(\d{3})(\d{3})(\d{4})(\d{2})/', '$1.$2.$3/$4-$5', $supplier?->cpf_cnpj);
                                                $fullSupplier = $supplier?->corporate_name . ' - ' . $cnpjFormatted;
                                            @endphp
                                            @if ($supplier)
                                                <span class="tag-list-item">{{ $fullSupplier }}</span>
                                                <!-- APENAS PARA PODER BUSCAR PELO CNPJ SEM FORMATAÇÃO-->
                                                <span style="display: none">{{ $supplier?->cpf_cnpj }}</span>
                                            @else
                                                ---
                                            @endif
                                        @endforeach
                                    </div>
                                </td>
                                <td class="hidden-1024">
                                    {{ $product->is_supplies_contract ? 'Suprimentos' : 'Solicitante' }}</td>

                                <td class="hidden-1280">
                                    <div class="tag-list">
                                        @forelse ($companies as $company)
                                            @php
                                                $cnpjFormatted = $company->cnpj ? preg_replace('/(\d{2})(\d{3})(\d{3})(\d{4})(\d{2})/', '$1.$2.$3/$4-$5', $company->cnpj) : 'CNPJ indefinido';
                                                $fullCompany = $company->name . ' - ' . $cnpjFormatted;
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
                                    <span hidden> {{ \Carbon\Carbon::parse($product->desired_date)->format('Y-m-d H:i:s') }}</span>
                                    {{ $product->desired_date ? \Carbon\Carbon::parse($product->desired_date)->format('d/m/Y') : '---' }}
                                </td>

                                @php
                                    $showPurchaseOrder = isset($product->purchase_order) && $product->status === PurchaseRequestStatus::FINALIZADA;
                                @endphp
                                <td>{{ $showPurchaseOrder ? $product->purchase_order : '---' }}</td>
                                <td>
                                    {{-- str_pad para ordenação por string no dataTables --}}
                                    <span hidden>{{ str_pad($amount, 10, '0', STR_PAD_LEFT) }}</span>
                                    R$ {{ $formatedAmount }}
                                </td>

                                <td class="text-center" style="white-space: nowrap;">
                                    <button data-modal-name="{{ 'Analisando Solicitação de Produto - Nº ' . $product->id }}" data-id="{{ $product->id }}"
                                        data-request="{{ json_encode($modalData) }}" rel="tooltip" title="Analisar" class="btn" data-bs-toggle="modal"
                                        data-bs-target="#modal-supplies" data-cy="btn-analisar-{{ $index }}">
                                        <i class="fa fa-search"></i>
                                    </button>
                                    @php
                                        $existSuppliesUser = (bool) $product->suppliesUser?->person->name;
                                        $existResponsibility = (bool) $product->responsibility_marked_at;
                                        $isOwnUserRequest = $product->user->id === auth()->user()->id;
                                        $isToShow = !$existSuppliesUser && !$existResponsibility && !$isOwnUserRequest;
                                    @endphp
                                    <a href="{{ route('supplies.product.detail', ['id' => $product->id]) }}" class="btn btn-link openDetail" rel="tooltip" title="Abrir"
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
