$(() => {
    // muda data desejada mínima quando serviço já prestado

    const $desiredDate = $('#desired-date');
    const $serviceAlreadyProvided = $('.radio-already-provided');
    const currentDate = moment();
    const minInitialDate = moment('2020-01-01');

    function desiredDateGreaterThanCurrent() {
        const desiredDate = moment($desiredDate.val());

        return desiredDate.isAfter(currentDate);
    }

    function changeMinDesiredDate() {
        const isValidDate = desiredDateGreaterThanCurrent();
        const serviceAlreadyProvided = $serviceAlreadyProvided.filter(':checked').val() === "1";

        const minDate = serviceAlreadyProvided ? minInitialDate : currentDate;

        $desiredDate.attr('min', minDate.format('YYYY-MM-DD'));
    }

    $serviceAlreadyProvided.add($desiredDate).on('change', changeMinDesiredDate).filter(':checked').trigger('change');
});
