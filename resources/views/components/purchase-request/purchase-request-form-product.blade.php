@php
    use App\Enums\PurchaseRequestStatus;
    use App\Enums\PaymentMethod;

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

    $purchaseRequestProductAmount = $purchaseRequest?->product?->amount === null ? null : (float) $purchaseRequest?->product?->amount;
    $productQuantityOfInstallments = $purchaseRequest?->product?->quantity_of_installments === null ? null : (int) $purchaseRequest?->product?->quantity_of_installments;

    // verifica status para desabilitar campos para o usuário
    $requestAlreadySent = $purchaseRequest?->status !== PurchaseRequestStatus::RASCUNHO;
    // ve se tem request e não foi enviada
    $hasRequestNotSent = $issetPurchaseRequest && !$requestAlreadySent;
    // ve se tem request ja enviada e n é copia
    $hasSentRequest = $issetPurchaseRequest && $requestAlreadySent && !$isCopy;
@endphp

<style>
    .cost-center-container {
        margin-bottom: 5px
    }

    h4 {
        font-size: 20px;
    }

    .product-row hr {
        border-top: 5px solid rgb(178, 177, 177);
        margin: 0px;
    }
</style>


<div class="row">

    <div class="col-sm-6">
        @if ($hasRequestNotSent)
            <h2>Editar Solicitação</h2>
        @elseif ($hasSentRequest)
            <div class="alert alert-info alert-dismissable">
                <button type="button" class="close" data-dismiss="alert">&times;</button>
                <h5>
                    <strong>ATENÇÃO:</strong> Esta solicitação já foi enviada ao setor de suprimentos responsável.
                </h5>
            </div>
            <h2>Visualizar Solicitação</h2>
        @else
            <h2>Nova Solicitação</h2>
        @endif
    </div>

    {{-- @if (isset($purchaseRequest))
        <div class="col-md-6 pull-right">
            <x-modalDelete />
            <button data-route="purchaseRequests"
                data-name="{{ 'Solicitação de compra - ID ' . $purchaseRequest->id }}"
                data-id="{{ $purchaseRequest->id }}" data-toggle="modal" data-target="#modal" rel="tooltip"
                title="Excluir" class="btn btn-danger pull-right" style="margin-right: 15px">
                Excluir solicitação
            </button>
        </div>
    @endif --}}
</div>

<hr style="margin-top:5px; margin-bottom:30px;">


