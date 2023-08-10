@php $costCenterApportionment = $purchaseRequest->costCenterApportionment ?? []; @endphp
@forelse ($costCenterApportionment as $index => $apportionment)
    <div class="row cost-center-container">

        <div class="col-sm-6">
            <div class="form-group">
                <label style="display:block;" class="control-label">Centro de custo da despesa</label>
                <select name="cost_center_apportionments[{{ $index }}][cost_center_id]" id="select-cost-center" data-cy="select-cost-center"
                    class='select2-me' data-rule-required="true" style="width:100%;" placeholder="Ex: Almoxarifado">
                    <option value=""></option>
                    @foreach ($costCenters as $costCenter)
                        @php 
                            $isApportionmentSelect = isset($apportionment) && $apportionment->cost_center_id === $costCenter->id; 
                            $companyName = $costCenter->company->name;
                            $costCenterName = $costCenter->name;
                            $formattedCnpj = preg_replace('/(\d{2})(\d{3})(\d{3})(\d{4})(\d{2})/', '$1.$2.$3/$4-$5', $costCenter->company->cnpj);
                        @endphp
                        <option value="{{ $costCenter->id }}" @selected($isApportionmentSelect)>
                            {{ $formattedCnpj . ' - ' . $companyName . ' - ' . $costCenterName }}
                        </option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="col-sm-2">
            <label for="cost_center_apportionments[{{ $index }}][apportionment_percentage]" class="control-label"> Rateio (%) </label>
            <div class="input-group">
                <span class="input-group-addon">%</span>
                <input type="number" placeholder="0.00" class="form-control" min="0" max="100" name="cost_center_apportionments[{{ $index }}][apportionment_percentage]"
                    id="cost_center_apportionments[{{ $index }}][apportionment_percentage]" data-cy="cost_center_apportionments[{{ $index }}][apportionment_percentage]"
                    value="{{ $apportionment->apportionment_percentage }}">
            </div>
        </div>

        <div class="col-sm-2">
            <label for="cost_center_apportionments[{{ $index }}][apportionment_currency]" class="control-label"> Rateio (R$) </label>
            <div class="input-group">
                <span class="input-group-addon">R$</span>
                <input type="number" placeholder="0.00" class="form-control" min="0" max="500000" id="cost_center_apportionments[{{ $index }}][apportionment_currency]"
                    name="cost_center_apportionments[{{ $index }}][apportionment_currency]" data-cy="cost_center_apportionments[{{ $index }}][apportionment_currency]" value="{{ $apportionment->apportionment_currency }}">
            </div>
        </div>

        <div class="col-sm-1" style="margin-top: 28px;">
            <button class="btn btn-icon btn-small btn-danger delete-cost-center" data-cy="btn-delete-cost-center-{{$index}}"><i class="fa fa-trash-o"></i></button>
        </div>

    </div>
@empty
    <div class="row cost-center-container">
        <div class="col-sm-6">
            <div class="form-group">
                <label class="control-label" style="display:block"> Centro de custo da despesa </label>
                <select style="width:100%" id="select-cost-center" name="cost_center_apportionments[0][cost_center_id]" data-cy="cost_center_apportionments[0][cost_center_id]"
                    class='select2-me' required data-rule-required="true" placeholder="Ex: Almoxarifado">
                    <option value=""></option>
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
            <label for="cost_center_apportionments[0][apportionment_percentage]" class="control-label"> Rateio (%) </label>
            <div class="input-group">
                <span class="input-group-addon">%</span>
                <input type="number" placeholder="0.00" class="form-control apportionment-percentage" min="0" name="cost_center_apportionments[0][apportionment_percentage]"
                    id="cost_center_apportionments[0][apportionment_percentage]" data-cy="cost_center_apportionments[0][apportionment_percentage]">
            </div>
        </div>

        <div class="col-sm-2">
            <label for="cost_center_apportionments[0][apportionment_currency]" class="control-label"> Rateio (R$) </label>
            <div class="input-group">
                <span class="input-group-addon">R$</span>
                <input type="number" name="cost_center_apportionments[0][apportionment_currency]" id="cost_center_apportionments[0][apportionment_currency]"
                     data-cy="cost_center_apportionments[0][apportionment_currency]" placeholder="0.00" class="form-control" min="0">
            </div>
        </div>

        <div class="col-sm-1" style="margin-top: 28px;">
            <button class="btn btn-icon btn-small btn-danger delete-cost-center" data-cy="btn-delete-cost-center-0">
                <i class="fa fa-trash-o"></i>
            </button>
        </div>
    </div>
@endforelse

{{-- ADICIONAR CENTRO DE CUSTO --}}
<button type="button" class="btn btn-small btn-primary add-cost-center-btn" data-cy="btn-add-cost-center">
   Adicionar linha
</button>

