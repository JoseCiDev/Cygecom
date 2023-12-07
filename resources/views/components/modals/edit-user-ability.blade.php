@props(['abilities' => $abilities])

@push('styles')
    <style>
        .color-info {
            display: flex;
            flex-wrap: wrap;
            gap: 5px;
            justify-content: space-around;
            padding: 10px;
        }

        .color-info small {
            padding: 0 3px;
        }

        .user-abilities-container li.list-group-item.get,
        .get {
            border-left: 6px solid #6DC066;
        }

        .user-abilities-container li.list-group-item.post,
        .post {
            border-left: 6px solid #FFA500;
        }

        .user-abilities-container li.list-group-item.delete,
        .delete {
            border-left: 6px solid #E74C3C;
        }

        .user-abilities-container li.list-group-item.type-authorize,
        .type-authorize {
            border-left: 6px solid #000;
        }

        .user-abilities-container .list-group {
            display: flex;
            flex-direction: column;
            gap: 4px;
        }

        .user-abilities-container .list-group .list-group-item {
            border: .25px solid var(--black-color);
            border-radius: 4px;
        }

        #modal-form-user-ability #store-user-abilities {
            display: flex;
            gap: 10px;
            align-items: center;
        }

        #modal-form-user-ability #store-user-abilities .spinner-border {
            width: 20px;
            height: 20px;
            display: none;
        }

        @media(min-width: 768px) {
            .user-abilities-container .list-group {
                flex-direction: row;
                flex-wrap: wrap;
            }

            .user-abilities-container .list-group .list-group-item {
                flex: 1 0 24%;
            }
        }
    </style>
@endpush

<div class="modal fade" id="modal-edit-user-ability" tabindex="-1" aria-labelledby="modal-edit-user-ability-title" aria-hidden="true">
    <div class="modal-dialog modal-fullscreen">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title" id="modal-edit-user-ability-title">Edição de habilidades</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="alert alert-warning" role="alert">
                    Atenção! Edição de habilidades do usuário <span id="modal-user-ability-id"></span>
                </div>

                <div class="toast-container position-fixed bottom-0 end-0 p-3">
                    <div id="abilityToast" class="toast" role="alert" aria-live="assertive" aria-atomic="true">
                        <div class="toast-header">
                            <strong class="me-auto toast-header-title text-light"></strong>
                            <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
                        </div>
                        <div class="toast-body"></div>
                    </div>
                </div>


                <form id="modal-form-user-ability" method="POST">
                    @csrf

                    <div class="user-abilities-container">
                        <h4>Habilidades do usuário</h4>
                        <small>
                            As habilidades do usuário podem ser ativadas/desativadas.
                            Apenas habilidades excedentes do perfil são gerenciáveis.
                        </small>

                        <ul class="list-group" id="user-abilities">
                            @foreach ($abilities as $ability)
                                @php
                                    $nameParts = explode('.', $ability->name);
                                    $method = count($nameParts) > 1 ? $nameParts[0] : 'type-authorize';
                                @endphp

                                <li class="list-group-item {{ $method }}">
                                    <div class="form-check form-switch" data-bs-toggle='tooltip' data-bs-placement='top'
                                        data-bs-title="{{ $ability->name }} (ID: {{ $ability->id }})">
                                        <input class="form-check-input ability-input" type="checkbox" role="switch" name="abilities[]" id="ability-{{ $ability->id }}"
                                            value="{{ $ability->id }}">
                                        <label class="form-check-label" for="ability-{{ $ability->id }}">
                                            {{ $ability->description }}
                                        </label>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                        <button type="submit" id="store-user-abilities" class="btn btn-primary">
                            <div class="spinner-border" role="status"></div>
                            Salvar alterações
                        </button>
                    </div>
                </form>
            </div>
            <div class="color-info">
                <small class="get">Acessar dados</small>
                <small class="post">Modificar dados</small>
                <small class="delete">Excluir dados</small>
                <small class="type-authorize">Autorização de perfil</small>
            </div>
        </div>
    </div>
</div>

@push('scripts')
    <script type="module">
        const $storeUserAbilities = $('#store-user-abilities');
        const $abilityToast = $('#abilityToast');
        const $modalEditUserAbility = $('#modal-edit-user-ability');

        $modalEditUserAbility.on('show.bs.modal', (event) => {
            const button = $(event.relatedTarget);
            const id = button.data('user-id');
            const apiUrlGetUser = `api/user/show/${id}`;
            const apiUrlStoreUser = `api/user/abilities/store/${id}`;
            const $form = $('#modal-form-user-ability');
            const $loaderSpinner = $('#store-user-abilities .spinner-border');

            const submit = (event) => {
                event.preventDefault();
                $loaderSpinner.show();
                $storeUserAbilities.prop('disabled', true);

                const $currentElement = $(event.target);
                const formData = $currentElement.serializeArray();
                const csrfToken = formData.find(el => el.name === "_token");

                $.post({
                    url: apiUrlStoreUser,
                    headers: {
                        'X-CSRF-TOKEN': csrfToken
                    },
                    data: formData,
                    success: function(response) {
                        $abilityToast.find('.toast-header').addClass('bg-success');
                        $abilityToast.find('.toast-header-title').text('Sucesso!');
                        $abilityToast.find('.toast-body').text('Habilidades do usuários atualizadas com sucesso!');
                        bootstrap.Toast.getOrCreateInstance($abilityToast).show();
                    },
                    error: function(error) {
                        $abilityToast.find('.toast-header').addClass('bg-danger');
                        $abilityToast.find('.toast-header-title').text('Falha!');
                        $abilityToast.find('.toast-body').text('Não foi possível atualizar as habilidades do usuários! Verifique suas habilidades.');
                        bootstrap.Toast.getOrCreateInstance($abilityToast).show();
                    },
                    complete: (data) => {
                        $loaderSpinner.hide()
                        $storeUserAbilities.prop('disabled', false);
                    }
                });
            }

            $.get({
                url: apiUrlGetUser,
                dataType: 'json',
                success: function(data) {
                    const {
                        id,
                        email,
                        person: {
                            name: personName,
                            cpf_cnpj
                        },
                        profile: {
                            name: profileName,
                            abilities: profileAbilities
                        },
                        abilities
                    } = data.data;

                    const $abilities = $('.ability-input');

                    $('#modal-user-ability-id').text(`${personName} (ID: ${id}) - E-mail: ${email} - Perfil: ${profileName}`);

                    $abilities.each((_, element) => {
                        const $currentElement = $(element);

                        const isProfileAbility = Boolean(profileAbilities.find((element) => element.id == $currentElement.val()));
                        const isUserAbility = Boolean(abilities.find((element) => element.id == $currentElement.val()));

                        const $listGroupItem = $currentElement.closest('.list-group-item');

                        $currentElement.prop('disabled', isProfileAbility);
                        $currentElement.prop('checked', isProfileAbility);

                        if (isProfileAbility) {
                            $listGroupItem.hide();
                        } else {
                            $listGroupItem.show();
                        }

                        if (isUserAbility) {
                            $currentElement.prop('checked', true);
                        }
                    })

                    $form.attr('action', `/abilities/store/${id}`);
                },
                error: function(error) {
                    $abilityToast.find('.toast-header').addClass('bg-danger');
                    $abilityToast.find('.toast-header-title').text('Erro na requisição!');
                    $abilityToast.find('.toast-body').text('Contate o administrador. Não possível buscar informações do usuário.');
                    bootstrap.Toast.getOrCreateInstance($abilityToast).show();
                }
            });

            $form.on('submit', submit);
        });
    </script>
@endpush
