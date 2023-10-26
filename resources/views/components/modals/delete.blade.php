<div class="modal fade" id="modal-delete" tabindex="-1" aria-labelledby="modal-delete-label" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="modal-delete-label">Excluir <strong class="name"></strong></h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="modal-delete-message">
                <p>Tem certeza que deseja excluir <strong class="name"></strong>?</p>
                <p>Essa ação não pode ser desfeita!</p>
            </div>
            <form id="modal-form-delete" data-cy="modal-form-delete" method="POST" action="">
                @csrf
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary btn-danger" id="modal-alert-submit" id="modal-delete-submit">Excluir</button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
    <script type="module">
        const $modalDelete = $("#modal-delete");
        $modalDelete.on('show.bs.modal', (event) => {
            const button = $(event.relatedTarget);
            const name = button.data('name');
            const id = button.data('id');
            const route = button.data('route');

            const routes = {
                products: `/products/delete/${id}`,
                user: `/user/delete/${id}`,
                supplier: `/suppliers/delete/${id}`,
                purchaseRequests: `/request/delete/${id}`
            }

            const action = routes[route] || "#";

            $modalDelete.find('#modal-delete-label .name').text(name);
            $modalDelete.find('#modal-delete-message .name').text(name);
            $modalDelete.find('#modal-form-delete').attr('action', action);
        });
    </script>
@endpush
