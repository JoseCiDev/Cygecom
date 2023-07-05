<x-app>

    <x-slot name="title">
        <h1>Solicitar serviço</h1>
    </x-slot>

    <style>
        .cost-center-container {
            margin-bottom: 10px
        }

        h4 {
            font-size: 20px;
        }
    </style>

    <form class="form-validate" id="request-form" method="POST"
        action="@if (isset($quoteRequest) && !$isCopy) {{ route('request.update', ['id' => $id]) }}
                    @else {{ route('requests.new') }} @endif">
        @csrf

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

            <div class="is-finished-checkbox"
                style="
                display: flex;
                align-items: center;
                margin-bottom:20px;
                gap: 5px;
            ">
                <input type="checkbox" id="checkbox-is-finished-service" class="checkbox-is-finished-service"
                    style="margin:0" name="is_finished">
                <label for="checkbox-is-finished-service" style="margin:0;">
                    Este serviço já foi prestado.
                </label>
            </div>

            <div class="row" style="margin-bottom:5px;">
                <div class="col-sm-4">
                    <div class="form-group">
                        <label for="reason" class="control-label">Motivo da
                            solicitação</label>
                        <textarea required name="reason" id="reason" rows="4" placeholder="Ex: conserto de ar condicionado"
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
                        Serviço se enquadra na categoria COMEX?
                    </label>
                    <div class="form-check" style="12px; margin-top:4px;">
                        <input name="is_comex" value="1" class="radio-comex" type="radio"
                            data-skin="minimal">
                        <label class="form-check-label" style="margin-right:15px;">Sim</label>
                        <input name="is_comex"value="0" class="radio-comex" type="radio"
                            data-skin="minimal">
                        <label class="form-check-label">Não</label>
                    </div>
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
                                data-rule-required="false" style="width:100%;"
                                data-placeholder="Escolha uma produto">
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

                <div class="row">
                    {{-- TOTAL --}}
                    <div class="col-sm-2">
                        <div class="form-group">
                            <label for="ammount" class="control-label">Valor total (R$)</label>
                            <input type="text" id="amount" placeholder="R$0,00 " class="form-control amount">
                        </div>
                    </div>
                    <div class="col-sm-2">
                        <div class="form-group">
                            <label for="payday" class="control-label">Data pagamento</label>
                            <input type="date" name="desired_date" id="payday" data-rule-required="false"
                                class="form-control payday"
                                value="{{ isset($quoteRequest) && $quoteRequest->desired_date ? $quoteRequest->desired_date : '' }}">
                        </div>
                    </div>

                    {{-- FORMA DE PAGAMENTO --}}
                    <div class="service-row">
                        <div class="col-sm-3">
                            <div class="form-group">
                                <label for="payment-method" class="control-label">Forma de pagamento</label>
                                <select name="payment_method" id="payment-method" class='select2-me payment-method'
                                    data-rule-required="false" style="width:100%; padding-top:2px;"
                                    data-placeholder="Escolha uma forma">
                                    <option value=""></option>
                                    <option value="1">PIX</option>
                                    <option value="3">BOLETO</option>
                                    <option value="4">CARTÃO CORPORATIVO</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-5">
                        <div class="form-group">
                            <label for="payment-info" class="control-label">Dados de pagamento</label>
                            <textarea name="payment_info" id="payment-info" rows="3"
                                placeholder="Ex.: Chave pix (CNPJ): 00.000.000/0000-00. Pagamento online." data-rule-required="false"
                                class="form-control text-area no-resize payment-info">{{ $quoteRequest->description ?? null }}</textarea>
                        </div>
                        <div class="small" style="color:rgb(85, 85, 85); margin-top:-10px;">
                            <p>
                                * Este campo precisa conter todas as informações utilizadas para pagamento do
                                fornecedor.
                            </p>
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
                <button type="submit" class="btn btn-primary">Salvar</button>
                <a href="{{ url()->previous() }}" class="btn">Cancelar</a>
            </div>

        </div>
    </form>

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

        // muda campos required para serviço já prestado
        const $inputIsFinished = $('input[name="is_finished"]')
        const $selectSupplier = $('.select-supplier');
        const $amount = $('.amount');
        const $payday = $('.payday');
        const $paymentMethod = $('.payment-method');
        const $paymentInfo = $('.payment-info');
        const elementsToChangeRequired = [
            $selectSupplier, $amount, $payday, $paymentMethod, $paymentInfo
        ];

        $inputIsFinished.on('click', function() {
            const isFinished = $(this).is(':checked');
            elementsToChangeRequired.forEach(function(element) {
                elementLast = element.last();
                elementLast.data('rule-required', isFinished);
                elementLast.valid();
                elementLast.removeClass('has error')
                if (!isFinished) {
                    elementLast.closest('.form-group').removeClass('has-error');
                }
            });
        });

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
                .find('input, textarea')
                .prop('disabled', !isContractedBySupplies)
                .val('');

            $elementsToDisable
                .find('select')
                .prop('disabled', !isContractedBySupplies)
                .trigger('change.select2')
                .find('option').val('');

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

    });
</script>
