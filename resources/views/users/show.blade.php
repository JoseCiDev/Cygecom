@php
    $getProfileAbilities = $groupedProfileAbilities->get('get', collect());
    $apiProfileAbilities = $groupedProfileAbilities->get('api', collect());
    $postProfileAbilities = $groupedProfileAbilities->get('post', collect());
    $deleteProfileAbilities = $groupedProfileAbilities->get('delete', collect());
    $authorizeProfileAbilities = $groupedProfileAbilities->get('authorize', collect());

    $getUserAbilities = $groupedUserAbilities->get('get', collect());
    $apiUserAbilities = $groupedUserAbilities->get('api', collect());
    $postUserAbilities = $groupedUserAbilities->get('post', collect());
    $deleteUserAbilities = $groupedUserAbilities->get('delete', collect());
    $authorizeUserAbilities = $groupedUserAbilities->get('authorize', collect());
@endphp

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

            .user-container li.list-group-item.get,
            .get {
                border-left: 6px solid #6DC066;
            }

            .user-container li.list-group-item.post,
            .post {
                border-left: 6px solid #FFA500;
            }

            .user-container li.list-group-item.delete,
            .delete {
                border-left: 6px solid #E74C3C;
            }

            .user-container li.list-group-item.api,
            .api {
                border-left: 6px solid #9abf20;
            }

            .user-container li.list-group-item.type-authorize,
            .type-authorize {
                border-left: 6px solid #000;
            }

            .user-container .user-header .options {
                padding: 15px 0;
                display: flex;
                flex-wrap: wrap;
                gap: 5px;
            }

            .user-container .user-header .options>* {
                min-width: fit-content;
                flex: 1 0 auto;
            }

            .user-container .info {
                display: flex;
                flex-wrap: wrap;
                column-gap: 10px;
            }

            .user-container .info p {
                flex-grow: 1;
                flex-basis: 250px;
            }

            .user-container .list-group {
                display: flex;
                flex-direction: column;
                gap: 5px;
            }

            .user-container .list-group .list-group-item {
                border: 1px solid var(--grey-primary-color);
                border-radius: 4px;
            }

            @media(min-width: 768px) {
                .user-container .user-header .options>* {
                    flex-grow: 0;
                }

                .user-container .list-group {
                    flex-direction: row;
                    flex-wrap: wrap;
                }

                .user-container .list-group .list-group-item {
                    flex: 1 0 calc(50% - 4px);
                    max-width: calc(50% - 4px);
                }
            }

            @media(min-width: 1024px) {
                .user-container .info p {
                    flex-grow: 0;
                    flex-basis: 30%;
                    max-width: 30%;
                }

                .user-container .list-group {
                    flex-direction: row;
                    flex-wrap: wrap;

                }

                .user-container .list-group .list-group-item {
                    flex: 1 0 45%;
                }

                .user-header .header {
                    display: flex;
                    justify-content: space-between;
                    padding-bottom: 20px;
                }

                .user-container .user-header .options {
                    padding: 0;
                    justify-content: flex-end;
                }

            }

            @media(min-width: 1440px) {
                .user-container .info p {
                    flex-grow: 0;
                    flex-basis: 24%;
                }

                .user-container .list-group .list-group-item {
                    flex: 1 0 calc(25% - 4px);
                    max-width: calc(25% - 4px);
                }
            }
        </style>
    @endpush

    <x-modals.delete />
    <x-modals.edit-user-ability :grouped-abilities="$groupedAbilities" />

    <div class="user-container">
        <div class="user-header">
            <div class="header">
                <h1 class="page-title">Usuário {{ $name }}</h1>

                <div class="options">
                    <a href="{{ route('users.edit', ['user' => $id]) }}" class="btn btn-small btn-secondary" rel="tooltip">
                        <i class="fa-solid fa-pen-to-square"></i>
                        Editar dados usuário
                    </a>

                    @can('get.api.users.show', 'post.api.user.abilities.store')
                        <button class="btn btn-mini btn-secondary" data-bs-toggle="modal" data-bs-target="#modal-edit-user-ability" data-user-id={{ $id }}>
                            <i class="fa-solid fa-sliders"></i>
                            Editar habilidades
                        </button>
                    @endcan

                    @can('delete.api.users.destroy')
                        <button data-route="api.users.destroy" data-name="{{ $name }}" data-id="{{ $id }}" data-cy="btn-modal-excluir-usuario" data-bs-toggle="modal"
                            data-bs-target="#modal-delete" rel="tooltip" title="Excluir" class="btn btn-primary btn-small btn-danger">
                            Excluir usuário
                        </button>
                    @endcan
                </div>
            </div>

            <div class="info">
                <p> <strong>E-mail:</strong> {{ $email }} </p>
                <p> <strong>Telefone/Celular:</strong> {{ $phone }} </p>
                <p> <strong>Perfil:</strong> {{ $profile }} </p>
                <p> <strong>Setor:</strong> {{ $sector }} </p>
                <p> <strong>Empresa:</strong> {{ $company }} / {{ $cnpj }}</p>
                <p> <strong>Usuário aprovador:</strong> {{ $approverName }} / {{ $approverEmail }} </p>
                <p> <strong>Autorização para solicitar:</strong> {{ $isBuyer }}</p>
                <p> <strong>Solicita para outras pessoas:</strong> {{ $canAssociateRequest }}</p>
            </div>

            <hr>

            <h4>
                <i class="fa-solid fa-circle-info" data-bs-toggle="tooltip" data-bs-placement="top"
                    data-bs-title="Habilidades vinculadas diretamente ao perfil que o usuário possui. ({{ $profile }})"></i>
                <strong>Habilidades do perfil do usuário:</strong>
            </h4>

            <div class="color-info">
                <small class="get">Acessar dados</small>
                <small class="post">Modificar dados</small>
                <small class="delete">Excluir dados</small>
                <small class="type-authorize">Autorização de perfil</small>
            </div>

            <h5 class="ability-list-title">Perfil do usuário pode acessar os seguintes dados e telas:</h5>
            <ul class="list-group" id="user-abilities">
                @foreach ($getProfileAbilities as $ability)
                    @php
                        $nameParts = explode('.', $ability->name);
                        $method = count($nameParts) > 1 ? $nameParts[0] : 'type-authorize';
                        $profileNames = $ability->profiles->pluck('name');
                    @endphp
                    <li class="list-group-item {{ $method }}"
                        @can('admin') data-bs-toggle='tooltip' data-bs-placement='top' data-bs-title="{{ $ability->name }} (ID: {{ $ability->id }})" @endcan>
                        {{ $ability->description }}
                    </li>
                @endforeach
            </ul>

            <h5 class="ability-list-title">
                <i class="fa-solid fa-circle-info" data-bs-toggle='tooltip' data-bs-placement='top'
                    data-bs-title="API's são consultas dinâmicas que normalmente são usadas em caixas flutuantes, dados que precisam ser acessados sem recarregar páginas ou tabelas que estão consultando dados"></i>
                API's - Permissões dinâmicas do perfil:
            </h5>
            <ul class="list-group" id="user-abilities">
                @foreach ($apiProfileAbilities as $ability)
                    @php
                        $profileNames = $ability->profiles->pluck('name');
                    @endphp
                    <li class="list-group-item api" data-bs-toggle='tooltip' data-bs-placement='top' data-bs-title="{{ $ability->name }} (ID: {{ $ability->id }})">
                        {{ $ability->description }}
                    </li>
                @endforeach
            </ul>

            <h5 class="ability-list-title">Perfil do usuário pode modificar os seguintes dados:</h5>
            <ul class="list-group" id="user-abilities">
                @foreach ($postProfileAbilities as $ability)
                    @php
                        $nameParts = explode('.', $ability->name);
                        $method = count($nameParts) > 1 ? $nameParts[0] : 'type-authorize';
                        $profileNames = $ability->profiles->pluck('name');
                    @endphp
                    <li class="list-group-item {{ $method }}"
                        @can('admin') data-bs-toggle='tooltip' data-bs-placement='top' data-bs-title="{{ $ability->name }} (ID: {{ $ability->id }})" @endcan>
                        {{ $ability->description }}
                    </li>
                @endforeach
            </ul>

            <h5 class="ability-list-title">Perfil do usuário pode excluir os seguintes dados:</h5>
            <ul class="list-group" id="user-abilities">
                @foreach ($deleteProfileAbilities as $ability)
                    @php
                        $nameParts = explode('.', $ability->name);
                        $method = count($nameParts) > 1 ? $nameParts[0] : 'type-authorize';
                        $profileNames = $ability->profiles->pluck('name');
                    @endphp
                    <li class="list-group-item {{ $method }}"
                        @can('admin') data-bs-toggle='tooltip' data-bs-placement='top' data-bs-title="{{ $ability->name }} (ID: {{ $ability->id }})" @endcan>
                        {{ $ability->description }}
                    </li>
                @endforeach
            </ul>

            <h5 class="ability-list-title">Ao acessar e modificar dados esse perfil é autorizado como:</h5>
            <ul class="list-group" id="user-abilities">
                @foreach ($authorizeProfileAbilities as $ability)
                    @php
                        $nameParts = explode('.', $ability->name);
                        $method = count($nameParts) > 1 ? $nameParts[0] : 'type-authorize';
                        $profileNames = $ability->profiles->pluck('name');
                    @endphp
                    <li class="list-group-item {{ $method }}"
                        @can('admin') data-bs-toggle='tooltip' data-bs-placement='top' data-bs-title="{{ $ability->name }} (ID: {{ $ability->id }})" @endcan>
                        {{ $ability->description }}
                    </li>
                @endforeach
            </ul>

            <hr>

            <h4>
                <i class="fa-solid fa-circle-info" data-bs-toggle="tooltip" data-bs-placement="top"
                    data-bs-title="Habilidades configuradas para necessidades específicas desse usuário."></i>
                <strong>Habilidades específicas do usuário:</strong>
            </h4>

            <h5 class="ability-list-title">Pode acessar os seguintes dados e telas:</h5>
            <ul class="list-group" id="user-abilities">
                @forelse ($getUserAbilities as $ability)
                    @php
                        $nameParts = explode('.', $ability->name);
                        $method = count($nameParts) > 1 ? $nameParts[0] : 'type-authorize';
                        $profileNames = $ability->profiles->pluck('name');
                    @endphp
                    <li class="list-group-item {{ $method }}"
                        @can('admin') data-bs-toggle='tooltip' data-bs-placement='top' data-bs-title="{{ $ability->name }} (ID: {{ $ability->id }})" @endcan>
                        {{ $ability->description }}
                    </li>
                @empty
                    <small>Nenhuma habilidade além das existentes no perfil foi encontrada.</small>
                @endforelse
            </ul>

            <h5 class="ability-list-title">
                <i class="fa-solid fa-circle-info" data-bs-toggle='tooltip' data-bs-placement='top'
                    data-bs-title="API's são consultas dinâmicas que normalmente são usadas em caixas flutuantes, dados que precisam ser acessados sem recarregar páginas ou tabelas que estão consultando dados"></i>
                API's - Permissões dinâmicas:
            </h5>
            <ul class="list-group" id="user-abilities">
                @foreach ($apiUserAbilities as $ability)
                    @php
                        $profileNames = $ability->profiles->pluck('name');
                    @endphp
                    <li class="list-group-item api" data-bs-toggle='tooltip' data-bs-placement='top' data-bs-title="{{ $ability->name }} (ID: {{ $ability->id }})">
                        {{ $ability->description }}
                    </li>
                @endforeach
            </ul>

            <h5 class="ability-list-title">Pode modificar o seguintes dados:</h5>
            <ul class="list-group" id="user-abilities">
                @forelse ($postUserAbilities as $ability)
                    @php
                        $nameParts = explode('.', $ability->name);
                        $method = count($nameParts) > 1 ? $nameParts[0] : 'type-authorize';
                        $profileNames = $ability->profiles->pluck('name');
                    @endphp
                    <li class="list-group-item {{ $method }}"
                        @can('admin') data-bs-toggle='tooltip' data-bs-placement='top' data-bs-title="{{ $ability->name }} (ID: {{ $ability->id }})" @endcan>
                        {{ $ability->description }}
                    </li>
                @empty
                    <small>Nenhuma habilidade além das existentes no perfil foi encontrada.</small>
                @endforelse
            </ul>

            <h5 class="ability-list-title">Pode excluir os seguintes dados:</h5>
            <ul class="list-group" id="user-abilities">
                @forelse ($deleteUserAbilities as $ability)
                    @php
                        $nameParts = explode('.', $ability->name);
                        $method = count($nameParts) > 1 ? $nameParts[0] : 'type-authorize';
                        $profileNames = $ability->profiles->pluck('name');
                    @endphp
                    <li class="list-group-item {{ $method }}"
                        @can('admin') data-bs-toggle='tooltip' data-bs-placement='top' data-bs-title="{{ $ability->name }} (ID: {{ $ability->id }})" @endcan>
                        {{ $ability->description }}
                    </li>
                @empty
                    <small>Nenhuma habilidade além das existentes no perfil foi encontrada.</small>
                @endforelse
            </ul>

            <h5 class="ability-list-title">Ao acessar e modificar dados esse usuário é autorizado como:</h5>
            <ul class="list-group" id="user-abilities">
                @forelse ($authorizeUserAbilities as $ability)
                    @php
                        $nameParts = explode('.', $ability->name);
                        $method = count($nameParts) > 1 ? $nameParts[0] : 'type-authorize';
                        $profileNames = $ability->profiles->pluck('name');
                    @endphp
                    <li class="list-group-item {{ $method }}"
                        @can('admin') data-bs-toggle='tooltip' data-bs-placement='top' data-bs-title="{{ $ability->name }} (ID: {{ $ability->id }})" @endcan>
                        {{ $ability->description }}
                    </li>
                @empty
                    <small>Nenhuma habilidade além das existentes no perfil foi encontrada.</small>
                @endforelse
            </ul>
        </div>
    </div>
</x-app>
