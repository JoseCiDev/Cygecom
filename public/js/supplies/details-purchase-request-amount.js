$(() => {
    const $amount = $('#amount'); // hidden
    const $formatAmount = $('#format-amount');

    // masks
    let formatAmountMasked = $formatAmount.imask({
        mask: Number,
        scale: 2,
        thousandsSeparator: '.',
        normalizeZeros: true,
        padFractionalZeros: true,
        min: 0,
        max: 1000000000,
    });

    formatAmountMasked.value = $amount.val().replace('.', ',');

    $formatAmount.on('input', function() {
        const formattedValue = $(this).val();
        if (formattedValue !== null) {
            const processedValue = formatAmountMasked.unmaskedValue;
            if (!isNaN(processedValue)) {
                $amount.val(processedValue);
            }
        }
    });

    $formatAmount.trigger('input');
})
