$(()=> {
    const $btnSubmitRequest = $('.btn-submit-request');
    const $sendAction = $('#action');

    $btnSubmitRequest.on('click', function(event) {
        event.preventDefault();

        bootbox.confirm({
            message: "Esta solicitação será <strong>enviada</strong> para o setor de <strong>suprimentos responsável</strong>. <br><br> Deseja confirmar esta ação?",
            buttons: {
                confirm: {
                    label: 'Sim, enviar solicitação',
                    className: 'btn-success'
                },
                cancel: {
                    label: 'Cancelar',
                    className: 'btn-danger'
                }
            },
            callback: function(result) {
                if (result) {
                    $sendAction.val('submit-request');
                    $('#request-form').trigger('submit');
                }
            }
        });
    });
});