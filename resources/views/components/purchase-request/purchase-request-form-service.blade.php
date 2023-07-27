@php
    $issetPurchaseRequest = isset($purchaseRequest);
    $purchaseRequest ??= null;
    $isCopy ??= null;
    $serviceInstallments = $purchaseRequest?->service?->installments;
@endphp


<style>
    .cost-center-container {
        margin-bottom: 10px;
    }
</style>

<x-ModalSupplierRegister />

<div class="row">
    <div class="col-sm-6">
        <h2>
            {{ isset($purchaseRequest) ? 'Editar solicitação' : 'Nova solicitação' }}
        </h2>
    </div>
    @if (isset($purchaseRequest))
        <div class="col-md-6 pull-right">
            <x-modalDelete />
            <button data-route="purchaseRequests" data-name="{{ 'Solicitação de compra - ID ' . $purchaseRequest->id }}"
                data-id="{{ $purchaseRequest->id }}" data-toggle="modal" data-target="#modal" rel="tooltip" title="Excluir"
                class="btn btn-danger pull-right" style="margin-right: 15px">
                Excluir solicitação
            </button>
        </div>
    @endif
</div>

<hr style="margin-top:5px; margin-bottom:30px;">

<div class="box-content">
    <form enctype="multipart/form-data" class="form-validate" id="request-form" method="POST"
        action="@if (isset($purchaseRequest) && !$isCopy) {{ route('request.service.update', ['id' => $id]) }}
                    @else {{ route('request.service.register') }} @endif">
        @csrf

        <input type="hidden" name="type" value="service">

        <div class="row center-block" style="padding-bottom: 10px;">
            <h4>CONTRATANTE</h4>
        </div>

        {{-- CENTRO DE CUSTOS --}}
        @if (isset($purchaseRequest))
            @foreach ($purchaseRequest->costCenterApportionment as $index => $apportionment)
                <div class="row cost-center-container">
                    <div class="col-sm-6">
                        <label style="display:block;" for="textfield" class="control-label">Centro de custo da
                            despesa</label>
                        <select name="cost_center_apportionments[{{ $index }}][cost_center_id]"
                            class='select2-me @error('cost_center_id_{{ $index }}') is-invalid @enderror'
                            required data-rule-required="true" style="width:100%;" placeholder="Ex: Almoxarifado">
                            <option value=""></option>
                            @foreach ($costCenters as $costCenter)
                                @php
                                    $isApportionmentSelect = isset($apportionment) && $apportionment->cost_center_id === $costCenter->id;
                                @endphp
                                <option value="{{ $costCenter->id }}" {{ $isApportionmentSelect ? 'selected' : '' }}>
                                    {{ $costCenter->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-sm-2">
                        <label for="cost_center_apportionments[{{ $index }}][apportionment_percentage]"
                            class="control-label">
                            Rateio (%)
                        </label>
                        <div class="input-group">
                            <span class="input-group-addon">%</span>
                            <input type="number" placeholder="0.00" class="form-control" min="0"
                                name="cost_center_apportionments[{{ $index }}][apportionment_percentage]"
                                id="cost_center_apportionments[{{ $index }}][apportionment_percentage]"
                                value="{{ $apportionment->apportionment_percentage }}">
                            @error('cost_center_apportionments[{{ $index }}][apportionment_percentage]')
                                <p><strong>{{ $message }}</strong></p>
                            @enderror
                        </div>
                    </div>

                    <div class="col-sm-2">
                        <label for="cost_center_apportionments[{{ $index }}][apportionment_currency]"
                            class="control-label">
                            Rateio (R$)
                        </label>
                        <div class="input-group">
                            <span class="input-group-addon">R$</span>
                            <input type="number" placeholder="0.00" class="form-control" min="0"
                                name="cost_center_apportionments[{{ $index }}][apportionment_currency]"
                                id="cost_center_apportionments[{{ $index }}][apportionment_currency]"
                                value="{{ $apportionment->apportionment_currency }}">
                            @error('cost_center_apportionments[{{ $index }}][apportionment_currency]')
                                <p><strong>{{ $message }}</strong></p>
                            @enderror
                        </div>
                    </div>

                    <div class="col-sm-1" style="margin-top: 28px;">
                        <button class="btn btn-icon btn-small btn-danger delete-cost-center"><i
                                class="fa fa-trash-o"></i></button>
                    </div>
                </div>
            @endforeach
        @else
            <div class="row cost-center-container">
                <div class="col-sm-6">
                    <label for="textfield" class="control-label" style="display:block">
                        Centro de custo da despesa
                    </label>
                    <select style="width:100%" name="cost_center_apportionments[0][cost_center_id]"
                        class='select2-me
            @error('cost_center_id_{{ $index }}') is-invalid @enderror'
                        required data-rule-required="true" placeholder="Ex: Almoxarifado">
                        <option value="" disalbed></option>
                        @foreach ($costCenters as $costCenter)
                            @php
                                $isUserCostCenter = isset($user->person->costCenter) && $user->person->costCenter->id == $costCenter->id;
                                $costCenterCompanyName = $costCenter->company->corporate_name;
                                $costCenterName = $costCenter->name;
                                $costCenterSeniorCode = $costCenter->senior_code;
                            @endphp
                            <option value="{{ $costCenter->id }}" {{ $isUserCostCenter ? 'selected' : '' }}>
                                {{ $costCenterCompanyName . ' - ' . $costCenterName . ' - ' . $costCenterSeniorCode }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-sm-2">
                    <label for="cost_center_apportionments[0][apportionment_percentage]" class="control-label">
                        Rateio (%)
                    </label>
                    <div class="input-group">
                        <span class="input-group-addon">%</span>
                        <input type="number" placeholder="0.00" class="form-control" min="0"
                            name="cost_center_apportionments[0][apportionment_percentage]"
                            id="cost_center_apportionments[0][apportionment_percentage]">
                        @error('cost_center_apportionments[0][apportionment_percentage]')
                            <p><strong>{{ $message }}</strong></p>
                        @enderror
                    </div>
                </div>

                <div class="col-sm-2">
                    <label for="cost_center_apportionments[0][apportionment_currency]" class="control-label">
                        Rateio (R$)
                    </label>
                    <div class="input-group">
                        <span class="input-group-addon">R$</span>
                        <input type="number" name="cost_center_apportionments[0][apportionment_currency]"
                            id="cost_center_apportionments[0][apportionment_currency]" placeholder="0.00"
                            class="form-control" min="0">
                        @error('cost_center_apportionments[0][apportionment_currency]')
                            <p><strong>{{ $message }}</strong></p>
                        @enderror
                    </div>
                </div>

                <div class="col-sm-1" style="margin-top: 28px;">
                    <button class="btn btn-icon btn-small btn-danger delete-cost-center">
                        <i class="fa fa-trash-o"></i>
                    </button>
                </div>
            </div>
        @endif

        {{-- ADICIONAR CENTRO DE CUSTO --}}
        <button type="button" class="btn btn-small btn-primary add-cost-center-btn">
            Adicionar linha
        </button>

        <hr>

        <div class="full-product-line product-form">
            <div class="row center-block" style="padding-bottom: 10px;">
                <h4>DADOS DA SOLICITAÇÃO</h4>
            </div>

            <div class="row" style="margin-bottom:20px; margin-top:5px;">

                {{-- RESPONSÁVEL CONTRATAÇÃO --}}
                <div class="col-sm-3">
                    <label for="form-check" class="control-label" style="padding-right:10px;">
                        Quem está responsável por esta contratação?
                    </label>
                    <div class="form-check">
                        <input name="is_supplies_contract"value="1" class="radio-who-wants"
                            id="is-supplies-contract" type="radio" @checked((isset($purchaseRequest) && (bool) $purchaseRequest->is_supplies_contract) || !isset($purchaseRequest))>
                        <label class="form-check-label" for="is-supplies-contract">Suprimentos</label>

                        <input name="is_supplies_contract" value="0" class="radio-who-wants" type="radio"
                            id="is-area-contract" style="margin-left: 7px;" @checked(isset($purchaseRequest) && !(bool) $purchaseRequest->is_supplies_contract)>
                        <label class="form-check-label" for="is-area-contract"> Área solicitante</label>
                    </div>
                </div>

                {{-- SERVIÇO JÁ PRESTADO --}}
                <div class="col-sm-3">
                    <label for="form-check" class="control-label" style="padding-right:10px;">
                        Este serviço já foi prestado?
                    </label>
                    <div class="form-check">
                        <input name="service[already_provided]"value="1" class="radio-already-provided"
                            id="already-provided" type="radio" @checked((isset($purchaseRequest) && (bool) $purchaseRequest->service->already_provided) || !isset($purchaseRequest))>
                        <label class="form-check-label" for="already-provided">Sim</label>

                        <input name="service[already_provided]" value="0" class="radio-already-provided"
                            type="radio" id="not-provided" style="margin-left: 7px;" @checked(isset($purchaseRequest) && !(bool) $purchaseRequest->service->already_provided)>
                        <label class="form-check-label" for="not-provided">Não</label>
                    </div>
                </div>

            </div>

            <div class="row" style="margin-bottom:5px;">

                {{-- MOTIVO --}}
                <div class="col-sm-4">
                    <div class="form-group">
                        <label for="reason" class="control-label">
                            Motivo da solicitação
                        </label>
                        <textarea data-rule-required="true" minlength="20" name="reason" id="reason" rows="4"
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
                <div class="col-sm-8">
                    <div class="form-group">
                        <label for="description" class="control-label">Descrição</label>
                        <textarea data-rule-required="true" minlength="40" name="description" id="description" rows="4"
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
                        <input data-rule-required="true" minlength="20" name="local_description"
                            value="{{ $purchaseRequest->local_description ?? null }}" type="text"
                            id="local-description"
                            placeholder="Ex: HKM - Av. Gentil Reinaldo Cordioli, 161 - Jardim Eldorado"
                            class="form-control">
                    </div>
                </div>

                <div class="col-sm-2">
                    <div class="form-group">
                        <label for="desired-date" class="control-label">Data desejada</label>
                        <input type="date" name="desired_date" id="desired-date" class="form-control"
                            value="{{ $purchaseRequest->desired_date ?? null }}">
                    </div>
                </div>

                {{-- COMEX --}}
                <div class="col-sm-4">
                    <label for="form-check" class="control-label" style="padding-right:10px;">
                        Contrato se enquadra na categoria COMEX?
                    </label>
                    <div class="form-check" style="12px; margin-top:4px;">
                        <input name="is_comex" value="1" @checked(isset($purchaseRequest) && (bool) $purchaseRequest->is_comex) class="radio-comex"
                            type="radio" data-skin="minimal">
                        <label class="form-check-label" for="services" style="margin-right:15px;">Sim</label>
                        <input name="is_comex"value="0" @checked((isset($purchaseRequest) && !(bool) $purchaseRequest->is_comex) || !isset($purchaseRequest)) class="radio-comex"
                            type="radio" data-skin="minimal">
                        <label class="form-check-label" for="">Não</label>
                    </div>
                </div>

            </div>

            <div class="row">

                {{-- LINK --}}
                <div class="col-sm-6 link-util">
                    <label for="purchase-request-files[path]" class="control-label">Link</label>
                    <input
                        value="{{ isset($purchaseRequest->purchaseRequestFile[0]) && $purchaseRequest->purchaseRequestFile[0]->path ? $purchaseRequest->purchaseRequestFile[0]->path : '' }}"
                        type="text"
                        placeholder="Adicone um link válido. Ex: Contrato disponibilizado pelo fornecedor"
                        name="purchase_request_files[path]" id="purchase-request-files[path]" class="form-control">
                </div>

                {{-- OBSERVACAO --}}
                <div class="col-sm-6">
                    <div class="form-group">
                        <label for="observation" class="control-label">
                            Observações
                        </label>
                        <textarea name="observation" id="observation" rows="2"
                            placeholder="Informações complementares desta solicitação" class="form-control text-area no-resize">{{ $purchaseRequest->observation ?? null }}</textarea>
                    </div>
                </div>

            </div>

            <div class="suppliers-block">
                <div class="row center-block" style="padding-bottom: 5px;">
                    <h4>INFORMAÇÕES DO FORNECEDOR</h4>
                </div>
                <div class="row" style="margin-top: 15px">

                    {{-- FORNECEDOR (CNPJ/RAZAO SOCIAL --}}
                    <div class="col-sm-4 form-group">
                        <label style="display:block;" for="service[supplier_id]" class="control-label">
                            Fornecedor (CNPJ - RAZÃO SOCIAL)
                        </label>
                        <select name="service[supplier_id]" class='select2-me'
                            data-placeholder="Escolha um fornecedor" style="width:100%;">
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
                            <input type="text" id="attendant" name="service[seller]"
                                placeholder="Pessoa responsável pela cotação" class="form-control"
                                data-rule-minlength="2" value="{{ $purchaseRequest?->service?->seller ?? null }}">
                        </div>
                    </div>

                    {{-- TELEFONE --}}
                    <div class="col-sm-2">
                        <div class="form-group">
                            <label for="phone-number" class="control-label">Telefone</label>
                            <input type="text" name="service[phone]" id="phone-number"
                                placeholder="(00) 0000-0000" class="form-control" minLength="14"
                                value="{{ $purchaseRequest?->service?->phone ?? null }}">
                        </div>
                    </div>

                    {{-- E-MAIL --}}
                    <div class="col-sm-3">
                        <div class="form-group">
                            <label for="email" class="control-label">E-mail</label>
                            <input type="email" name="service[email]" id="email"
                                placeholder="user_email@vendedor.com.br" class="form-control" data-rule-email="true"
                                value="{{ $purchaseRequest?->service?->email ?? null }}">
                        </div>
                    </div>

                </div>
            </div>

            <hr>

            <div class="payment-block">
                <div class="row center-block" style="padding-bottom: 10px;">
                    <h4>PAGAMENTO</h4>
                </div>

                <div class="row">
                    {{-- CONDIÇÃO DE PAGAMENTO --}}
                    <div class="col-sm-2">
                        <div class="form-group">
                            <label for="service[is_prepaid]" class="control-label">Condição de pagamento</label>
                            <select name="service[is_prepaid]" id="service[is_prepaid]"
                                class='select2-me service[is_prepaid]' style="width:100%; padding-top:2px;"
                                data-placeholder="Escolha uma opção">
                                <option value=""></option>
                                <option value="1" @selected(isset($purchaseRequest->service) && (bool) $purchaseRequest->service->is_prepaid)>Pagamento antecipado</option>
                                <option value="0" @selected(isset($purchaseRequest->service) && !(bool) $purchaseRequest->service->is_prepaid)>Pagamento após execução</option>
                            </select>
                        </div>
                    </div>

                    {{-- VALOR TOTAL --}}
                    <div class="col-sm-2">
                        <div class="form-group">
                            <label for="format-amount" class="control-label">Valor total do serviço</label>
                            <div class="input-group">
                                <span class="input-group-addon">R$</span>
                                <input type="text" id="format-amount" placeholder="0.00"
                                    class="form-control format-amount"
                                    value="{{ (float) $purchaseRequest?->service?->price ?? null }}">
                                <input type="hidden" name="service[price]" id="amount"
                                    class="amount no-validation"
                                    value="{{ (float) $purchaseRequest?->service?->price ?? null }}">
                            </div>
                        </div>
                    </div>

                    {{-- FORMA DE PAGAMENTO --}}
                    <div class="col-sm-2">
                        <div class="form-group">
                            <label for="payment-method" class="control-label">Forma de pagamento</label>
                            @php
                                $paymentMethod = null;
                                if (isset($purchaseRequest->service) && isset($purchaseRequest->service->paymentInfo)) {
                                    $paymentMethod = $purchaseRequest->service->paymentInfo->payment_method;
                                }
                            @endphp
                            <select name="service[payment_info][payment_method]" id="payment-method"
                                class='select2-me payment-method' style="width:100%; padding-top:2px;"
                                data-placeholder="Escolha uma opção">
                                <option value=""></option>
                                <option value="PIX" {{ $paymentMethod === 'PIX' ? 'selected' : '' }}>PIX</option>
                                <option value="DEPÓSITO BANCÁRIO"
                                    {{ $paymentMethod === 'DEPÓSITO BANCÁRIO' ? 'selected' : '' }}>DEPÓSITO BANCÁRIO
                                </option>
                                <option value="BOLETO" {{ $paymentMethod === 'BOLETO' ? 'selected' : '' }}>BOLETO
                                </option>
                                <option value="CARTÃO CRÉDITO"
                                    {{ $paymentMethod === 'CARTÃO CRÉDITO' ? 'selected' : '' }}>CARTÃO CRÉDITO</option>
                                <option value="CARTÃO DÉBITO"
                                    {{ $paymentMethod === 'CARTÃO DÉBITO' ? 'selected' : '' }}>CARTÃO DÉBITO</option>
                            </select>
                        </div>
                    </div>

                    <input type="hidden" value="" name="service[payment_info][id]">

                    {{-- Nº PARCELAS --}}
                    <div class="col-sm-2">
                        <div class="form-group">
                            <label for="installments-number" class="control-label">Nº de parcelas</label>
                            @php
                                $quantityOfInstallments = $purchaseRequest?->service?->quantity_of_installments;
                            @endphp
                            <select name="service[quantity_of_installments]" class='select2-me'
                                id="installments-number" style="width:100%; padding-top:2px;"
                                data-placeholder="Escolha uma opção">
                                <option value=""></option>
                                <option value="1" @selected($quantityOfInstallments === 1)>1x</option>
                                <option value="2" @selected($quantityOfInstallments === 2)>2x</option>
                                <option value="3" @selected($quantityOfInstallments === 3)>3x</option>
                                <option value="4" @selected($quantityOfInstallments === 4)>4x </option>
                                <option value="5" @selected($quantityOfInstallments === 5)>5x</option>
                                <option value="6" @selected($quantityOfInstallments === 6)>6x</option>
                            </select>
                        </div>
                    </div>
                </div>

                {{-- TABLE PARCELAS --}}
                <div class="row" style="display:flex; align-items:center; margin-top:15px; margin-bottom:5px;">
                    <h4 class="col-sm-6">
                        <i class="fa fa-dollar"></i>
                        Parcelas deste serviço
                    </h4>
                    <div class="col-sm-6 btn-add-installment" hidden>
                        <button type="button" class="btn btn-success pull-right btn-small btn-add-installment"
                            data-route="user" rel="tooltip" title="Adicionar Parcela">
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
                                            <th class="col-sm-2">VENCIMENTO</th>
                                            <th class="col-sm-2">VALOR</th>
                                            <th class='col-sm-4 hidden-350'>OBSERVAÇÃO</th>
                                            <th class='col-sm-2 hidden-1024'>STATUS</th>
                                            <th class='col-sm-2 hidden-480'>AÇÕES</th>
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

                <div class="row justify-content-center">
                    <div class="col-12">
                        <fieldset id="files-group">
                            <legend>Arquivos</legend>
                            <input type="file" class="form-control" name="arquivos[]" multiple>
                            <ul class="list-group" style="margin-top:15px">
                                @if (isset($files))
                                    @foreach ($files as $each)
                                        @php
                                            $filenameSearch = explode('/', $each->path);
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
            </div>
            <div class="form-actions pull-right" style="margin-top:50px;">
                <button type="submit" class="btn btn-primary">Salvar</button>
                <a href="{{ route('requests.own') }}" class="btn">Cancelar</a>
            </div>
        </div>
    </form>

    <x-modal-edit-service-installment :statusValues="$statusValues" />

</div>


<script src="{{ asset('js/supplies/select2-custom.js') }}"></script>
<script>
    $(document).ready(function() {
        const $costCenterPercentage = $('.cost-center-container input[name$="[apportionment_percentage]"]');
        const $costCenterCurrency = $('.cost-center-container input[name$="[apportionment_currency]"]');
        const $fileRemove = $('button.file-remove');
        const $filesGroup = $('fieldset#files-group');
        const csrfToken = $('meta[name="csrf-token"]').attr('content');

        function disableSelectedOptions() {
            const selectedValues = $.map($('.cost-center-container select'), (self) => {
                return $(self).val();
            });
            $('.cost-center-container option').each((_, option) => {
                const includedValues = selectedValues.includes($(option).prop('value'));
                const isSelectedOption = $(option).is(':selected');
                const disabled = includedValues && !isSelectedOption;
                $(option).prop({
                    disabled
                });
            })
        }

        function checkCostCenterCount() {
            const costCenterCount = $('.cost-center-container').length;
            costCenterCount > 1 ? $('.delete-cost-center').prop('disabled', false) : $('.delete-cost-center')
                .prop('disabled', true);
        }
        checkCostCenterCount()

        function updateApportionmentFields() {
            const hasPercentageInput = $costCenterPercentage.filter(function() {
                return $(this).val() !== '';
            }).length > 0;

            const hasCurrencyInput = $costCenterCurrency.filter(function() {
                return $(this).val() !== '';
            }).length > 0;

            $costCenterPercentage.not(':disabled').prop('disabled', !hasPercentageInput && hasCurrencyInput);
            $costCenterCurrency.not(':disabled').prop('disabled', !hasCurrencyInput && hasPercentageInput);

            if (!hasPercentageInput && !hasCurrencyInput) {
                $costCenterPercentage.prop('disabled', false);
                $costCenterCurrency.prop('disabled', false);
            }
        }
        updateApportionmentFields();

        // Desabilita os outros campos de "rateio" de outro tipo quando um tipo é selecionado
        $costCenterPercentage.add($costCenterCurrency).on('input', updateApportionmentFields);

        // Add Centro de Custo
        $('.add-cost-center-btn').click(function() {
            updateApportionmentFields();
            const newRow = $('.cost-center-container').last().clone();
            newRow.find(
                'select[name^="cost_center_apportionments"], input[name^="cost_center_apportionments"]'
            ).each(function() {
                const oldName = $(this).attr('name');
                const regexNewName = /\[(\d+)\]/;
                const lastIndex = Number(oldName.match(regexNewName).at(-1));
                const newName = oldName.replace(regexNewName, `[${lastIndex + 1}]`);
                $(this).attr('name', newName);
            });

            newRow.find("input, select").val("");
            newRow.find('.select2-container').remove();
            newRow.find('.select2-me').select2();

            $('.cost-center-container').last().after(newRow);
            newRow.find('.delete-cost-center').removeAttr('hidden');
            checkCostCenterCount();
            disableSelectedOptions();
        });

        $(document).on('click', '.delete-cost-center', function() {
            $(this).closest('.cost-center-container').remove();
            updateApportionmentFields();
            checkCostCenterCount();
            disableSelectedOptions();
        });

        $(document).on('change', '.cost-center-container .select2-me', disableSelectedOptions);


        const $amount = $('.amount');
        const $serviceAmount = $('#format-amount');
        const $phoneNumber = $('#phone-number');

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


        const $selectSupplier = $('.select-supplier');
        const $paymentMethod = $('.payment-method');
        const $paymentInfo = $('.payment-info');

        const purchaseRequest = @json($purchaseRequest);

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
                        return '<button type="button" rel="tooltip" title="Editar Parcela" class="btn btn-edit-installment"><i class="fa fa-edit"></i></button>';
                    }
                }
            ],
            orderable: false,
            paging: false,
            info: false,
            searching: false,
            language: {
                emptyTable: "",
                zeroRecords: ""
            },
            order: [
                [0, 'desc']
            ],
            createdRow: function(row, data, dataIndex) {
                const hiddenFormattedDate = $(row).data('hidden-date');
                $(row).attr('data-hidden-date', hiddenFormattedDate);
            }
        });

        const isRequestCopy = @json($isCopy);
        const isNotCopyAndIssetPurchaseRequest = !isRequestCopy && purchaseRequest;

        function fillHiddenInputsWithRowData() {
            const tableData = $installmentsTable.data();
            const hiddenInputsContainer = $('.hidden-installments-inputs-container');

            hiddenInputsContainer.empty();

            if (tableData.length > 0) {
                tableData.each(function(rowData, index) {
                    const expireDate = rowData.expire_date;

                    const value = rowData.value;
                    const observation = rowData.observation;
                    const status = rowData.status;

                    const idInput = document.createElement('input');
                    idInput.type = 'number';
                    idInput.name = 'service[service_installments][' + index + '][id]';
                    idInput.value = isNotCopyAndIssetPurchaseRequest ? purchaseRequest?.service
                        ?.installments[index]?.id : null;
                    idInput.hidden = true;

                    const expireDateInput = document.createElement('input');
                    expireDateInput.type = 'date';
                    expireDateInput.name = 'service[service_installments][' + index +
                        '][expire_date]';
                    expireDateInput.value = expireDate;
                    expireDateInput.hidden = true;

                    const valueInput = document.createElement('input');
                    valueInput.type = 'number';
                    valueInput.name = 'service[service_installments][' + index + '][value]';
                    valueInput.value = value;
                    valueInput.hidden = true;

                    const observationInput = document.createElement('input');
                    observationInput.type = 'text';
                    observationInput.name = 'service[service_installments][' + index +
                        '][observation]';
                    observationInput.value = observation;
                    observationInput.hidden = true;

                    const statusInput = document.createElement('input');
                    statusInput.type = 'text';
                    statusInput.name = 'service[service_installments][' + index + '][status]';
                    statusInput.value = status;
                    statusInput.hidden = true;

                    hiddenInputsContainer.append(
                        idInput,
                        expireDateInput,
                        valueInput,
                        observationInput,
                        statusInput,
                    );
                });
            } else {
                const idInput = document.createElement('input');
                idInput.type = 'number';
                idInput.name = 'service[service_installments][0][id]';
                idInput.value = isNotCopyAndIssetPurchaseRequest ? purchaseRequest?.service?.installments[index]
                    ?.id : null;
                idInput.hidden = true;

                const expireDateInput = document.createElement('input');
                expireDateInput.type = 'date';
                expireDateInput.name = 'service[service_installments][0][expire_date]';
                expireDateInput.value = "";
                expireDateInput.hidden = true;

                const valueInput = document.createElement('input');
                valueInput.type = 'number';
                valueInput.name = 'service[service_installments][0][value]';
                valueInput.value = "";
                valueInput.hidden = true;

                const observationInput = document.createElement('input');
                observationInput.type = 'text';
                observationInput.name = 'service[service_installments][0][observation]';
                observationInput.value = "";
                observationInput.hidden = true;

                const statusInput = document.createElement('input');
                statusInput.type = 'text';
                statusInput.name = 'service[service_installments][0][status]';
                statusInput.value = "";
                statusInput.hidden = true;

                hiddenInputsContainer.append(
                    idInput,
                    expireDateInput,
                    valueInput,
                    observationInput,
                    statusInput,
                );
            }
        }

        function deleteHiddenInputs(row) {
            const index = $installmentsTable.row(row).index();
            $('input[name^="service[service_installments][' + index + ']"]').remove();
        }

        function updateHiddenInputIndex() {
            $('input[name^="service[service_installments]"]').each(function() {
                const currentName = $(this).attr('name');
                const newIndex = currentName.replace(/\[(\d+)\]/, function(match, index) {
                    const currentIndex = parseInt(index);
                    return '[' + (currentIndex - 1) + ']';
                });
                $(this).attr('name', newIndex);
            });
        }

        fillHiddenInputsWithRowData();


        // verifica EU ou SUPRIMENTOS (desabilitar fornecedores e pagamento)
        const $radioIsContractedBySupplies = $('.radio-who-wants');
        const $suppliersBlock = $('.suppliers-block');
        const $paymentBlock = $('.payment-block');
        const $linkUtil = $('.link-util');

        $radioIsContractedBySupplies.on('change', function() {
            const isContractedBySupplies = $(this).val() === "1";
            const $elementsToDisable = $suppliersBlock.add($paymentBlock);

            $elementsToDisable
                .find('input, textarea')
                .prop('readonly', isContractedBySupplies);

            $elementsToDisable
                .find('select')
                .prop('disabled', isContractedBySupplies)
                .trigger('change.select2');

            // esconde link caso SUPRIMENTOS
            $linkUtil.prop('hidden', isContractedBySupplies);

            //$installmentsTable.clear().draw();
        }).filter(':checked').trigger('change');

        const $inputInstallmentsNumber = $('#installments-number');

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
            $('#modal-edit-service-installment').modal('show');

            const expireDate = $('#edit-expire-date');
            const value = $('#edit-value');
            const status = $('#edit-status');
            const observation = $('#edit-observation');

            const disabled = selectedRowIndex !== 0;
            value.prop({
                disabled
            });

            if (rowData.expire_date) {
                const formattedDate = new Date(rowData.expire_date.split('/').reverse().join('-'));
                expireDate.val(formattedDate.toISOString().split('T')[0]);
            }

            value.val(rowData.value);
            observation.val(rowData.observation);

            status.select2('val', statusValues.find((status) => status.description === rowData.status).id);

            $('#form-modal-edit-service-installment').one('submit', function(event) {
                event.preventDefault();

                const expireDate = $('#edit-expire-date').val();

                const value = $('#edit-value').val();
                const status = $('#edit-status').find(':selected').text();
                const observation = $('#edit-observation').val();

                // insere valores editados na tabela
                if (selectedRowIndex !== null) {
                    $installmentsTable.cell(selectedRowIndex, 0).data(expireDate);
                    $installmentsTable.cell(selectedRowIndex, 1).data(value);
                    $installmentsTable.cell(selectedRowIndex, 2).data(observation);
                    $installmentsTable.cell(selectedRowIndex, 3).data(status);
                    $installmentsTable.cell(selectedRowIndex, 4).data(editButton);
                    $installmentsTable.draw();

                    if (selectedRowIndex === 0) {
                        const amount = parseFloat($amount.val());
                        const rows = $installmentsTable.rows().data();
                        const selectedRowData = rows[selectedRowIndex];
                        const selectedValue = parseFloat(selectedRowData.value);

                        // Recalcula o valor das parcelas restantes
                        const recalculatedValue = (amount - selectedValue) / (rows.length - 1);

                        rows.each(function(rowData, index) {
                            if (index !== selectedRowIndex) {
                                $installmentsTable.cell(index, 1).data(recalculatedValue
                                    .toFixed(2));
                            }
                        });

                        $installmentsTable.draw();
                    }
                }

                selectedRowIndex = null;

                fillHiddenInputsWithRowData();

                // limpa valores dos inputs (será repopulado na abertura do modal)
                $(this).find('input, select').val('');
                $(this).find('textarea').val('');

                $('#modal-edit-service-installment').modal('hide');
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

        $fileRemove.click(async (e) => {
            const target = $(e.target);
            const li = target.closest('li');
            const idPurchaseRequestFile = li.data("id-purchase-request-file");

            try {
                const response = await fetch("/request/remove-file/" + idPurchaseRequestFile, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': csrfToken
                    }
                });
                if (response.ok) {
                    li.remove();
                    $filesGroup.find('div.alert-success').fadeIn(500).fadeOut(2500);
                }else{
                    $filesGroup.find('div.alert-danger').fadeIn(500).fadeOut(2500);
                }
            } catch (error) {
                console.error(error);
            }
        });
    });
</script>
