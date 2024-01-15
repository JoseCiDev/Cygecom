$(() => {
    const $btnOpenDetail = $('.openDetail');
    $btnOpenDetail.on('click', (event) => {
        event.preventDefault();
        const $currentElement = $(event.target).closest('.openDetail')
        const url = $currentElement.attr('href');
        const isToShowString = $currentElement.data('is-to-show') || false;
        const isToShow = JSON.parse(isToShowString);

        if(!isToShow) {
            return window.location.href = url;
        }

        const modalTitle = "Confirmar atribuição de solicitação";
        const message = "Ainda não existe responsável por essa solicitação. Ao atribuir responsável, a solicitação passará para status <strong>Em tratativa</strong>.<br>Deseja se tornar o responsável?";
        $.fn.showModalAlert(modalTitle, message, () => window.location.href = url);
    });
});
