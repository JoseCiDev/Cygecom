$(() => {
    // muda data desejada mínima quando serviço já prestado

    const $desiredDate = $('#desired-date');
    const $serviceAlreadyProvided = $('.radio-already-provided');
    const currentDate = moment();
    const minInitialDate = moment('2020-01-01').format('YYYY-MM-DD');

    $desiredDate.attr('min', currentDate.format('YYYY-MM-DD'))

    function changeMinDesiredDate() {
        const serviceAlreadyProvided = $(this).val() === "1";

        const minDate = serviceAlreadyProvided ? minInitialDate : currentDate.format('YYYY-MM-DD');

        $desiredDate.attr('min', minDate);

        $desiredDate.rules('add', {
            min: minDate
        });
    }

    $serviceAlreadyProvided.on('change', changeMinDesiredDate).filter(':checked').trigger('change');
});
