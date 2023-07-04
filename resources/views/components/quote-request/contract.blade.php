<x-app>

    <x-slot name="title">
        <h1>Solicitar Novo Contrato</h1>
    </x-slot>

    <style>
        [contenteditable] {
            outline: 0px solid transparent;
        }

        #contract-title {
            border: none;
        }

        #contract-title::placeholder {
            font-size: 16px;
        }

        #contract-title {
            font-size: 20px;
            padding-left: 0px;
        }

        .cost-center-container {
            margin-bottom: 10px;
        }

        h4 {
            font-size: 20px;
        }
    </style>

    <form class="form-validate" id="request-form" method="POST"
        action="@if (isset($quoteRequest) && !$isCopy) {{ route('request.update', ['id' => $id]) }}
                    @else {{ route('requests.new') }} @endif">
        @csrf

        <div class="row contract-title-container" style="margin-bottom:10px; margin-top:18px;">
            <div class="col-sm-8 contract-title">
                <div class="form-group">
                    <label for="contract-title" class="control-label">Nome do contrato: </label>
                    <input type="text" id="contract-title" name="contract_title"
                        placeholder="Digite aqui um nome para este contrato..." class="form-control"
                        data-rule-required="true" minlength="15">
                </div>
            </div>
        </div>

        <div class="row" style="margin-bottom:10px; margin-top:5px;">
            <div class="col-sm-4">
                <label for="form-check" class="control-label" style="padding-right:10px;">
                    Quem está responsável por esta contratação?
                </label>
                <div class="form-check">
                    <input name="x" value="1" class="radio-who-wants" type="radio">
                    <label class="form-check-label" for="services" style="margin-right:15px;">Eu mesmo(a)</label>
                    <input checked name="x"value="0" class="radio-who-wants" type="radio">
                    <label class="form-check-label" for="who-wants">Suprimentos</label>
                </div>
            </div>
        </div>

        <div class="row center-block" style="padding-bottom: 10px;">
            <h4>CONTRATANTE</h4>
        </div>

        {{-- CENTRO DE CUSTOS --}}
        @if (isset($quoteRequest))
            @foreach ($quoteRequest->costCenterApportionment as $index => $apportionment)
                <div class="row cost-center-container">
                    <div class="col-sm-6">
                        <label style="display:block;" for="textfield" class="control-label">Centro de custo da
                            despesa</label>
                        <select name="cost_center_apportionments[{{ $index }}][cost_center_id]"
                            class='select2-me @error('cost_center_id_{{ $index }}') is-invalid @enderror'
                            data-rule-required="true" style="width:100%;" placeholder="Ex: Almoxarifado">
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

                    <div class="col-md-2">
                        <label for="cost_center_apportionments[{{ $index }}][apportionment_percentage]"
                            class="control-label">Rateio (%)
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

                    <div class="col-md-2">
                        <label for="cost_center_apportionments[{{ $index }}][apportionment_currency]"
                            class="control-label">Rateio (R$)
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

                <div class="col-md-2">
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

                <div class="col-md-2">
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

        <div class="full-product-line product-form" data-product="1">
            <div class="row center-block" style="padding-bottom: 10px;">
                <h4>DETALHES DA SOLICITAÇÃO</h4>
            </div>

            <div class="row" style="margin-bottom:5px;">
                <div class="col-sm-4">
                    <div class="form-group">
                        <label for="reason" class="control-label">
                            Motivo da solicitação
                        </label>
                        <textarea required name="reason" id="reason" rows="4"
                            placeholder="Ex: Ar condicionado da sala de reuniões do atrium apresenta defeitos de funcionamento"
                            class="form-control text-area no-resize">{{ $quoteRequest->reason ?? null }}</textarea>
                    </div>
                    <div class="small" style="color:rgb(85, 85, 85); margin-top:-10px; margin-bottom:20px;">
                        <p>* Por favor, forneça uma breve descrição do motivo pelo qual você está solicitando esta
                            compra.
                        </p>
                    </div>
                </div>
                <div class="col-sm-8">
                    <div class="form-group">
                        <label for="description" class="control-label">Descrição</label>
                        <textarea required name="description" id="description" rows="4"
                            placeholder="Ex.: Contratação de serviço para consertar e verificar o estado dos ar-condicionados da HKM."
                            class="form-control text-area no-resize">{{ $quoteRequest->description ?? null }}</textarea>
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
                        <label for="local-description" class="control-label local-description">
                            Local de execução do serviço
                        </label>
                        <input name="local_description"
                            value="@if (isset($quoteRequest)) {{ $quoteRequest->local_description }} @endif"
                            type="text" id="local-description"
                            placeholder="Ex: HKM - Av. Gentil Reinaldo Cordioli, 161 - Jardim Eldorado"
                            class="form-control local-description" data-rule-required="true" data-rule-minlength="2">
                    </div>
                </div>

                <div class="col-sm-2">
                    <div class="form-group">
                        <label for="desired-date" class="control-label">Data desejada</label>
                        <input type="date" name="desired_date" id="desired-date" class="form-control"
                            value="{{ isset($quoteRequest) && $quoteRequest->desired_date ? $quoteRequest->desired_date : '' }}">
                    </div>
                </div>

                <div class="col-sm-4">
                    <label for="form-check" class="control-label" style="padding-right:10px;">
                        Contrato se enquadra na categoria COMEX?
                    </label>
                    <div class="form-check" style="12px; margin-top:4px;">
                        <input name="is_comex" value="1" @if (isset($quoteRequest) && $quoteRequest->is_comex) checked @endif
                            class="radio-comex" type="radio" data-skin="minimal">
                        <label class="form-check-label" for="services" style="margin-right:15px;">Sim</label>
                        <input name="is_comex"value="0" @if (isset($quoteRequest) && !$quoteRequest->is_comex) checked @endif
                            class="radio-comex" type="radio" data-skin="minimal">
                        <label class="form-check-label" for="">Não</label>
                    </div>
                </div>

            </div>

            <div class="row">
                <div class="col-sm-8">
                    <label for="quote_request_files[path]" class="control-label">
                        Link de sugestão</label>
                    <input type="text" placeholder="Adicone um link válido" name="quote_request_files[path]"
                        id="quote_request_files[path]" data-rule-url="true" class="form-control">
                </div>
            </div>

            <hr>

            {{-- BLOCO FORNECEDOR --}}
            <div class="suppliers-block">
                <div class="row center-block" style="padding-bottom: 10px;">
                    <h4>INFORMAÇÕES DO FORNECEDOR</h4>
                </div>
                <div class="row">
                    {{-- CNPJ/NOME FORNECEDOR --}}
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label for="supplier" class="control-label">Fornecedor (CNPJ - RAZÃO
                                SOCIAL)</label>
                            <select name="suppliers[0][id]" id="supplier" class='select2-me select-supplier'
                                style="width:100%;" data-placeholder="Encontre o fornecedor desejado">
                                <option value=""></option>
                                @foreach ($suppliers as $supplier)
                                    <option value="{{ $supplier['id'] }}">
                                        {{ $supplier['corporate_name'] }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    {{-- VENDEDOR/ATENDENTE --}}
                    <div class="col-sm-3">
                        <div class="form-group">
                            <label for="attendant" class="control-label">Vendedor/Atendente</label>
                            <input type="text" id="attendant" name="suppliers[0][attendant]"
                                placeholder="Pessoa responsável pela cotação" class="form-control"
                                data-rule-minlength="2">
                        </div>
                    </div>
                    {{-- TELEFONE --}}
                    <div class="col-sm-2">
                        <div class="form-group">
                            <label for="phone-number" class="control-label">Telefone</label>
                            <input type="text" name="suppliers[0][phone_number]" id="phone-number"
                                placeholder="(00) 0000-0000" class="form-control mask_phone">
                        </div>
                    </div>
                    {{-- E-MAIL --}}
                    <div class="col-sm-3">
                        <div class="form-group">
                            <label for="email" class="control-label">E-mail</label>
                            <input type="text" name="suppliers[0][email]" id="email"
                                placeholder="user_email@vendedor.com.br" class="form-control"
                                data-rule-minlength="2">
                        </div>
                    </div>
                </div>
            </div>

            <hr>

            <div class="payment-block">
                <div class="row center-block" style="padding-bottom: 10px;">
                    <h4>PAGAMENTO</h4>
                </div>

                <div class="row" style="margin-bottom:20px;">
                    <div class="col-sm-4">
                        <label for="form-check" class="control-label" style="padding-right:10px;">
                            Valor do contrato será:
                        </label>
                        <div class="form-check" style="12px; display:inline;">
                            {{-- FIXO --}}
                            <input name="is_fixed_value" value="1" class="radio-is-fixed-value" type="radio"
                                data-skin="minimal" checked>
                            <label class="form-check-label" for="services" style="margin-right:15px;">FIXO</label>
                            {{-- VARIAVEL --}}
                            <input name="is_fixed_value" value="0" class="radio-is-fixed-value" type="radio"
                                data-skin="minimal">
                            <label class="form-check-label" for="">VARIÁVEL</label>
                        </div>
                        <div class="small" style="color:rgb(85, 85, 85);">
                            <p>(Se o valor final do contrato não estiver difinido, será VARIÁVEL).</p>
                        </div>
                    </div>

                    {{-- VALOR TOTAL --}}
                    <div class="col-sm-2" style="margin-top:-10px;">
                        <div class="form-group">
                            <label for="amount" class="control-label">Valor total do contrato</label>
                            <div class="input-group">
                                <span class="input-group-addon">R$</span>
                                <input type="number" name="amount" id="amount" placeholder="0.00"
                                    class="form-control amount" min="0">
                                @error('unit_price')
                                    <p><strong>{{ $message }}</strong></p>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">

                    {{-- DATA INICIO --}}
                    <div class="col-sm-2">
                        <div class="form-group">
                            <label for="start-date" class="control-label">Vigência - Data início</label>
                            <input type="date" name="start_date" id="start-date" class="form-control start-date"
                                value="{{ isset($quoteRequest) && $quoteRequest->desired_date ? $quoteRequest->desired_date : '' }}">
                        </div>
                    </div>

                    {{-- DATA FIM --}}
                    <div class="col-sm-2">
                        <div class="form-group">
                            <label for="end-date" class="control-label">Vigência - Data fim</label>
                            <input type="date" name="end_date" id="end-date" class="form-control end-date"
                                value="{{ isset($quoteRequest) && $quoteRequest->desired_date ? $quoteRequest->desired_date : '' }}">
                        </div>
                    </div>

                    {{-- DATA PAGAMENTO --}}
                    <div class="col-sm-2">
                        <div class="form-group">
                            <label for="pay-day" class="control-label">Dia de pagamento</label>
                            <input type="text" name="payday" class="form-control pay-day" id="pay-day"
                                placeholder="Ex: 15">
                        </div>
                    </div>

                    {{-- RECORRENCIA --}}
                    <div class="service-row">
                        <div class="col-sm-2">
                            <div class="form-group">
                                <label for="recurrence" class="control-label">Recorrência</label>
                                <select name="recurrence" id="recurrence" class='select2-me recurrence'
                                    style="width:100%; padding-top:2px;" data-placeholder="Escolha uma opção">
                                    <option value=""></option>
                                    <option value="1">ÚNICA</option>
                                    <option value="2">MENSAL</option>
                                    <option value="3">ANUAL</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    {{-- CONDIÇÃO DE PAGAMENTO --}}
                    <div class="col-sm-2">
                        <div class="form-group">
                            <label for="payment-method" class="control-label">Condição de pagamento</label>
                            <select name="payment_method" id="payment-method" class='select2-me payment-method'
                                style="width:100%; padding-top:2px;" data-placeholder="Escolha uma opção">
                                <option value=""></option>
                                <option value="1">Antecipado</option>
                                <option value="2">Normal</option>
                            </select>
                        </div>
                    </div>

                    {{-- FORMA DE PAGAMENTO --}}
                    <div class="service-row">
                        <div class="col-sm-2">
                            <div class="form-group">
                                <label for="payment-method" class="control-label">Forma de pagamento</label>
                                <select name="payment_method" id="payment-method" class='select2-me payment-method'
                                    style="width:100%; padding-top:2px;" data-placeholder="Escolha uma opção">
                                    <option value=""></option>
                                    <option value="1">PIX</option>
                                    <option value="2">DEPÓSITO BANCÁRIO</option>
                                    <option value="3">BOLETO</option>
                                    <option value="4">CARTÃO CRÉDITO</option>
                                    <option value="5">CARTÃO DÉBITO</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- TABLE PARCELAS --}}
                <div class="row" style="display:flex; align-items:center; margin-top:15px; margin-bottom:5px;">
                    <h4 class="col-sm-6">
                        <i class="fa fa-dollar"></i>
                        Parcelas deste contrato
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
                                <table class="table table-hover table-nomargin table-striped">
                                    <thead>
                                        <tr>
                                            <th class="col-sm-2">VENCIMENTO</th>
                                            <th class="col-sm-2">VALOR</th>
                                            <th class='col-sm-5 hidden-350'>OBSERVAÇÃO</th>
                                            <th class='col-sm-2 hidden-1024'>STATUS</th>
                                            <th class='col-sm-1 hidden-480'>AÇÕES</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="form-actions pull-right" style="margin-top:30px;">
                <input type="hidden" name="isSaveAndQuote" value="0">
                <button type="button" class="btn btn-primary" id="isSaveAndQuote">
                    Enviar solicitação
                    <i style="margin-left:5px;" class="glyphicon glyphicon-new-window"></i>
                </button>
                <button type="submit" class="btn btn-primary">Salvar alterações</button>
                <a href="{{ url()->previous() }}" class="btn">Cancelar</a>
            </div>
        </div>
    </form>

    <x-modal-add-installment />

    <x-modal-edit-installment :statusValues="$statusValues" />

