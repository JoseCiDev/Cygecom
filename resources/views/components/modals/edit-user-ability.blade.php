@props(['grouped-abilities' => $groupedAbilities])

@php
    $getAbilities = $groupedAbilities->get('get', collect());
    $apiAbilities = $groupedAbilities->get('api', collect());
    $postAbilities = $groupedAbilities->get('post', collect());
    $deleteAbilities = $groupedAbilities->get('delete', collect());
    $authorizeAbilities = $groupedAbilities->get('authorize', collect());
@endphp

@push('styles')
    <style>
        @keyframes blink {
            0% {
                box-shadow: inset 0px 0px 0 0px var(--bs-warning);
            }

            50% {
                box-shadow: inset 0px 0px 20px 0px var(--bs-warning);
            }

            100% {
                box-shadow: inset 0px 0px 0 0px var(--bs-warning);
            }
        }

        .ability-relation-alert {
            animation: blink 1.5s infinite;
        }

        .ability-list-title {
            margin-top: 20px;
        }

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

        .user-abilities-container li.list-group-item.api,
        .api {
            border-left: 6px solid #9abf20;
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
            cursor: pointer;
            transition: box-shadow .2s ease-in-out, transform .2s ease-in-out;
        }

        .user-abilities-container .list-group .list-group-item:hover {
            transform: translateY(-5px);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.3);
        }

        .user-abilities-container .list-group .list-group-item:focus-within {
            transform: translateY(-5px);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.3);
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
                flex: 1 0 calc(50% - 4px);
                max-width: calc(50% - 4px);
            }
        }

        @media(min-width: 1440px) {
            .user-abilities-container .list-group .list-group-item {
                flex: 1 0 calc(25% - 4px);
                max-width: calc(25% - 4px);
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


                <form id="modal-form-user-ability">
                    @csrf

                    <div class="user-abilities-container">
                        <h4>Habilidades do usuário</h4>
                        <small>
                            As habilidades do usuário podem ser ativadas/desativadas.
                            Apenas habilidades excedentes do perfil são gerenciáveis.
                        </small>

                        <h5 class="ability-list-title">Pode acessar quais dados e telas?</h5>
                        <ul class="list-group" id="user-abilities">
                            @forelse ($getAbilities as $ability)
                                @php
                                    $nameParts = explode('.', $ability->name);
                                    $method = count($nameParts) > 1 ? $nameParts[0] : 'type-authorize';
                                @endphp
                                <li class="list-group-item {{ $method }}">
                                    <div class="form-check form-switch"
                                        @can('admin') data-bs-toggle='tooltip' data-bs-placement='top' data-bs-title="{{ $ability->name }} (ID: {{ $ability->id }})" @endcan>
                                        <input class="form-check-input ability-input" type="checkbox" role="switch" name="abilities[]" id="ability-{{ $ability->id }}"
                                            value="{{ $ability->id }}">
                                        <label class="form-check-label" for="ability-{{ $ability->id }}">
                                            {{ $ability->description }}
                                        </label>
                                    </div>
                                </li>
                            @empty
                                <small>Nenhuma habilidade além das existentes no perfil foi encontrada.</small>
                            @endforelse
                        </ul>

                        <h5 class="ability-list-title">
                            <i class="fa-solid fa-circle-info" data-bs-toggle='tooltip' data-bs-placement='top'
                                data-bs-title="API's são consultas dinâmicas que normalmente são usadas em caixas flutuantes, dados que precisam ser acessados sem recarregar páginas ou tabelas que estão consultando dados"></i>
                            API's - Quais permissões dinâmicas esse perfil deve ter?
                        </h5>
                        <ul class="list-group" id="user-abilities">
                            @forelse ($apiAbilities as $ability)
                                <li class="list-group-item api">
                                    <div class="form-check form-switch" data-bs-toggle='tooltip' data-bs-placement='top'
                                        data-bs-title="{{ $ability->name }} (ID: {{ $ability->id }})">
                                        <input class="form-check-input ability-input" type="checkbox" role="switch" name="abilities[]" id="ability-{{ $ability->id }}"
                                            value="{{ $ability->id }}">
                                        <label class="form-check-label" for="ability-{{ $ability->id }}">
                                            {{ $ability->description }}
                                        </label>
                                    </div>
                                </li>
                            @empty
                                <small>Nenhuma habilidade além das existentes no perfil foi encontrada.</small>
                            @endforelse
                        </ul>

                        <h5 class="ability-list-title">Pode modificar quais dados?</h5>
                        <ul class="list-group" id="user-abilities">
                            @forelse ($postAbilities as $ability)
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
                            @empty
                                <small>Nenhuma habilidade além das existentes no perfil foi encontrada.</small>
                            @endforelse
                        </ul>

                        <h5 class="ability-list-title">Pode excluir quais dados?</h5>
                        <ul class="list-group" id="user-abilities">
                            @forelse ($deleteAbilities as $ability)
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
                            @empty
                                <small>Nenhuma habilidade além das existentes no perfil foi encontrada.</small>
                            @endforelse
                        </ul>

                        <h5 class="ability-list-title">Ao acessar e modificar dados esse usuário é autorizado como?</h5>
                        <ul class="list-group" id="user-abilities">
                            @forelse ($authorizeAbilities as $ability)
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
                            @empty
                                <small>Nenhuma habilidade além das existentes no perfil foi encontrada.</small>
                            @endforelse
                        </ul>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                        @can('post.api.user.abilities.store')
                            <button type="submit" id="store-user-abilities" class="btn btn-primary">
                                <div class="spinner-border" role="status"></div>
                                Salvar alterações
                            </button>
                        @endcan
                    </div>
                </form>
            </div>
            <div class="color-info">
                <small class="get">Acessar dados</small>
                <small class="api">API's - Ações dinâmicas</small>
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
        const $listGroupItem = $('.list-group-item');
        const $abilitiesInputs = $('input[name="abilities[]"]');

        let refreshPage = false;

        const toggleCheckbox = (event) => {
            const $checkBox = $(event.target).find('input[name="abilities[]"]');
            $checkBox.prop('checked', !$checkBox.prop('checked'));
        }

        $modalEditUserAbility.on('hidden.bs.modal', (event) => {
            if (refreshPage) {
                location.reload();
            }
        });

        $modalEditUserAbility.on('show.bs.modal', (event) => {
            const button = $(event.relatedTarget);
            const id = button.data('user-id');
            const apiUrlGetUser = `/api/users/show/${id}`;
            const apiUrlStoreUser = `/api/users/abilities/store/${id}`;
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

                        refreshPage = true;
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

                    console.log(id);
                    $form.attr('action', `/abilities/store/${id}`);
                },
                error: function(error) {
                    $abilityToast.find('.toast-header').addClass('bg-danger');
                    $abilityToast.find('.toast-header-title').text('Erro na requisição!');
                    $abilityToast.find('.toast-body').text('Contate o administrador. Não possível buscar informações do usuário.');
                    bootstrap.Toast.getOrCreateInstance($abilityToast).show();
                }
            });

            $form.off('submit');
            $form.on('submit', submit);
        });

        $listGroupItem.on('click', toggleCheckbox);

        $abilitiesInputs.on('input', (event) => $.fn.checkAbilityRelations(event));
    </script>
@endpush
