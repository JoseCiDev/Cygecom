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

<x-app>
    <x-modals.delete />
    <x-modals.supplies-product-info />

    <div class="row" style="margin-bottom: 15px">
        <div class="col-md-12 text-left">
            <h1 class="page-title">Solicitações de produtos</h1>
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

                    <table id="table-supplies-list" class="table table-hover table-nomargin table-striped table-bordered" style="width:100%"
                        data-column_filter_dateformat="dd-mm-yy" data-nosort="0" data-checkall="all">
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
                            @foreach ($requests as $index => $product)
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
                                        <span hidden>{{ str_pad($amount, 10, '0', STR_PAD_LEFT) }}</span>
                                        R$ {{ $formatedAmount }}
                                    </td>

                                    <td class="text-center" style="white-space: nowrap;">
                                        @can('get.api.requests.show')
                                            <button class="btn btn-mini btn-secondary" data-id="{{ $product->id }}" data-bs-toggle="modal"
                                                data-bs-target="#modal-supplies-product-info" title="Analisar solicitação">
                                                <i class="fa-solid fa-magnifying-glass"></i>
                                            </button>
                                        @endcan
                                        @php
                                            $existSuppliesUser = (bool) $product->suppliesUser?->person->name;
                                            $existResponsibility = (bool) $product->responsibility_marked_at;
                                            $isOwnUserRequest = $product->user->id === auth()->user()->id;
                                            $isToShow = !$existSuppliesUser && !$existResponsibility && !$isOwnUserRequest;
                                        @endphp
                                        @can('get.supplies.product.show')
                                            <a href="{{ route('supplies.product.show', ['id' => $product->id]) }}" class="btn btn-mini btn-secondary openDetail" title="Abrir"
                                                data-is-to-show="{{ $isToShow ? 'true' : 'false' }}" data-cy="btn-open-details-{{ $index }}">
                                                <i class="fa fa-external-link"></i>
                                            </a>
                                        @endcan
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
