$(() => {
    const $btnOpenDetail = $('.openDetail');

    $(document).on('click', $btnOpenDetail.selector, function(event) {
        event.preventDefault();
        const url = $(this).attr('href');
        const isToShowString = $(this).data('is-to-show');
        const isToShow = JSON.parse(isToShowString);
        
        if(!isToShow) {
            return window.location.href = url;
        }

        bootbox.confirm({
            title: "Confirmar atribuição de solicitação",
            message: `Ainda não existe responsável por essa solicitação.
                    <br>
                    Deseja se tornar o responsável?
                    <br>
                    <small>Aviso: Não será possível trocar o responsável posteriormente.</small>`,
            buttons: {
                confirm: {
                    label: 'Concordar e ir',
                    className: 'btn-success'
                },
                cancel: {
                    label: 'Não',
                    className: 'btn-danger'
                }
            },
            callback: function(result) {
                if (result) {
                    window.location.href = url;
                } 
            }
        });
    })
});