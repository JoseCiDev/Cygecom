<x-app>
    @push('styles')
        <style>
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

            .profile-form .profile-name-container {
                display: flex;
                flex-direction: column;
                gap: 16px;
                font-size: 14px;
            }

            .profile-form .profile-name-container .alert ul {
                padding-left: 13px;
            }

            .profile-form .profile-name {
                max-width: 400px;
                display: flex;
                flex-direction: column;
                gap: 8px;
            }

            .profile-form .profile-name label {
                color: var(--grey-primary-color);
                font-size: 22px;
            }

            .profile-form .alert {
                border: 1px solid var(--alert-color);
                border-radius: 4px;
                background-color: #FFFCEF;
                color: #666;
            }

            .profile-form .alert ul {
                margin-top: 8px;
            }

            .profile-form .alert .fa-triangle-exclamation {
                color: var(--alert-color);
            }

            .profile-form>.list-group {
                display: flex;
                flex-direction: column;
                gap: 4px;
            }

            .profile-form>.list-group .list-group-item {
                border: .25px solid var(--black-color);
                border-radius: 4px;
                cursor: pointer;
            }

            .profile-form .box-group {
                padding-top: 20px;
            }

            @media(min-width: 768px) {
                .profile-form>.list-group {
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

                #form-create-profile #create-profile {
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

            @media(min-width: 1366px) {
                .profile-form .profile-name-container {
                    flex-direction: row;
                }

                .profile-form .profile-name-container .profile-name {
                    flex-grow: 1;
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

    <x-toast />

    <h1>Criação de perfil</h1>
    <p>
        O módulo de criação de perfis permite configurar identidades significativas. Garantir que esses perfis sejam úteis e
        representativos é crucial para integridade do sistema.
    </p>

    <form id="form-create-profile" action="{{ route('profile.store') }}" method="POST" class="profile-form">
        @csrf
        <div class="profile-name-container">
            <div class="profile-name">
                <label for="name">Nome do novo perfil</label>
                <input type="text" id="name" data-cy="name" name="name" placeholder="Ex: suprimentos_inp, diretor, admin" class="form-control" minlength="4" maxlength="30"
                    required>
            </div>

            <div class="alert">
                <strong><i class="fa-solid fa-triangle-exclamation"></i> Regras de criação de perfil:</strong>
                <ul>
                    <li> Nome de perfil é único, não deve ter espaço, e não deve ter caracteres especiais ou acentos, exceto "_". Ex.: suprimentos_hkm </li>
                    <li> Escolha um nome de perfil que facilite o processo de entendimento dos usuários.</li>
                    <li> Evite perfis específicos que serão usados apenas em excessões. Ex.: suprimentos_luis, diretor_luis </li>
                    <li> Garanta que as habilidades estejam corretas. Isso ajuda a evitar perfis com acessos incorretos ou incompletos. </li>
                    <li> Analise <a href="{{ route('users.index') }}" class="link-danger">usuários e habilidades</a> antes de criar um novo perfil.
                        Talvez realizar ajustes em habilidades existentes seja a melhor opção. </li>
                </ul>
            </div>
        </div>

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
            <h3>Gerencie as habilidades do novo perfil</h3>
            <div class="color-info">
                <small class="get">Acessar dados</small>
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
                @endphp
                <li class="list-group-item {{ $method }}" for="ability-{{ $ability->id }}">
                    <div class="form-check form-switch" data-bs-toggle='tooltip' data-bs-placement='top' data-bs-title="{{ $ability->name }} (ID: {{ $ability->id }})">
                        <input class="form-check-input ability-input" type="checkbox" role="switch" name="abilities[]" id="ability-{{ $ability->id }}" value="{{ $ability->id }}"
                            @checked($profileNames->contains('normal')) data-profiles='{{ $profileNames }}'>
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
                @endphp
                <li class="list-group-item {{ $method }}">
                    <div class="form-check form-switch" data-bs-toggle='tooltip' data-bs-placement='top' data-bs-title="{{ $ability->name }} (ID: {{ $ability->id }})">
                        <input class="form-check-input ability-input" type="checkbox" role="switch" name="abilities[]" id="ability-{{ $ability->id }}"
                            value="{{ $ability->id }}" @checked($profileNames->contains('normal')) data-profiles='{{ $profileNames }}'>
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
                @endphp
                <li class="list-group-item {{ $method }}">
                    <div class="form-check form-switch" data-bs-toggle='tooltip' data-bs-placement='top' data-bs-title="{{ $ability->name }} (ID: {{ $ability->id }})">
                        <input class="form-check-input ability-input" type="checkbox" role="switch" name="abilities[]" id="ability-{{ $ability->id }}"
                            value="{{ $ability->id }}" @checked($profileNames->contains('normal')) data-profiles='{{ $profileNames }}'>
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
                @endphp
                <li class="list-group-item {{ $method }}">
                    <div class="form-check form-switch" data-bs-toggle='tooltip' data-bs-placement='top' data-bs-title="{{ $ability->name }} (ID: {{ $ability->id }})">
                        <input class="form-check-input ability-input" type="checkbox" role="switch" name="abilities[]" id="ability-{{ $ability->id }}"
                            value="{{ $ability->id }}" @checked($profileNames->contains('normal')) data-profiles='{{ $profileNames }}'>
                        <label class="form-check-label" for="ability-{{ $ability->id }}">
                            {{ $ability->description }}
                        </label>
                    </div>
                </li>
            @endforeach
        </ul>

        @can('post.profile.store')
            <button type="button" class="btn btn-large btn-primary" id="create-profile">
                Criar perfil
            </button>
        @endcan
    </form>

    @push('scripts')
        <script type="module">
            $(() => {
                const $createProfileBtn = $('#create-profile');
                const $profileBtns = $('button[data-profile]');
                const $listGroupItem = $('.list-group-item');

                const setProfileAbilities = (event) => {
                    event.preventDefault();
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

                const createProfile = (event) => {
                    event.preventDefault();

                    const $form = $('#form-create-profile');
                    const $name = $('#name');
                    const regex = /^[a-z_]+$/u;

                    if (!$form.valid()) {
                        $name.focus();
                        $.fn.createToast('Nome de perfil é um campo obrigatório!', 'Ops... Faltou o nome', 'bg-warning');
                        return;
                    }

                    if (!regex.test($name.val())) {
                        $name.focus();
                        $.fn.createToast('Espaços, letras maiúsculas, números e caracteres especiais não são permitidos, exceto _', 'Ops... Nome inválido', 'bg-warning');
                        return;
                    }

                    const title = 'Atenção! Confirme que deseja criar um novo perfil';
                    const message =
                        `Essa ação não poderá ser desfeita.
                         Ao concordar e criar um novo perfil, em seguida, atribua-o aos usuários necessários.
                         Evite manter o novo perfil sem relações.
                         Em caso de não possuir autorização contate o gestor de usuários.`;

                    $.fn.showModalAlert(title, message, () => $('#form-create-profile').trigger('submit'), 'modal-lg');
                }

                const toggleCheckbox = (event) => {
                    const $checkBox = $(event.target).find('input[name="abilities[]"]');
                    $checkBox.prop('checked', !$checkBox.prop('checked'));
                }

                $createProfileBtn.on('click', createProfile);

                $profileBtns.on('click', setProfileAbilities);

                $listGroupItem.on('click', toggleCheckbox);
            });
        </script>
    @endpush
</x-app>
