@push('styles')
    <style>
        #modal-delete-submit {
            display: flex;
            gap: 5px;
            align-items: center;
            justify-content: center;
        }

        #modal-delete-submit .spinner-border {
            width: 20px;
            height: 20px;
            display: none;
        }
    </style>
@endpush

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

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-primary btn-danger" id="modal-delete-submit">
                    <div class="spinner-border" role="status"></div>
                    Excluir
                </button>
            </div>

        </div>
    </div>
</div>

@push('scripts')
    <script type="module">
        const $modalDelete = $("#modal-delete");

        const deleteAction = (event, url) => {
            event.preventDefault();
            $('#modal-delete-submit .spinner-border').show();

            $.ajax({
                url,
                type: 'DELETE',
                data: {
                    _token: $('meta[name="csrf-token"]').attr('content')
                },
                success: (response) => {
                    bootstrap.Modal.getInstance($modalDelete).hide();

                    const redirectRoute = response.redirect;
                    const message = response.message;
                    const title = 'Sucesso!';
                    const className = 'bg-success';
                    $.fn.createToast(message, title, className);

                    if (redirectRoute) {
                        setTimeout(() => {
                            window.location.href = redirectRoute;
                        }, 3000);
                    }
                },
                error: (error) => {
                    const message = error.responseJSON.message;
                    const title = 'Ops! Algo deu errado';
                    const className = 'bg-danger';
                    $.fn.createToast(message, title, className);
                },
                complete: () => {
                    $('#modal-delete-submit .spinner-border').hide();
                }
            });
        }

        $modalDelete.on('show.bs.modal', (event) => {
            const button = $(event.relatedTarget);
            const name = button.data('name');
            const id = button.data('id');
            const route = button.data('route');

            const routes = {
                'api.users.destroy': @json(route('api.users.destroy', ['user' => '__user__'])).replace('__user__', id),
                'api.suppliers.destroy': @json(route('api.suppliers.destroy', ['supplier' => '__supplier__'])).replace('__supplier__', id),
                'api.requests.destroy': @json(route('api.requests.destroy', ['purchaseRequest' => '__purchaseRequest__'])).replace('__purchaseRequest__', id),
                'api.userProfile.destroy': @json(route('api.userProfile.destroy', ['userProfile' => '__userProfile__'])).replace('__userProfile__', id),
            }

            const url = routes[route] || "#";

            $modalDelete.find('#modal-delete-label .name').text(name);
            $modalDelete.find('#modal-delete-message .name').text(name);
            $('#modal-delete-submit').on('click', (event) => deleteAction(event, url));
        });
    </script>
@endpush
