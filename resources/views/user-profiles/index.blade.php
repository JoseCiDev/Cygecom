@php
    use App\Enums\MainProfile;
@endphp

<x-app>
    @push('styles')
        <style>
            .header {
                display: flex;
                flex-wrap: wrap;
                justify-content: space-between;
                gap: 20px;
                margin-bottom: 20px;
            }

            .box {
                margin: 0 auto;
                max-width: 1100px;
            }

            .actions {
                display: flex;
                justify-content: center;
                align-items: center;
                gap: 5px;
            }
        </style>
    @endpush

    <x-modals.delete />
    <x-toast />

    <div class="box">

        <div class="header">
            <h1 class="page-title">Lista de perfis</h1>
            <a href="{{ route('profile.create') }}" class="btn btn-primary btn-large">Novo perfil</a>
        </div>

        <table id="profiles-table" style="width: 100%" class="table table-hover table-bordered dataTable">
            <thead>
                <tr>
                    <th>Nº</th>
                    <th>Nome</th>
                    <th>Qtd. usuários</th>
                    <th>Qtd. habilidades</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($profiles as $profile)
                    <tr>
                        <td>{{ $profile->id }}</td>
                        <td>{{ $profile->name }}</td>
                        <td>{{ $profile->user->count() }} usuários</td>
                        <td>{{ $profile->abilities->count() }} habilidades</td>
                        <td>
                            <div class="actions">
                                @if (!MainProfile::tryFrom($profile->name))
                                    <a href="{{ route('profile.edit', ['userProfile' => $profile]) }}" class="btn btn-mini btn-secondary" rel="tooltip" data-bs-toggle="tooltip"
                                        data-bs-placement="top" data-bs-title="Editar habilidades do perfil">
                                        <i class="fa-solid fa-sliders"></i>
                                    </a>

                                    <button class="btn btn-mini btn-secondary" data-route="api.userProfile.destroy" data-name="perfil {{ $profile->name }}"
                                        data-id="{{ $profile->id }}" data-bs-toggle="modal" data-bs-target="#modal-delete">
                                        <i class="fa-solid fa-trash" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Excluir perfil"></i>
                                    </button>
                                @else
                                    <small>Não editável</small>
                                @endif
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

    </div>

</x-app>
