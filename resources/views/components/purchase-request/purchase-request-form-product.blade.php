@php
    use App\Enums\PurchaseRequestStatus;
    use App\Enums\PaymentMethod;

    $currentUser = auth()->user();

    $issetPurchaseRequest = isset($purchaseRequest);
    $purchaseRequest ??= null;
    $isCopy ??= null;

    $allProducts = $purchaseRequest?->purchaseRequestProduct ?? null;
    if ($allProducts) {
        $productSuppliers = [];
        foreach ($allProducts as $product) {
            $productSuppliers[$product['supplier_id']][] = $product;
        }
    }

    $selectedPaymentMethod = null;
    $selectedPaymentTerm = null;
    if (isset($purchaseRequest->product) && isset($purchaseRequest->product->paymentInfo)) {
        $selectedPaymentMethod = $purchaseRequest->product->paymentInfo->payment_method;
        $selectedPaymentTerm = $purchaseRequest->product->paymentInfo->payment_terms;
    }

    $purchaseRequestProductAmount = $purchaseRequest?->product?->amount === null ? null : (float) $purchaseRequest?->product?->amount;
    $productQuantityOfInstallments = $purchaseRequest?->product?->quantity_of_installments === null ? null : (int) $purchaseRequest?->product?->quantity_of_installments;

    $paymentMethods = array_map(
        fn($item) => [
            'text' => $item->label(),
            'value' => $item->value,
        ],
        $paymentMethods,
    );

    // verifica status para desabilitar campos para o usuário
    $requestAlreadySent = $purchaseRequest?->status !== PurchaseRequestStatus::RASCUNHO;
    // ve se tem request e não foi enviada
    $hasRequestNotSent = $issetPurchaseRequest && !$requestAlreadySent;
    // ve se tem request ja enviada e n é copia
    $hasSentRequest = $issetPurchaseRequest && $requestAlreadySent && !$isCopy;
@endphp

@push('styles')
    <style>
        .cost-center-container {
            margin-bottom: 5px;
        }

        h4 {
            font-size: 20px;
        }

        .product-row hr {
            margin: 0px;
        }

        .supplier-block .product-container .product-row:nth-of-type(odd) {
            background-color: #f7f7f7;
        }

        .supplier-block .product-container .product-row:nth-of-type(even) {
            background-color: #ffffff;
        }

        .supplier-container {
            display: flex;
            flex-direction: column;
        }
    </style>
@endpush

<div class="row" style="margin: 0 0 30px;">

    <div class="col-sm-6" style="padding: 0">
        @if ($hasRequestNotSent)
            <h1 class="page-title">Editar solicitação de produto nº {{ $purchaseRequest->id }}</h1>
        @elseif ($hasSentRequest)
            <div class="alert alert-info alert-dismissable">
                <h5>
                    <strong>ATENÇÃO:</strong> Esta solicitação já foi enviada ao setor de suprimentos responsável.
                </h5>
            </div>
            <h1 class="page-title">Visualizar solicitação de produto nº {{ $purchaseRequest->id }}</h1>
        @else
            <h1 class="page-title">Nova solicitação de produto</h1>
        @endif
    </div>
    @if (isset($purchaseRequest) && !$requestAlreadySent)
        <div class="col-md-6 pull-right" style="padding: 0">
            <x-modals.delete />
            <x-toast />

            <button data-cy="btn-delete-request" data-route="api.requests.destroy" data-name="{{ 'Solicitação de produto - Nº ' . $purchaseRequest->id }}"
                data-id="{{ $purchaseRequest->id }}" data-bs-toggle="modal" data-bs-target="#modal-delete" rel="tooltip" title="Excluir"
                class="btn btn-primary btn-danger pull-right">
                Excluir solicitação
            </button>
        </div>
    @endif

</div>

<hr style="margin-top:5px; margin-bottom:30px;">


