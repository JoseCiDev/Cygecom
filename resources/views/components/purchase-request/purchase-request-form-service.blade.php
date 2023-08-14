@php
    use App\Enums\PurchaseRequestStatus;
    use App\Enums\PaymentMethod;

    $issetPurchaseRequest = isset($purchaseRequest);
    $purchaseRequest ??= null;
    $isCopy ??= null;
    $serviceInstallments = $purchaseRequest?->service?->installments;
    $purchaseRequestServicePrice = $purchaseRequest?->service?->price === null ? null : (float) $purchaseRequest?->service?->price;
    $serviceQuantityOfInstallments = $purchaseRequest?->service?->quantity_of_installments === null ? null : (int) $purchaseRequest?->service?->quantity_of_installments;

    $selectedPaymentMethod = null;
    $selectedPaymentTerm = null;
    if (isset($purchaseRequest->service) && isset($purchaseRequest->service->paymentInfo)) {
        $selectedPaymentMethod = $purchaseRequest->service->paymentInfo->payment_method;
        $selectedPaymentTerm = $purchaseRequest->service->paymentInfo->payment_terms;
    }

    // verifica status para desabilitar campos para o usuário
    $requestAlreadySent = $purchaseRequest?->status !== PurchaseRequestStatus::RASCUNHO;
    // ve se tem request e não foi enviada
    $hasRequestNotSent = $issetPurchaseRequest && !$requestAlreadySent;
    // ve se tem request ja enviada e n é copia
    $hasSentRequest = $issetPurchaseRequest && $requestAlreadySent && !$isCopy;
@endphp


<style>
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

<div class="row">

    <div class="col-sm-6">
        @if ($hasRequestNotSent)
            <h2>Editar Solicitação</h2>
        @elseif ($hasSentRequest)
            <div class="alert alert-info alert-dismissable">
                <button data-cy="btn-close-alert" type="button" class="close" data-dismiss="alert">&times;</button>
                <h5>
                    <strong>ATENÇÃO:</strong> Esta solicitação já foi enviada ao setor de suprimentos responsável.
                </h5>
            </div>
            <h2>Visualizar Solicitação</h2>
        @else
            <h2>Nova Solicitação</h2>
        @endif
    </div>
    @if (isset($purchaseRequest) && !$requestAlreadySent)
        <div class="col-md-6 pull-right">
            <x-modalDelete />
            <button data-cy="btn-delete-request" data-route="purchaseRequests"
                data-name="{{ 'Solicitação de compra - Nº ' . $purchaseRequest->id }}"
                data-id="{{ $purchaseRequest->id }}" data-toggle="modal" data-target="#modal" rel="tooltip"
                title="Excluir" class="btn btn-danger pull-right" style="margin-right: 15px">
                Excluir solicitação
            </button>
        </div>
    @endif
</div>

<hr style="margin-top:5px; margin-bottom:30px;">

