<div class="modal fade" id="modal" tabindex="-1" role="dialog" aria-labelledby="modal-label" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="modal-label">Excluir <strong class="name"></strong></h4>
            </div>
            <div class="modal-body">
                <p>Tem certeza que deseja excluir <strong class="name"></strong>?</p>
                <p>Essa ação não pode ser desfeita!</p>
            </div>
            <form id="modal-form-delete" method="POST" action="">
                @csrf
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-danger">Excluir</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    $('#modal').on('show.bs.modal', function (event) {
        const button = $(event.relatedTarget);
        const name = button.data('name');
        const id = button.data('id');
        const route = button.data('route');
        const modal = $(this);

        let action = '#'
        if(route === 'products') {
            action = `/products/delete/${id}`
        } else if (route === 'user') {
            action = `/user/delete/${id}` 
        } else if (route === 'supplier') {
            action = `/suppliers/delete/${id}`
        } else if (route === 'purchaseRequests') {
            action =`/request/delete/${id}`
        }

        modal.find('.name').text(name);
        modal.find('#modal-form-delete').attr('action', action );
    });
</script>
