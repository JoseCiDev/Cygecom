<x-app>
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

            .ability-list-title:first-of-type {
                margin-top: 0;
            }

            .color-info {
                display: flex;
                flex-wrap: wrap;
                gap: 5px;
                padding: 10px;
            }

            .color-info small {
                padding: 0 3px;
            }

            .edit-profile.alert {
                border: 1px solid var(--alert-color);
                border-radius: 4px;
                background-color: #FFFCEF;
                color: #666;
                font-size: 14px;
                width: fit-content;
            }

            .edit-profile.alert ul {
                margin-top: 8px;
            }

            .edit-profile.alert .fa-triangle-exclamation {
                color: var(--alert-color);
            }

            .profile-form li.list-group-item.get,
            .get {
                border-left: 6px solid #6DC066;
            }

            .profile-form li.list-group-item.post,
            .post {
                border-left: 6px solid #FFA500;
            }

            .profile-form li.list-group-item.delete,
            .delete {
                border-left: 6px solid #E74C3C;
            }

            .profile-form li.list-group-item.api,
            .api {
                border-left: 6px solid #9abf20;
            }

            .profile-form li.list-group-item.type-authorize,
            .type-authorize {
                border-left: 6px solid #000;
            }

            .profile-form,
            .profile-form .profile-types {
                display: flex;
                flex-direction: column;
                gap: 15px;
            }

            .profile-form .profile-name {
                max-width: 400px;
            }

            .profile-form .list-group {
                display: flex;
                flex-direction: column;
                gap: 4px;
            }

            .profile-form .list-group .list-group-item {
                border: .25px solid var(--black-color);
                border-radius: 4px;
                cursor: pointer;
                transition: box-shadow .2s ease-in-out, transform .2s ease-in-out;
            }

            .profile-form .list-group .list-group-item:hover {
                transform: translateY(-5px);
                box-shadow: 0 4px 8px rgba(0, 0, 0, 0.3);
            }

            .profile-form .list-group .list-group-item:focus-within {
                transform: translateY(-5px);
                box-shadow: 0 4px 8px rgba(0, 0, 0, 0.3);
            }

            .profile-form .box-group {
                padding-top: 20px;
            }

            @media(min-width: 768px) {
                .profile-form .list-group {
                    flex-direction: row;
                    flex-wrap: wrap;
                }

                .profile-form>.list-group .list-group-item {
                    flex: 1 0 calc(50% - 4px);
                    max-width: calc(50% - 4px);
                }
            }

            @media(min-width: 1024px) {
                .profile-form .profile-types {
                    flex-direction: row;
                    flex-wrap: wrap;
                }

                #form-edit-profile #edit-profile {
                    align-self: flex-end;
                }
            }

            @media(min-width: 1280px) {
                .profile-form .color-info-container {
                    display: flex;
                    align-items: center;
                    gap: 20px;
                }
            }

            @media(min-width: 1440px) {
                .profile-form>.list-group .list-group-item {
                    flex: 1 0 calc(25% - 4px);
                    max-width: calc(25% - 4px);
                }
            }
        </style>
    @endpush

    <h2>Edição do perfil {{ $profile->name }}</h2>
    <p>
        O módulo de criação de perfis permite configurar identidades significativas. Garantir que esses perfis sejam úteis e
        representativos é crucial para integridade do sistema.
    </p>

    <div class="alert edit-profile">
        <strong><i class="fa-solid fa-triangle-exclamation"></i> Regras de criação de perfil:</strong>
        <ul>
            <li> Não é possível alterar o nome do perfil </li>
            <li> Escolha um nome de perfil que facilite o processo de entendimento dos usuários.</li>
            <li> Evite perfis específicos que serão usados apenas em excessões. Ex.: suprimentos_luis, diretor_luis </li>
            <li> Garanta que as habilidades estejam corretas. Isso ajuda a evitar perfis com acessos incorretos ou incompletos. </li>
            <li> Analise <a href="{{ route('users.index') }}" class="link-danger">usuários e habilidades</a> antes de ajustar o perfil.
                Talvez realizar ajustes em habilidades existentes seja a melhor opção. </li>
        </ul>
    </div>

    <form id="form-edit-profile" action="{{ route('profile.update', ['userProfile' => $profile]) }}" method="POST" class="profile-form">
        @csrf

        <div class="box-group">
            <h3>Escolha um grupo de habilidades</h3>
            <div class="profile-types">
                <button class="btn btn-secondary" data-profile="normal"><i class="fa-solid fa-plus-minus"></i> habililidades normais</button>
                <button class="btn btn-secondary" data-profile="suprimentos_inp"><i class="fa-solid fa-plus-minus"></i> habililidades de suprimentos INP</button>
                <button class="btn btn-secondary" data-profile="suprimentos_hkm"><i class="fa-solid fa-plus-minus"></i> habililidades de suprimentos HKM</button>
                <button class="btn btn-secondary" data-profile="gestor_usuarios"><i class="fa-solid fa-plus-minus"></i> habililidades de gestor de usuários</button>
                <button class="btn btn-secondary" data-profile="gestor_fornecedores"><i class="fa-solid fa-plus-minus"></i> habililidades de gestor de fornecedores</button>
                <button class="btn btn-secondary" data-profile="diretor"><i class="fa-solid fa-plus-minus"></i> habililidades de diretor</button>
            </div>
        </div>

        <div class="box-group color-info-container">
            <h3>Gerencie as habilidades do perfil {{ $profile->name }}</h3>
            <div class="color-info">
                <small class="get">Acessar dados</small>
                <small class="api">API's - Ações dinâmicas</small>
                <small class="post">Modificar dados</small>
                <small class="delete">Excluir dados</small>
                <small class="type-authorize">Autorização de perfil</small>
            </div>
        </div>

        <h5 class="ability-list-title">Esse perfil pode acessar quais dados e telas?</h5>
        <ul class="list-group" id="user-abilities">
            @foreach ($getAbilities as $ability)
                @php
                    $nameParts = explode('.', $ability->name);
                    $method = count($nameParts) > 1 ? $nameParts[0] : 'type-authorize';
                    $profileNames = $ability->profiles->pluck('name');
                    $isChecked = $profile->abilities->pluck('name')->contains($ability->name);
                @endphp
                <li class="list-group-item {{ $method }}">
                    <div class="form-check form-switch"
                        @can('admin') data-bs-toggle='tooltip' data-bs-placement='top' data-bs-title="{{ $ability->name }} (ID: {{ $ability->id }})" @endcan>
                        <input class="form-check-input ability-input" type="checkbox" role="switch" name="abilities[]" id="ability-{{ $ability->id }}" value="{{ $ability->id }}"
                            @checked($isChecked) data-profiles='{{ $profileNames }}'>
                        <label class="form-check-label" for="ability-{{ $ability->id }}">
                            {{ $ability->description }}
                        </label>
                    </div>
                </li>
            @endforeach
        </ul>

        <h5 class="ability-list-title">
            <i class="fa-solid fa-circle-info" data-bs-toggle='tooltip' data-bs-placement='top'
                data-bs-title="API's são consultas dinâmicas que normalmente são usadas em caixas flutuantes, dados que precisam ser acessados sem recarregar páginas ou tabelas que estão consultando dados"></i>
            API's - Quais permissões dinâmicas esse perfil deve ter?
        </h5>
        <ul class="list-group" id="user-abilities">
            @foreach ($apiAbilities as $ability)
                @php
                    $profileNames = $ability->profiles->pluck('name');
                    $isChecked = $profile->abilities->pluck('name')->contains($ability->name);
                @endphp
                <li class="list-group-item api">
                    <div class="form-check form-switch"
                        @can('admin') data-bs-toggle='tooltip' data-bs-placement='top' data-bs-title="{{ $ability->name }} (ID: {{ $ability->id }})" @endcan>
                        <input class="form-check-input ability-input" type="checkbox" role="switch" name="abilities[]" id="ability-{{ $ability->id }}"
                            value="{{ $ability->id }}" @checked($isChecked) data-profiles='{{ $profileNames }}'>
                        <label class="form-check-label" for="ability-{{ $ability->id }}">
                            {{ $ability->description }}
                        </label>
                    </div>
                </li>
            @endforeach
        </ul>

        <h5 class="ability-list-title">Esse perfil pode modificar quais dados?</h5>
        <ul class="list-group" id="user-abilities">
            @foreach ($postAbilities as $ability)
                @php
                    $nameParts = explode('.', $ability->name);
                    $method = count($nameParts) > 1 ? $nameParts[0] : 'type-authorize';
                    $profileNames = $ability->profiles->pluck('name');
                    $isChecked = $profile->abilities->pluck('name')->contains($ability->name);
                @endphp
                <li class="list-group-item {{ $method }}">
                    <div class="form-check form-switch"
                        @can('admin') data-bs-toggle='tooltip' data-bs-placement='top' data-bs-title="{{ $ability->name }} (ID: {{ $ability->id }})" @endcan>
                        <input class="form-check-input ability-input" type="checkbox" role="switch" name="abilities[]" id="ability-{{ $ability->id }}"
                            value="{{ $ability->id }}" @checked($isChecked) data-profiles='{{ $profileNames }}'>
                        <label class="form-check-label" for="ability-{{ $ability->id }}">
                            {{ $ability->description }}
                        </label>
                    </div>
                </li>
            @endforeach
        </ul>

        <h5 class="ability-list-title">O que esse perfil pode excluir?</h5>
        <ul class="list-group" id="user-abilities">
            @foreach ($deleteAbilities as $ability)
                @php
                    $nameParts = explode('.', $ability->name);
                    $method = count($nameParts) > 1 ? $nameParts[0] : 'type-authorize';
                    $profileNames = $ability->profiles->pluck('name');
                    $isChecked = $profile->abilities->pluck('name')->contains($ability->name);
                @endphp
                <li class="list-group-item {{ $method }}">
                    <div class="form-check form-switch"
                        @can('admin') data-bs-toggle='tooltip' data-bs-placement='top' data-bs-title="{{ $ability->name }} (ID: {{ $ability->id }})" @endcan>
                        <input class="form-check-input ability-input" type="checkbox" role="switch" name="abilities[]" id="ability-{{ $ability->id }}"
                            value="{{ $ability->id }}" @checked($isChecked) data-profiles='{{ $profileNames }}'>
                        <label class="form-check-label" for="ability-{{ $ability->id }}">
                            {{ $ability->description }}
                        </label>
                    </div>
                </li>
            @endforeach
        </ul>

        <h5 class="ability-list-title">Ao acessar e modificar dados esse perfil é autorizado como?</h5>
        <ul class="list-group" id="user-abilities">
            @foreach ($authorizeAbilities as $ability)
                @php
                    $nameParts = explode('.', $ability->name);
                    $method = count($nameParts) > 1 ? $nameParts[0] : 'type-authorize';
                    $profileNames = $ability->profiles->pluck('name');
                    $isChecked = $profile->abilities->pluck('name')->contains($ability->name);
                @endphp
                <li class="list-group-item {{ $method }}">
                    <div class="form-check form-switch"
                        @can('admin') data-bs-toggle='tooltip' data-bs-placement='top' data-bs-title="{{ $ability->name }} (ID: {{ $ability->id }})" @endcan>
                        <input class="form-check-input ability-input" type="checkbox" role="switch" name="abilities[]" id="ability-{{ $ability->id }}"
                            value="{{ $ability->id }}" @checked($isChecked) data-profiles='{{ $profileNames }}'>
                        <label class="form-check-label" for="ability-{{ $ability->id }}">
                            {{ $ability->description }}
                        </label>
                    </div>
                </li>
            @endforeach
        </ul>

        @can('post.profile.update')
            <button type="button" class="btn btn-primary btn-large" id="edit-profile">
                Atualizar perfil
            </button>
        @endcan
    </form>

    @push('scripts')
        <script type="module">
            $(() => {
                const $updateProfileBtn = $('#edit-profile');
                const $profileBtns = $('button[data-profile]');
                const $listGroupItem = $('.list-group-item');
                const $abilitiesInputs = $('input[name="abilities[]"]');

                const setProfileAbilities = (event) => {
                    event.preventDefault();
                    $listGroupItem.removeClass('ability-relation-alert');

                    const $profileTarget = $(event.target).data('profile');

                    const abilitiesTargetsUnchecked = $('.ability-input').filter((_, element) => {
                        const $currentElement = $(element);
                        const profiles = $currentElement.data('profiles');
                        const isAbilityTarget = profiles.includes($profileTarget);

                        if (isAbilityTarget) {
                            return !$currentElement.is(':checked');
                        }
                    })

                    $('.ability-input').each((_, element) => {
                        const $currentElement = $(element);
                        const profiles = $currentElement.data('profiles');
                        const isAbilityTarget = profiles.includes($profileTarget);

                        if (isAbilityTarget) {
                            $currentElement.prop('checked', abilitiesTargetsUnchecked.length ? true : false);
                        }
                    })
                };

                const updateProfile = (event) => {
                    event.preventDefault();

                    const title = 'Atenção! Confirme que deseja atualizar esse perfil';
                    const message =
                        `Ao concordar você irá impactar diretamente nas ações dos usuários`;

                    $.fn.showModalAlert(title, message, () => $('#form-edit-profile').trigger('submit'), 'modal-lg');
                }

                const toggleCheckbox = (event) => {
                    const $checkBox = $(event.target).find('input[name="abilities[]"]');
                    $checkBox.prop('checked', !$checkBox.prop('checked'));

                    $checkBox.trigger('change');
                }

                $updateProfileBtn.on('click', updateProfile);

                $profileBtns.on('click', setProfileAbilities);

                $listGroupItem.on('click', toggleCheckbox);

                $abilitiesInputs.on('change', (event) => $.fn.checkAbilityRelations(event));
            });
        </script>
    @endpush
</x-app>
