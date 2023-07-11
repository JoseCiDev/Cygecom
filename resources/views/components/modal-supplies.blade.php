<div class="modal fade" id="modal-supplies" tabindex="-1" role="dialog" aria-labelledby="modal-label" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="modal-label"><strong class="name"></strong></h4>
            </div>
            <div class="modal-body">
                <p>Aqui consta informações detalhadas da solicitação</p>
                <div class="modal-body-dynamic">
                    <ul class="modal-body-dynamic-list"></ul>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
            </div>
        </div>
    </div>
</div>

<script>
    $('#modal-supplies').on('show.bs.modal', function (event) {
        const list = $('.modal-body-dynamic-list')
        list.text('')

        const modal = $(this);
        const button = $(event.relatedTarget);
        const name = button.data('name');
        const id = button.data('id');

        modal.find('.name').text(name);

        const request = button.data('request');
        const response = Object.entries(request)
        response.forEach(element => {
            list.append(`<li>${element[0]}: ${element[1]}</li>`)
        })

    });
</script>
