$(() => {
    // Muda data desejada mnima quando serviço já prestado
    const $desiredDate = $('#desired-date');
    const $serviceAlreadyProvided = $('.radio-already-provided');
    const currentDate = moment().format('YYYY-MM-DD');
    const minInitialDate = moment('2020-01-01').format('YYYY-MM-DD');

    function desiredDateGreaterThanCurrent() {
        const desiredDate = $desiredDate.val();

        return desiredDate > currentDate;
    }

    function changeMinDesiredDate() {
        const isValidDate = desiredDateGreaterThanCurrent();
        const serviceAlreadyProvided = $serviceAlreadyProvided.filter(':checked').val() === "1";

        const minDate = serviceAlreadyProvided ? minInitialDate : currentDate;

        $desiredDate.attr('min', minDate);
    }

    $serviceAlreadyProvided.add($desiredDate).on('change', changeMinDesiredDate).filter(':checked').trigger('change');
});