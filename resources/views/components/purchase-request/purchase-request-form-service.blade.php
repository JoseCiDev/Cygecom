@php
    use App\Enums\PurchaseRequestStatus;
    use App\Enums\PaymentMethod;

    $currentUser = auth()->user();

    $issetPurchaseRequest = isset($purchaseRequest);
    $purchaseRequest ??= null;
    $isCopy ??= null;
    $serviceInstallments = $purchaseRequest?->service?->installments;
    $purchaseRequestServicePrice = $purchaseRequest?->service?->price === null ? null : (float) $purchaseRequest?->service?->price;
    $serviceQuantityOfInstallments = $purchaseRequest?->service?->quantity_of_installments === null ? null : (int) $purchaseRequest?->service?->quantity_of_installments;
    $serviceName = $purchaseRequest?->service?->name && !$isCopy ? $purchaseRequest?->service?->name : null;

    $selectedPaymentMethod = null;
    $selectedPaymentTerm = null;
    if (isset($purchaseRequest->service) && isset($purchaseRequest->service->paymentInfo)) {
        $selectedPaymentMethod = $purchaseRequest->service->paymentInfo->payment_method;
        $selectedPaymentTerm = $purchaseRequest->service->paymentInfo->payment_terms;
    }

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
        #service-title {
            border: 1px solid rgb(195, 195, 195);
        }

        #service-title::placeholder {
            font-size: 16px;
        }

        #service-title {
            font-size: 20px;
        }

        .label-service-title {
            font-size: 16px;
        }

        .cost-center-container {
            margin-bottom: 5px;
        }

        h4 {
            font-size: 20px;
        }

        div.dataTables_wrapper div.dataTables_length,
        div.dataTables_wrapper div.dataTables_info {
            display: none;
            /* remover espao em branco do datatables*/
        }
    </style>
@endpush

<div class="row" style="margin: 0 0 30px;">

    <div class="col-sm-6" style="padding: 0">
        @if ($hasRequestNotSent)
            <h1 class="page-title">Editar solicitação de serviço pontual nº {{ $purchaseRequest->id }}</h1>
        @elseif ($hasSentRequest)
            <div class="alert alert-info alert-dismissable">
                <h5>
                    <strong>ATENÇÃO:</strong> Esta solicitação já foi enviada ao setor de suprimentos responsável.
                </h5>
            </div>
            <h1 class="page-title">Visualizar solicitação de serviço pontual nº {{ $purchaseRequest->id }}</h1>
        @else
            <h1 class="page-title">Nova solicitação de serviço pontual</h1>
        @endif
    </div>
    @if (isset($purchaseRequest) && !$requestAlreadySent)
        <div class="col-md-6 pull-right" style="padding: 0">
            <x-modals.delete />

            <button data-cy="btn-delete-request" data-route="api.requests.destroy" data-name="{{ 'Solicitação de serviço pontual - Nº ' . $purchaseRequest->id }}"
                data-id="{{ $purchaseRequest->id }}" data-bs-toggle="modal" data-bs-target="#modal-delete" rel="tooltip" title="Excluir"
                class="btn btn-primary btn-danger pull-right">
                Excluir solicitação
            </button>
        </div>
    @endif
</div>

<hr style="margin-top:5px; margin-bottom:30px;">