<div class="box-content">
    <form enctype="multipart/form-data" class="form-validate" id="request-form" data-cy="request-form" method="POST"
        action="@if (isset($purchaseRequest) && !$isCopy) {{ route('request.service.update', ['id' => $id]) }}
                    @else {{ route('request.service.register') }} @endif">
        @csrf

        <input type="hidden" name="type" value="service" class="no-validation" data-cy="type">

        <div class="row center-block" style="padding-bottom: 10px;">
            <h4>CONTRATANTE</h4>
        </div>

        {{-- CENTRO DE CUSTOS --}}
        <x-CostCenterApportionment :purchaseRequest="$purchaseRequest" />

        <hr>

        <div class="full-product-line product-form">
            <div class="row center-block" style="padding-bottom: 10px;">
                <h4>DADOS DA SOLICITAÇÃO</h4>
            </div>

            <div class="row" style="margin-bottom:10px; margin-top:5px;">

                {{-- RESPONSÁVEL CONTRATAÇÃO --}}
                <div class="col-sm-5">
                    <div class="form-group">
                        <label for="form-check" class="control-label" style="padding-right:10px;">
                            Quem está responsável por esta contratação?
                        </label>
                        <fieldset data-rule-required="true">
                            <div class="row">
                                <div class="col-sm-3">
                                    <input name="is_supplies_contract"value="1" class="radio-who-wants" required
                                        id="is-supplies-contract" data-cy="is-supplies-contract" type="radio"
                                        @checked(isset($purchaseRequest) && (bool) $purchaseRequest->is_supplies_contract)>
                                    <label class="form-check-label" for="is-supplies-contract">Suprimentos</label>
                                </div>
                                <div class="col-sm-4">
                                    <input name="is_supplies_contract" value="0" class="radio-who-wants"
                                        type="radio" required id="is-area-contract" data-cy="is-area-contract"
                                        style="margin-left: 7px;" @checked(isset($purchaseRequest) && !(bool) $purchaseRequest->is_supplies_contract)>
                                    <label class="form-check-label" for="is-area-contract"> Área solicitante</label>
                                </div>
                            </div>
                        </fieldset>
                    </div>
                </div>

                {{-- COMEX --}}
                <div class="col-sm-4">
                    <div class="form-group">
                        <label for="form-check" class="control-label" style="padding-right:10px;">
                            Contrato se enquadra na categoria COMEX?
                        </label>
                        <fieldset data-rule-required="true">
                            <div class="row">
                                <div class="col-sm-5">
                                    <input name="is_comex" data-cy="is_comex_true" value="1"
                                        @checked(isset($purchaseRequest) && (bool) $purchaseRequest->is_comex) class="radio-comex" type="radio"
                                        data-skin="minimal" required>
                                    <label class="form-check-label" for="services"
                                        style="margin-right:15px;">Sim</label>
                                    <input name="is_comex" data-cy="is_comex_false" value="0"
                                        @checked(isset($purchaseRequest) && !(bool) $purchaseRequest->is_comex) class="radio-comex" type="radio"
                                        data-skin="minimal" required>
                                    <label class="form-check-label" for="">Não</label>
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
                        <label for="reason" class="control-label">
                            Motivo da solicitação
                        </label>
                        <textarea data-rule-required="true" minlength="20" name="reason" id="reason" data-cy="reason" rows="4"
                            placeholder="Ex: Ar condicionado da sala de reuniões do atrium apresenta defeitos de funcionamento"
                            class="form-control text-area no-resize">{{ $purchaseRequest->reason ?? null }}</textarea>
                    </div>
                    <div class="small" style="color:rgb(85, 85, 85); margin-top:-10px; margin-bottom:20px;">
                        <p>* Por favor, forneça uma breve descrição do motivo pelo qual você está solicitando esta
                            compra.
                        </p>
                    </div>
                </div>

                {{-- DESCRICAO --}}
                <div class="col-sm-7">
                    <div class="form-group">
                        <label for="description" class="control-label">Descrição</label>
                        <textarea data-rule-required="true" minlength="20" name="description" id="description" data-cy="description"
                            rows="4"
                            placeholder="Ex.: Contratação de serviço para consertar e verificar o estado dos ar-condicionados da HKM."
                            class="form-control text-area no-resize">{{ $purchaseRequest->description ?? null }}</textarea>
                    </div>
                    <div class="small" style="color:rgb(85, 85, 85); margin-top:-10px; margin-bottom:20px;">
                        <p>* Descreva com detalhes o que deseja solicitar e informações úteis para uma possível cotação.
                        </p>
                    </div>
                </div>

            </div>

            <div class="row">

                {{-- LOCAL --}}
                <div class="col-sm-6">
                    <div class="form-group">
                        <label for="local-description" class="control-label">
                            Local de prestação do serviço
                        </label>
                        <input data-rule-required="true" minlength="5" name="local_description"
                            value="{{ $purchaseRequest->local_description ?? null }}" type="text"
                            id="local-description" data-cy="local-description"
                            placeholder="Ex: HKM - Av. Gentil Reinaldo Cordioli, 161 - Jardim Eldorado"
                            class="form-control">
                    </div>
                </div>

                {{-- SERVIÇO JÁ PRESTADO --}}
                <div class="col-sm-2">
                    <div class="form-group">
                        <label for="form-check" class="control-label" style="padding-right:10px;">
                            Este serviço já foi prestado?
                        </label>
                        <fieldset data-rule-required="true">
                            <input name="service[already_provided]" value="1" class="radio-already-provided"
                                id="already-provided" data-cy="already-provided" type="radio" required
                                @checked(isset($purchaseRequest) && (bool) $purchaseRequest->service->already_provided)>
                            <label class="form-check-label" for="already-provided">Sim</label>
                            <input name="service[already_provided]" value="0" class="radio-already-provided"
                                required type="radio" id="not-provided" data-cy="not-provided"
                                style="margin-left: 7px;" @checked(isset($purchaseRequest) && !(bool) $purchaseRequest->service->already_provided)>
                            <label class="form-check-label" for="not-provided">Não</label>
                        </fieldset>
                    </div>
                </div>

                <div class="col-sm-2">
                    <div class="form-group">
                        <label for="desired-date" class="control-label">Data desejada do serviço</label>
                        <input type="date" name="desired_date" id="desired-date" data-cy="desired-date"
                            class="form-control" min="2023-07-24"
                            value="{{ $purchaseRequest->desired_date ?? null }}">
                    </div>
                </div>

            </div>

            <div class="row">

                {{-- LINK --}}
                <div class="col-sm-6">
                    <div class="form-group">
                        <label for="support_links" class="control-label">Links de apoio / sugestão</label>
                        <textarea placeholder="Adicone um ou mais links válidos para apoio ou sugestão." rows="3" name="support_links"
                            id="support_links" data-cy="support_links" class="form-control text-area no-resize">{{ isset($purchaseRequest->support_links) && $purchaseRequest->support_links ? $purchaseRequest->support_links : '' }}</textarea>
                    </div>
                </div>

                {{-- OBSERVACAO --}}
                <div class="col-sm-6">
                    <div class="form-group">
                        <label for="observation" class="control-label">
                            Observações
                        </label>
                        <textarea name="observation" id="observation" data-cy="observation" rows="3"
                            placeholder="Informações complementares desta solicitação" class="form-control text-area no-resize">{{ $purchaseRequest->observation ?? null }}</textarea>
                    </div>
                </div>

            </div>

            <hr>

            <div class="payment-block">
                <div class="row center-block" style="padding-bottom: 10px;">
                    <h4>PAGAMENTO</h4>
                </div>

                <div class="row" style="margin-bottom: -50;">
                    {{-- CONDIÇÃO DE PAGAMENTO --}}
                    <div class="col-sm-2">
                        <div class="form-group">
                            <label class="control-label">Condição de pagamento</label>
                            <select name="service[payment_info][payment_terms]" id="payment-terms"
                                data-cy="payment-terms" class='select2-me service[payment_info][payment_terms]'
                                style="width:100%; padding-top:2px;" data-placeholder="Escolha uma opção">
                                <option value=""></option>
                                @foreach ($paymentTerms as $paymentTerm)
                                    <option value="{{ $paymentTerm->value }}" @selected($paymentTerm->value === $selectedPaymentTerm)>
                                        {{ $paymentTerm->label() }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    {{-- VALOR TOTAL --}}
                    <div class="col-sm-2">
                        <div class="form-group">
                            <label for="format-amount" class="control-label">Valor total do serviço</label>
                            <div class="input-group">
                                <span class="input-group-addon">R$</span>
                                <input type="text" id="format-amount" data-cy="format-amount" placeholder="0.00"
                                    class="form-control format-amount" value="{{ $purchaseRequestServicePrice }}">
                                <input type="hidden" name="service[price]" id="amount" data-cy="amount"
                                    class="amount no-validation" value="{{ $purchaseRequestServicePrice }}">
                            </div>
                        </div>
                    </div>

                    {{-- FORMA DE PAGAMENTO --}}
                    <div class="col-sm-2">
                        <div class="form-group">
                            <label class="control-label">Forma de pagamento</label>
                            <select name="service[payment_info][payment_method]" id="payment-method"
                                data-cy="payment-method" class='select2-me payment-method'
                                style="width:100%; padding-top:2px;" data-placeholder="Escolha uma opção">
                                <option value=""></option>
                                @foreach ($paymentMethods as $paymentMethod)
                                    <option value="{{ $paymentMethod->value }}" @selected($paymentMethod->value === $selectedPaymentMethod)>
                                        {{ $paymentMethod->label() }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <input type="hidden" class="no-validation" value="{{ $purchaseRequest?->service?->paymentInfo?->id ?? null }}"
                        name="service[payment_info][id]">

                    {{-- Nº PARCELAS --}}
                    <div class="col-sm-1">
                        <div class="form-group">
                            <label class="control-label">Nº de parcelas</label>
                            <input type="text" class="form-control format-installments-number"
                                data-cy="format-installments-number" placeholder="Ex: 24"
                                value="{{ $serviceQuantityOfInstallments }}">
                            <input type="hidden" name="service[quantity_of_installments]" id="installments-number"
                                data-cy="installments-number" class="installments-number no-validation"
                                value="{{ $serviceQuantityOfInstallments }}">
                        </div>
                    </div>

                    {{-- DESCRICAO DADOS PAGAMENTO --}}
                    <div class="col-sm-5" style="margin-bottom: -20px;">
                        <div class="form-group">
                            <label for="payment-info-description" class="control-label">
                                Detalhes do pagamento
                            </label>
                            <textarea name="service[payment_info][description]" id="payment-info-description" data-cy="payment-info-description"
                                rows="3" placeholder="Informações sobre pagamento. Ex: Chave PIX, dados bancários do fornecedor, etc..."
                                class="form-control text-area no-resize">{{ $purchaseRequest->service->paymentInfo->description ?? null }}</textarea>
                        </div>
                    </div>
                </div>

                {{-- TABLE PARCELAS --}}
                <div class="row" style="display:flex; align-items:center; margin-bottom:7px;">
                    <h4 class="col-sm-6">
                        <i class="fa fa-dollar"></i>
                        PARCELAS DESTE SERVIÇO
                    </h4>
                    <div class="col-sm-6 btn-add-installment" hidden>
                        <button type="button" class="btn btn-success pull-right btn-small btn-add-installment"
                            data-cy="btn-add-installment" data-route="user" rel="tooltip"
                            title="Adicionar Parcela">
                            + Adicionar parcela
                        </button>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-12">
                        <div class="box">
                            <div class="box-content nopadding">
                                <table class="table table-hover table-nomargin table-striped"
                                    id="installments-table-striped">
                                    <thead>
                                        <tr>
                                            <th class="col-sm-2">
                                                <i class="fa fa-calendar-o" style="padding-right:5px;"></i>
                                                VENCIMENTO
                                            </th>
                                            <th class="col-sm-2">
                                                <i class="fa fa-money" style="padding-right:5px;"></i>
                                                VALOR
                                            </th>
                                            <th class='col-sm-4 hidden-350'>
                                                <i class="fa fa-pencil-square" style="padding-right:5px;"></i>
                                                OBSERVAÇÃO
                                            </th>
                                            <th class='col-sm-2 hidden-1024'>
                                                <i class="fa fa-tasks" style="padding-right:5px;"></i>
                                                STATUS
                                            </th>
                                            <th class='col-sm-2 hidden-480'>
                                                <i class="fa fa-sliders" style="padding-right:5px;"></i>
                                                AÇÕES
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

            <hr>

            <div class="suppliers-block">
                <div class="row center-block">
                    <h4>INFORMAÇÕES DO FORNECEDOR</h4>
                </div>
                <div class="row" style="margin-top: 10px">

                    {{-- FORNECEDOR (CNPJ/RAZAO SOCIAL --}}
                    <div class="col-sm-4 form-group">
                        <label for="service[supplier_id]" style="display:block;" class="control-label">
                            Fornecedor (CNPJ - RAZÃO SOCIAL)
                        </label>
                        <select name="service[supplier_id]" class='select2-me select-supplier'
                            data-cy="service[supplier_id]" data-placeholder="Escolha um fornecedor"
                            style="width:100%;">
                            <option value=""></option>
                            @foreach ($suppliers as $supplier)
                                @php $supplierSelected = isset($purchaseRequest->service) && $purchaseRequest->service->supplier_id === $supplier->id; @endphp
                                <option value="{{ $supplier->id }}" @selected($supplierSelected)>
                                    {{ "$supplier->cpf_cnpj - $supplier->corporate_name" }}</option>
                            @endforeach
                        </select>
                    </div>

                    {{-- VENDEDOR/ATENDENTE --}}
                    <div class="col-sm-3">
                        <div class="form-group">
                            <label for="attendant" class="control-label">Vendedor/Atendente</label>
                            <input type="text" id="attendant" name="service[seller]" data-cy="attendant"
                                placeholder="Pessoa responsável pela cotação" class="form-control"
                                data-rule-minlength="2" value="{{ $purchaseRequest?->service?->seller ?? null }}">
                        </div>
                    </div>

                    {{-- TELEFONE --}}
                    <div class="col-sm-2">
                        <div class="form-group">
                            <label for="phone-number" class="control-label">Telefone</label>
                            <input type="text" name="service[phone]" id="phone-number" data-cy="phone-number"
                                placeholder="(00) 0000-0000" class="form-control" minLength="14"
                                value="{{ $purchaseRequest?->service?->phone ?? null }}">
                        </div>
                    </div>

                    {{-- E-MAIL --}}
                    <div class="col-sm-3">
                        <div class="form-group">
                            <label for="email" class="control-label">E-mail</label>
                            <input type="email" name="service[email]" id="email" data-cy="email"
                                placeholder="user_email@vendedor.com.br" class="form-control" data-rule-email="true"
                                value="{{ $purchaseRequest?->service?->email ?? null }}">
                        </div>
                    </div>

                </div>
            </div>

            <hr style="margin-top: 20px; margin-bottom: 20px;">

            {{-- ARQUIVOS --}}
            <div class="row justify-content-center">
                <div class="col-sm-12">
                    <fieldset id="files-group">
                        <h4 style="margin-bottom: 20px;">
                            <i class="fa fa-paperclip"></i> Anexos
                        </h4>
                        <input type="file" class="form-control" name="arquivos[]" data-cy="arquivos" multiple>
                        <ul class="list-group" style="margin-top:15px">
                            @if (isset($files))
                                @foreach ($files as $each)
                                    @php
                                        $filenameSearch = explode('/', $each->original_name);
                                        $filename = end($filenameSearch);
                                    @endphp
                                    <li class="list-group-item" data-id-purchase-request-file="{{ $each->id }}">
                                        <div class="row">
                                            <div class="col-xs-6">
                                                <i class='fa fa-file'></i><a style='margin-left:5px'
                                                    href="{{ env('AWS_S3_BASE_URL') . $each->path }}"target="_blank">{{ $filename }}</a>
                                            </div>
                                            <div class="col-xs-6 text-right">
                                                <button type="button" class="btn btn-primary file-remove"><i
                                                        class='fa fa-trash'
                                                        style='margin-right:5px'></i>Excluir</span>
                                            </div>
                                        </div>
                                    </li>
                                @endforeach
                            @endif
                        </ul>
                        <div class="alert alert-success" style="display:none;margin:15px 0px 15px 0px;"><i
                                class="fa fa-check"></i> Excluido com sucesso!</div>
                        <div class="alert alert-danger" style="display:none;margin:15px 0px 15px 0px;"><i
                                class="fa fa-close"></i> Não foi possível excluir, por favor tente novamente mais
                            tarde.</div>
                    </fieldset>
                </div>
            </div>

            <div class="form-actions pull-right" style="margin-top:50px; padding-bottom:20px">
                @if (!$hasSentRequest)
                    <input type="hidden" name="action" id="action" data-cy="action" value="">

                    <button type="submit" data-cy="save-draft" class="btn btn-primary btn-draft"
                        style="margin-right: 10px">
                        Salvar rascunho
                    </button>

                    <button type="submit" name="submit_request" data-cy="submit_request" style="margin-right: 10px"
                        class="btn btn-success btn-submit-request" value="submit-request">
                        Salvar e enviar solicitação
                        <i class="fa fa-paper-plane"></i>
                    </button>

                    <a href="{{ route('requests.own') }}" class="btn" data-cy="btn-cancel">Cancelar</a>
                @endif

                @if ($hasSentRequest)
                    <a href="{{ route('requests.own') }}" class="btn btn-primary btn-large"
                        data-cy="btn-back">VOLTAR</a>
                @endif
            </div>

        </div>
    </form>

    <x-ModalEditServiceInstallment :statusValues="$statusValues" />

    <x-ModalSupplierRegister />

</div>

<script src="{{ asset('js/supplies/select2-custom.js') }}"></script>
<script src="{{ asset('js/service-form/desired-date-config.js') }}"></script>
<script src="{{ asset('js/service-form/file-remove-button-config.js') }}"></script>
<script src="{{ asset('js/service-form/submit-buttons-config.js') }}"></script>
<script src="{{ asset('js/service-form/imasks.js') }}"></script>

<script>
    $(() => {
        const purchaseRequest = @json($purchaseRequest);
        const hasSentRequest = @json($hasSentRequest);
        const isRequestCopy = @json($isCopy);
        const statusValues = @json($statusValues);

        const $amount = $('.amount');
        const $inputInstallmentsNumber = $('.installments-number');
        const $radioIsContractedBySupplies = $('.radio-who-wants');
        const $paymentBlock = $('.payment-block');
        const $paymentTerm = $('#payment-terms');

        const $editValueInputModal = $('#edit-value');
        const $editValueHiddenModal = $('#edit-value-hidden');

        let selectedRowIndex = null;

        editValueInputModalMasked = $editValueInputModal.imask({
            mask: Number,
            scale: 2,
            thousandsSeparator: '.',
            normalizeZeros: true,
            padFractionalZeros: true,
            min: 0,
            max: 1000000000,
        });

        function fillHiddenInputsWithRowData() {
            const isNotCopyAndIssetPurchaseRequest = !isRequestCopy && purchaseRequest;
            const tableData = $installmentsTable.data();
            const hiddenInputsContainer = $('.hidden-installments-inputs-container');

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
            $('#modal-edit-service-installment').modal('show');

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

            observation.val(rowData.observation);

            status.select2('val', statusValues.find((status) => status.description === rowData.status).id);

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

                $('#modal-edit-service-installment').modal('hide');
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
            .prop('readonly', true);

        $paymentBlock
            .find('select')
            .prop('disabled', true)
            .trigger('change.select2');

        // verifica EU ou SUPRIMENTOS (desabilitar fornecedores e pagamento)
        $radioIsContractedBySupplies.on('change', function() {
            const isContractedBySupplies = $(this).val() === "1";
            const $suppliersBlock = $('.suppliers-block');
            const labelSuppliersSuggestion = "Deseja indicar um fornecedor?";
            const labelSuppliersChoose = "Fornecedor - CNPJ / Razão Social";

            // muda label
            const supplierSelect = $suppliersBlock.find('select');
            const newLabel = isContractedBySupplies ? labelSuppliersSuggestion : labelSuppliersChoose;

            supplierSelect.siblings(`label[for="${supplierSelect.attr('name')}"]`).text(newLabel);
            supplierSelect.data('rule-required', !isContractedBySupplies);

            // desabilita pagamento
            $paymentBlock.find('input, textarea').prop('readonly', isContractedBySupplies);

            $paymentBlock.find('select').prop('disabled', isContractedBySupplies).trigger(
                'change.select2');

            if (isContractedBySupplies) {
                $installmentsTable.clear().draw();
            }
        });

        if (!hasSentRequest || $radioIsContractedBySupplies.filter(':checked').val() === "1") {
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
            const $paymentMethod = $('.payment-method');
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

        // desabilita todos os campos do form caso solicitacao ja enviada
        if (hasSentRequest) {
            $('#request-form').find('input, textarea, checkbox').prop('disabled', true);
            $('#request-form').find('select').prop('disabled', true);
            $('.file-remove').prop('disabled', true);
        }
    });
</script>