<div class="box-content">
    <form enctype="multipart/form-data" class="form-validate" id="request-form" method="POST"
        action="@if (isset($purchaseRequest) && !$isCopy) {{ route('request.product.update', ['type' => $purchaseRequest->type, 'id' => $id]) }}
                    @else {{ route('request.product.register') }} @endif">
        @csrf

        <input type="hidden" name="type" value="product">

        <div class="row center-block" style="padding-bottom: 10px;">
            <h4>CONTRATANTE</h4>
        </div>

        {{-- CENTRO DE CUSTOS --}}
        @if (isset($purchaseRequest))
            @foreach ($purchaseRequest->costCenterApportionment as $index => $apportionment)
                <div class="row cost-center-container">
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label style="display:block;" class="control-label">Centro de custo da
                                despesa</label>
                            <select name="cost_center_apportionments[{{ $index }}][cost_center_id]"
                                id="select-cost-center" data-cy="cost-center-apportionments-{{ $index }}"
                                class='select2-me @error('cost_center_id_{{ $index }}') is-invalid @enderror'
                                data-rule-required="true" style="width:100%;" placeholder="Ex: Almoxarifado">
                                <option value=""></option>
                                @foreach ($costCenters as $costCenter)
                                    @php
                                        $isApportionmentSelect = isset($apportionment) && $apportionment->cost_center_id === $costCenter->id;
                                        $companyName = $costCenter->company->name;
                                        $costCenterName = $costCenter->name;
                                        $formattedCnpj = preg_replace('/(\d{2})(\d{3})(\d{3})(\d{4})(\d{2})/', '$1.$2.$3/$4-$5', $costCenter->company->cnpj);
                                    @endphp
                                    <option value="{{ $costCenter->id }}"
                                        {{ $isApportionmentSelect ? 'selected' : '' }}>
                                        {{ $formattedCnpj . ' - ' . $companyName . ' - ' . $costCenterName }}
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
                                id="cost_center_apportionments[{{ $index }}][apportionment_percentage]"
                                data-cy="cost-center-apportionments-{{ $index }}-apportionment_percentage"
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
                                data-cy="cost-center-apportionments-{{ $index }}-apportionment_currency"
                                value="{{ $apportionment->apportionment_currency }}">
                            @error('cost_center_apportionments[{{ $index }}][apportionment_currency]')
                                <p><strong>{{ $message }}</strong></p>
                            @enderror
                        </div>
                    </div>

                    <div class="col-sm-1" style="margin-top: 28px;">
                        <button class="btn btn-icon btn-small btn-danger delete-cost-center"
                            data-cy="delete-cost-center"><i class="fa fa-trash-o"></i>
                        </button>
                    </div>
                </div>
            @endforeach
        @else
            <div class="row cost-center-container">
                <div class="col-sm-6">
                    <div class="form-group">
                        <label class="control-label" style="display:block">
                            Centro de custo da despesa
                        </label>
                        <select style="width:100%" id="select-cost-center" data-cy="select-cost-center"
                            name="cost_center_apportionments[0][cost_center_id]"
                            class='select2-me
                                    @error('cost_center_id_{{ $index }}') is-invalid @enderror'
                            required data-rule-required="true" placeholder="Ex: Almoxarifado">
                            <option value="" disalbed></option>
                            @foreach ($costCenters as $costCenter)
                                @php
                                    $isUserCostCenter = isset($user->person->costCenter) && $user->person->costCenter->id == $costCenter->id;
                                    $companyName = $costCenter->company->name;
                                    $costCenterName = $costCenter->name;
                                    $formattedCnpj = preg_replace('/(\d{2})(\d{3})(\d{3})(\d{4})(\d{2})/', '$1.$2.$3/$4-$5', $costCenter->company->cnpj);
                                @endphp
                                <option value="{{ $costCenter->id }}" @selected($isUserCostCenter)>
                                    {{ $formattedCnpj . ' - ' . $companyName . ' - ' . $costCenterName }}
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
                        <input type="number" placeholder="0.00" class="form-control apportionment-percentage"
                            min="0" name="cost_center_apportionments[0][apportionment_percentage]"
                            id="cost_center_apportionments[0][apportionment_percentage]"
                            data-cy="cost_center_apportionments-0-apportionment_percentage">
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
                            id="cost_center_apportionments[0][apportionment_currency]"
                            data-cy="cost_center_apportionments-0-apportionment_currency" placeholder="0.00"
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
        <button type="button" class="btn btn-small btn-primary add-cost-center-btn" data-cy="add-cost-center-btn">
            Adicionar linha
        </button>

        <hr>

        <div class="full-product-line product-form" data-product="1">
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
                            id="is-supplies-contract" data-cy="is-supplies-contract" type="radio"
                            @checked((isset($purchaseRequest) && (bool) $purchaseRequest->is_supplies_contract) || !isset($purchaseRequest))>
                        <label class="form-check-label" for="is-supplies-contract">Suprimentos</label>

                        <input name="is_supplies_contract" value="0" class="radio-who-wants" type="radio"
                            id="is-area-contract" data-cy="is-area-contract" style="margin-left: 7px;"
                            @checked(isset($purchaseRequest) && !(bool) $purchaseRequest->is_supplies_contract)>
                        <label class="form-check-label" for="is-area-contract"> Área solicitante</label>
                    </div>
                </div>

                {{-- COMEX --}}
                <div class="col-sm-4">
                    <label for="form-check" class="control-label" style="padding-right:10px;">
                        Contrato se enquadra na categoria COMEX?
                    </label>
                    <div class="form-check">
                        <input name="is_comex" data-cy="is-comex" value="1" @checked(isset($purchaseRequest) && (bool) $purchaseRequest->is_comex)
                            class="radio-comex" type="radio" data-skin="minimal">
                        <label class="form-check-label" for="services" style="margin-right:15px;">Sim</label>
                        <input name="is_comex" data-cy="is-not-comex" value="0" @checked((isset($purchaseRequest) && !(bool) $purchaseRequest->is_comex) || !isset($purchaseRequest))
                            class="radio-comex" type="radio" data-skin="minimal">
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

                <div class="col-sm-6" style="margin-bottom:8px;">
                    <div class="form-group product-input" id="product-input">
                        <label for="local-description" class="control-label">
                            Local de entrega do produto
                        </label>
                        <input name="local_description"
                            value="@if (isset($purchaseRequest)) {{ $purchaseRequest->local_description }} @endif"
                            type="text" id="local-description" data-cy="local-description"
                            placeholder="Informe em qual local / sala ficará o produto" class="form-control"
                            data-rule-required="true" data-rule-minlength="2">
                    </div>
                </div>

                {{-- PRODUTO JÁ COMPRADO --}}
                <div class="col-sm-3" style="width: 20%">
                    <label for="form-check" class="control-label" style="padding-right:10px">
                        Você já realizou a compra deste produto?
                    </label>
                    <div class="form-check">
                        <input name="product[already_purchased]" value="1" class="radio-already-purchased"
                            id="already-purchased" data-cy="already-purchased" type="radio"
                            @checked(isset($purchaseRequest) && (bool) $purchaseRequest->product->already_purchased)>
                        <label class="form-check-label" for="already-purchased">Sim</label>

                        <input name="product[already_purchased]" value="0" class="radio-already-purchased"
                            type="radio" id="not-provided" data-cy="not-provided" style="margin-left: 7px;"
                            @checked((isset($purchaseRequest) && !(bool) $purchaseRequest->product->already_purchased) || !isset($purchaseRequest))>
                        <label class="form-check-label" for="not-provided">Não</label>
                    </div>
                </div>

                <div class="col-sm-2">
                    <div class="form-group">
                        <label for="desired-date" class="control-label">Data desejada entrega do produto</label>
                        <input type="date" name="desired_date" id="desired-date" data-cy="desired-date"
                            class="form-control" min="2023-07-24"
                            value="{{ $purchaseRequest->desired_date ?? null }}">
                    </div>
                </div>

            </div>

            <div class="row">
                <div class="col-sm-6">
                    <div class="form-group">
                        <label for="support-links" class="control-label">Links de apoio /
                            sugestão</label>
                        <textarea placeholder="Adicone um ou mais links válidos. Ex: Contrato disponibilizado pelo fornecedor" rows="3"
                            name="support_Links" id="support-links" data-cy="support-links" class="form-control text-area no-resize">{{ $purchaseRequest?->support_links ?? null }}</textarea>
                    </div>
                </div>

                <div class="col-sm-6">
                    <div class="form-group">
                        <label for="observation" class="control-label"> Observação </label>
                        <textarea name="observation" id="request-observation" data-cy="request-observation" rows="3"
                            placeholder="Observação" class="form-control text-area no-resize"></textarea>
                    </div>
                </div>
            </div>

            <div class="payment-block">
                <div class="row center-block" style="padding-bottom: 10px;">
                    <h4>PAGAMENTO</h4>
                </div>

                <div class="row" style="margin-bottom: -50;">
                    {{-- CONDIÇÃO DE PAGAMENTO --}}
                    <div class="col-sm-2">
                        <div class="form-group">
                            <label class="control-label">Condição de pagamento</label>
                            <select name="product[is_prepaid]" id="product-is-prepaid" data-cy="product-is-prepaid"
                                class='select2-me product[is_prepaid]' style="width:100%; padding-top:2px;"
                                data-placeholder="Escolha uma opção">
                                <option value=""></option>
                                <option value="1" @selected(isset($purchaseRequest->product) && (bool) $purchaseRequest->product->is_prepaid)>Pagamento antecipado</option>
                                <option value="0" @selected(isset($purchaseRequest->product) && !(bool) $purchaseRequest->product->is_prepaid)>Pagamento após execução</option>
                            </select>
                        </div>
                    </div>

                    {{-- VALOR TOTAL --}}
                    <div class="col-sm-2">
                        <div class="form-group">
                            <label for="format-amount" class="control-label">Valor total do(s) produto(s)</label>
                            <div class="input-group">
                                <span class="input-group-addon">R$</span>
                                <input type="text" id="format-amount" data-cy="format-amount" placeholder="0.00"
                                    class="form-control format-amount" value="{{ $purchaseRequestProductAmount }}">
                                <input type="hidden" name="product[amount]" id="amount" data-cy="amount"
                                    class="amount no-validation" value="{{ $purchaseRequestProductAmount }}">
                            </div>
                        </div>
                    </div>

                    {{-- FORMA DE PAGAMENTO --}}
                    <div class="col-sm-2">
                        <div class="form-group">
                            <label class="control-label">Forma de pagamento</label>
                            @php
                                $selectedPaymentMethod = null;
                                if (isset($purchaseRequest->product) && isset($purchaseRequest->product->paymentInfo)) {
                                    $selectedPaymentMethod = $purchaseRequest->product->paymentInfo->payment_method;
                                }
                            @endphp
                            <select name="product[payment_info][payment_method]" id="payment-method"
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

                    <input type="hidden" id="product-payment-info-id" data-cy="product-payment-info-id"
                        class="no-validation" value="" name="product[payment_info][id]">

                    {{-- Nº PARCELAS --}}
                    <div class="col-sm-1">
                        <div class="form-group">
                            <label class="control-label">Nº de parcelas</label>
                            <input type="text" class="form-control format-installments-number"
                                placeholder="Ex: 24" value="{{ $productQuantityOfInstallments }}">
                            <input type="hidden" name="product[quantity_of_installments]" id="installments-number"
                                data-cy="installments-number" class="installments-number no-validation"
                                value="{{ $productQuantityOfInstallments }}">
                        </div>
                    </div>

                    {{-- DESCRICAO DADOS PAGAMENTO --}}
                    <div class="col-sm-5" style="margin-bottom: -20px;">
                        <div class="form-group">
                            <label for="payment-info-description" class="control-label">
                                Detalhes do pagamento
                            </label>
                            <textarea name="product[payment_info][description]" id="payment-info-description" data-cy="payment-info-description"
                                rows="3" placeholder="Informações sobre pagamento. Ex: Chave PIX, dados bancários do fornecedor, etc..."
                                class="form-control text-area no-resize">{{ $purchaseRequest->product->paymentInfo->description ?? null }}</textarea>
                        </div>
                    </div>
                </div>

                {{-- TABLE PARCELAS --}}
                <div class="row" style="display:flex; align-items:center; margin-bottom:7px;">
                    <h4 class="col-sm-6">
                        <i class="fa fa-dollar"></i>
                        PARCELAS
                    </h4>
                    <div class="col-sm-6 btn-add-installment" hidden>
                        <button type="button" class="btn btn-success pull-right btn-small btn-add-installment"
                            data-route="user" rel="tooltip" title="Adicionar Parcela"
                            data-cy="btn-add-installment">
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

            {{-- FORNECEDORES COM PRODUTOS --}}

            <div class="supplier-container">
                @php $supplierIndex = 0; @endphp
                @if ($issetPurchaseRequest)
                    @foreach ($productSuppliers as $supplierId => $products)
                        <x-purchase-request.product.supplier :productCategories="$productCategories" :suppliers="$suppliers" :supplierId="$supplierId"
                            :products="$products" :supplierIndex="$supplierIndex" :isCopy="$isCopy" />
                        @php $supplierIndex++; @endphp
                    @endforeach
                @else
                    <x-purchase-request.product.supplier :productCategories="$productCategories" :suppliers="$suppliers" :supplierIndex="$supplierIndex" />
                @endif

                <button type="button" style="margin-top:15px;" class="btn btn-large btn-primary add-supplier-btn">
                    <i class="glyphicon glyphicon-plus"></i>
                    <strong>Adicionar fornecedor</strong>
                </button>

            </div>
        </div>

        <hr style="margin-top: 30px; margin-bottom: 25px;">

        {{-- ARQUIVOS --}}
        <div class="row justify-content-center">
            <div class="col-sm-12">
                <fieldset id="files-group">
                    <h4 style="margin-bottom: 20px;">
                        <i class="fa fa-paperclip"></i> Anexos
                    </h4>
                    <input type="file" class="form-control" name="arquivos[]" multiple>
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
                                                    class='fa fa-trash' style='margin-right:5px'></i>Excluir</span>
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
                <input type="hidden" name="action" id="action" value="">

                <button type="submit" class="btn btn-primary btn-draft" style="margin-right: 10px">
                    Salvar rascunho
                </button>

                <button type="submit" name="submit_request" style="margin-right: 10px"
                    class="btn btn-success btn-submit-request" value="submit-request">
                    Salvar e enviar solicitação
                    <i class="fa fa-paper-plane"></i>
                </button>

                <a href="{{ route('requests.own') }}" class="btn">Cancelar</a>
            @endif

            @if ($hasSentRequest)
                <a href="{{ route('requests.own') }}" class="btn btn-primary btn-large">VOLTAR</a>
            @endif
        </div>
    </form>

    <x-ModalSupplierRegister />

    <x-modal-edit-product-installment :statusValues="$statusValues" />

