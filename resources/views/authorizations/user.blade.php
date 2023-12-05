@php
    $name = $user->person->name;
    $email = $user->email;
    $phone = $user->person->phone?->number;
    $profile = $user->profile->name;
    $sector = $user->person->costCenter->name;
    $company = $user->person->costCenter->company->name;
    $cnpj = preg_replace('/(\d{2})(\d{3})(\d{3})(\d{4})(\d{2})/', '$1.$2.$3/$4-$5', $user->person->costCenter->company->cnpj);
    $approverName = $user->approver?->person->name ?? '---';
    $approverEmail = $user->approver?->email ?? '---';
    $isBuyer = $user->is_buyer ? 'Autorizado' : 'Não autorizado';
    $canAssociateRequest = $user?->can_associate_requester ? 'Autorizado' : 'Não autorizado';
    $profileAbilities = $user->profile->abilities;
    $userAbilities = $user->abilities;
@endphp

<x-app>
    @push('styles')
        <style>
            .user-container li.list-group-item.get {
                border-left: 6px solid #6DC066;
            }

            .user-container li.list-group-item.post {
                border-left: 6px solid #FFA500;
            }

            .user-container li.list-group-item.delete {
                border-left: 6px solid #E74C3C;
            }

            .user-container li.list-group-item.type-authorized {
                border-left: 6px solid #000;
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
            }

            @media(min-width: 1440px) {
                .user-container .info p {
                    flex-grow: 0;
                    flex-basis: 24%;
                }

                .user-container .list-group .list-group-item {
                    flex: 1 0 32%;
                }
            }
        </style>
    @endpush

    <div class="user-container">
        <h1>Usuário {{ $name }}</h1>

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

        <p><strong>Habilidades do perfil do usuário:</strong> </p>
        <ul class="list-group list-group-abilities">
            @foreach ($profileAbilities as $ability)
                @php
                    $nameParts = explode('.', $ability->name);
                    $method = count($nameParts) > 1 ? $nameParts[0] : 'type-authorized';
                @endphp

                <li class="list-group-item {{ $method }}" data-bs-toggle='tooltip' data-bs-placement='top' data-bs-title="{{ $ability->name }} (ID: {{ $ability->id }})">
                    {{ $ability->description }}
                </li>
            @endforeach
        </ul>

        <hr>

        <p><strong>Habilidades expecíficas do usuário:</strong> </p>
        <ul class="list-group list-group-abilities">
            @forelse ($userAbilities as $ability)
                @php
                    $nameParts = explode('.', $ability->name);
                    $method = count($nameParts) > 1 ? $nameParts[0] : 'type-authorized';
                @endphp
                <li class="list-group-item {{ $method }}" data-bs-toggle='tooltip' data-bs-placement='top' data-bs-title="{{ $ability->name }} (ID: {{ $ability->id }})">
                    {{ $ability->description }}
                </li>
            @empty
                <small>Nenhuma habilidade além das existentes no perfil foi encontrada.</small>
            @endforelse
        </ul>
    </div>

</x-app>