<div class="box-content">
    <form enctype="multipart/form-data" class="form-validate" id="request-form" method="POST"
        action="@if (isset($purchaseRequest) && !$isCopy) {{ route('requests.product.update', ['type' => $purchaseRequest->type, 'id' => $id]) }}
                    @else {{ route('requests.product.store') }} @endif">
        @csrf

        <input type="hidden" name="type" value="product">

        <div class="row center-block" style="padding-bottom: 10px;">
            <h3>Contrante</h3>
        </div>

        {{-- CENTRO DE CUSTOS --}}
        <x-CostCenterApportionment :purchaseRequest="$purchaseRequest" />

        <hr>

        <div class="full-product-line product-form" data-product="1">
            <div class="row center-block" style="padding-bottom: 10px;">
                <h3>Dados da solicitação</h3>
            </div>

            @if ($currentUser->can_associate_requester)
                <div class="row" style="margin-bottom: 15px;">
                    <div class="col-sm-4 form-group">
                        <label for="requester" style="display:block;" class="regular-text">
                            Atribuir um solicitante
                        </label>
                        <select name="requester_person_id" class='select2-me' data-cy="requester" data-placeholder="Escolha um colaborador" style="width:100%;">
                            <option value=""></option>
                            @foreach ($people as $person)
                                @php
                                    if ($person->id === $currentUser->person->id) {
                                        continue;
                                    }
                                    $selected = $person->id === $purchaseRequest?->requester?->id;
                                @endphp
                                <option value="{{ $person->id }}" @selected($selected)>{{ $person->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
            @endif

            <div class="row" style="margin-bottom:10px; margin-top:5px;">

                <div class="col-sm-2">
                    <div class="form-group" style="display: flex">
                        <input name="is_only_quotation" type="checkbox" id="checkbox-only-quotation" data-cy="checkbox-only-quotation" class="checkbox-only-quotation no-validation"
                            style="margin:0" @checked((bool) $purchaseRequest?->is_only_quotation)>
                        <label for="checkbox-only-quotation" class="regular-text form-check-label" style="margin-left:10px;">Solicitação somente de cotação/orçamento</label>
                    </div>
                </div>

                {{-- RESPONSÁVEL CONTRATAÇÃO --}}
                <div class="col-sm-4">
                    <div class="form-group">
                        <label class="regular-text">Quem fez/fará esta compra de produto?</label>
                        <fieldset data-rule-required="true">
                            <div class="row">
                                <div class="col-sm-12">
                                    <input name="is_supplies_contract"value="1" class="radio-who-wants" required id="is-supplies-contract" data-cy="is-supplies-contract"
                                        type="radio" @checked(isset($purchaseRequest) && (bool) $purchaseRequest->is_supplies_contract)>
                                    <label class="form-check-label secondary-text" for="is-supplies-contract">Suprimentos</label>
                                    <input name="is_supplies_contract" value="0" class="radio-who-wants" type="radio" required id="is-area-contract"
                                        data-cy="is-area-contract" style="margin-left: 7px;" @checked(isset($purchaseRequest) && !(bool) $purchaseRequest->is_supplies_contract)>
                                    <label class="form-check-label secondary-text" for="is-area-contract">Eu (Área
                                        solicitante)</label>
                                </div>
                            </div>
                        </fieldset>
                    </div>
                </div>

                {{-- COMEX --}}
                <div class="col-sm-4">
                    <div class="form-group">
                        <label for="form-check" class="regular-text" style="padding-right:10px;">
                            Este(s) produto(s) será importado (COMEX)
                        </label>
                        <fieldset data-rule-required="true">
                            <div class="row">
                                <div class="col-sm-5">
                                    <input name="is_comex" data-cy="is-comex" value="1" @checked(isset($purchaseRequest) && (bool) $purchaseRequest->is_comex) class="radio-comex" type="radio" data-skin="minimal"
                                        required>
                                    <label class="form-check-label secondary-text" for="services" style="margin-right:15px;">Sim</label>
                                    <input name="is_comex" data-cy="is-not-comex" value="0" @checked(isset($purchaseRequest) && !(bool) $purchaseRequest->is_comex) class="radio-comex" type="radio"
                                        data-skin="minimal" required>
                                    <label class="form-check-label secondary-text" for="">Não</label>
                                </div>
                            </div>
                        </fieldset>
                    </div>
                </div>

            </div>

            <div class="row" style="margin-bottom:5px;">

                {{-- MOTIVO --}}
                <div class="col-sm-5">
                    <div class="form-group">
                        <label for="reason" class="regular-text">
                            Motivo da solicitação
                        </label>
                        <textarea data-rule-required="true" minlength="20" name="reason" id="reason" data-cy="reason" rows="4"
                            placeholder="Ex.: Devido aumento da demanda de produção, necessário a compra de uma máquina/equipamento." class="form-control text-area no-resize">{{ $purchaseRequest->reason ?? null }}</textarea>
                    </div>
                    <div class="small" style="margin-top: 10px; margin-bottom:20px;">
                        <p class="secondary-text">*Informe o motivo que você está solicitando essa compra.</p>
                    </div>
                </div>

                <div class="col-sm-2">
                    <div class="form-group">
                        <label for="desired-date" class="regular-text">Data desejada entrega do produto</label>
                        <input type="date" name="desired_date" id="desired-date" data-cy="desired-date" max="2100-01-01" class="form-control"
                            value="{{ $purchaseRequest->desired_date ?? null }}">
                    </div>
                </div>

                <div class="col-sm-6" style="margin-top:-6px;">
                    <div class="form-group product-input" id="product-input">
                        <label for="local-description" class="regular-text">
                            Em qual sala/prédio ficará o produto solicitado
                        </label>
                        <input name="local_description" value="@if (isset($purchaseRequest)) {{ $purchaseRequest->local_description }} @endif" type="text"
                            id="local-description" data-cy="local-description" placeholder="Informe em qual local / sala ficará o produto" class="form-control"
                            data-rule-required="true" data-rule-minlength="2">
                    </div>
                </div>

                {{-- DESCRICAO - (HIDDEN COM VALOR DEFAULT) --}}
                <div class="col-sm-7" hidden>
                    <div class="form-group">
                        <label for="description" class="regular-text">Descrição</label>
                        <textarea data-rule-required="true" minlength="20" name="description" id="description" data-cy="description" rows="4"
                            placeholder="Ex.: Contratação de serviço para consertar e verificar o estado dos ar-condicionados da HKM." class="form-control text-area no-resize">Solicitação de produto(s).</textarea>
                    </div>
                    <div class="small" style="color:rgb(85, 85, 85); margin-top: 5px; margin-bottom:20px;">
                        <p>* Descreva com detalhes o que deseja solicitar e informações úteis para uma possível cotação. </p>
                    </div>
                </div>

            </div>


            <div class="row mt-3">
                <div class="col-sm-6">
                    <div class="form-group">
                        <label for="support-links" class="regular-text">Links de apoio / sugestão
                        </label>
                        <textarea placeholder="Adicione link(s) de sugestão de compra, site do fornecedor, etc." rows="3" name="support_links" id="support-links" data-cy="support-links"
                            class="form-control text-area no-resize">{{ $purchaseRequest?->support_links ?? null }}</textarea>
                    </div>
                </div>

                <div class="col-sm-6">
                    <div class="form-group">
                        <label for="observation" class="regular-text"> Observação </label>
                        <textarea name="observation" id="request-observation" data-cy="request-observation" rows="3" placeholder="Informações complementares desta solicitação"
                            class="form-control text-area no-resize">{{ $purchaseRequest?->observation ?? null }}</textarea>
                    </div>
                </div>
            </div>

            <div class="payment-block">
                <div class="row center-block" style="padding-bottom: 10px;">
                    <h3>Pagamento</h3>
                </div>

                <div class="row" style="margin-bottom: -50;">
                    {{-- CONDIÇÃO DE PAGAMENTO --}}
                    <div class="col-sm-2">
                        <div class="form-group">
                            <label class="regular-text">Condição de pagamento</label>
                            <select name="product[payment_info][payment_terms]" id="payment-terms" data-cy="payment-terms"
                                class='select2-me product[payment_info][payment_terms]' style="width:100%; padding-top:2px;" data-placeholder="Escolha uma opção">
                                <option value=""></option>
                                @foreach ($paymentTerms as $paymentTerm)
                                    <option value="{{ $paymentTerm->value }}" @selected($paymentTerm->value === $selectedPaymentTerm?->value)>
                                        {{ $paymentTerm->label() }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    {{-- VALOR TOTAL --}}
                    <div class="col-sm-2">
                        <div class="form-group">
                            <label for="format-amount" class="regular-text">Valor total do(s) produto(s)</label>
                            <div class="input-group">
                                <span class="input-group-text">R$</span>
                                <input type="text" id="format-amount" name="format-amount" data-cy="format-amount" placeholder="0.00" class="form-control format-amount"
                                    value="{{ str_replace('.', ',', $purchaseRequestProductAmount) }}">
                                <input type="hidden" name="product[amount]" id="amount" data-cy="amount" class="amount no-validation"
                                    value="{{ $purchaseRequestProductAmount }}">
                            </div>
                        </div>
                    </div>

                    {{-- FORMA DE PAGAMENTO --}}
                    <div class="col-sm-2">
                        <div class="form-group">
                            <label class="regular-text">Forma de pagamento</label>
                            <select name="product[payment_info][payment_method]" id="payment-method" data-cy="payment-method" class='select2-me payment-method'
                                style="width:100%; padding-top:2px;" data-placeholder="Escolha uma opção">
                                <option value=""></option>
                                @foreach ($paymentMethods as $paymentMethod)
                                    <option value="{{ $paymentMethod['value'] }}" @selected($paymentMethod['value'] === $selectedPaymentMethod?->value)>
                                        {{ $paymentMethod['text'] }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <input type="hidden" id="product-payment-info-id" data-cy="product-payment-info-id" class="no-validation"
                        value="{{ $purchaseRequest?->product?->paymentInfo?->id ?? null }}" name="product[payment_info][id]">

                    {{-- Nº PARCELAS --}}
                    <div class="col-sm-1">
                        <div class="form-group">
                            <label class="control-label regular-text">Nº parcelas</label>
                            <input type="text" class="form-control format-installments-number" name="installments-number" placeholder="Ex: 24"
                                value="{{ $productQuantityOfInstallments }}">
                            <input type="hidden" name="product[quantity_of_installments]" id="installments-number" data-cy="installments-number"
                                class="installments-number no-validation" value="{{ $productQuantityOfInstallments }}">
                        </div>
                    </div>

                    {{-- DESCRICAO DADOS PAGAMENTO --}}
                    <div class="col-sm-5" style="margin-bottom: -20px;">
                        <div class="form-group">
                            <label for="payment-info-description" class="regular-text">
                                Detalhes do pagamento
                            </label>
                            <textarea name="product[payment_info][description]" id="payment-info-description" data-cy="payment-info-description" rows="3"
                                placeholder="Ex: chave PIX, dados bancários do fornecedor, etc." class="form-control text-area no-resize">{{ $purchaseRequest->product->paymentInfo->description ?? null }}</textarea>
                        </div>
                    </div>
                </div>

                {{-- TABLE PARCELAS --}}
                <div class="row" style="display:flex; align-items:center; margin-bottom:7px;">
                    <h3 class="col-sm-6">
                        <i class="fa fa-dollar"></i>
                        Parcelas
                    </h3>
                </div>
                <div class="row">
                    <div class="col-sm-12">
                        <div class="box">
                            <div class="box-content nopadding regular-text">
                                <table class="table table-hover table-nomargin table-striped" id="installments-table-striped">
                                    <thead>
                                        <tr>
                                            <th class="col-sm-2">
                                                <i class="fa-solid fa-calendar" style="padding-right:5px;"></i>
                                                Vencimento
                                            </th>
                                            <th class="col-sm-2">
                                                <i class="fa-solid fa-money-bill" style="padding-right:5px;"></i>
                                                Valor
                                            </th>
                                            <th class='col-sm-4 hidden-350'>
                                                <i class="fa fa-pencil-square" style="padding-right:5px;"></i>
                                                Observação
                                            </th>
                                            <th class='col-sm-2 hidden-1024'>
                                                <i class="fa fa-tasks" style="padding-right:5px;"></i>
                                                Status
                                            </th>
                                            <th class='col-sm-2 hidden-480'>
                                                <i class="fa fa-sliders" style="padding-right:5px;"></i>
                                                Ações
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
                                <div class="hidden-installments-inputs-container">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- FORNECEDORES COM PRODUTOS --}}
            <div class="supplier-container">
                <h3 class="supplier-title"><i class="glyphicon glyphicon-briefcase"></i> Fornecedor(es)</h3>

                @php $supplierIndex = 0; @endphp
                @if ($issetPurchaseRequest)
                    @foreach ($productSuppliers as $supplierId => $products)
                        <x-purchase-request.product.supplier :productCategories="$productCategories" :suppliers="$suppliers" :supplierId="$supplierId" :products="$products" :supplierIndex="$supplierIndex" :isCopy="$isCopy" />
                        @php $supplierIndex++; @endphp
                    @endforeach
                @else
                    <x-purchase-request.product.supplier :productCategories="$productCategories" :suppliers="$suppliers" :supplierIndex="$supplierIndex" />
                @endif

                <button type="button" style="margin-top:15px;" class="btn btn-primary btn-small add-supplier-btn">
                    <i class="glyphicon glyphicon-plus"></i>
                    <strong>Adicionar fornecedor</strong>
                </button>
            </div>
        </div>

        <hr style="margin-top: 30px; margin-bottom: 25px;">

        {{-- ARQUIVOS --}}
        <div class="row justify-content-center">
            <div class="col-sm-12">
                <x-RequestFiles :purchaseRequestId="$purchaseRequest?->id" :isCopy="$isCopy" />
            </div>
        </div>

        <div class="form-actions pull-right" style="margin-top:50px; padding-bottom:20px">
            @if (!$hasSentRequest)
                <input type="hidden" name="action" id="action" value="">

                <button type="submit" class="btn btn-primary btn-draft" style="margin-right: 10px">
                    Salvar rascunho
                </button>

                <button type="submit" name="submit_request" class="btn btn-primary btn-success btn-submit-request" value="submit-request">
                    Salvar e enviar solicitação
                </button>
            @endif

            @if ($hasSentRequest)
                <a href="{{ route('requests.index.own') }}" class="btn btn-primary btn-large">VOLTAR</a>
            @endif
        </div>
    </form>

    <x-modals.supplier-register />

    <x-modals.edit-product-installment :statusValues="$statusValues" />

</div>

@push('scripts')
    <script type="module" src="{{ asset('js/purchase-request/product-suggestions-from-api.js') }}"></script>
    <script type="module" src="{{ asset('js/supplies/select2-custom.js') }}"></script>

    <script type="module">
        $(() => {
            const $productQuantity = $('.product-quantity');

            $productQuantity.each(function() {
                const maskOptions = {
                    mask: Number,
                    min: 1,
                    max: 10000,
                    thousandsSeparator: ''
                };

                const mask = IMask(this, maskOptions);
            });
        });
    </script>

    <script type="module">
        $(document).ready(function() {
            const hasSentRequest = @json($hasSentRequest);

            const $amount = $('.amount');
            const $serviceAmount = $('#format-amount');
            const $phoneNumber = $('#phone-number');

            // masks
            $phoneNumber.imask({
                mask: [{
                        mask: '(00) 0000-0000'
                    },
                    {
                        mask: '(00) 00000-0000'
                    }
                ]
            });

            $serviceAmount.imask({
                mask: Number,
                scale: 2,
                thousandsSeparator: '.',
                normalizeZeros: true,
                padFractionalZeros: true,
                min: 0,
                max: 1000000000,
            });

            // mascaras pra modal edicao
            const $editValueInputModal = $('#edit-value');
            const $editValueHiddenModal = $('#edit-value-hidden');

            const editValueInputModalMasked = $editValueInputModal.imask({
                mask: Number,
                scale: 2,
                thousandsSeparator: '.',
                normalizeZeros: true,
                padFractionalZeros: true,
                min: 0,
                max: 1000000000,
            });

            const $inputInstallmentsNumber = $('.installments-number');
            const $formatInputInstallmentsNumber = $('.format-installments-number');

            $formatInputInstallmentsNumber.imask({
                mask: IMask.MaskedRange,
                from: 1,
                to: 60,
                autofix: 'pad'
            });

            const $filesGroup = $('fieldset#files-group');
            const csrfToken = $('meta[name="csrf-token"]').attr('content');

            // muda data desejada mínima quando serviço já prestado
            const $desiredDate = $('#desired-date');
            const currentDate = moment();
            const minInitialDate = moment('2020-01-01').format('YYYY-MM-DD');

            $desiredDate.attr('min', currentDate.format('YYYY-MM-DD'))

            // trata valor serviço mascara
            $serviceAmount.on('input', function() {
                const formattedValue = $(this).val();
                if (formattedValue !== null) {
                    const processedValue = formattedValue.replace(/[^0-9,]/g, '').replace(/,/g, '.');
                    const rawValue = parseFloat(processedValue);
                    if (!isNaN(rawValue)) {
                        $amount.val(rawValue.toFixed(2)).trigger('change');
                    }
                }
            });

            // sim está repetindo muito...

            // trata qtd parcelas mascara
            $formatInputInstallmentsNumber.on('input', function() {
                const formattedValue = $(this).val();
                if (formattedValue !== null) {
                    const rawValue = parseInt(formattedValue);
                    if (!isNaN(rawValue)) {
                        $inputInstallmentsNumber.val(rawValue).trigger('change');
                    }
                }
            });
            // ---

            // sim está repetindo muito...

            // trata valor serviço mascara
            $editValueInputModal.on('input', function() {
                const formattedValue = $(this).val();
                if (formattedValue !== null) {
                    const processedValue = editValueInputModalMasked.unmaskedValue;
                    if (!isNaN(processedValue)) {
                        $editValueHiddenModal.val(processedValue);
                    }
                }
            });
            // ---

            // sim está repetindo muito...

            const $selectSupplier = $('.select-supplier');
            const $paymentMethod = $('#payment-method');
            const $paymentInfo = $('.payment-info');

            const purchaseRequest = @json($purchaseRequest);
            const isRequestCopy = @json($isCopy);
            const isNotCopyAndIssetPurchaseRequest = !isRequestCopy && purchaseRequest;

            // dataTable config - parcelas
            const $installmentsTable = $('#installments-table-striped').DataTable({
                defer: true,
                data: purchaseRequest?.product?.installments || [],
                columns: [{
                        data: "expire_date",
                        render: function(data, type, row, meta) {
                            if (!data) {
                                return "";
                            }
                            const formattedDate = moment(data, "YYYY/MM/DD").format("DD/MM/YYYY");
                            return formattedDate || "";
                        }
                    },
                    {
                        data: "value",
                        render: function(data, type, row, meta) {
                            const dataWithR$ = "R$" + data;
                            return dataWithR$;
                        }
                    },
                    {
                        data: "observation",
                    },
                    {
                        data: "status",
                    },
                    {
                        data: null,
                        render: function(data, type, row, meta) {
                            const btnEdit = $(
                                '<div><button type="button" rel="tooltip" title="Editar Parcela" class="btn btn-edit-installment"><i class="fa fa-edit"></i></button></div>'
                            );
                            btnEdit.find('button').prop('disabled', hasSentRequest);

                            return btnEdit.html();
                        }
                    }
                ],
                orderable: false,
                paging: true,
                pageLength: 12,
                info: false,
                searching: false,
                bLengthChange: false,
                language: {
                    emptyTable: "Nenhuma parcela adicionada.",
                    paginate: {
                        previous: "Anterior",
                        next: "Próximo",
                    },
                },
                order: [
                    [0, 'desc']
                ],
                createdRow: function(row, data, dataIndex) {
                    const hiddenFormattedDate = $(row).data('hidden-date');
                    $(row).attr('data-hidden-date', hiddenFormattedDate);
                }
            });

            const hiddenInputsContainer = $('.hidden-installments-inputs-container');

            function fillHiddenInputsWithRowData() {
                const tableData = $installmentsTable.data();
                hiddenInputsContainer.empty();
                tableData.each(function(rowData, index) {
                    const expireDate = rowData.expire_date;
                    const value = rowData.value;
                    const observation = rowData.observation;
                    const status = rowData.status;

                    const idInput = document.createElement('input');
                    idInput.type = 'number';
                    idInput.name = 'product[product_installments][' + index + '][id]';
                    idInput.value = isNotCopyAndIssetPurchaseRequest ? purchaseRequest?.product
                        ?.installments[index]?.id : null;
                    idInput.hidden = true;
                    idInput.className = "no-validation";
                    idInput.setAttribute('data-cy', 'product-product_installments-' + index + '-id');

                    const expireDateInput = document.createElement('input');
                    expireDateInput.type = 'date';
                    expireDateInput.name = 'product[product_installments][' + index +
                        '][expire_date]';
                    expireDateInput.value = expireDate;
                    expireDateInput.hidden = true;
                    expireDateInput.className = "no-validation";
                    expireDateInput.setAttribute('data-cy', 'product-product_installments-' + index +
                        '-expire_date');

                    const valueInput = document.createElement('input');
                    valueInput.type = 'number';
                    valueInput.name = 'product[product_installments][' + index + '][value]';
                    valueInput.value = value;
                    valueInput.hidden = true;
                    valueInput.className = "no-validation";
                    valueInput.setAttribute('data-cy', 'product-product_installments-' + index +
                        '-value');

                    const observationInput = document.createElement('input');
                    observationInput.type = 'text';
                    observationInput.name = 'product[product_installments][' + index +
                        '][observation]';
                    observationInput.value = observation;
                    observationInput.hidden = true;
                    observationInput.className = "no-validation";
                    observationInput.setAttribute('data-cy', 'product-product_installments-' + index +
                        '-observation');

                    const statusInput = document.createElement('input');
                    statusInput.type = 'text';
                    statusInput.name = 'product[product_installments][' + index + '][status]';
                    statusInput.value = status;
                    statusInput.hidden = true;
                    statusInput.className = "no-validation";
                    statusInput.setAttribute('data-cy', 'product-product_installments-' + index +
                        '-status');

                    hiddenInputsContainer.append(
                        idInput,
                        expireDateInput,
                        valueInput,
                        observationInput,
                        statusInput,
                    );
                });
            }

            function deleteHiddenInputs(row) {
                const index = $installmentsTable.row(row).index();
                $('input[name^="product[product_installments][' + index + ']"]').remove();
            }

            function updateHiddenInputIndex() {
                $('input[name^="product[product_installments]"]').each(function() {
                    const currentName = $(this).attr('name');
                    const newIndex = currentName.replace(/\[(\d+)\]/, function(match, index) {
                        const currentIndex = parseInt(index);
                        return '[' + (currentIndex - 1) + ']';
                    });
                    $(this).attr('name', newIndex);
                });
            }

            fillHiddenInputsWithRowData();


            // verifica AREA ou SUPRIMENTOS (desabilitar pagamento)
            const $radioIsContractedBySupplies = $('.radio-who-wants');
            const $supplierBlock = $('.supplier-block');
            const $paymentBlock = $('.payment-block');

            const labelSuppliersSuggestion = "Deseja indicar um fornecedor?";
            const labelSuppliersChoose = "Fornecedor - CNPJ / Razão Social";

            // desabilita pagamento ao entrar em register
            $paymentBlock
                .find('input, textarea')
                .prop('disabled', true);

            $paymentBlock
                .find('select')
                .prop('disabled', true)
                .trigger('change.select2');

            $radioIsContractedBySupplies.on('change', function() {
                const isContractedBySupplies = $(this).val() === "1";

                // muda label
                const supplierSelect = $('select.select-supplier');
                const newLabel = isContractedBySupplies ? labelSuppliersSuggestion : labelSuppliersChoose;

                supplierSelect.siblings('label').text(newLabel);

                supplierSelect.before().removeAttr('data-rule-required');

                // muda label data desejada
                const labelDesiredDateAlreadyProvided = "Data da entrega do produto";
                const labelDesiredDateDefault = "Data desejada entrega do produto";
                const newLabelDate = isContractedBySupplies ? labelDesiredDateDefault : labelDesiredDateAlreadyProvided;
                $desiredDate.siblings('label').text(newLabelDate);

                isContractedBySupplies ? $desiredDate.removeRequired() : $desiredDate.makeRequired()

                // desabilita e limpa inputs pagamento
                $paymentBlock
                    .find('input, textarea')
                    .prop('disabled', isContractedBySupplies);

                $paymentBlock
                    .find('select')
                    .prop('disabled', isContractedBySupplies)
                    .trigger('change.select2');

                if (isContractedBySupplies) {
                    supplierSelect.removeRequired();
                    supplierSelect.closest('.form-group').removeClass('has-error');
                    $supplierBlock.find('.help-block').remove();

                    $paymentBlock
                        .find('input, textarea')
                        .val('');
                    $paymentBlock
                        .find('select')
                        .val('')
                        .trigger('change.select2');

                    $installmentsTable.clear().draw();
                    hiddenInputsContainer.empty();

                    return;
                }

                supplierSelect.makeRequired();
            });

            if (!hasSentRequest || $radioIsContractedBySupplies.is(':checked')) {
                $radioIsContractedBySupplies.filter(':checked').trigger('change');
            }

            const editButton =
                '<button type="button" rel="tooltip" title="Editar Parcela" class="btn btn-edit-installment"><i class="fa fa-edit"></i></button>';

            function generateInstallments(numberOfInstallments) {
                const installmentValue = ($amount.val() / numberOfInstallments).toFixed(2);

                const installmentsData = [];
                const rowsData = [];

                for (let i = 1; i <= numberOfInstallments; i++) {
                    const installmentDate = new Date();
                    const formattedDate = installmentDate.toLocaleDateString('pt-BR');
                    const hiddenFormattedDate = installmentDate.toISOString();

                    const installmentData = {
                        expire_date: "",
                        value: installmentValue,
                        observation: "Parcela " + i + "/" + numberOfInstallments,
                        status: "PENDENTE",
                        //installmentDate
                    };

                    installmentsData.push(installmentData);
                    rowsData.push(installmentData);
                }

                for (const installmentData of installmentsData) {
                    const rowNode = $installmentsTable.row.add(installmentData).node();
                    $(rowNode).children('td').eq(0).attr('data-hidden-date', installmentData[5]);
                }

                fillHiddenInputsWithRowData();

                //$installmentsTable.draw();
                $installmentsTable.clear().rows.add(rowsData).draw();
            }

            let selectedRowIndex = null;

            $('#installments-table-striped tbody').on('click', 'tr', function(event) {
                event.preventDefault();

                if ($(event.target).closest('.btn-edit-installment').length) {
                    const rowData = $installmentsTable.row(this).data();
                    selectedRowIndex = $installmentsTable.row(this).index();
                    openModalForEdit(rowData);
                }
            });

            const statusValues = @json($statusValues);

            // modal edit installment
            function openModalForEdit(rowData) {
                const modalEditProductInstallment = bootstrap.Modal.getOrCreateInstance('#modal-edit-product-installment');
                modalEditProductInstallment.show();

                const expireDate = $('#edit-expire-date');
                const $editValue = $('#edit-value');
                const status = $('#edit-status');
                const observation = $('#edit-observation');

                if (rowData.expire_date) {
                    const formattedDate = new Date(rowData.expire_date.split('/').reverse().join('-'));
                    expireDate.val(formattedDate.toISOString().split('T')[0]);
                }

                editValueInputModalMasked.value = rowData.value.replace('.', ',');
                $editValue.val(editValueInputModalMasked.value);

                $editValueInputModal.trigger('input');

                const statusToModal = (statusValues.find((status) => status.description === rowData.status)).id;
                status.val(statusToModal).trigger('change');

                observation.val(rowData.observation);

                $('#form-modal-edit-product-installment').one('submit', function(event) {
                    event.preventDefault();

                    const expireDate = $('#edit-expire-date').val();

                    const value = parseFloat($('#edit-value-hidden').val());
                    const status = $('#edit-status').find(':selected').text();
                    const observation = $('#edit-observation').val();

                    // insere valores editados na tabela
                    if (selectedRowIndex !== null) {
                        $installmentsTable.cell(selectedRowIndex, 0).data(expireDate);
                        $installmentsTable.cell(selectedRowIndex, 1).data(value.toFixed(2));
                        $installmentsTable.cell(selectedRowIndex, 2).data(observation);
                        $installmentsTable.cell(selectedRowIndex, 3).data(status);
                        $installmentsTable.cell(selectedRowIndex, 4).data(editButton);
                        $installmentsTable.draw();
                    }

                    selectedRowIndex = null;

                    fillHiddenInputsWithRowData();

                    // limpa valores dos inputs (será repopulado na abertura do modal)
                    $(this).find('input, select').val('');
                    $(this).find('textarea').val('');

                    $('#status').val('').trigger('change');

                    const modalEditProductInstallment = bootstrap.Modal.getOrCreateInstance('#modal-edit-product-installment');
                    modalEditProductInstallment.hide();
                });
            }

            // gerar parcelas a partir do change de varios inputs
            $amount.add($inputInstallmentsNumber).on('change', function() {
                const changeableInputs = [
                    $amount.val(),
                    $inputInstallmentsNumber.val()
                ];

                if (!changeableInputs.every(Boolean)) {
                    return;
                }
                const numberOfInstallments = $inputInstallmentsNumber.val();
                $installmentsTable.clear();
                generateInstallments(numberOfInstallments);
            });

            const $paymentTerm = $('#payment-terms');
            const $paymentInfoDescription = $('#payment-info-description');

            $paymentTerm.on('change', function() {
                const paymentTerm = $(this).val() === "anticipated";

                if (!paymentTerm) {
                    $serviceAmount
                        .add($paymentMethod)
                        .add($formatInputInstallmentsNumber)
                        .add($paymentInfoDescription)
                        .removeRequired()
                        .closest('.form-group')
                        .removeClass('has-error');

                    $paymentBlock.find('.help-block').remove();

                    return;
                }

                $serviceAmount
                    .add($paymentMethod)
                    .add($formatInputInstallmentsNumber)
                    .add($paymentInfoDescription)
                    .makeRequired();

            }).trigger('change');

            if (!hasSentRequest || $paymentTerm.filter(':selected').val() === "anticipated") {
                $paymentTerm.filter(':selected').trigger('change.select2');
            }


            const selectedPaymentMethod = @json($selectedPaymentMethod);
            const paymentMethodsIsComex = @json($paymentMethods);

            const paymentMethodsNotComex = paymentMethodsIsComex
                .filter(function({
                    value
                }) {
                    return value !== 'internacional';
                });

            const $radioComex = $('.radio-comex');

            $radioComex.on('change', function() {
                const isComex = $(this).val() === "1";

                $paymentMethod.empty();

                const emptyOption = new Option();
                $paymentMethod.append(emptyOption);

                if (!isComex) {
                    paymentMethodsNotComex.forEach(function({
                        text,
                        value
                    }) {
                        const option = new Option(text, value);
                        if (value === selectedPaymentMethod) {
                            option.selected = true;
                        }
                        $paymentMethod.append(option);
                    });
                } else {
                    paymentMethodsIsComex.forEach(function({
                        text,
                        value
                    }) {
                        const option = new Option(text, value);
                        if (value === selectedPaymentMethod) {
                            option.selected = true;
                        }
                        $paymentMethod.append(option);
                    });
                }

                // Destruir e recriar o Select2
                $paymentMethod.select2('destroy');
                $paymentMethod.select2();
            });

            if (!hasSentRequest && $radioComex.is(':checked')) {
                $radioComex.filter(':checked').trigger('change');
            }


            // add supplier
            const $supplierContainer = $('.supplier-container');
            const $addSupplierBtn = $('.add-supplier-btn');

            function checkSuppliersContainerLength() {
                const suppliersCount = $supplierContainer.find('.supplier-block').length;
                const suppliersCountGreaterThanOne = suppliersCount > 1;

                $('.delete-supplier').prop('disabled', !suppliersCountGreaterThanOne).toggleClass('disabled-button',
                    !suppliersCountGreaterThanOne);
            }

            const $productContainer = $('.product-container');

            function checkProductRows() {
                $('.supplier-block').each(function() {
                    const $productContainer = $(this).find('.product-container');
                    const $productRow = $productContainer.find('.product-row');
                    const productRowCount = $productRow.length;

                    $productContainer.find('.delete-product').prop('disabled', productRowCount <= 1);
                });
            }

            checkSuppliersContainerLength();
            checkProductRows();

            $(document).on('click', '.add-supplier-btn', function() {
                @php
                    $viewPath = 'components.purchase-request.product.supplier.index';
                    $viewWithParams = view($viewPath, compact('productCategories', 'suppliers'));
                @endphp
                const $newContainer = $(@json($viewWithParams->render()));
                const $currentSupplierBlock = $('.supplier-container').find('.supplier-block').last();

                const [_, ...rest] = $newContainer
                    .find('.product-row').toArray();
                rest.forEach(element => {
                    $(element).remove();
                });

                $newContainer.find(
                    'select[name^="purchase_request_products"], input[name^="purchase_request_products"]'
                ).each(function() {
                    //const oldName = $(this).attr('name');
                    const lastFoundClass = Array.from(this.classList).at(-1);
                    const oldName = $currentSupplierBlock.find('.' + lastFoundClass).last().attr(
                        'name');
                    const regexNewName = /purchase_request_products\[(\d+)\](.*)/;
                    const lastIndex = Number(oldName.match(regexNewName).at(1));
                    const anotherRegex = /\[\d+\]/;

                    const newName = oldName
                        .replaceAll(/\[\d+\]/g, `[0]`)
                        .replace(/\[\d+\]/, `[${lastIndex + 1}]`);

                    $(this).attr('name', newName);
                });

                $newContainer.find("input, select").val("");
                $newContainer.find('.select2-container').remove();
                $newContainer.find('.select2-me').select2();

                // $newContainer.find('select.select-supplier').makeRequired();

                $('.supplier-block').last().after($newContainer);
                $newContainer.find('.delete-supplier').removeAttr('hidden');

                $newContainer.find('[data-rule-required]').makeRequired();

                checkSuppliersContainerLength();
                checkProductRows();

                const $selectSupplier = $newContainer.find('select').first();

                addBtnSupplierSelect($selectSupplier);

                if (!$radioIsContractedBySupplies.is(':checked')) {
                    return;
                }

                $radioIsContractedBySupplies.filter(':checked').trigger('change');
            });

            $(document).on('click', '.delete-supplier', function(event) {
                event.preventDefault();

                const $supplierBlock = $(this).closest('.supplier-block');

                const title = "Atenção!"
                const message = "<p>Ao remover este fornecedor, todos os produtos associados serão excluídos. Esta ação não poderá ser desfeita.</p>";
                $.fn.showModalAlert(title, message, () => {
                    $supplierBlock.remove();

                    // atualiza os índices dos fornecedores restantes
                    const $supplierBlocks = $('.supplier-block');
                    $supplierBlocks.each(function(index) {
                        $(this).find(
                            'select[name^="purchase_request_suppliers"], input[name^="purchase_request_suppliers"]'
                        ).each(function() {
                            const oldName = $(this).attr('name');
                            const regexNewName =
                                /purchase_request_suppliers\[(\d+)\](.*)/;
                            const newName = oldName.replace(
                                regexNewName,
                                `purchase_request_suppliers[${index}]$2`
                            );
                            $(this).attr('name', newName);
                        });
                    });

                    checkSuppliersContainerLength();
                    checkProductRows();
                });
            });



            $(document).on('click', '.add-product-btn', function() {
                @php
                    $viewPath = 'components.purchase-request.product.product.index';
                    $viewWithParams = view($viewPath, compact('productCategories'));
                @endphp
                const newRow = $(@json($viewWithParams->render()));
                const $currentSupplierBlock = $(this).closest('.supplier-block');

                newRow.find(
                    'select[name^="purchase_request_products"], input[name^="purchase_request_products"]'
                ).each(function() {
                    const lastFoundClass = Array.from(this.classList).at(-1);
                    const $lastProductRow = $currentSupplierBlock.find('.product-row').last();
                    const oldName = $lastProductRow.find('.' + lastFoundClass).last().attr('name');
                    const regexNewName = /\[products\]\[(\d+)\]/;
                    const lastIndex = Number(oldName.match(regexNewName).at(1));
                    const newName = oldName.replace(regexNewName, `[products][${lastIndex + 1}]`);
                    $(this).attr('name', newName);
                    $(this).attr('data-cy', newName);
                });

                newRow.find("input, select").val("");
                newRow.find('.select2-container').remove();
                newRow.find('.select2-me').select2();

                newRow.find('[data-rule-required]').makeRequired();

                $(this).siblings('.product-row').last().after(newRow);
                newRow.find('.delete-product').removeAttr('hidden');

                checkProductRows();
            });

            $(document).on('click', '.delete-product', function() {
                $(this).closest('.product-row').remove();

                checkProductRows();
            });

            // salvar rascunho ou enviar
            const $btnSubmitRequest = $('.btn-submit-request');
            const $sendAction = $('#action');

            $btnSubmitRequest.on('click', function(event) {
                event.preventDefault();

                const title = "Atenção!"
                const message =
                    "Esta solicitação será <strong>enviada</strong> para o setor de <strong>suprimentos responsável</strong>. <br><br> Deseja confirmar esta ação?";
                $.fn.showModalAlert(title, message, () => {
                    $sendAction.val('submit-request');
                    $('#request-form').trigger('submit');
                });
            });

            // desabilita todos os campos do form caso solicitacao ja enviada
            if (hasSentRequest) {
                $('#request-form')
                    .find('input, textarea, checkbox')
                    .prop('disabled', hasSentRequest);

                $('#request-form')
                    .find('select')
                    .prop('disabled', hasSentRequest);

                $('.file-remove').prop('disabled', hasSentRequest);

                $('.add-supplier-btn').prop('disabled', hasSentRequest);
                $('.delete-supplier').prop('disabled', hasSentRequest);
                $('.delete-supplier').attr('disabled', hasSentRequest);

                $('.add-product-btn').prop('disabled', hasSentRequest);
                $('.delete-product').prop('disabled', hasSentRequest);

                $('.add-cost-center-btn').prop('disabled', hasSentRequest);
                $('.delete-cost-center').prop('disabled', hasSentRequest);
            }
        });
    </script>
@endpush