</x-app>

<script>
    $(document).ready(function() {
        const $costCenterPercentage = $('.cost-center-container input[name$="[apportionment_percentage]"]');
        const $costCenterCurrency = $('.cost-center-container input[name$="[apportionment_currency]"]');

        $('#isSaveAndQuote').click(function() {
            $('input[name="isSaveAndQuote"]').val('1');
            $('#request-form').submit();
        });

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

        // tem fornecedor? sim / não
        const $inputHasSupplier = $('input[name="has_supplier"]')
        const $suppliersBlock = $('.suppliers-block');

        $inputHasSupplier.on('change', function() {
            const hasSupplier = $(this).val() === "1";
            $suppliersBlock.attr('hidden', !hasSupplier);
        });

        // verifica EU ou SUPRIMENTOS (desabilitar fornecedores e pagamento)
        const $radioIsContractedBySupplies = $('.radio-who-wants');
        const $paymentBlock = $('.payment-block');

        $radioIsContractedBySupplies.on('change', function() {
            const isContractedBySupplies = $(this).val() === "1";
            const $elementsToDisable = $suppliersBlock.add($paymentBlock);

            $elementsToDisable
                .find('input')
                .prop('disabled', !isContractedBySupplies);

            $elementsToDisable
                .find('select')
                .prop('disabled', !isContractedBySupplies)
                .trigger('change.select2');

        }).trigger('change');

        // add product
        const $productRowTemplate = $(".full-product-line").last()
        $(document).on('click', '.delete-product', function() {
            $(this).parent().parent().remove();
            $(this).parent().parent().parent().remove();
        });

        $(document).on('click', ".add-product", function() {
            const $containerCnpj = $(this).parentsUntil("[data-cnpj]").last();
            const $products = $containerCnpj.find("[data-product]")
            const $lastProduct = $products.last();
            const $firstProduct = $products.first();
            let productCount = $lastProduct.data("product") + 1;
            const $newProductRow = $productRowTemplate.clone();
            $newProductRow.data('product', productCount);
            $newProductRow.find(":text").val("");
            $newProductRow.find('.select2-container').remove();
            $newProductRow.find('.select2-me').attr('id', 's2-' + productCount).select2();
            $newProductRow.find('h4').text('Produto ' + (productCount));
            $lastProduct.after($newProductRow);
        });

        // add parcelas na table
        const $inputStartDate = $('.start-date');
        const $inputEndDate = $('.end-date');
        const $payDay = $('.pay-day');
        const $recurrence = $('#recurrence');
        const $amount = $('.amount');

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
            const isUniqueRecurrence = $recurrence.find(':selected').val() === "1";
            const monthsPassed = calculateMonthsPassed(startDate, endDate);
            if (monthsPassed >= 1) {
                const numberOfInstallments = isUniqueRecurrence ? 1 : monthsPassed;
                return numberOfInstallments;
            }

            return;
        }

        // dataTable config
        const $installmentsTable = $('.table-striped').DataTable({
            paging: false,
            info: false,
            searching: false,
            language: {
                emptyTable: "",
                zeroRecords: ""
            },
            order: [
                [4, 'asc']
            ],
            createdRow: function(row, data, dataIndex) {
                const hiddenFormattedDate = $(row).data('hidden-date');
                $(row).attr('data-hidden-date', hiddenFormattedDate);
            }
        });

        // hide and show btn add parcela
        const $radioIsFixedValue = $('input[name="is_fixed_value"]');
        const $btnAddInstallment = $('.btn-add-installment');

        $radioIsFixedValue.on('change', function() {
            const isFixedValue = $(this).val() === "1";
            $btnAddInstallment.attr('hidden', isFixedValue);
            $installmentsTable.clear().draw();
            $inputsForInstallmentEvents =
                $recurrence
                .add($amount)
                .add($payDay)
                .add($inputStartDate)
                .add($inputEndDate)
            if (isFixedValue) {
                addFixedInstallmentsEvent($inputsForInstallmentEvents);
            } else {
                $inputsForInstallmentEvents.off('change');
            }
        }).first().trigger('change');

        // declaracao dos botoes edit e delete do datatable
        const editButton =
            '<button type="button" rel="tooltip" title="Editar Parcela" class="btn btn-edit-installment"><i class="fa fa-edit"></i></button>';
        const deleteButton =
            '<button href="#" class="btn btn-delete-installment" style="margin-left:5px" title="Excluir"><i class="fa fa-times"></i></button>';
        const buttonsHTML = editButton + deleteButton;

        function generateInstallments(numberOfInstallments) {
            const startDate = new Date($inputStartDate.val());
            const payDay = $payDay.val();
            const amount = ($amount.val() / numberOfInstallments).toFixed(2);

            const installmentsData = [];

            for (let i = 1; i <= numberOfInstallments; i++) {
                const installmentDate = new Date(startDate.getFullYear(), startDate.getMonth() + i, payDay);
                const formattedDate = installmentDate.toLocaleDateString('pt-BR');
                const hiddenFormattedDate = installmentDate.toISOString();

                const installmentData = [
                    formattedDate,
                    amount,
                    "Parcela " + i + "/" + numberOfInstallments,
                    "PENDENTE",
                    buttonsHTML,
                    installmentDate
                ];

                installmentsData.push(installmentData);
            }

            for (const installmentData of installmentsData) {
                const rowNode = $installmentsTable.row.add(installmentData).node();
                $(rowNode).children('td').eq(0).attr('data-hidden-date', installmentData[5]);
            }

            $installmentsTable.draw();
        }

        // gerar parcelas a partir do change de varios inputs
        function addFixedInstallmentsEvent($inputsForInstallmentEvents) {
            $inputsForInstallmentEvents.on('change', function() {
                const changeableInputs = [
                    $recurrence.val(),
                    $amount.val(),
                    $payDay.val(),
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

        function resetModal() {
            $('#form-modal-edit-installment')[0].reset();
            $('#edit-status').val('').trigger('change');

            $('#form-modal-add-installment')[0].reset();
            $('#edit-status').val('').trigger('change');
        }

        $('.btn-add-installment').on('click', function() {
            $('#modal-add-installment').modal('show');
        });

        // form modal add installment
        $('#form-modal-add-installment').on('submit', function(e) {
            e.preventDefault();

            $('#edit-status').select2({
                maximumSelectionLength: 1
            });

            const expireDate = new Date($('#expire-date').val());
            const expireDateFormatted = expireDate.toLocaleDateString('pt-BR', {
                timeZone: 'UTC'
            });
            const hiddenFormattedDate = expireDate.toLocaleDateString('sv', {
                timeZone: 'UTC'
            });
            const value = $('#value').val();
            const status = $('#status').find(':selected').text();
            const observation = $('#observation').val();

            const installmentModalData = [
                expireDateFormatted,
                value,
                observation,
                status,
                buttonsHTML,
                hiddenFormattedDate
            ];

            $installmentsTable.row.add(installmentModalData);
            $installmentsTable.draw()

            resetModal();
            //$(this).find('select').select2();
            $('#modal-add-installment').modal('hide');
        });

        $('.table-striped tbody').on('click', 'tr', function(event) {
            event.preventDefault();

            if ($(event.target).closest('.btn-delete-installment').length) {
                const row = $(this);
                const installmentId = row.data('id');
                $installmentsTable.row(row).remove().draw();
            } else if ($(event.target).closest('.btn-edit-installment').length) {
                const rowData = $installmentsTable.row(this).data();
                openModalForEdit(rowData);
                selectedRowIndex = $installmentsTable.row(this).index();
            }
        });

        const statusValues = @json($statusValues);

        let selectedRowIndex = null;

        // modal edit installment
        function openModalForEdit(rowData) {
            $('#modal-edit-installment').modal('show');

            const expireDate = $('#edit-expire-date');
            const value = $('#edit-value');
            const status = $('#edit-status');
            const observation = $('#edit-observation');

            const formattedDate = new Date(rowData[0].split('/').reverse().join('-'));
            expireDate.val(formattedDate.toISOString().split('T')[0]);

            value.val(rowData[1]);
            observation.text(rowData[2]);

            status.select2('val', statusValues.find((status) => status.description === rowData[3]).id);

            $('#form-modal-edit-installment').on('submit', function(event) {
                event.preventDefault();

                const expireDate = new Date($('#edit-expire-date').val());
                const value = $('#edit-value').val();
                const status = $('#edit-status').find(':selected').text();
                const observation = $('#edit-observation').val();

                const expireDateFormatted = expireDate.toLocaleDateString('pt-BR', {
                    timeZone: 'UTC'
                });
                const hiddenFormattedDate = expireDate.toLocaleDateString('sv', {
                    timeZone: 'UTC'
                });

                if (selectedRowIndex !== null) {
                    $installmentsTable.cell(selectedRowIndex, 0).data(expireDateFormatted);
                    $installmentsTable.cell(selectedRowIndex, 1).data(value);
                    $installmentsTable.cell(selectedRowIndex, 2).data(observation);
                    $installmentsTable.cell(selectedRowIndex, 3).data(status);
                    $installmentsTable.cell(selectedRowIndex, 4).data(buttonsHTML);
                    $installmentsTable.draw();
                }

                selectedRowIndex = null;

                resetModal();
                $('#modal-edit-installment').modal('hide');
            });
        }
    });
</script>
