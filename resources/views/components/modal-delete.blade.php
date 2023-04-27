<div class="modal fade" id="user-modal" tabindex="-1" role="dialog" aria-labelledby="user-modal-label" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="user-modal-label">Excluir usuário <strong id="user-name"></strong></h4>
            </div>
            <div class="modal-body">
                <p>Tem certeza que deseja excluir o usuário <strong id="user-name"></strong>?</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-danger">Excluir</button>
            </div>
        </div>
    </div>
</div>

<script>
    $('#user-modal').on('show.bs.modal', function (event) {
        const button = $(event.relatedTarget);
        const userName = button.data('user-name');
        const userId = button.data('user-id');
        const modal = $(this);
        modal.find('#user-name').text(userName);
        // modal.find('.btn-danger').attr('href', '/users/' + userId + '/delete');
    });
</script>
