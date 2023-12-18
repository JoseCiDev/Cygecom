<x-app>
    @push('styles')
        <style>
            .ability-list-title {
                margin-top: 20px;
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
            }

            @media(min-width: 768px) {
                .profile-form .list-group {
                    flex-direction: row;
                    flex-wrap: wrap;
                }

                .profile-form .list-group .list-group-item {
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

            @media(min-width: 1440px) {
                .profile-form .list-group .list-group-item {
                    flex: 1 0 calc(25% - 4px);
                    max-width: calc(25% - 4px);
                }
            }
        </style>
    @endpush

    <h2>Criação de perfil</h2>
    <p>
        O módulo de criação de perfis permite configurar identidades significativas. Garantir que esses perfis sejam úteis e
        representativos é crucial para integridade do sistema.
    </p>

    <div class="alert alert-warning" role="alert">
        <strong>Regras de criação de perfil:</strong>
        <ul class="list-group">
            <li class="list-group-item bg-transparent"> Nome de perfil é único. </li>
            <li class="list-group-item bg-transparent"> Nome de perfil não deve ter espaço. Separe palavras com caracter "_". Ex.: suprimentos_hkm. </li>
            <li class="list-group-item bg-transparent"> Nome de perfil não deve ter caracteres especias ou acentos, exceto "_". </li>
            <li class="list-group-item bg-transparent"> Evite perfis específicos que serão usados apenas em excessões. Ex.: suprimentos_luis, diretor_luis </li>
            <li class="list-group-item bg-transparent"> Garanta que as habilidades estejam corretas. Isso ajuda a evitar perfis com acessos incorretos ou incompletos. </li>
            <li class="list-group-item bg-transparent"> Escolha um nome de perfil que facilite o processo de entendimento dos usuários. Ex.: suprimentos_hkm, suprimentos_inp </li>
            <li class="list-group-item bg-transparent"> Analise <a href="{{ route('users.index') }}" class="link-danger">usuários e habilidades</a> antes de
                criar um novo perfil. Pode ser que ajustar um ou poucos usuários seja a melhor solução. </li>
            <li class="list-group-item bg-transparent"> Conjunto de habilidades é único. Mesmo perfis idênticos com nomes diferentes não são permitidos. </li>
        </ul>
    </div>

    <form id="form-create-profile" action="{{ route('profile.store') }}" method="POST" class="profile-form mt-5">
        @csrf
        <div class="profile-name">
            <label for="name">Nome do perfil:</label>
            <input type="text" id="name" data-cy="name" name="name" placeholder="Ex: suprimentos_inp, diretor, admin" class="form-control" minlength="4" maxlength="30">
        </div>

        <div class="color-info">
            <small class="get">Acessar dados</small>
            <small class="post">Modificar dados</small>
            <small class="delete">Excluir dados</small>
            <small class="type-authorize">Autorização de perfil</small>
        </div>

        <div class="profile-types">
            <button class="btn btn-secondary" data-profile="normal"><i class="fa-solid fa-plus-minus"></i> habililidades normais</button>
            <button class="btn btn-secondary" data-profile="suprimentos_inp"><i class="fa-solid fa-plus-minus"></i> habililidades de suprimentos INP</button>
            <button class="btn btn-secondary" data-profile="suprimentos_hkm"><i class="fa-solid fa-plus-minus"></i> habililidades de suprimentos HKM</button>
            <button class="btn btn-secondary" data-profile="gestor_usuarios"><i class="fa-solid fa-plus-minus"></i> habililidades de gestor de usuários</button>
            <button class="btn btn-secondary" data-profile="gestor_fornecedores"><i class="fa-solid fa-plus-minus"></i> habililidades de gestor de fornecedores</button>
            <button class="btn btn-secondary" data-profile="diretor"><i class="fa-solid fa-plus-minus"></i> habililidades de diretor</button>
        </div>

        <h3 class="ability-list-title">Esse perfil pode acessar quais dados e telas?</h3>
        <ul class="list-group" id="user-abilities">
            @foreach ($getAbilities as $ability)
                @php
                    $nameParts = explode('.', $ability->name);
                    $method = count($nameParts) > 1 ? $nameParts[0] : 'type-authorize';
                    $profileNames = $ability->profiles->pluck('name');
                @endphp
                <li class="list-group-item {{ $method }}">
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

        <h3 class="ability-list-title">Esse perfil pode modificar quais dados?</h3>
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

        <h3 class="ability-list-title">O que esse perfil pode excluir?</h3>
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

        <h3 class="ability-list-title">Ao acessar e modificar dados esse perfil é autorizado como?</h3>
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

        <button type="button" class="btn btn-primary" id="create-profile">
            Criar perfil
        </button>
    </form>

    @push('scripts')
        <script type="module">
            $(() => {
                const $createProfileBtn = $('#create-profile');
                const $profileBtns = $('button[data-profile]');

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

                    const title = 'Atenção! Confirme que deseja criar um novo perfil';
                    const message =
                        `Essa ação não poderá ser desfeita.
                         Ao concordar e criar um novo perfil, em seguida, atribua-o aos usuários necessários.
                         Evite manter o novo perfil sem relações.
                         Em caso de não possuir autorização contate o gestor de usuários.`;

                    $.fn.showModalAlert(title, message, () => $('#form-create-profile').trigger('submit'), 'modal-lg');
                }

                $createProfileBtn.on('click', createProfile);

                $profileBtns.on('click', setProfileAbilities);
            });
        </script>
    @endpush
</x-app>
