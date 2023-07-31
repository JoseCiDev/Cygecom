@php
    use App\Enums\PurchaseRequestStatus;

    $issetPurchaseRequest = isset($purchaseRequest);
    $purchaseRequest ??= null;
    $isCopy ??= null;
    $contractInstallments = $purchaseRequest?->contract?->installments;
    $contractPayday = $purchaseRequest?->contract?->payday;
    $purchaseRequestContractAmount = $purchaseRequest?->contract?->amount === null ? null : (float) $purchaseRequest?->contract?->amount;
    $recurrence = $purchaseRequest?->contract?->recurrence ?? null;

    // verifica status para desabilitar campos para o usuário
    $requestAlreadySent = $purchaseRequest?->status !== PurchaseRequestStatus::RASCUNHO;
    // ve se tem request e não foi enviada
    $hasRequestNotSent = $issetPurchaseRequest && !$requestAlreadySent;
    // ve se tem request ja enviada e n é copia
    $hasSentRequest = $issetPurchaseRequest && $requestAlreadySent && !$isCopy;
@endphp

<style>
    #contract-title {
        border: 1px solid rgb(195, 195, 195);
        padding: 18px 0px 23px 10px;
    }

    #contract-title::placeholder {
        font-size: 16px;
    }

    #contract-title {
        font-size: 20px;
    }

    .label-contract-title {
        font-size: 16px;
    }

    .cost-center-container {
        margin-bottom: 10px;
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
        <div class="col-sm-6 pull-right">
            <x-modalDelete />
            <button data-cy="btn-delete-request" data-route="purchaseRequests" data-name="{{ 'Solicitação de compra - ID ' . $purchaseRequest->id }}"
                data-id="{{ $purchaseRequest->id }}" data-toggle="modal" data-target="#modal" rel="tooltip"
                title="Excluir" class="btn btn-danger pull-right" style="margin-right: 15px">
                Excluir solicitação
            </button>
        </div>
    @endif

</div>

<hr style="margin-top:5px; margin-bottom:30px;">

<div class="box-content">

    @php
        if (isset($purchaseRequest) && !$isCopy) {
            $route = route('request.contract.update', ['type' => $purchaseRequest->type, 'id' => $id]);
        } else {
            $route = route('request.contract.register');
        }
    @endphp
    <form enctype="multipart/form-data" class="form-validate" id="request-form" data-cy="request-form" data method="POST"
        action="{{ $route }}">

        @csrf

        <input type="hidden" name="type" value="contract" data-cy="type">

        {{-- NOME CONTRATO --}}
        <div class="row contract-title-container" style="margin-bottom:5px; margin-top:18px;">
            <div class="col-sm-6 contract-title">
                <div class="form-group">
                    <label for="contract-title" class="control-label label-contract-title">Nome do contrato: </label>
                    <input type="text" id="contract-title" data-cy="contract-title" name="contract[name]"
                        placeholder="Digite aqui um nome para este contrato... Ex: Contrato Work DB - 07/23 até 07/24"
                        class="form-control" data-rule-required="true" minlength="15"
                        value="@if (isset($purchaseRequest->contract) && $purchaseRequest->contract->name) {{ $purchaseRequest->contract->name }} @endif">
                </div>
            </div>
        </div>

        <div class="row center-block" style="padding-bottom: 10px;">
            <h4>CONTRATANTE</h4>
        </div>

        {{-- CENTRO DE CUSTOS --}}
        @if (isset($purchaseRequest))
            @foreach ($purchaseRequest->costCenterApportionment as $index => $apportionment)
                <div class="row cost-center-container">
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label style="display:block;" for="textfield" class="control-label">Centro de custo da
                                despesa</label>
                            <select name="cost_center_apportionments[{{ $index }}][cost_center_id]" data-cy="cost_center_apportionments[{{ $index }}][cost_center_id]"
                                class='select2-me @error('cost_center_id_{{ $index }}') is-invalid @enderror'
                                required data-rule-required="true" style="width:100%;" placeholder="Ex: Almoxarifado">
                                <option value=""></option>
                                @foreach ($costCenters as $costCenter)
                                    @php
                                        $isApportionmentSelect = isset($apportionment) && $apportionment->cost_center_id === $costCenter->id;
                                    @endphp
                                    <option value="{{ $costCenter->id }}"
                                        {{ $isApportionmentSelect ? 'selected' : '' }}>
                                        {{ $costCenter->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
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
                                id="cost_center_apportionments[{{ $index }}][apportionment_percentage]" data-cy="cost_center_apportionments[{{ $index }}][apportionment_percentage]"
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
                                id="cost_center_apportionments[{{ $index }}][apportionment_currency]" data-cy="cost_center_apportionments[{{ $index }}][apportionment_currency]"
                                value="{{ $apportionment->apportionment_currency }}">
                            @error('cost_center_apportionments[{{ $index }}][apportionment_currency]')
                                <p><strong>{{ $message }}</strong></p>
                            @enderror
                        </div>
                    </div>

                    <div class="col-sm-1" style="margin-top: 28px;">
                        <button class="btn btn-icon btn-small btn-danger delete-cost-center" data-cy="btn-delete-cost-center-{{$index}}"><i class="fa fa-trash-o"></i></button>
                    </div>
                </div>
            @endforeach
        @else
            <div class="row cost-center-container">
                <div class="col-sm-6">
                    <div class="form-group">
                        <label for="textfield" class="control-label" style="display:block">
                            Centro de custo da despesa
                        </label>
                        <select style="width:100%" name="cost_center_apportionments[0][cost_center_id]" data-cy="cost_center_apportionments[0][cost_center_id]"
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
                </div>

                <div class="col-sm-2">
                    <label for="cost_center_apportionments[0][apportionment_percentage]" class="control-label">
                        Rateio (%)
                    </label>
                    <div class="input-group">
                        <span class="input-group-addon">%</span>
                        <input type="number" placeholder="0.00" class="form-control" min="0"
                            name="cost_center_apportionments[0][apportionment_percentage]"
                            id="cost_center_apportionments[0][apportionment_percentage]" data-cy="cost_center_apportionments[0][apportionment_percentage]">
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
                            id="cost_center_apportionments[0][apportionment_currency]" data-cy="cost_center_apportionments[0][apportionment_currency]" placeholder="0.00"
                            class="form-control" min="0">
                        @error('cost_center_apportionments[0][apportionment_currency]')
                            <p><strong>{{ $message }}</strong></p>
                        @enderror
                    </div>
                </div>

                <div class="col-sm-1" style="margin-top: 28px;">
                    <button class="btn btn-icon btn-small btn-danger delete-cost-center" data-cy="btn-delete-cost-center-0">
                        <i class="fa fa-trash-o"></i>
                    </button>
                </div>
            </div>
        @endif

        {{-- ADICIONAR CENTRO DE CUSTO --}}
        <button type="button" class="btn btn-small btn-primary add-cost-center-btn" data-cy="btn-add-cost-center">
            Adicionar linha
        </button>

        <hr>

        <div class="full-product-line product-form">
            <div class="row center-block" style="padding-bottom: 10px;">
                <h4>DADOS DA SOLICITAÇÃO</h4>
            </div>

            <div class="row" style="margin-bottom:15px; margin-top:5px;">

                <div class="col-sm-3">
                    <label for="form-check" class="control-label" style="padding-right:10px;">
                        Quem está responsável por esta contratação?
                    </label>
                    <div class="form-check">
                        <input name="is_supplies_contract"value="1" class="radio-who-wants"
                            id="is-supplies-contract" data-cy="is-supplies-contract" type="radio" @checked((isset($purchaseRequest) && (bool) $purchaseRequest->is_supplies_contract) || !isset($purchaseRequest))>
                        <label class="form-check-label" for="is-supplies-contract">Suprimentos</label>

                        <input name="is_supplies_contract" value="0" class="radio-who-wants" type="radio"
                            id="is-area-contract" data-cy="is-area-contract" style="margin-left: 7px;" @checked(isset($purchaseRequest) && !(bool) $purchaseRequest->is_supplies_contract)>
                        <label class="form-check-label" for="is-area-contract"> Área solicitante</label>
                    </div>
                </div>

                {{-- COMEX --}}
                <div class="col-sm-4">
                    <label for="form-check" class="control-label" style="padding-right:10px;">
                        Contrato se enquadra na categoria COMEX?
                    </label>
                    <div class="form-check">
                        <input name="is_comex" data-cy="is_comex_true" value="1" @checked(isset($purchaseRequest) && (bool) $purchaseRequest->is_comex) class="radio-comex"
                            type="radio" data-skin="minimal">
                        <label class="form-check-label" for="services" style="margin-right:15px;">Sim</label>
                        <input name="is_comex" data-cy="is_comex_false" value="0" @checked((isset($purchaseRequest) && !(bool) $purchaseRequest->is_comex) || !isset($purchaseRequest)) class="radio-comex"
                            type="radio" data-skin="minimal">
                        <label class="form-check-label" for="">Não</label>
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
                <div class="col-sm-8">
                    <div class="form-group">
                        <label for="description" class="control-label">Descrição</label>
                        <textarea data-rule-required="true" minlength="20" name="description" id="description" data-cy="description" rows="4"
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
                            Local da prestação do serviço
                        </label>
                        <input name="local_description" value="{{ $purchaseRequest->local_description ?? null }}"
                            type="text" id="local-description" data-cy="local-description"
                            placeholder="Ex: HKM - Av. Gentil Reinaldo Cordioli, 161 - Jardim Eldorado"
                            class="form-control" data-rule-required="true" minlength="5">
                    </div>
                </div>

                <div class="col-sm-2">
                    <div class="form-group">
                        <label for="desired-date" class="control-label">Data desejada da contratação</label>
                        <input type="date" name="desired_date" id="desired-date" data-cy="desired-date" class="form-control"
                            value="{{ $purchaseRequest->desired_date ?? null }}">
                    </div>
                </div>

            </div>

            <div class="row">

                {{-- LINK --}}
                <div class="col-sm-6">
                    <div class="form-group">
                        <label for="purchase-request-files[path]" class="control-label">Links de apoio /
                            sugestão</label>
                        <textarea placeholder="Adicone um ou mais links válidos. Ex: Contrato disponibilizado pelo fornecedor" rows="3"
                            name="purchase_request_files[path]" id="purchase-request-files[path]" data-cy="purchase-request-files[path]" class="form-control text-area no-resize">{{ isset($purchaseRequest->purchaseRequestFile[0]) && $purchaseRequest->purchaseRequestFile[0]->path ? $purchaseRequest->purchaseRequestFile[0]->path : '' }}</textarea>
                    </div>
                </div>

                {{-- OBSERVACAO --}}
                <div class="col-sm-6">
                    <div class="form-group">
                        <label for="request-observation" class="control-label">
                            Observações
                        </label>
                        <textarea name="observation" id="request-observation" data-cy="request-observation" rows="3"
                            placeholder="Informações complementares desta solicitação" class="form-control text-area no-resize">{{ $purchaseRequest->observation ?? null }}</textarea>
                    </div>
                </div>

            </div>

            <hr>

            <div class="payment-block">
                <div class="row center-block" style="padding-bottom: 10px;">
                    <h4>PAGAMENTO</h4>
                </div>

                <div class="row" style="margin-bottom: 20px;">
                    <div class="col-sm-4">
                        <label for="form-check" class="control-label" style="padding-right:10px;">
                            Valor do contrato será:
                        </label>
                        @php
                            $isFixedPayment = isset($purchaseRequest->contract) && $purchaseRequest->contract->is_fixed_payment;
                        @endphp
                        <div class="form-check" style="12px; display:inline;">
                            {{-- FIXO --}}
                            <input name="contract[is_fixed_payment]" data-cy="contract[is_fixed_payment]-true" value="1" class="radio-is-fixed-value"
                                type="radio" data-skin="minimal" @checked(
                                    (isset($purchaseRequest->contract->is_fixed_payment) && $isFixedPayment) ||
                                        !isset($purchaseRequest->contract->is_fixed_payment))>
                            <label class="form-check-label" for="services" style="margin-right:15px;">FIXO</label>
                            {{-- VARIAVEL --}}
                            <input name="contract[is_fixed_payment]" data-cy="contract[is_fixed_payment]-false" value="0" class="radio-is-fixed-value"
                                type="radio" data-skin="minimal" @checked(isset($purchaseRequest->contract->is_fixed_payment) && !$isFixedPayment)>
                            <label class="form-check-label" for="">VARIÁVEL</label>
                        </div>
                        <div class="small" style="color:rgb(85, 85, 85);">
                            <p>(Se o valor final do contrato não estiver difinido, será VARIÁVEL).</p>
                        </div>
                    </div>

                    {{-- CONDIÇÃO DE PAGAMENTO --}}
                    <div class="col-sm-2" style="margin-top:-10px;">
                        <div class="form-group">
                            <label for="contract[is_prepaid]" class="control-label">Condição de pagamento</label>
                            <select name="contract[is_prepaid]" id="contract-is-prepaid" data-cy="contract-is-prepaid"
                                class='select2-me contract[is_prepaid]' style="width:100%; padding-top:2px;"
                                data-placeholder="Escolha uma opção">
                                <option value=""></option>
                                <option value="1" @selected(isset($purchaseRequest->contract) && (bool) $purchaseRequest->contract->is_prepaid)>Pagamento antecipado</option>
                                <option value="0" @selected(isset($purchaseRequest->contract) && !(bool) $purchaseRequest->contract->is_prepaid)>Pagamento após execução</option>
                            </select>
                        </div>
                    </div>

                    <div class="col-sm-2" style="margin-top:-10px;">
                        <div class="form-group">
                            <label class="control-label">Valor total do contrato: </label>
                            <div class="input-group">
                                <span class="input-group-addon">R$</span>
                                <input type="text" placeholder="0,00" class="form-control format-amount"
                                    id="format-amount" data-cy="format-amount" value="{{ $purchaseRequestContractAmount }}">
                                <input type="hidden" name="contract[amount]" id="amount" data-cy="amount"
                                    class="amount no-validation" value="{{ $purchaseRequestContractAmount }}">
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-2" style="margin-top:-10px;">
                        <div class="form-group">
                            <label class="control-label">Vigência - data inicío</label>
                            <input type="date" name="contract[start_date]" data-cy="contract[start_date]" class="form-control start-date"
                                value="{{ $purchaseRequest->contract->start_date ?? null }}">
                        </div>
                    </div>

                    <div class="col-sm-2" style="margin-top:-10px;">
                        <div class="form-group" style="margin-bottom:0px;">
                            <label class="control-label">Vigência - data fim</label>
                            <input type="date" name="contract[end_date]" class="form-control end-date" data-cy="contract[end_date]"
                                value="{{ $purchaseRequest->contract->end_date ?? null }}">
                        </div>
                        <div class="no-end-date"
                            style="
                                display: flex;
                                align-items: center;
                                gap: 5px;
                                margin-top:4px;
                            ">
                            <input type="checkbox" id="checkbox-has-no-end-date" data-cy="checkbox-has-no-end-date" class="checkbox-has-no-end-date"
                                style="margin:0">
                            <label for="checkbox-has-no-end-date" style="margin:0; font-size: 11px;">
                                Vigência indeterminada
                            </label>
                        </div>
                    </div>
                </div>

                <div class="row">

                    {{-- RECORRENCIA --}}
                    <div class="col-sm-2">
                        <div class="form-group">
                            <label class="control-label">Recorrência</label>
                            <select name="recurrence" id="recurrence" data-cy="recurrence" class="select2-me recurrence"
                                style="width: 100%; padding-top: 2px;" data-placeholder="Escolha uma opção">
                                <option value=""></option>
                                <option value="unique" {{ $recurrence?->value === 'unique' ? 'selected' : '' }}>ÚNICA
                                </option>
                                <option value="monthly" {{ $recurrence?->value === 'monthly' ? 'selected' : '' }}>
                                    MENSAL
                                </option>
                                <option value="yearly" {{ $recurrence?->value === 'yearly' ? 'selected' : '' }}>ANUAL
                                </option>
                            </select>
                        </div>
                    </div>

                    <div class="col-sm-2">
                        <div class="form-group">
                            <label class="control-label">Dia de vencimento</label>
                            <select name="contract[payday]" id="contract-payday" data-cy="contract-payday" class='select2-me contract[payday]'
                                style="width:100%; padding-top:2px;" data-placeholder="Escolha uma opção">
                                <option value=""></option>
                                @for ($day = 1; $day <= 31; $day++)
                                    <option value="{{ $day }}" @selected($contractPayday === $day)>
                                        {{ $day }}</option>
                                @endfor
                            </select>
                        </div>
                    </div>

                    {{-- FORMA DE PAGAMENTO --}}
                    <div class="col-sm-2">
                        <div class="form-group">
                            <label class="control-label">Forma de pagamento</label>
                            @php
                                $paymentMethod = null;
                                if (isset($purchaseRequest->contract) && isset($purchaseRequest->contract->paymentInfo)) {
                                    $paymentMethod = $purchaseRequest->contract->paymentInfo->payment_method;
                                }
                            @endphp
                            <select name="contract[payment_info][payment_method]" id="payment-method" data-cy="payment-method"
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

                    {{-- DESCRICAO DADOS PAGAMENTO --}}
                    <div class="col-sm-6" style="margin-bottom: -20px;">
                        <div class="form-group">
                            <label for="payment-info-description" class="control-label">
                                Detalhes do pagamento
                            </label>
                            <textarea name="contract[payment_info][description]" id="payment-info-description" data-cy="payment-info-description" rows="3"
                                placeholder="Informações sobre pagamento. Ex: Chave PIX, dados bancários do fornecedor, etc..."
                                class="form-control text-area no-resize">{{ $purchaseRequest->contract->paymentInfo->description ?? null }}</textarea>
                        </div>
                    </div>

                    <input type="hidden" value="" name="contract[payment_info][id]" data-cy="contract[payment_info][id]">

                    <input type="hidden" value="" name="contract[quantity_of_installments]" id="qtd-installments" data-cy="qtd-installments">
                </div>

                {{-- TABLE PARCELAS --}}
                <div class="row" style="display:flex; align-items:center; margin-bottom:5px;">
                    <h4 class="col-sm-6">
                        <i class="fa fa-dollar"></i>
                        Parcelas deste contrato
                    </h4>
                    <div class="col-sm-6 div-btn-add-installment" hidden>
                        <button type="button" class="btn btn-success pull-right btn-small btn-add-installment" data-cy="btn-add-installment"
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
                <div class="row center-block" style="padding-bottom: 5px;">
                    <h4>INFORMAÇÕES DO FORNECEDOR</h4>
                </div>
                <div class="row" style="margin-top: 10px">

                    {{-- FORNECEDOR (CNPJ/RAZAO SOCIAL --}}
                    <div class="col-sm-4 form-group">
                        <label style="display:block;" for="contract[supplier_id]" class="control-label">
                            Fornecedor (CNPJ - RAZÃO SOCIAL)
                        </label>
                        <select name="contract[supplier_id]" data-cy="contract[supplier_id]" class='select2-me'
                            data-placeholder="Escolha uma fornecedor" style="width:100%;">
                            <option value=""></option>
                            @foreach ($suppliers as $supplier)
                                @php $supplierSelected = isset($purchaseRequest->contract) && $purchaseRequest->contract->supplier_id === $supplier->id; @endphp
                                <option value="{{ $supplier->id }}" @selected($supplierSelected)>
                                    {{ "$supplier->cpf_cnpj - $supplier->corporate_name" }}</option>
                            @endforeach
                        </select>
                    </div>

                    {{-- VENDEDOR/ATENDENTE --}}
                    <div class="col-sm-3">
                        <div class="form-group">
                            <label for="attendant" class="control-label">Vendedor/Atendente</label>
                            <input type="text" id="attendant" data-cy="attendant" name="contract[seller]"
                                placeholder="Pessoa responsável pela cotação" class="form-control"
                                data-rule-minlength="2" value="{{ $purchaseRequest?->contract?->seller ?? null }}">
                        </div>
                    </div>

                    {{-- TELEFONE --}}
                    <div class="col-sm-2">
                        <div class="form-group">
                            <label for="phone-number" class="control-label">Telefone</label>
                            <input type="text" name="contract[phone]" id="phone-number" data-cy="phone-number"
                                placeholder="(00) 0000-0000" class="form-control mask_phone"
                                value="{{ $purchaseRequest?->contract?->phone ?? null }}">
                        </div>
                    </div>

                    {{-- E-MAIL --}}
                    <div class="col-sm-3">
                        <div class="form-group">
                            <label for="email" class="control-label">E-mail</label>
                            <input type="text" name="contract[email]" id="email" data-cy="email"
                                placeholder="user_email@vendedor.com.br" class="form-control" data-rule-minlength="2"
                                value="{{ $purchaseRequest?->contract?->email ?? null }}">
                        </div>
                    </div>

                </div>
            </div>

            <hr>

            {{-- ARQUIVOS --}}
            <div class="row justify-content-center">
                <div class="col-sm-12">
                    <fieldset id="files-group">
                        <legend>Arquivos</legend>
                        <input type="file" class="form-control" name="arquivos[]" data-cy="arquivos" multiple>
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

            <div class="form-actions pull-right" style="margin-top:50px; padding-bottom:20px">
                @if (!$hasSentRequest)
                    <input type="hidden" name="action" id="action" value="" data-cy="action">

                    <button type="submit" data-cy="save-draft" class="btn btn-primary btn-draft" style="margin-right: 10px">
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
                    <a href="{{ route('requests.own') }}" class="btn btn-primary btn-large" data-cy="btn-back">VOLTAR</a>
                @endif
            </div>
        </div>
    </form>

    <x-modal-add-installment />

    <x-modal-edit-installment :statusValues="$statusValues" />

    <x-ModalSupplierRegister />

</div>

<script src="{{ asset('js/supplies/select2-custom.js') }}"></script>
<script>
    $(document).ready(function() {
        const purchaseRequest = @json($purchaseRequest);
        const statusValues = @json($statusValues);
        const isRequestCopy = @json($isCopy);
        const hasSentRequest = @json($hasSentRequest);

        const $amount = $('.amount');
        const $contractAmount = $('.format-amount');

        $('#request-form')
            .find('input, textarea, checkbox')
            .prop('disabled', hasSentRequest);

        $('#request-form')
            .find('select')
            .prop('disabled', hasSentRequest);

        $('.file-remove').prop('disabled', hasSentRequest);


        // masks
        $contractAmount.imask({
            mask: Number,
            scale: 2,
            thousandsSeparator: '.',
            normalizeZeros: true,
            padFractionalZeros: true,
            min: 0,
            max: 1000000000,
        });

        // mascaras pra modal edicao e add
        const $valueModalAdd = $('#value');
        const $valueModalAddHidden = $('#value-hidden');

        const $editValueInputModal = $('#edit-value');
        const $editValueHiddenModal = $('#edit-value-hidden');

        $editValueInputModal.imask({
            mask: Number,
            scale: 2,
            thousandsSeparator: '.',
            normalizeZeros: true,
            padFractionalZeros: true,
            min: 0,
            max: 1000000000,
        });

        $valueModalAdd.imask({
            mask: Number,
            scale: 2,
            thousandsSeparator: '.',
            normalizeZeros: true,
            padFractionalZeros: true,
            min: 0,
            max: 1000000000,
        });


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
        checkCostCenterCount();

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

        // desabilita botao caso nao tenha sido preenchido cost center corretamente;
        const $btnAddCostCenter = $('.add-cost-center-btn');
        const $costCenterSelect = $('.cost-center-container select');

        function toggleCostCenterBtn() {
            const costCenterContainer = $(this).closest('.cost-center-container');

            const costCenterSelect = costCenterContainer
                .find('select')
                .val();

            const costcenterPercentage = costCenterContainer
                .find('input[name$="[apportionment_percentage]"]')
                .val()

            const costCenterCurrency = costCenterContainer
                .find('input[name$="[apportionment_currency]"]')
                .val()

            const isValidApportionment = Boolean(costCenterSelect && (costcenterPercentage ||
                costCenterCurrency));

            $btnAddCostCenter.prop('disabled', !isValidApportionment);
        }

        $(document).on('input change',
            `${$costCenterSelect.selector}, ${$costCenterPercentage.selector}, ${$costCenterCurrency.selector}`,
            toggleCostCenterBtn);

        toggleCostCenterBtn.bind($('.cost-center-container').last()[0])();

        // Desabilita os outros campos de "rateio" de outro tipo quando um tipo é selecionado
        $costCenterPercentage.add($costCenterCurrency).on('input', updateApportionmentFields);


        // trata valor serviço mascara
        $contractAmount.on('input', function() {
            const formattedValue = $(this).val();
            if (formattedValue !== null) {
                const processedValue = formattedValue.replace(/[^0-9,]/g, '').replace(/,/g, '.');
                const rawValue = parseFloat(processedValue);
                if (!isNaN(rawValue)) {
                    $amount.val(rawValue.toFixed(2)).trigger('change');
                }
            }
        });
        // ---

        // sim está repetindo muito...

        // trata valor serviço mascara
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
        // ---

        $valueModalAdd.on('input', function() {
            const formattedValue = $(this).val();
            if (formattedValue !== null) {
                const processedValue = formattedValue.replace(/[^0-9,]/g, '').replace(/,/g, '.');
                const rawValue = parseFloat(processedValue);
                if (!isNaN(rawValue)) {
                    $valueModalAddHidden.val(rawValue.toFixed(2)).trigger('change');
                }
            }
        });
        // ---


        // set desired date min
        const currentDate = moment().format('YYYY-MM-DD');
        const $desiredDate = $('#desired-date');

        $desiredDate.attr('min', currentDate);


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
            toggleCostCenterBtn.bind(this)();
        });

        $(document).on('click', '.delete-cost-center', function() {
            $(this).closest('.cost-center-container').remove();
            updateApportionmentFields();
            checkCostCenterCount();
            disableSelectedOptions();
            toggleCostCenterBtn.bind($('.cost-center-container').last()[0])();
        });

        $(document).on('change', '.cost-center-container .select2-me', disableSelectedOptions);

        // add parcelas na table
        const $inputStartDate = $('.start-date');
        const $inputEndDate = $('.end-date');
        const $recurrence = $('#recurrence');

        function calculateMonthsPassed(startDate, endDate) {
            const startYear = startDate.getFullYear();
            const startMonth = startDate.getMonth();
            const endYear = endDate.getFullYear();
            const endMonth = endDate.getMonth();

            const months = (endYear - startYear) * 12 + (endMonth - startMonth);

            return months;
        }

        function calculateNumberOfInstallments() {
            const startDate = new Date($inputStartDate.val());
            const endDate = new Date($inputEndDate.val());
            const isUniqueRecurrence = $recurrence.find(':selected').val() === "unique";
            const monthsPassed = calculateMonthsPassed(startDate, endDate);
            if (monthsPassed >= 1) {
                const numberOfInstallments = isUniqueRecurrence ? 1 : monthsPassed;
                return numberOfInstallments;
            }

            return;
        }


        // dataTable config
        const $installmentsTable = $('#installments-table-striped').DataTable({
            defer: true,
            data: purchaseRequest?.contract?.installments || [],
            columns: [{
                    data: "expire_date",
                    render: function(data, type, row, meta) {
                        if (!data) {
                            return "";
                        }
                        const formattedDate = moment(data, "YYYY/MM/DD").format("DD/MM/YYYY");
                        return formattedDate || null;
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
                            "<div><button type='button' rel='tooltip' title='Editar Parcela' class='btn btn-edit-installment'><i class='fa fa-edit'></i></button></div>"
                        );
                        const btnDelete = $(
                            "<div><button type='button' class='btn btn-delete-installment' style='margin-left:5px' title='Excluir'><i class='fa fa-times'></i></button></div>"
                        );

                        btnEdit.find('button').prop('disabled', hasSentRequest);
                        btnDelete.find('button').prop('disabled', hasSentRequest);

                        return btnEdit.html() + " " + btnDelete.html();
                    }
                }
            ],
            orderable: false,
            paging: true,
            pageLength: 12,
            info: "Página _PAGE_ of _PAGES_",
            searching: false,
            language: {
                lengthMenu: "",
                emptyTable: "Nenhuma parcela adicionada.",
                zeroRecords: "",
                paginate: {
                    previous: "Anterior",
                    next: "Próximo",
                },
                info: ""
            },
            order: [
                [0, 'desc']
            ],
            // createdRow: function(row, data, dataIndex) {
            //     const hiddenFormattedDate = $(row).data('hidden-date');
            //     $(row).attr('data-hidden-date', hiddenFormattedDate);
            // }
        });

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
                    idInput.name = 'contract[contract_installments][' + index + '][id]';
                    idInput.value = isNotCopyAndIssetPurchaseRequest ? purchaseRequest?.contract
                        ?.installments[index]?.id : null;
                    idInput.hidden = true;

                    const expireDateInput = document.createElement('input');
                    expireDateInput.type = 'date';
                    expireDateInput.name = 'contract[contract_installments][' + index +
                        '][expire_date]';
                    expireDateInput.value = expireDate;
                    expireDateInput.hidden = true;

                    const valueInput = document.createElement('input');
                    valueInput.type = 'number';
                    valueInput.name = 'contract[contract_installments][' + index + '][value]';
                    valueInput.value = value;
                    valueInput.hidden = true;

                    const observationInput = document.createElement('input');
                    observationInput.type = 'text';
                    observationInput.name = 'contract[contract_installments][' + index +
                        '][observation]';
                    observationInput.value = observation;
                    observationInput.hidden = true;

                    const statusInput = document.createElement('input');
                    statusInput.type = 'text';
                    statusInput.name = 'contract[contract_installments][' + index + '][status]';
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
                idInput.type = 'text';
                idInput.name = 'contract[contract_installments][0][id]';
                idInput.value = isNotCopyAndIssetPurchaseRequest ? purchaseRequest?.contract?.installments[0]
                    ?.id :
                    null;
                idInput.hidden = true;

                const expireDateInput = document.createElement('input');
                expireDateInput.type = 'text';
                expireDateInput.name = 'contract[contract_installments][0][expire_date]';
                expireDateInput.value = "";
                expireDateInput.hidden = true;

                const valueInput = document.createElement('input');
                valueInput.type = 'text';
                valueInput.name = 'contract[contract_installments][0][value]';
                valueInput.value = "";
                valueInput.hidden = true;

                const observationInput = document.createElement('input');
                observationInput.type = 'text';
                observationInput.name = 'contract[contract_installments][0][observation]';
                observationInput.value = "";
                observationInput.hidden = true;

                const statusInput = document.createElement('input');
                statusInput.type = 'text';
                statusInput.name = 'contract[contract_installments][0][status]';
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
            $('input[name^="contract[contract_installments][' + index + ']"]').remove();
        }

        function updateHiddenInputIndex() {
            $('input[name^="contract[contract_installments]"]').each(function() {
                const currentName = $(this).attr('name');
                const newIndex = currentName.replace(/\[(\d+)\]/, function(match, index) {
                    const currentIndex = parseInt(index);
                    return '[' + (currentIndex - 1) + ']';
                });
                $(this).attr('name', newIndex);
            });
        }

        fillHiddenInputsWithRowData();

        // hide and show btn add parcela
        const $radioIsFixedValue = $('.radio-is-fixed-value');
        const $divBtnAddInstallment = $('.div-btn-add-installment');
        const $btnAddInstallment = $('.btn-add-installment');
        const $checkboxHasNoEndDate = $('.checkbox-has-no-end-date');

        $radioIsFixedValue.on('change', function() {
            const isFixedValue = $(this).val() === "1";
            $divBtnAddInstallment.attr('hidden', isFixedValue);

            if (!isRequestCopy && !purchaseRequest) {
                $installmentsTable.clear().draw();
            }

            $inputsForInstallmentEvents =
                $recurrence
                .add($amount)
                .add($inputStartDate)
                .add($inputEndDate)
            if (isFixedValue) {
                addFixedInstallmentsEvent($inputsForInstallmentEvents);
            } else {
                $inputsForInstallmentEvents.off('change');
            }
        }).filter(':checked').trigger('change');

        // show btn add installment quando VIGENCIA INDETERMINADA
        $checkboxHasNoEndDate.on('click', function() {
            hasNoEndDate = $(this).is(':checked');
            $divBtnAddInstallment.attr('hidden', !hasNoEndDate);

            if (hasNoEndDate) {
                $(this).data('last-value', $inputEndDate.val());
            }

            const currentValue = hasNoEndDate ? null : $(this).data('last-value');
            $inputEndDate.prop('readonly', hasNoEndDate).val(currentValue);

            $installmentsTable.clear().draw();
        });


        // verifica EU ou SUPRIMENTOS (desabilitar fornecedores e pagamento)
        const $radioIsContractedBySupplies = $('.radio-who-wants');
        const $paymentBlock = $('.payment-block');
        const $suppliersBlock = $('.suppliers-block');

        const labelSuppliersSuggestion = "Deseja indicar um fornecedor?";
        const labelSuppliersChoose = "Fornecedor - CNPJ / Razão Social";

        $radioIsContractedBySupplies.on('change', function() {
            const isContractedBySupplies = $(this).val() === "1";

            // muda label
            const supplierSelect = $suppliersBlock.find('select');
            const newLabel = isContractedBySupplies ? labelSuppliersSuggestion : labelSuppliersChoose;

            supplierSelect.siblings('label[for="' + supplierSelect.attr('name') + '"]').text(newLabel);
            supplierSelect.data('rule-required', !isContractedBySupplies);

            // desabilita pagamento
            $paymentBlock
                .find('input, textarea')
                .prop('readonly', isContractedBySupplies);

            $paymentBlock
                .find('input[type="checkbox"], input[type="radio"]')
                .prop('disabled', isContractedBySupplies);

            $paymentBlock
                .find('select')
                .prop('disabled', isContractedBySupplies)
                .trigger('change.select2');


            if (isContractedBySupplies) {
                //$paymentBlock.find('.form-group').removeClass('has-error').valid();
                $installmentsTable.clear().draw();
            }

        });

        if (!hasSentRequest || $radioIsContractedBySupplies.filter(':checked').val() === "1") {
            $radioIsContractedBySupplies.filter(':checked').trigger('change');
        }


        // declaracao dos botoes edit e delete do datatable
        const editButton =
            '<button type="button" rel="tooltip" title="Editar Parcela" class="btn btn-edit-installment"><i class="fa fa-edit"></i></button>';
        const deleteButton =
            '<button href="#" class="btn btn-delete-installment" style="margin-left:5px" title="Excluir"><i class="fa fa-times"></i></button>';
        const buttonsHTML = editButton + deleteButton;

        function generateInstallments(numberOfInstallments) {
            const startDate = new Date($inputStartDate.val());
            const totalAmount = ($amount.val() / numberOfInstallments).toFixed(2);

            const installmentsData = [];

            for (let i = 1; i <= numberOfInstallments; i++) {
                const installmentDate = new Date();
                const formattedDate = installmentDate.toLocaleDateString('pt-BR');
                //const hiddenFormattedDate = installmentDate.toISOString();

                const installmentData = {
                    expire_date: "",
                    value: totalAmount,
                    observation: "Parcela " + i + "/" + numberOfInstallments,
                    status: "PENDENTE",
                    // hiddenFormattedDate
                };

                installmentsData.push(installmentData);
            }

            for (const installmentData of installmentsData) {
                const rowNode = $installmentsTable.row.add(installmentData).node();
                $(rowNode).children('td').eq(0).attr('hidden', installmentData[4]);
            }

            fillHiddenInputsWithRowData();

            $installmentsTable.draw();
        }

        // gerar parcelas a partir do change de varios inputs
        function addFixedInstallmentsEvent($inputsForInstallmentEvents) {
            $inputsForInstallmentEvents.on('change', function() {
                const changeableInputs = [
                    $recurrence.val(),
                    $amount.val(),
                    $inputStartDate.val(),
                    $inputEndDate.val()
                ];
                if (!changeableInputs.every(Boolean)) {
                    return;
                }
                const numberOfInstallments = calculateNumberOfInstallments();
                $installmentsTable.clear();
                generateInstallments(numberOfInstallments);
            });
        }

        $('.btn-add-installment').on('click', function() {
            $('#modal-add-installment').modal('show');
        });

        // form modal add installment
        $('#form-modal-add-installment').on('submit', function(event) {
            event.preventDefault();

            const isValid = $(this).valid();

            if (!isValid) {
                return;
            }

            $('#edit-status').select2({
                maximumSelectionLength: 1
            });

            const expireDate = new Date($('#expire-date').val());
            const expireDateFormatted = expireDate.toLocaleDateString('pt-BR', {
                timeZone: 'UTC'
            });
            const value = $('#value-hidden').val();
            const status = $('#status').find(':selected').text();
            const observation = $('#observation').val();

            const installmentModalData = {
                expireDateFormatted,
                value,
                observation,
                status,
                //hiddenFormattedDate
            };

            $installmentsTable.row.add(installmentModalData);
            $installmentsTable.draw();

            fillHiddenInputsWithRowData();

            $(this).find('input, select').val('');
            $(this).find('textarea').val('');

            $('#modal-add-installment').modal('hide');
        });

        $('#installments-table-striped tbody').on('click', 'tr', function(event) {
            event.preventDefault();

            if ($(event.target).closest('.btn-delete-installment').length) {
                const row = $(this);
                const installmentId = row.data('id');

                deleteHiddenInputs(row);
                updateHiddenInputIndex();

                $installmentsTable.row(row).remove().draw();

            } else if ($(event.target).closest('.btn-edit-installment').length) {
                const rowData = $installmentsTable.row(this).data();
                openModalForEdit(rowData);
                selectedRowIndex = $installmentsTable.row(this).index();
            }
        });

        let selectedRowIndex = null;

        // modal edit installment
        function openModalForEdit(rowData) {
            $('#modal-edit-installment').modal('show');

            const expireDate = $('#edit-expire-date');
            const value = $('#edit-value');
            const status = $('#edit-status');
            const observation = $('#edit-observation');

            if (rowData.expire_date) {
                const formattedDate = new Date(rowData.expire_date.split('/').reverse().join('-'));
                expireDate.val(formattedDate.toISOString().split('T')[0]);
            }

            value.val(rowData.value);
            observation.val(rowData.observation);

            status.select2('val', statusValues.find((status) => status.description === rowData.status).id);

            $('#form-modal-edit-installment').on('submit', function(event) {
                event.preventDefault();

                const expireDateInput = $('#edit-expire-date').val();

                const value = $('#edit-value').val();
                const status = $('#edit-status').find(':selected').text();
                const observation = $('#edit-observation').val();

                if (selectedRowIndex !== null) {
                    $installmentsTable.cell(selectedRowIndex, 0).data(expireDateInput);
                    $installmentsTable.cell(selectedRowIndex, 1).data(value);
                    $installmentsTable.cell(selectedRowIndex, 2).data(observation);
                    $installmentsTable.cell(selectedRowIndex, 3).data(status);
                    $installmentsTable.draw();
                }

                selectedRowIndex = null;

                fillHiddenInputsWithRowData();

                $(this).find('input, select').val('');
                $(this).find('textarea').val('');

                $('#modal-edit-installment').modal('hide');
            });
        }

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
                } else {
                    $filesGroup.find('div.alert-danger').fadeIn(500).fadeOut(2500);
                }
            } catch (error) {
                console.error(error);
            }
        });

        // calculo para enviar qtd parcelas
        const $quantityOfInstallments = $('#qtd-installments');

        function calculateQtdInstallmentsToSend() {
            const qtdInstallments = $installmentsTable.data().length;
            $quantityOfInstallments.val(qtdInstallments);
        }

        $installmentsTable.on('draw.dt', calculateQtdInstallmentsToSend);

        const $isPrePaid = $('#contract-is-prepaid');
        const $paymentInfoDescription = $('#payment-info-description');
        const $paymentMethod = $('#payment-method');
        const $payday = $('#contract-payday');

        $isPrePaid.on('change', function() {
            const isPrePaid = $(this).val() === "1";
            $contractAmount.data('rule-required', isPrePaid);
            $paymentMethod.data('rule-required', isPrePaid);
            $payday.data('rule-required', isPrePaid);
            $paymentInfoDescription.data('rule-required', isPrePaid);
            $recurrence.data('rule-required', isPrePaid);
            $inputStartDate.data('rule-required', isPrePaid);
            $inputEndDate.data('rule-required', isPrePaid);

            if (!isPrePaid) {
                $contractAmount.closest('.form-group').removeClass('has-error');
                $paymentMethod.closest('.form-group').removeClass('has-error');
                $payday.closest('.form-group').removeClass('has-error');
                $paymentInfoDescription.closest('.form-group').removeClass('has-error');
                $recurrence.closest('.form-group').removeClass('has-error');
                $inputStartDate.closest('.form-group').removeClass('has-error');
                $inputEndDate.closest('.form-group').removeClass('has-error');

                $paymentBlock.find('.help-block').remove();
            }
        });

        if (!hasSentRequest || $isPrePaid.filter(':selected').val() === "1") {
            $isPrePaid.filter(':selected').trigger('change.select2');
        }

        // btns
        const $btnSubmitRequest = $('.btn-submit-request');
        const $sendAction = $('#action');

        $btnSubmitRequest.on('click', function(event) {
            event.preventDefault();

            bootbox.confirm({
                message: "Esta solicitação será <strong>enviada</strong> para o setor de <strong>suprimentos responsável</strong>. <br><br> Deseja confirmar esta ação?",
                buttons: {
                    confirm: {
                        label: 'Sim, enviar solicitação',
                        className: 'btn-success'
                    },
                    cancel: {
                        label: 'Cancelar',
                        className: 'btn-danger'
                    }
                },
                callback: function(result) {
                    if (result) {
                        $sendAction.val('submit-request');
                        $('#request-form').trigger('submit');
                    }
                }
            });
        });
    });
</script>
