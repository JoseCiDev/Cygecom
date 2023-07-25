$(() => {
    const btnOpenDetail = $('.openDetail');

    btnOpenDetail.on('click', function(e) {
        e.preventDefault();
        const url = $(this).attr('href');
        const isToShowString = $(this).attr('isToShow');
        const isToShow = JSON.parse(isToShowString);
        
        if(!isToShow) {
            return window.location.href = url;
        }

        bootbox.confirm({
            title: "Confirmar responsabilidade",
            message: `Ainda não existe responsável por essa solicitação.
                    <br>
                    Você aceita ficar como o responsável?
                    <br>
                    <small><i class="fa fa-warning"/> Aviso: Caso seja sua própria solicitação não é será possível ser o responsável.</small>`,
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
    });
});