</div>

<script src="{{ asset('js/supplies/select2-custom.js') }}"></script>
<script>
    $(document).ready(function() {
        hasSentRequest = @json($hasSentRequest);

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

        $editValueInputModal.imask({
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


        const $costCenterPercentage = $('.cost-center-container input[name$="[apportionment_percentage]"]');
        const $costCenterCurrency = $('.cost-center-container input[name$="[apportionment_currency]"]');

        const $fileRemove = $('button.file-remove');
        const $filesGroup = $('fieldset#files-group');
        const csrfToken = $('meta[name="csrf-token"]').attr('content');


        // Verifica quem vai cotar e aplica regra em campo description
        $('input[name="is_supplies_quote"]').change(function() {
            if ($('#supplie_quote').is(':checked')) {
                $('#description').prop('required', true)
                $('.description-span').show()
            } else {
                $('#description').prop('required', false)
                $('.description-span').hide()
            }
        });

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
                const processedValue = formattedValue.replace(/[^0-9,]/g, '').replace(/,/g, '.');
                const rawValue = parseFloat(processedValue);
                if (!isNaN(rawValue)) {
                    $editValueHiddenModal.val(rawValue.toFixed(2)).trigger('change');
                }
            }
        });
        // ---

        // sim está repetindo muito...

        const $selectSupplier = $('.select-supplier');
        const $paymentMethod = $('.payment-method');
        const $paymentInfo = $('.payment-info');

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

            $('.add-product').prop('disabled', hasSentRequest);
            $('.delete-product').prop('disabled', hasSentRequest);

            $('.add-cost-center-btn').prop('disabled', hasSentRequest);
            $('.delete-cost-center').prop('disabled', hasSentRequest);
        }

        const purchaseRequest = @json($purchaseRequest);
        const isRequestCopy = @json($isCopy);
        const isNotCopyAndIssetPurchaseRequest = !isRequestCopy && purchaseRequest;

        // dataTable config - parcelas
        const $installmentsTable = $('#installments-table-striped').DataTable({
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
            } else {
                const idInput = document.createElement('input');
                idInput.type = 'number';
                idInput.name = 'product[product_installments][0][id]';
                idInput.value = isNotCopyAndIssetPurchaseRequest ? purchaseRequest?.product?.installments[0]
                    ?.id : null;
                idInput.hidden = true;
                idInput.className = "no-validation";
                idInput.setAttribute('data-cy', 'product-product_installments-0-id');

                const expireDateInput = document.createElement('input');
                expireDateInput.type = 'date';
                expireDateInput.name = 'product[product_installments][0][expire_date]';
                expireDateInput.value = "";
                expireDateInput.hidden = true;
                expireDateInput.className = "no-validation";
                expireDateInput.setAttribute('data-cy', 'product-product_installments-0-expire_date');


                const valueInput = document.createElement('input');
                valueInput.type = 'number';
                valueInput.name = 'product[product_installments][0][value]';
                valueInput.value = "";
                valueInput.hidden = true;
                valueInput.className = "no-validation";
                valueInput.setAttribute('data-cy', 'product-product_installments-0-value');

                const observationInput = document.createElement('input');
                observationInput.type = 'text';
                observationInput.name = 'product[product_installments][0][observation]';
                observationInput.value = "";
                observationInput.hidden = true;
                observationInput.className = "no-validation";
                observationInput.setAttribute('data-cy', 'product-product_installments-0-observation');

                const statusInput = document.createElement('input');
                statusInput.type = 'text';
                statusInput.name = 'product[product_installments][0][status]';
                statusInput.value = "";
                statusInput.hidden = true;
                statusInput.className = 'no-validation';
                statusInput.setAttribute('data-cy', 'product-product_installments-0-status');

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


        // verifica EU ou SUPRIMENTOS (desabilitar fornecedores e pagamento)
        const $radioIsContractedBySupplies = $('.radio-who-wants');
        const $suppliersBlock = $('.suppliers-block');
        const $paymentBlock = $('.payment-block');

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
            //.data('rule-required', !isContractedBySupplies);

            $paymentBlock
                .find('select')
                .prop('disabled', isContractedBySupplies)
                //.data('rule-required', !isContractedBySupplies)
                .trigger('change.select2');

            if (isContractedBySupplies) {
                //$paymentBlock.find('.form-group').removeClass('has-error');
                //$paymentBlock.find('input').valid();
                $installmentsTable.clear().draw();
            }
        });

        if (!hasSentRequest || $radioIsContractedBySupplies.filter(':checked').val() === "1") {
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
            $('#modal-edit-product-installment').modal('show');

            const expireDate = $('#edit-expire-date');
            const value = $('#edit-value');
            const status = $('#edit-status');
            const observation = $('#edit-observation');

            // const disabled = selectedRowIndex !== 0;
            // value.prop({
            //     disabled
            // });

            if (rowData.expire_date) {
                const formattedDate = new Date(rowData.expire_date.split('/').reverse().join('-'));
                expireDate.val(formattedDate.toISOString().split('T')[0]);
            }

            value.val(rowData.value);
            observation.val(rowData.observation);

            status.select2('val', statusValues.find((status) => status.description === rowData.status).id);

            $('#form-modal-edit-product-installment').one('submit', function(event) {
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

                    // comentado recalculo de parcelas para facilitar no futuro

                    // if (selectedRowIndex === 0) {
                    //     const amount = parseFloat($amount.val());
                    //     const rows = $installmentsTable.rows().data();
                    //     const selectedRowData = rows[selectedRowIndex];
                    //     const selectedValue = parseFloat(selectedRowData.value);

                    //     // Recalcula o valor das parcelas restantes
                    //     const recalculatedValue = (amount - selectedValue) / (rows.length - 1);

                    //     rows.each(function(rowData, index) {
                    //         if (index !== selectedRowIndex) {
                    //             $installmentsTable.cell(index, 1).data(recalculatedValue
                    //                 .toFixed(2));
                    //         }
                    //     });

                    //     $installmentsTable.draw();
                    // }

                    // ---------------------------------------------------------------
                }

                selectedRowIndex = null;

                fillHiddenInputsWithRowData();

                // limpa valores dos inputs (será repopulado na abertura do modal)
                $(this).find('input, select').val('');
                $(this).find('textarea').val('');

                $('#modal-edit-product-installment').modal('hide');
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

        const $isPrePaid = $('#service-is-prepaid');
        const $paymentInfoDescription = $('#payment-info-description');

        $isPrePaid.on('change', function() {
            const isPrePaid = $(this).val() === "1";
            $serviceAmount.data('rule-required', isPrePaid);
            $paymentMethod.data('rule-required', isPrePaid);
            $formatInputInstallmentsNumber.data('rule-required', isPrePaid);
            $paymentInfoDescription.data('rule-required', isPrePaid);

            if (!isPrePaid) {
                $serviceAmount.closest('.form-group').removeClass('has-error');
                $paymentMethod.closest('.form-group').removeClass('has-error');
                $formatInputInstallmentsNumber.closest('.form-group').removeClass('has-error');
                $paymentInfoDescription.closest('.form-group').removeClass('has-error');
                $paymentInfoDescription.closest('.form-group').removeClass('has-error');

                $paymentBlock.find('.help-block').remove();
            }
        });

        if (!hasSentRequest || $isPrePaid.filter(':selected').val() === "1") {
            $isPrePaid.filter(':selected').trigger('change.select2');
        }


        // add supplier
        const $supplierContainer = $('.supplier-container');
        const $addSupplierBtn = $('.add-supplier-btn');

        function checkSuppliersContainerLength() {
            const suppliersCount = $supplierContainer.find('.supplier-block').length;
            const suppliersCountGreaterThanOne = suppliersCount > 1;
            $('.delete-supplier').prop('disabled', !suppliersCountGreaterThanOne);
        }

        const $productContainer = $('.product-container');
        const $addProductBtn = $('.add-product-btn');

        function checkProductRows() {
            $('.supplier-block').each(function() {
                const $productContainer = $(this).find('.product-container');
                const productRowCount = $productContainer.find('.product-row').length;

                $productContainer.find('.delete-product').prop('disabled', productRowCount <= 1);
            });
        }

        checkSuppliersContainerLength();
        checkProductRows();

        $(document).on('click', '.add-supplier-btn', function() {
            const $supplierContainerTemplate = $(this).closest('.supplier-container').find(
                '.supplier-block').last();

            const $newContainer = $supplierContainerTemplate.clone();

            const [_, ...rest] = $newContainer
                .find('.product-row').toArray();
            rest.forEach(element => {
                $(element).remove();
            });


            $newContainer.find(
                'select[name^="purchase_request_products"], input[name^="purchase_request_products"]'
            ).each(function() {
                const oldName = $(this).attr('name');
                const regexNewName = /purchase_request_products\[(\d+)\](.*)/;
                const lastIndex = Number(oldName.match(regexNewName).at(1));
                const anotherRegex = /\[\d+\]/;

                // poderia ser (e foi mermo)
                const newName = oldName
                    .replaceAll(/\[\d+\]/g, `[0]`)
                    .replace(/\[\d+\]/, `[${lastIndex + 1}]`);
                // assinado: --get

                // POWER OF GAMBIARRATION (venceu) será?
                // const newName = oldName
                //     .replace(regexNewName, `purchase_request_products[${lastIndex + 1}]$2`
                //         // função para fazer replace nas demais ocorrências (exceto a primeira);
                //         .replace(anotherRegex, (i => m => !i++ ? m : '')(0))
                //     );

                $(this).attr('name', newName);
            });


            $newContainer.find("input, select").val("");
            $newContainer.find('.select2-container').remove();
            $newContainer.find('.select2-me').select2();

            $('.supplier-block').last().after($newContainer);
            $newContainer.find('.delete-supplier').removeAttr('hidden');

            checkSuppliersContainerLength();
            checkProductRows();

            const $selectSupplier = $newContainer.find('select').first();

            console.log($selectSupplier);

            addBtnSupplierSelect($selectSupplier);
        });

        $(document).on('click', '.delete-supplier', function() {
            $(this).closest('.supplier-block').remove();

            // Atualizar os índices dos fornecedores restantes
            const $supplierBlocks = $('.supplier-block');
            $supplierBlocks.each(function(index) {
                $(this).find(
                    'select[name^="purchase_request_suppliers"], input[name^="purchase_request_suppliers"]'
                ).each(function() {
                    const oldName = $(this).attr('name');
                    const regexNewName = /purchase_request_suppliers\[(\d+)\](.*)/;
                    const newName = oldName.replace(regexNewName,
                        `purchase_request_suppliers[${index}]$2`);
                    $(this).attr('name', newName);
                });
            });

            checkSuppliersContainerLength();
            checkProductRows();
        });


        $(document).on('click', '.add-product-btn', function() {
            const $productRowTemplate = $(this).closest('.product-container').find('.product-row')
                .last();
            const newRow = $productRowTemplate.clone();
            newRow.find(
                'select[name^="purchase_request_products"], input[name^="purchase_request_products"]'
            ).each(function() {
                const oldName = $(this).attr('name');
                const regexNewName = /\[products\]\[(\d+)\]/;
                const lastIndex = Number(oldName.match(regexNewName).at(1));
                const newName = oldName.replace(regexNewName, `[products][${lastIndex + 1}]`);
                $(this).attr('name', newName);
            });

            newRow.find("input, select").val("");
            newRow.find('.select2-container').remove();
            newRow.find('.select2-me').select2();

            $(this).siblings('.product-row').last().after(newRow);
            newRow.find('.delete-product').removeAttr('hidden');

            checkProductRows();
        });

        $(document).on('click', '.delete-product', function() {
            $(this).closest('.product-row').remove();

            checkProductRows();
        });

        // salvar rascunho ou

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
    });
</script>