<script>
    $(() => {
        const $costCenterSelect = $('.cost-center-container select[name^="cost_center_apportionments"]');
        const $costCenterPercentage = $('.cost-center-container input[name$="[apportionment_percentage]"]');
        const $costCenterCurrency = $('.cost-center-container input[name$="[apportionment_currency]"]');

        const $btnAddCostCenter = $('.add-cost-center-btn');

        function manageApportionmentState() {
            const $costCenterSelect = $('.cost-center-container select[name^="cost_center_apportionments"]');
            const $costCenterPercentage = $('.cost-center-container input[name$="[apportionment_percentage]"]');
            const $costCenterCurrency = $('.cost-center-container input[name$="[apportionment_currency]"]');

            const hasPercentageInputFilled = $costCenterPercentage.filter(function() {
                return $(this).val() !== '';
            }).length > 0;

            const hasCurrencyInputFilled = $costCenterCurrency.filter(function() {
                return $(this).val() !== '';
            }).length > 0;

            const disablePercentageInputs = !hasPercentageInputFilled && hasCurrencyInputFilled;
            const disableCurrencyInputs = !hasCurrencyInputFilled && hasPercentageInputFilled;

            if(disablePercentageInputs) {
                $costCenterPercentage.prop('disabled', true);
                $costCenterPercentage.val(null);
            } else if(disableCurrencyInputs) {
                $costCenterCurrency.prop('disabled', true);
                $costCenterCurrency.val(null);
            } else if (!hasPercentageInputFilled && !hasCurrencyInputFilled) {
                $costCenterPercentage.prop('disabled', false);
                $costCenterCurrency.prop('disabled', false);
            }
        }

        function manageBtnDeleteState() {
            const costCenterCount = $('.cost-center-container').length;

            costCenterCount > 1 ? $('.delete-cost-center').prop('disabled', false) : $('.delete-cost-center').prop('disabled', true);
        }

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

        function manageCostCenterBtnState() {
            const costCenterContainers = $('.cost-center-container');
            const $btnAddCostCenter = $('.add-cost-center-btn');

            let allSelectsSelected = true;
            costCenterContainers.each(function() {
                const costCenterSelect = $(this).find('select');
                const isSelectSelected = Boolean(costCenterSelect.val());

                if (!isSelectSelected) {
                    allSelectsSelected = false;
                    return false;
                }
            });

            let allCostCenterPercentageFilled = true;
            let allCostCenterCurrencyFilled = true;

            costCenterContainers.each(function() {
                const percentageInput = $(this).find('input[name$="[apportionment_percentage]"]');
                const currencyInput = $(this).find('input[name$="[apportionment_currency]"]');

                if (!percentageInput.val()) {
                    allCostCenterPercentageFilled = false;
                }

                if (!currencyInput.val()) {
                    allCostCenterCurrencyFilled = false;
                }
            });

            const isValidApportionment = allSelectsSelected && (allCostCenterPercentageFilled || allCostCenterCurrencyFilled);

            // desabilita botao caso nao tenha sido preenchido cost center corretamente;
            $btnAddCostCenter.prop('disabled', !isValidApportionment);
        }

        function setCalculetedPercentage() {
            const $costCenterPercentage = $('.cost-center-container input[name$="[apportionment_percentage]"]');
            let totalPercentage = 0;
            let fieldsWithValues = [];

            $costCenterPercentage.each(function() {
                const percentage = parseFloat($(this).val());
                if (!isNaN(percentage)) {
                    totalPercentage += percentage;
                    fieldsWithValues.push($(this))
                }
            });

            const difference = 100 - totalPercentage;
            const distribution = Math.floor(difference / fieldsWithValues.length);
            const remaining = difference - (distribution * fieldsWithValues.length);

            fieldsWithValues.forEach(function($field, index) {
                let adjustedValue = parseFloat($field.val()) + distribution;
                if (index < remaining) {
                    adjustedValue += 1;
                }

                $field.val(adjustedValue);
            });
        }

        $('.add-cost-center-btn').click(function() {
            manageApportionmentState();
            const newRow = $('.cost-center-container').last().clone();
            newRow.find('select[name^="cost_center_apportionments"], input[name^="cost_center_apportionments"]')
            .each(function() {
                const oldName = $(this).attr('name');
                const regexNewName = /\[(\d+)\]/;
                const lastIndex = Number(oldName.match(regexNewName).at(-1));
                const newName = oldName.replace(regexNewName, `[${lastIndex + 1}]`);
                $(this).attr('name', newName);
                $(this).attr('id', newName);
                $(this).attr('data-cy', newName);
            });

            newRow.find("input, select").val(null);
            newRow.find('.select2-container').remove();
            newRow.find('.select2-me').select2();

            $('.cost-center-container').last().after(newRow);
            newRow.find('.delete-cost-center').removeAttr('hidden');

            manageBtnDeleteState();
            disableSelectedOptions();
            manageCostCenterBtnState();
        });

        $(document).on('click', '.delete-cost-center', function() {
            $(this).closest('.cost-center-container').remove();
            manageApportionmentState();
            manageBtnDeleteState();
            disableSelectedOptions();
            manageCostCenterBtnState();
            setCalculetedPercentage();
        });

        // Vincular eventos de input e change aos elementos
        $(document).on('change', $costCenterSelect.selector, manageCostCenterBtnState);
        $(document).on('input focus', $costCenterCurrency.selector, manageCostCenterBtnState);
        $(document).on('input focus', $costCenterPercentage.selector, manageCostCenterBtnState);

        // Desabilita os outros campos de "rateio" de outro tipo quando um tipo é selecionado
        $(document).on('input focus', `${$costCenterPercentage.selector}, ${$costCenterCurrency.selector}`, manageApportionmentState);

        $(document).on('input change', '.cost-center-container .select2-me', disableSelectedOptions);

        manageApportionmentState();
        manageCostCenterBtnState();
        manageBtnDeleteState();
    });
</script>
