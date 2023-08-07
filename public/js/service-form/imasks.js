$(() => {
    const $phoneNumber = $('#phone-number');
    $phoneNumber.imask({ mask: [ {  mask: '(00) 0000-0000' }, { mask: '(00) 00000-0000' } ] });

    // Trata o valor total do serviço
    const $amount = $('.amount');
    const $serviceAmount = $('#format-amount');
    $serviceAmount.imask({ mask: Number, scale: 2, thousandsSeparator: '.', normalizeZeros: true, padFractionalZeros: true, min: 0,  max: 1000000000, });
    $serviceAmount.on('input', function() {
        const totalPriceService = $(this).val();
        if (totalPriceService !== null) {
            const formattedTotalPrice = totalPriceService.replace(/[^0-9,]/g, '').replace(/,/g, '.');
            const rawValue = parseFloat(formattedTotalPrice);
            const isNumber = !isNaN(rawValue);
            if (isNumber) {
                $amount.val(rawValue.toFixed(2)).trigger('change');
            }
        }
    });       
    
    // Trata qtd parcelas mascara
    const $inputInstallmentsNumber = $('.installments-number');
    const $formatInputInstallmentsNumber = $('.format-installments-number');
    $formatInputInstallmentsNumber.imask({ mask: IMask.MaskedRange, from: 1, to: 60, autofix: 'pad', });
    $formatInputInstallmentsNumber.on('input', function() {
        const installmentNumber = $(this).val();
        if (installmentNumber !== null) {
            const rawValue = parseInt(installmentNumber);
            if (!isNaN(rawValue)) {
                $inputInstallmentsNumber.val(rawValue).trigger('change');
            }
        }
    });
});
