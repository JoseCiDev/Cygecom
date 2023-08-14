$(() => {
    const $costCenterPercentage = $('.cost-center-container input[name$="[apportionment_percentage]"]');
    const $costCenterCurrency = $('.cost-center-container input[name$="[apportionment_currency]"]');
    const $btnAddCostCenter = $('.add-cost-center-btn');

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

    function checkCostCenterCount() {
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

    // Add Centro de Custo
    $('.add-cost-center-btn').click(function() {
        updateApportionmentFields();
        const newRow = $('.cost-center-container').last().clone();
        newRow.find('select[name^="cost_center_apportionments"], input[name^="cost_center_apportionments"]')
        .each(function() {
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
});