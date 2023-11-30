<x-app>
    @push('styles')
        <style>
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
                    flex: 1 0 33%;
                }
            }

            @media(min-width: 1024px) {
                .profile-form .profile-types {
                    flex-direction: row;
                    flex-wrap: wrap;
                }
            }

            @media(min-width: 1440px) {
                .profile-form .list-group .list-group-item {
                    flex: 1 0 24%;
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
            <li class="list-group-item bg-transparent">
                Evite perfis específicos que serão usados apenas em excessões.
                Em casos específicos deve ser usado o gerenciamento de
                <a href="{{ route('abilities.index') }}" class="link-danger">habildades de usuários</a>
            </li>

            <li class="list-group-item bg-transparent">
                Implemente habilidades que mantenham a integridade do sistema.
                Garanta que as habilidades estejam corretas. Isso ajuda a evitar perfis com acessos incorretos ou incompletos.
            </li>

            <li class="list-group-item bg-transparent"> Forneça um nome de perfil semântico que facilite o processo de entendimento dos usuários.</li>
            <li class="list-group-item bg-transparent"> Analise o módulo de configuração de habilidades antes de criar novos perfis. </li>
            <li class="list-group-item bg-transparent"> Nome de perfil é único; </li>
            <li class="list-group-item bg-transparent"> Nome de perfil não deve ter espaço. Separe palavras com caracter "_". Ex.: suprimentos_hkm; </li>
            <li class="list-group-item bg-transparent"> Conjunto de habilidades é único. (Perfis idênticos com nomes diferentes não são permitidos); </li>
        </ul>
    </div>

    <form action="{{ route('abilities.profile.create') }}" method="POST" class="profile-form mt-5">
        @csrf
        <div class="profile-name">
            <label for="name">Nome do perfil:</label>
            <input type="text" id="name" data-cy="name" name="name" placeholder="Ex: suprimentos_atrium, tributario" class="form-control" minlength="15" maxlength="50">
        </div>

        <div class="profile-types">
            <button class="btn btn-secondary" data-profile="normal"><i class="fa-solid fa-plus"></i> habilidades normais</button>
            <button class="btn btn-secondary" data-profile="admin"><i class="fa-solid fa-plus"></i> habilidades de administrador</button>
            <button class="btn btn-secondary" data-profile="suprimentos_inp"><i class="fa-solid fa-plus"></i> habilidades de suprimentos INP</button>
            <button class="btn btn-secondary" data-profile="suprimentos_hkm"><i class="fa-solid fa-plus"></i> habilidades de suprimentos HKM</button>
            <button class="btn btn-secondary" data-profile="gestor_usuario"><i class="fa-solid fa-plus"></i> habilidades gestor de usuários</button>
            <button class="btn btn-secondary" data-profile="gestor_fornecedores"><i class="fa-solid fa-plus"></i> habilidades gestor de fornecedores</button>
            <button class="btn btn-secondary" data-profile="diretor"><i class="fa-solid fa-plus"></i> habilidades de diretor</button>
        </div>

        <label for="user-abilities">Lista de habilidades para o novo perfil</label>
        <ul class="list-group" id="user-abilities">
            @foreach ($abilities as $ability)
                <li class="list-group-item">
                    <div class="form-check form-switch" data-bs-toggle='tooltip' data-bs-placement='top' data-bs-title="{{ $ability->name }} (ID: {{ $ability->id }})">
                        <input class="form-check-input ability-input" type="checkbox" role="switch" name="abilities[]" id="ability-{{ $ability->id }}" value="{{ $ability->id }}"
                            data-profiles='{{ $ability->profiles->pluck('name') }}'>
                        <label class="form-check-label" for="ability-{{ $ability->id }}">
                            {{ $ability->description }}
                        </label>
                    </div>
                </li>
            @endforeach
        </ul>

        <button class="btn btn-primary">
            Criar perfil
        </button>
    </form>

    @push('scripts')
        <script type="module">
            $(() => {
                const $profileBtns = $('button[data-profile]');

                const setProfileAbilities = (event) => {
                    event.preventDefault();
                    const $profileTarget = $(event.target).data('profile');

                    $('.ability-input').each((_, element) => {
                        const $currentElement = $(element);
                        const profiles = $currentElement.data('profiles');
                        const isChecked = profiles.find((el) => el === $profileTarget);

                        if (isChecked) {
                            $currentElement.prop('checked', true);
                        }
                    })

                };

                $profileBtns.on('click', setProfileAbilities);

                $('[data-bs-toggle="tooltip"]').each((_, tooltipTriggerEl) => new bootstrap.Tooltip(tooltipTriggerEl));
            });
        </script>
    @endpush
</x-app>
