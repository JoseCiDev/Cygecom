@php
    use App\Enums\{PurchaseRequestStatus, PaymentMethod, ContractRecurrence};

    $currentUser = auth()->user();

    $issetPurchaseRequest = isset($purchaseRequest);
    $purchaseRequest ??= null;
    $isCopy ??= null;
    $contractInstallments = $purchaseRequest?->contract?->installments;
    $contractPayday = $purchaseRequest?->contract?->payday;
    $purchaseRequestContractAmount = $purchaseRequest?->contract?->amount === null ? null : (float) $purchaseRequest?->contract?->amount;
    $recurrenceSelected = $purchaseRequest?->contract?->recurrence ?? null;
    $isFixedPayment = isset($purchaseRequest->contract) && $purchaseRequest->contract->is_fixed_payment;

    $selectedPaymentMethod = null;
    $selectedPaymentTerm = null;
    if (isset($purchaseRequest->contract) && isset($purchaseRequest->contract->paymentInfo)) {
        $selectedPaymentMethod = $purchaseRequest->contract->paymentInfo->payment_method;
        $selectedPaymentTerm = $purchaseRequest->contract->paymentInfo->payment_terms;
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
        #contract-title {
            border: 1px solid rgb(195, 195, 195);
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
@endpush

<div class="row" style="margin: 0 0 30px;">

    <div class="col-sm-6" style="padding: 0">
        @if ($hasRequestNotSent)
            <h1 class="page-title">Editar solicitação de serviço recorrente nº {{ $purchaseRequest->id }}</h1>
        @elseif ($hasSentRequest)
            <div class="alert alert-info alert-dismissable">
                <h5>
                    <strong>ATENÇÃO:</strong> Esta solicitação já foi enviada ao setor de suprimentos responsável.
                </h5>
            </div>
            <h1 class="page-title">Visualizar solicitação de serviço recorrente nº {{ $purchaseRequest->id }}</h1>
        @else
            <h1 class="page-title">Nova solicitação de serviço recorrente</h1>
        @endif
    </div>

    @if (isset($purchaseRequest) && !$requestAlreadySent)
        <div class="col-md-6 pull-right" style="padding: 0">
            <x-modals.delete />
            <x-toast />

            <button data-cy="btn-delete-request" data-route="api.requests.destroy" data-name="{{ 'Solicitação de serviço recorrente - Nº ' . $purchaseRequest->id }}"
                data-id="{{ $purchaseRequest->id }}" data-bs-toggle="modal" data-bs-target="#modal-delete" rel="tooltip" title="Excluir"
                class="btn btn-primary btn-danger pull-right">
                Excluir solicitação
            </button>
        </div>
    @endif

</div>

<hr style="margin-top:5px; margin-bottom:30px;">

<div class="box-content">

    @php
        if (isset($purchaseRequest) && !$isCopy) {
            $route = route('requests.contract.update', ['type' => $purchaseRequest->type, 'id' => $id]);
        } else {
            $route = route('requests.contract.store');
        }
    @endphp
    <form enctype="multipart/form-data" class="form-validate" id="request-form" data-cy="request-form" data method="POST" action="{{ $route }}">

        @csrf

        <input type="hidden" name="type" value="contract" data-cy="type">

        {{-- NOME CONTRATO --}}
        <div class="row contract-title-container" style="margin-bottom:5px; margin-top:18px;">
            <div class="col-sm-6 contract-title">
                <div class="form-group">
                    <label for="contract-title" class="regular-text label-contract-title">Nome do serviço recorrente: </label>
                    <input type="text" id="contract-title" data-cy="contract-title" name="contract[name]"
                        placeholder="Digite aqui um nome para este serviço recorrente... Ex: Contrato Work DB - 07/23 até 07/24" class="form-control" data-rule-required="true"
                        minlength="15" value="@if (isset($purchaseRequest->contract) && $purchaseRequest->contract->name && !$isCopy) {{ $purchaseRequest->contract->name }} @endif">
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

            <div class="row" style="margin-bottom:15px; margin-top:5px;">

                <div class="col-sm-2">
                    <div class="form-group" style="display: flex">
                        <input name="is_only_quotation" type="checkbox" id="checkbox-only-quotation" data-cy="checkbox-only-quotation" class="checkbox-only-quotation no-validation"
                            style="margin:0" @checked((bool) $purchaseRequest?->is_only_quotation)>
                        <label for="checkbox-only-quotation" class="regular-text form-check-label" style="margin-left:10px;">Solicitação somente de cotação/orçamento</label>
                    </div>
                </div>

                <div class="col-sm-4">
                    <div class="form-group">
                        <label for="form-check" class="regular-text" style="padding-right:10px;">
                            Quem fez/fará esta contratação?
                        </label>
                        <fieldset data-rule-required="true">
                            <div class="row">
                                <div class="col-sm-12">
                                    <input name="is_supplies_contract"value="1" class="radio-who-wants" required id="is-supplies-contract" data-cy="is-supplies-contract"
                                        type="radio" @checked(isset($purchaseRequest) && (bool) $purchaseRequest->is_supplies_contract)>
                                    <label class="form-check-label secondary-text" for="is-supplies-contract">Suprimentos</label>
                                    <input name="is_supplies_contract" value="0" class="radio-who-wants" type="radio" required id="is-area-contract"
                                        data-cy="is-area-contract" style="margin-left: 7px;" @checked(isset($purchaseRequest) && !(bool) $purchaseRequest->is_supplies_contract)>
                                    <label class="form-check-label secondary-text" for="is-area-contract">Eu (Área solicitante)</label>
                                </div>
                            </div>
                        </fieldset>
                    </div>
                </div>

                {{-- COMEX --}}
                <div class="col-sm-4">
                    <div class="form-group">
                        <label for="form-check" class="regular-text" style="padding-right:10px;">
                            Este serviço recorrente será importado (COMEX)?
                        </label>
                        <fieldset data-rule-required="true">
                            <div class="row">
                                <div class="col-sm-5">
                                    <input name="is_comex" id="is_comex_true" data-cy="is_comex_true" value="1" @checked(isset($purchaseRequest) && (bool) $purchaseRequest->is_comex) class="radio-comex"
                                        type="radio" data-skin="minimal" required>
                                    <label class="form-check-label secondary-text" for="is_comex_true" style="margin-right:15px;">Sim</label>
                                    <input name="is_comex" id="is_comex_false" data-cy="is_comex_false" value="0" @checked(isset($purchaseRequest) && !(bool) $purchaseRequest->is_comex) class="radio-comex"
                                        type="radio" data-skin="minimal" required>
                                    <label class="form-check-label secondary-text" for="is_comex_false">Não</label>
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
                        <textarea data-rule-required="true" minlength="20" name="reason" id="reason" data-cy="reason" rows="4"
                            placeholder="Ex: Ar condicionado da sala de reuniões do atrium apresenta defeitos de funcionamento" class="form-control text-area no-resize">{{ $purchaseRequest->reason ?? null }}</textarea>
                    </div>
                    <div class="small" style="margin-top: 10px; margin-bottom:20px;">
                        <p class="secondary-text">* Por favor, forneça uma breve descrição do motivo pelo qual você está solicitando esta compra.</p>
                    </div>
                </div>

                {{-- DESCRICAO --}}
                <div class="col-sm-7">
                    <div class="form-group">
                        <label for="description" class="regular-text">Detalhes do serviço recorrente</label>
                        <textarea data-rule-required="true" minlength="20" name="description" id="description" data-cy="description" rows="4"
                            placeholder="Descreva com detalhes o objetivo do serviço recorrente" class="form-control text-area no-resize">{{ $purchaseRequest->description ?? null }}</textarea>
                    </div>
                    <div class="small" style="margin-top: 10px; margin-bottom:20px;">
                        <p class="secondary-text">* Descreva com detalhes o que deseja solicitar e informações úteis para uma possível cotação.</p>
                    </div>
                </div>

            </div>

            <div class="row">

                {{-- LOCAL --}}
                <div class="col-sm-6">
                    <div class="form-group">
                        <label for="local-description" class="regular-text"> Local da prestação do serviço </label>
                        <input name="local_description" value="{{ $purchaseRequest->local_description ?? null }}" type="text" id="local-description"
                            data-cy="local-description" placeholder="Ex: HKM - Av. Gentil Reinaldo Cordioli, 161 - Jardim Eldorado" class="form-control"
                            data-rule-required="true" minlength="5">
                    </div>
                </div>

                <div class="col-sm-2">
                    <div class="form-group">
                        <label for="desired-date" class="regular-text">Data desejada da contratação</label>
                        <input type="date" name="desired_date" id="desired-date" data-cy="desired-date" min="2020-01-01" max="2100-01-01" class="form-control"
                            value="{{ $purchaseRequest->desired_date ?? null }}">
                    </div>
                </div>

            </div>

            <div class="row mt-3">

                {{-- LINK --}}
                <div class="col-sm-6">
                    <div class="form-group">
                        <label for="support_links" class="regular-text">Links de apoio / sugestão</label>
                        <textarea placeholder="Adicone um ou mais links válidos para apoio ou sugestão." rows="3" name="support_links" id="support_links" data-cy="support_links"
                            class="form-control text-area no-resize">{{ isset($purchaseRequest->support_links) && $purchaseRequest->support_links ? $purchaseRequest->support_links : '' }}</textarea>
                    </div>
                </div>

                {{-- OBSERVACAO --}}
                <div class="col-sm-6">
                    <div class="form-group">
                        <label for="request-observation" class="regular-text"> Observações </label>
                        <textarea name="observation" id="request-observation" data-cy="request-observation" rows="3" placeholder="Informações complementares desta solicitação"
                            class="form-control text-area no-resize">{{ $purchaseRequest->observation ?? null }}</textarea>
                    </div>
                </div>

            </div>

            <hr>

            <div class="payment-block">
                <div class="row center-block" style="padding-bottom: 10px;">
                    <h3>Pagamento</h3>
                </div>

                <div class="row" style="margin-bottom: 20px;">
                    <div class="col-sm-4">
                        <div class="form-group">
                            <fieldset data-rule-required="true">
                                <label for="form-check" class="regular-text" style="padding-right:10px;"> Valor do serviço recorrente será: </label>
                                {{-- FIXO --}}
                                <input name="contract[is_fixed_payment]" data-cy="contract[is_fixed_payment]-true" id="contract[is_fixed_payment]-true" value="1"
                                    class="radio-is-fixed-value" type="radio" data-skin="minimal" required @checked(isset($purchaseRequest->contract->is_fixed_payment) && $isFixedPayment)>

                                <label class="form-check-label secondary-text" for="contract[is_fixed_payment]-true" style="margin-right:15px;">Fixo</label>
                                {{-- VARIAVEL --}}
                                <input name="contract[is_fixed_payment]" data-cy="contract[is_fixed_payment]-false" id="contract[is_fixed_payment]-false" value="0"
                                    class="radio-is-fixed-value" type="radio" data-skin="minimal" required @checked(isset($purchaseRequest->contract->is_fixed_payment) && !$isFixedPayment)>

                                <label class="form-check-label secondary-text" for="contract[is_fixed_payment]-false">Variável</label>
                            </fieldset>

                            <div class="small">
                                <p class="secondary-text">(Se o valor final do serviço recorrente não estiver definido, será variável).</p>
                            </div>
                        </div>
                    </div>

                    {{-- CONDIÇÃO DE PAGAMENTO --}}
                    <div class="col-sm-2" style="margin-top:-10px;">
                        <div class="form-group">
                            <label class="regular-text">Condição de pagamento</label>
                            <select name="contract[payment_info][payment_terms]" id="payment-terms" data-cy="payment-terms" class='select2-me'
                                style="width:100%; padding-top:2px;" data-placeholder="Escolha uma opção">
                                <option value=""></option>
                                @foreach ($paymentTerms as $paymentTerm)
                                    <option value="{{ $paymentTerm->value }}" @selected($paymentTerm->value === $selectedPaymentTerm?->value)>
                                        {{ $paymentTerm->label() }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="col-sm-2" style="margin-top:-10px;">
                        <div class="form-group">
                            <label class="regular-text">Valor total do serviço recorrente: </label>
                            <div class="input-group">
                                <span class="input-group-text">R$</span>
                                <input type="text" placeholder="0,00" class="form-control format-amount" id="format-amount" name="format-amount" data-cy="format-amount"
                                    value="{{ str_replace('.', ',', $purchaseRequestContractAmount) }}">
                                <input type="hidden" name="contract[amount]" id="amount" data-cy="amount" class="amount no-validation"
                                    value="{{ $purchaseRequestContractAmount }}">
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-2" style="margin-top:-10px;">
                        <div class="form-group">
                            <label class="regular-text">Vigência - data inicío</label>
                            <input type="date" name="contract[start_date]" data-cy="contract[start_date]" class="form-control start-date"
                                value="{{ $purchaseRequest->contract->start_date ?? null }}">
                        </div>
                    </div>

                    <div class="col-sm-2" style="margin-top:-10px;">
                        <div class="form-group" style="margin-bottom:0px;">
                            <label class="regular-text">Vigência - data fim</label>
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
                            <input type="checkbox" id="checkbox-has-no-end-date" data-cy="checkbox-has-no-end-date" class="checkbox-has-no-end-date" style="margin:0">
                            <label for="checkbox-has-no-end-date" class="secondary-text" style="margin:0;"> Vigência indeterminada </label>
                        </div>
                    </div>
                </div>

                <div class="row">

                    {{-- RECORRENCIA --}}
                    <div class="col-sm-2">
                        <div class="form-group">
                            <label class="regular-text">Recorrência</label>
                            <select name="contract[recurrence]" id="recurrence" data-cy="recurrence" class="select2-me recurrence" style="width: 100%; padding-top: 2px;"
                                data-placeholder="Escolha uma opção">
                                <option value=""></option>
                                @foreach ($recurrenceOptions as $recurrence)
                                    <option value="{{ $recurrence->value }}" @selected($recurrence->value === $recurrenceSelected?->value)>
                                        {{ $recurrence->label() }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="col-sm-2">
                        <div class="form-group">
                            <label class="regular-text">Dia de vencimento</label>
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
                            <label class="regular-text">Forma de pagamento</label>
                            <select name="contract[payment_info][payment_method]" id="payment-method" data-cy="payment-method" class='select2-me payment-method'
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

                    {{-- DESCRICAO DADOS PAGAMENTO --}}
                    <div class="col-sm-6" style="margin-bottom: -20px;">
                        <div class="form-group">
                            <label for="payment-info-description" class="regular-text"> Detalhes do pagamento </label>
                            <textarea name="contract[payment_info][description]" id="payment-info-description" data-cy="payment-info-description" rows="3"
                                placeholder="Ex: chave PIX, dados bancários do fornecedor, etc." class="form-control text-area no-resize">{{ $purchaseRequest->contract->paymentInfo->description ?? null }}</textarea>
                        </div>
                    </div>

                    <input type="hidden" value="{{ $isCopy ? null : $purchaseRequest?->contract?->paymentInfo?->id }}" name="contract[payment_info][id]"
                        data-cy="contract[payment_info][id]">

                    <input type="hidden" value="" name="contract[quantity_of_installments]" id="qtd-installments" data-cy="qtd-installments">
                </div>

                {{-- TABLE PARCELAS --}}
                <div class="row mt-4" style="display:flex; align-items:center; margin-bottom:5px;">
                    <h3 class="col-sm-6">
                        <i class="fa fa-dollar"></i>
                        Parcelas deste serviço recorrente
                    </h3>
                    <div class="col-sm-6 div-btn-add-installment" style="margin-top:15px;" hidden>
                        <button type="button" class="btn btn-primary btn-small btn-success pull-right btn-add-installment" data-cy="btn-add-installment"
                            data-route="api.users.destroy" rel="tooltip" title="Adicionar Parcela">
                            + Adicionar parcela
                        </button>
                    </div>
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

                                <div class="hidden-installments-inputs-container"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <hr>

            <div class="suppliers-block">
                <div class="row center-block" style="padding-bottom: 5px;">
                    <h3>Informações do fornecedor</h3>
                </div>
                <div class="row" style="margin-top: 10px">

                    {{-- FORNECEDOR (CNPJ/RAZAO SOCIAL --}}
                    <div class="col-sm-4 form-group">
                        <label style="display:block;" for="contract[supplier_id]" class="regular-text">
                            Fornecedor (CNPJ - Razão social)
                        </label>
                        <select name="contract[supplier_id]" data-cy="contract[supplier_id]" class='select2-me select-supplier' data-placeholder="Escolha uma fornecedor"
                            style="width:100%;">
                            <option value="">Informe um fornecedor ou cadastre um novo</option>
                            @foreach ($suppliers as $supplier)
                                @php
                                    $supplierSelected = isset($purchaseRequest->contract) && $purchaseRequest->contract->supplier_id === $supplier->id;
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
                            <input type="text" id="attendant" data-cy="attendant" name="contract[seller]" placeholder="Pessoa responsável pela cotação"
                                class="form-control" data-rule-minlength="2" value="{{ $purchaseRequest?->contract?->seller ?? null }}">
                        </div>
                    </div>

                    {{-- TELEFONE --}}
                    <div class="col-sm-2">
                        <div class="form-group">
                            <label for="phone-number" class="regular-text">Telefone</label>
                            <input type="text" name="contract[phone]" id="phone-number" data-cy="phone-number" placeholder="(00) 0000-0000" class="form-control"
                                value="{{ $purchaseRequest?->contract?->phone ?? null }}">
                        </div>
                    </div>

                    {{-- E-MAIL --}}
                    <div class="col-sm-3">
                        <div class="form-group">
                            <label for="email" class="regular-text">E-mail</label>
                            <input type="text" name="contract[email]" id="email" data-cy="email" placeholder="user_email@vendedor.com.br" class="form-control"
                                data-rule-minlength="2" value="{{ $purchaseRequest?->contract?->email ?? null }}">
                        </div>
                    </div>

                </div>
            </div>

            <hr style="margin-top: 15px; margin-bottom: 15px;">

            {{-- ARQUIVOS --}}
            <div class="row justify-content-center">
                <div class="col-sm-12">
                    <x-RequestFiles :purchaseRequestId="$purchaseRequest?->id" :isCopy="$isCopy" />
                </div>
            </div>


            <div class="form-actions pull-right" style="margin-top:50px; padding-bottom:20px">
                @if (!$hasSentRequest)
                    <input type="hidden" name="action" id="action" value="" data-cy="action">

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

    <x-modals.add-installment />

    <x-ModalEditInstallment :statusValues="$statusValues" />

    <x-modals.supplier-register />

</div>

@push('scripts')
    <script type="module" src="{{ asset('js/supplies/select2-custom.js') }}"></script>
    <script type="module">
        $(() => {
            const $phoneNumber = $('#phone-number');
            $phoneNumber.imask({
                mask: [{
                    mask: '(00) 0000-0000'
                }, {
                    mask: '(00) 00000-0000'
                }]
            });
        });
    </script>

    <script type="module">
        $(document).ready(function() {
            const purchaseRequest = @json($purchaseRequest);
            const statusValues = @json($statusValues);
            const isRequestCopy = @json($isCopy);
            const hasSentRequest = @json($hasSentRequest);

            const $amount = $('.amount');
            const $contractAmount = $('.format-amount');

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

            const editValueInputModalMasked = $editValueInputModal.imask({
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

            const $filesGroup = $('fieldset#files-group');
            const csrfToken = $('meta[name="csrf-token"]').attr('content');

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
                    const processedValue = editValueInputModalMasked.unmaskedValue;
                    if (!isNaN(processedValue)) {
                        $editValueHiddenModal.val(processedValue);
                    }
                }
            });

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
            const minInitialDate = moment('2020-01-01').format('YYYY-MM-DD');
            const $desiredDate = $('#desired-date');

            $desiredDate.attr('min', currentDate);

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
                            return formattedDate || "";
                        }
                    },
                    {
                        data: "value",
                        render: function(data, type, row, meta) {
                            if (!data) {
                                return null;
                            }
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
            });

            const hiddenInputsContainer = $('.hidden-installments-inputs-container');

            const isNotCopyAndIssetPurchaseRequest = !isRequestCopy && purchaseRequest;

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

                const $inputsForInstallmentEvents =
                    $recurrence
                    .add($amount)
                    .add($inputStartDate)
                    .add($inputEndDate)
                if (isFixedValue) {
                    addFixedInstallmentsEvent($inputsForInstallmentEvents);
                } else {
                    $inputsForInstallmentEvents.off('change');
                    $recurrence.select2();
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

            // desabilita pagamento ao entrar em register
            $paymentBlock
                .find('input, textarea')
                .prop('disabled', true);

            $paymentBlock
                .find('input[type="checkbox"], input[type="radio"]')
                .prop('disabled', true);

            $paymentBlock
                .find('select')
                .prop('disabled', true)
                .trigger('change.select2');

            $radioIsContractedBySupplies.on('change', function() {
                const isContractedBySupplies = $(this).val() === "1";

                // muda label fornecedor
                const labelSuppliersSuggestion = "Deseja indicar um fornecedor?";
                const labelSuppliersChoose = "Fornecedor - CNPJ / Razão Social";
                const supplierSelect = $suppliersBlock.find('select');
                const newLabel = isContractedBySupplies ? labelSuppliersSuggestion : labelSuppliersChoose;

                // muda label data desejada
                const labelDesiredDateAlreadyProvided = "Data da contratação";
                const labelDesiredDateDefault = "Data desejada da contratação";
                const newLabelDate = !isContractedBySupplies ? labelDesiredDateAlreadyProvided :
                    labelDesiredDateDefault;
                $desiredDate.siblings('label').text(newLabelDate);

                supplierSelect.siblings('label[for="' + supplierSelect.attr('name') + '"]').text(newLabel);

                // desabilita pagamento
                $paymentBlock
                    .find('input, textarea')
                    .prop('disabled', isContractedBySupplies);

                $paymentBlock
                    .find('input[type="checkbox"], input[type="radio"]')
                    .prop('disabled', isContractedBySupplies);

                $paymentBlock
                    .find('select')
                    .prop('disabled', isContractedBySupplies)
                    .trigger('change.select2');


                if (isContractedBySupplies) {
                    $desiredDate.attr('min', currentDate);

                    $desiredDate.rules('add', {
                        min: currentDate
                    });

                    supplierSelect.removeRequired();
                    supplierSelect.closest('.form-group').removeClass('has-error');
                    $suppliersBlock.find('.help-block').remove();

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

                $desiredDate.attr('min', minInitialDate);

                $desiredDate.rules('add', {
                    min: minInitialDate
                });

                supplierSelect.makeRequired();
            });

            if (!hasSentRequest || $radioIsContractedBySupplies.is(':checked')) {
                $radioIsContractedBySupplies.filter(':checked').trigger('change');
            }


            // declaracao dos botoes edit e delete do datatable
            const editButton =
                '<button type="button" rel="tooltip" title="Editar Parcela" class="btn btn-edit-installment"><i class="fa fa-edit"></i></button>';
            const deleteButton =
                '<button href="#" class="btn btn-delete-installment" style="margin-left:5px" title="Excluir"><i class="fa-solid fa-trash"></i></button>';
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
                const modalAddInstallment = bootstrap.Modal.getOrCreateInstance('#modal-add-installment');
                modalAddInstallment.show();
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

                const expireDate = $('#expire-date').val();
                const expireDateFormatted = moment(expireDate).format('YYYY-MM-DD')
                const value = $('#value-hidden').val();
                const status = $('#status').find(':selected').text();
                const observation = $('#observation').val();

                const installmentModalData = {
                    'expire_date': expireDateFormatted,
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

                $('#status').val('').trigger('change');

                const modalAddInstallment = bootstrap.Modal.getInstance('#modal-add-installment');
                modalAddInstallment.hide();
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
                const modalEditInstallment = bootstrap.Modal.getOrCreateInstance('#modal-edit-installment');
                modalEditInstallment.show();

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

                const statusToModal = (statusValues.find((status) => status.description === rowData.status)).id;
                status.val(statusToModal).trigger('change');

                $('#form-modal-edit-installment').on('submit', function(event) {
                    event.preventDefault();

                    const expireDateInput = $('#edit-expire-date').val();

                    const value = parseFloat($('#edit-value-hidden').val());
                    const status = $('#edit-status').find(':selected').text();
                    const observation = $('#edit-observation').val();

                    if (selectedRowIndex !== null) {
                        $installmentsTable.cell(selectedRowIndex, 0).data(expireDateInput);
                        $installmentsTable.cell(selectedRowIndex, 1).data(value.toFixed(2));
                        $installmentsTable.cell(selectedRowIndex, 2).data(observation);
                        $installmentsTable.cell(selectedRowIndex, 3).data(status);
                        $installmentsTable.draw();
                    }

                    selectedRowIndex = null;

                    fillHiddenInputsWithRowData();

                    $(this).find('input, select').val('');
                    $(this).find('textarea').val('');

                    const modalEditInstallment = bootstrap.Modal.getInstance('#modal-edit-installment');
                    modalEditInstallment.hide();
                });
            }

            // calculo para enviar qtd parcelas
            const $quantityOfInstallments = $('#qtd-installments');

            function calculateQtdInstallmentsToSend() {
                const qtdInstallments = $installmentsTable.data().length;
                $quantityOfInstallments.val(qtdInstallments);
            }

            $installmentsTable.on('draw.dt', calculateQtdInstallmentsToSend);

            const $paymentTerm = $('#payment-terms');
            const $paymentInfoDescription = $('#payment-info-description');
            const $paymentMethod = $('#payment-method');
            const $payday = $('#contract-payday');

            $paymentTerm.on('change', function() {
                const paymentTerm = $(this).val() === "anticipated";

                if (!paymentTerm) {
                    $contractAmount
                        .add($paymentMethod)
                        .add($payday)
                        .add($paymentInfoDescription)
                        .add($recurrence)
                        .add($inputStartDate)
                        .removeRequired()
                        .closest('.form-group')
                        .removeClass('has-error');

                    $paymentBlock.find('.help-block').remove();

                    return;
                }

                $contractAmount
                    .add($paymentMethod)
                    .add($payday)
                    .add($paymentInfoDescription)
                    .add($recurrence)
                    .add($inputStartDate)
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


            // btns
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

            if (isRequestCopy) {
                $('#contract-title').focus();
            }

            if (hasSentRequest) {
                $('#request-form')
                    .find('input, textarea, checkbox')
                    .prop('disabled', hasSentRequest);

                $('#request-form')
                    .find('select')
                    .prop('disabled', hasSentRequest);

                $('.file-remove').prop('disabled', hasSentRequest);

                $('.btn-add-installment').prop('disabled', hasSentRequest);

                $('.add-cost-center-btn').prop('disabled', hasSentRequest);
                $('.delete-cost-center').prop('disabled', hasSentRequest);
            }
        });
    </script>
@endpush