<div class="box-content">
    <form enctype="multipart/form-data" class="form-validate" id="request-form" data-cy="request-form" method="POST"
        action="@if (isset($purchaseRequest) && !$isCopy) {{ route('requests.service.update', ['id' => $id]) }}
                    @else {{ route('requests.service.store') }} @endif">
        @csrf

        <input type="hidden" name="type" value="service" class="no-validation" data-cy="type">

        {{-- NOME SERVIÇO --}}
        <div class="row service-title-container" style="margin-bottom: 25px; margin-top:18px;">
            <div class="col-sm-6 contract-title">
                <div class="form-group">
                    <label for="service-title" class="regular-text label-service-title">Nome serviço pontual: </label>
                    <input type="text" id="service-title" data-cy="service-title" name="service[name]" placeholder="Ex: Serviço manutenção elevador - 07/23 - HKM"
                        class="form-control" data-rule-required="true" minlength="15" maxlength="200" value="{{ $serviceName }}">
                </div>
            </div>
        </div>

        <div class="row center-block" style="padding-bottom: 10px;">
            <h3>Contratante</h3>
        </div>

        {{-- CENTRO DE CUSTOS --}}
        <x-CostCenterApportionment :purchaseRequest="$purchaseRequest" />

        <hr>

        <div class="full-product-line product-form">
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
                                <option value="{{ $person->id }}" @selected($selected)>{{ $person->name }}</option>
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
                <div class="col-sm-3">
                    <div class="form-group">
                        <label for="form-check" class="regular-text" style="padding-right:10px;">
                            Quem fez/fará a contratação deste serviço?
                        </label>
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
                            Este serviço será importado (COMEX)?
                        </label>
                        <fieldset data-rule-required="true">
                            <div class="row">
                                <div class="col-sm-5">
                                    <input name="is_comex" data-cy="is_comex_true" value="1" @checked(isset($purchaseRequest) && (bool) $purchaseRequest->is_comex) class="radio-comex" type="radio"
                                        data-skin="minimal" required>
                                    <label class="form-check-label secondary-text" for="services" style="margin-right:15px;">Sim</label>
                                    <input name="is_comex" data-cy="is_comex_false" value="0" @checked(isset($purchaseRequest) && !(bool) $purchaseRequest->is_comex) class="radio-comex" type="radio"
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
                        <label for="reason" class="regular-text"> Motivo da solicitação </label>
                        <textarea data-rule-required="true" minlength="20" name="reason" id="reason" data-cy="reason" rows="4" class="form-control text-area no-resize">{{ $purchaseRequest->reason ?? null }}</textarea>
                    </div>
                    <div class="small" style="margin-top: 10px; margin-bottom:20px;">
                        <p class="secondary-text">*Informe o motivo pelo qual você está solicitando esta contratação
                        </p>
                    </div>
                </div>

                {{-- DESCRICAO --}}
                <div class="col-sm-7">
                    <div class="form-group">
                        <label for="description" class="regular-text">Descrição</label>
                        <textarea data-rule-required="true" minlength="20" name="description" id="description" data-cy="description" rows="4"
                            placeholder="Ex.: Contratação de serviço para conserto de uma máquina da produção que está apresentando defeitos." class="form-control text-area no-resize">{{ $purchaseRequest->description ?? null }}</textarea>
                    </div>
                    <div class="small" style="margin-top: 10px; margin-bottom:20px;">
                        <p class="secondary-text">*Descreva com detalhes o tipo de serviço que está solicitando.</p>
                    </div>
                </div>

            </div>

            <div class="row">

                {{-- LOCAL --}}
                <div class="col-sm-6">
                    <div class="form-group">
                        <label for="local-description" class="regular-text"> Local de prestação do serviço </label>
                        <input data-rule-required="true" minlength="5" name="local_description" value="{{ $purchaseRequest->local_description ?? null }}" type="text"
                            id="local-description" data-cy="local-description" placeholder="Ex: HKM - Av. Gentil Reinaldo Cordioli, 161 - Jardim Eldorado" class="form-control">
                    </div>
                </div>

                {{-- SERVIÇO JÁ PRESTADO --}}
                <div class="col-sm-2 div-already-provided">
                    <div class="form-group">
                        <label for="form-check" class="regular-text" style="padding-right:10px;">
                            Este serviço já foi prestado?
                        </label>
                        <fieldset data-rule-required="true">
                            <input name="service[already_provided]" value="1" class="radio-already-provided" @checked(isset($purchaseRequest) && (bool) $purchaseRequest->service->already_provided) id="already-provided"
                                data-cy="already-provided" type="radio" required>
                            <label class="form-check-label secondary-text" for="already-provided">Sim</label>
                            <input name="service[already_provided]" value="0" class="radio-already-provided" required type="radio" id="not-provided"
                                data-cy="not-provided" style="margin-left: 7px;" @checked(isset($purchaseRequest) && !(bool) $purchaseRequest->service->already_provided)>
                            <label class="form-check-label secondary-text" for="not-provided">Não</label>
                        </fieldset>
                    </div>
                </div>

                <div class="col-sm-2">
                    <div class="form-group">
                        <label for="desired-date" class="regular-text">Data desejada do serviço</label>
                        <input type="date" name="desired_date" id="desired-date" data-cy="desired-date" max="2100-01-01" class="form-control" min="2023-07-24"
                            value="{{ $purchaseRequest->desired_date ?? null }}">
                    </div>
                </div>

            </div>

            <div class="row mt-3">

                {{-- LINK --}}
                <div class="col-sm-6">
                    <div class="form-group">
                        <label for="support_links" class="regular-text">Links de apoio / sugestão</label>
                        <textarea rows="3" name="support_links" id="support_links" data-cy="support_links" class="form-control text-area no-resize">{{ isset($purchaseRequest->support_links) && $purchaseRequest->support_links ? $purchaseRequest->support_links : '' }}</textarea>
                    </div>
                </div>

                {{-- OBSERVACAO --}}
                <div class="col-sm-6">
                    <div class="form-group">
                        <label for="observation" class="regular-text">
                            Observações
                        </label>
                        <textarea name="observation" id="observation" data-cy="observation" rows="3" placeholder="Informações complementares desta solicitação"
                            class="form-control text-area no-resize">{{ $purchaseRequest->observation ?? null }}</textarea>
                    </div>
                </div>

            </div>

            <hr>

            <div class="payment-block">
                <div class="row center-block" style="padding-bottom: 10px;">
                    <h3>Pagamento</h3>
                </div>

                <div class="row" style="margin-bottom: -50;">
                    {{-- CONDIÇÃO DE PAGAMENTO --}}
                    <div class="col-sm-2">
                        <div class="form-group">
                            <label class="regular-text">Condição de pagamento</label>
                            <select name="service[payment_info][payment_terms]" id="payment-terms" data-cy="payment-terms"
                                class='select2-me service[payment_info][payment_terms]' style="width:100%; padding-top:2px;" data-placeholder="Escolha uma opção">
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
                            <label for="format-amount" class="regular-text">Valor total do serviço</label>
                            <div class="input-group">
                                <span class="input-group-text">R$</span>
                                <input type="text" id="format-amount" name="format-amount" data-cy="format-amount" placeholder="0.00" class="form-control format-amount"
                                    value="{{ str_replace('.', ',', $purchaseRequestServicePrice) }}">
                                <input type="hidden" name="service[price]" id="amount" data-cy="amount" class="amount no-validation"
                                    value="{{ $purchaseRequestServicePrice }}">
                            </div>
                        </div>
                    </div>

                    {{-- FORMA DE PAGAMENTO --}}
                    <div class="col-sm-2">
                        <div class="form-group">
                            <label class="regular-text">Forma de pagamento</label>
                            <select name="service[payment_info][payment_method]" id="payment-method" data-cy="payment-method" class='select2-me payment-method'
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

                    <input type="hidden" class="no-validation" value="{{ $isCopy ? null : $purchaseRequest?->service?->paymentInfo?->id }}" name="service[payment_info][id]">

                    {{-- Nº PARCELAS --}}
                    <div class="col-sm-1">
                        <div class="form-group">
                            <label class="control-label regular-text">Nº de parcelas</label>
                            <input type="text" class="form-control format-installments-number" name="installments-number" data-cy="format-installments-number"
                                placeholder="Ex: 24" value="{{ $serviceQuantityOfInstallments }}">
                            <input type="hidden" name="service[quantity_of_installments]" id="installments-number" data-cy="installments-number"
                                class="installments-number no-validation" value="{{ $serviceQuantityOfInstallments }}">
                        </div>
                    </div>

                    {{-- DESCRICAO DADOS PAGAMENTO --}}
                    <div class="col-sm-5" style="margin-bottom: -20px;">
                        <div class="form-group">
                            <label for="payment-info-description" class="regular-text"> Detalhes do pagamento </label>
                            <textarea name="service[payment_info][description]" id="payment-info-description" data-cy="payment-info-description" rows="3"
                                placeholder="Ex: chave PIX, dados bancários do fornecedor, etc." class="form-control text-area no-resize">{{ $purchaseRequest->service->paymentInfo->description ?? null }}</textarea>
                        </div>
                    </div>
                </div>

                {{-- TABLE PARCELAS --}}
                <div class="row" style="display:flex; align-items:center; margin-bottom:7px;">
                    <h3 class="col-sm-6">
                        <i class="fa fa-dollar"></i>
                        Parcelas deste serviço
                    </h3>
                </div>
                <div class="row">
                    <div class="col-sm-12">
                        <div class="box">
                            <div class="box-content nopadding regular-text">
                                <table class="table table-hover table-nomargin table-striped" id="installments-table-striped" style="width:100%">
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

                                {{-- PARCELAS SÃO ENVIADAS PELOS INPUT HIDDENS DESSE CONTAINER --}}
                                <div class="hidden-installments-inputs-container">
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <hr>

            <div class="suppliers-block">
                <div class="row center-block">
                    <h3>Informações do fornecedor</h3>
                </div>
                <div class="row" style="margin-top: 10px">

                    {{-- FORNECEDOR (CNPJ/RAZAO SOCIAL --}}
                    <div class="col-sm-4 form-group">
                        <label for="service[supplier_id]" style="display:block;" class="regular-text">
                            Fornecedor (CNPJ - Razão social)
                        </label>
                        <select name="service[supplier_id]" class='select2-me select-supplier' data-cy="service[supplier_id]" data-placeholder="Escolha um fornecedor"
                            style="width:100%;">
                            <option value="">Informe um fornecedor ou cadastre um novo</option>
                            @foreach ($suppliers as $supplier)
                                @php
                                    $supplierSelected = isset($purchaseRequest->service) && $purchaseRequest->service->supplier_id === $supplier->id;
                                    $cnpj = $supplier->cpf_cnpj ? preg_replace('/(\d{2})(\d{3})(\d{3})(\d{4})(\d{2})/', '$1.$2.$3/$4-$5', $supplier->cpf_cnpj) : 'CNPJ indefinido';
                                @endphp
                                <option value="{{ $supplier->id }}" @selected($supplierSelected)>
                                    {{ "$cnpj - $supplier->corporate_name" }}</option>
                            @endforeach
                        </select>
                    </div>

                    {{-- VENDEDOR/ATENDENTE --}}
                    <div class="col-sm-3">
                        <div class="form-group">
                            <label for="attendant" class="regular-text">Vendedor/Atendente</label>
                            <input type="text" id="attendant" name="service[seller]" data-cy="attendant" placeholder="Pessoa responsável pela cotação" class="form-control"
                                data-rule-minlength="2" value="{{ $purchaseRequest?->service?->seller ?? null }}">
                        </div>
                    </div>

                    {{-- TELEFONE --}}
                    <div class="col-sm-2">
                        <div class="form-group">
                            <label for="phone-number" class="regular-text">Telefone</label>
                            <input type="text" name="service[phone]" id="phone-number" data-cy="phone-number" placeholder="(00) 0000-0000" class="form-control"
                                minLength="14" value="{{ $purchaseRequest?->service?->phone ?? null }}">
                        </div>
                    </div>

                    {{-- E-MAIL --}}
                    <div class="col-sm-3">
                        <div class="form-group">
                            <label for="email" class="regular-text">E-mail</label>
                            <input type="email" name="service[email]" id="email" data-cy="email" placeholder="user_email@vendedor.com.br" class="form-control"
                                data-rule-email="true" value="{{ $purchaseRequest?->service?->email ?? null }}">
                        </div>
                    </div>

                </div>
            </div>

            <hr style="margin-top: 20px; margin-bottom: 20px;">

            {{-- ARQUIVOS --}}
            <div class="row justify-content-center">
                <div class="col-sm-12">
                    <x-RequestFiles :purchaseRequestId="$purchaseRequest?->id" :isCopy="$isCopy" />
                </div>
            </div>

            <div class="form-actions pull-right" style="margin-top:50px; padding-bottom:20px">
                @if (!$hasSentRequest && Gate::any(['post.requests.service.store', 'post.requests.service.update']))
                    <input type="hidden" name="action" id="action" data-cy="action" value="">

                    <button type="submit" data-cy="save-draft" class="btn btn-primary btn-draft" style="margin-right: 10px">
                        Salvar rascunho
                    </button>

                    <button type="submit" name="submit_request" data-cy="submit_request" style="margin-right: 10px" class="btn btn-primary btn-success btn-submit-request"
                        value="submit-request">
                        Salvar e enviar solicitação
                    </button>
                @endif

                @if ($hasSentRequest)
                    <a href="{{ route('requests.index.own') }}" class="btn btn-primary btn-large" data-cy="btn-back">VOLTAR</a>
                @endif
            </div>

        </div>
    </form>

    <x-ModalEditServiceInstallment :statusValues="$statusValues" />

    <x-modals.supplier-register />

</div>

@push('scripts')
    <script type="module" src="{{ asset('js/supplies/select2-custom.js') }}"></script>
    <script type="module" src="{{ asset('js/service-form/desired-date-config.js') }}"></script>
    <script type="module" src="{{ asset('js/service-form/submit-buttons-config.js') }}"></script>
    <script type="module" src="{{ asset('js/service-form/imasks.js') }}"></script>

    <script type="module">
        $(() => {
            const purchaseRequest = @json($purchaseRequest);
            const hasSentRequest = @json($hasSentRequest);
            const isRequestCopy = @json($isCopy);
            const statusValues = @json($statusValues);
            const selectedPaymentMethod = @json($selectedPaymentMethod);
            const paymentMethodsIsComex = @json($paymentMethods);

            const $amount = $('.amount');
            const $paymentMethod = $('#payment-method');
            const hiddenInputsContainer = $('.hidden-installments-inputs-container');
            const $inputInstallmentsNumber = $('.installments-number');
            const $radioIsContractedBySupplies = $('.radio-who-wants');
            const $paymentBlock = $('.payment-block');
            const $paymentTerm = $('#payment-terms');
            const $serviceAlreadyProvided = $('.radio-already-provided')
            const $divAlreadyProvided = $('.div-already-provided');
            const $desiredDate = $('#desired-date');

            const $editValueInputModal = $('#edit-value');
            const $editValueHiddenModal = $('#edit-value-hidden');

            let selectedRowIndex = null;

            const editValueInputModalMasked = $editValueInputModal.imask({
                mask: Number,
                scale: 2,
                thousandsSeparator: '.',
                normalizeZeros: true,
                padFractionalZeros: true,
                min: 0,
                max: 1000000000,
            });

            $editValueInputModal.on('input', function() {
                const formattedValue = $(this).val();
                if (formattedValue !== null) {
                    const processedValue = formattedValue.replace(/[^0-9,]/g, '').replace(/,/g, '.');
                    const rawValue = parseFloat(processedValue);
                    if (!isNaN(rawValue)) {
                        $editValueHiddenModal.val(rawValue.toFixed(2)).trigger('change');
                    }
                }
            });

            function fillHiddenInputsWithRowData() {
                const isNotCopyAndIssetPurchaseRequest = !isRequestCopy && purchaseRequest;
                const tableData = $installmentsTable.data();

                hiddenInputsContainer.empty();
                tableData.each(function(rowData, index) {
                    const expireDate = rowData.expire_date;
                    const value = rowData.value;
                    const observation = rowData.observation;
                    const status = rowData.status;

                    const idInput = document.createElement('input');
                    idInput.type = 'number';
                    idInput.name = `service[service_installments][${index}][id]`;
                    idInput.value = isNotCopyAndIssetPurchaseRequest ? purchaseRequest?.service
                        ?.installments[index]?.id : null;
                    idInput.hidden = true;
                    idInput.className = "no-validation";

                    const expireDateInput = document.createElement('input');
                    expireDateInput.type = 'date';
                    expireDateInput.name = `service[service_installments][${index}][expire_date]`;
                    expireDateInput.name = `service[service_installments][${index}][expire_date]`;
                    expireDateInput.value = expireDate;
                    expireDateInput.hidden = true;
                    expireDateInput.className = "no-validation";

                    const valueInput = document.createElement('input');
                    valueInput.type = 'number';
                    valueInput.name = `service[service_installments][${index}][value]`;
                    valueInput.name = `service[service_installments][${index}][value]`;
                    valueInput.value = value;
                    valueInput.hidden = true;
                    valueInput.className = "no-validation";

                    const observationInput = document.createElement('input');
                    observationInput.type = 'text';
                    observationInput.name = `service[service_installments][${index}][observation]`;
                    observationInput.name = `service[service_installments][${index}][observation]`;
                    observationInput.value = observation;
                    observationInput.hidden = true;
                    observationInput.className = "no-validation";

                    const statusInput = document.createElement('input');
                    statusInput.type = 'text';
                    statusInput.name = `service[service_installments][${index}][status]`;
                    statusInput.name = `service[service_installments][${index}][status]`;
                    statusInput.value = status;
                    statusInput.hidden = true;
                    statusInput.className = "no-validation";
                    hiddenInputsContainer.append(idInput, expireDateInput, valueInput, observationInput,
                        statusInput);
                });
            }

            function deleteHiddenInputs(row) {
                const index = $installmentsTable.row(row).index();
                $(`input[name^="service[service_installments][${index}]"]`).remove();
                $(`input[name^="service[service_installments][${index}]"]`).remove();
            }

            function updateHiddenInputIndex() {
                $('input[name^="service[service_installments]"]').each(function() {
                    const currentName = $(this).attr('name');
                    const newIndex = currentName.replace(/\[(\d+)\]/, function(match, index) {
                        const currentIndex = parseInt(index);
                        return `[${currentIndex - 1}]`;
                    });
                    $(this).attr('name', newIndex);
                });
            }

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
                        observation: `Parcela ${i}/${numberOfInstallments}`,
                        status: "PENDENTE",
                    };

                    installmentsData.push(installmentData);
                    rowsData.push(installmentData);
                }

                for (const installmentData of installmentsData) {
                    const rowNode = $installmentsTable.row.add(installmentData).node();
                    $(rowNode).children('td').eq(0).attr('data-hidden-date', installmentData[5]);
                }

                fillHiddenInputsWithRowData();

                $installmentsTable.clear().rows.add(rowsData).draw();
            }

            // modal edit installment
            function openModalForEdit(rowData) {
                const modalEditServiceInstallment = bootstrap.Modal.getOrCreateInstance('#modal-edit-service-installment');
                modalEditServiceInstallment.show();

                const expireDate = $('#edit-expire-date');
                const status = $('#edit-status');
                const observation = $('#edit-observation');

                if (rowData.expire_date) {
                    const formattedDate = new Date(rowData.expire_date.split('/').reverse().join('-'));
                    expireDate.val(formattedDate.toISOString().split('T')[0]);
                }

                editValueInputModalMasked.value = rowData.value.replace('.', ',');
                $editValueInputModal.val(editValueInputModalMasked.value);

                $editValueInputModal.trigger('input');

                const statusToModal = (statusValues.find((status) => status.description === rowData.status)).id;
                status.val(statusToModal).trigger('change');

                observation.val(rowData.observation);

                $('#form-modal-edit-service-installment').one('submit', function(event) {
                    event.preventDefault();

                    const expireDate = $('#edit-expire-date').val();
                    const value = parseFloat($('#edit-value-hidden').val());
                    const status = $('#edit-status').find(':selected').text();
                    const observation = $('#edit-observation').val();
                    const editButton =
                        '<button type="button" rel="tooltip" title="Editar Parcela" class="btn btn-edit-installment"><i class="fa fa-edit"></i></button>';

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

                    const modalEditServiceInstallment = bootstrap.Modal.getOrCreateInstance('#modal-edit-service-installment');
                    modalEditServiceInstallment.hide();
                });
            }

            // dataTable config - parcelas
            const $installmentsTable = $('#installments-table-striped').DataTable({
                data: purchaseRequest?.service?.installments || [],
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

            fillHiddenInputsWithRowData();

            // desabilita pagamento ao entrar em register
            $paymentBlock
                .find('input, textarea')
                .prop('disabled', true);

            $paymentBlock
                .find('select')
                .prop('disabled', true)
                .trigger('change.select2');

            // verifica EU ou SUPRIMENTOS (desabilitar fornecedores e pagamento)
            $radioIsContractedBySupplies.on('change', function() {
                const isContractedBySupplies = $(this).val() === "1";
                const $suppliersBlock = $('.suppliers-block');
                const supplierSelect = $suppliersBlock.find('select');

                // muda label fornecedor
                const labelSuppliersSuggestion = "Deseja indicar um fornecedor?";
                const labelSuppliersChoose = "Fornecedor - CNPJ / Razão Social";
                const newLabel = isContractedBySupplies ? labelSuppliersSuggestion : labelSuppliersChoose;
                supplierSelect.siblings(`label[for="${supplierSelect.attr('name')}"]`).text(newLabel);

                // muda label data desejada
                const labelDesiredDateAlreadyProvided = "Data da prestação do serviço";
                const labelDesiredDateDefault = "Data desejada do serviço";
                const newLabelDate = !isContractedBySupplies ? labelDesiredDateAlreadyProvided :
                    labelDesiredDateDefault;
                $desiredDate.siblings('label').text(newLabelDate);

                // desabilita pagamento
                $paymentBlock.find('input, textarea').prop('disabled', isContractedBySupplies);
                $paymentBlock.find('select').prop('disabled', isContractedBySupplies).trigger(
                    'change.select2');

                if (isContractedBySupplies) {
                    $serviceAlreadyProvided
                        .last()
                        .prop('checked', true);

                    $divAlreadyProvided
                        .attr('hidden', true);

                    supplierSelect.removeRequired();
                    supplierSelect
                        .closest('.form-group')
                        .removeClass('has-error');

                    $suppliersBlock
                        .find('.help-block')
                        .remove();

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
                } else {
                    /*
                        ## solução previa ##
                        tem um problema que é quando for edição e mover de suprimentos para area solicitante
                        o radio button vem selecionado, ao invés de vazio, como acontece em um registro novo.
                    */
                    if (!purchaseRequest) {
                        $serviceAlreadyProvided
                            .last()
                            .prop('checked', false);
                    }

                    $divAlreadyProvided
                        .attr('hidden', false);
                }

                supplierSelect.makeRequired();
            });

            if (!hasSentRequest || $radioIsContractedBySupplies.is(':checked')) {
                $radioIsContractedBySupplies.filter(':checked').trigger('change');
            }


            $('#installments-table-striped tbody').on('click', 'tr', function(event) {
                event.preventDefault();

                if ($(event.target).closest('.btn-edit-installment').length) {
                    const rowData = $installmentsTable.row(this).data();
                    selectedRowIndex = $installmentsTable.row(this).index();
                    openModalForEdit(rowData);
                }
            });

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

            $paymentTerm.on('change', function() {
                const $serviceAmount = $('#format-amount');
                const $formatInputInstallmentsNumber = $('.format-installments-number');
                const $paymentInfoDescription = $('#payment-info-description');
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

            // desabilita todos os campos do form caso solicitacao ja enviada
            if (hasSentRequest) {
                $('#request-form').find('input, textarea, checkbox').prop('disabled', true);
                $('#request-form').find('select').prop('disabled', true);
                $('.file-remove').prop('disabled', true);

                $('.add-cost-center-btn').prop('disabled', true);
                $('.delete-cost-center').prop('disabled', true);
            }
        });
    </script>
@endpush
