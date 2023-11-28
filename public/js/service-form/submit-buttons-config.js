$(()=> {
    const $btnSubmitRequest = $('.btn-submit-request');
    const $sendAction = $('#action');

    const message = "Esta solicitação será <strong>enviada</strong> para o setor de <strong>suprimentos responsável</strong>. <br><br> Deseja confirmar esta ação?";
    $btnSubmitRequest.on('click', function(event) {
        event.preventDefault();
        $.fn.showModalAlert('Atenção!', message, function () {
            $sendAction.val('submit-request');
            $('#request-form').trigger('submit');
        });
    });
});
