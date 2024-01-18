<x-app>
    @push('styles')
        <style>
            .user-header {
                display: flex;
                flex-wrap: wrap;
                justify-content: space-between;
                gap: 20px;
            }

            .actions {
                display: flex;
                gap: 4px;
                justify-content: center;
                align-items: center;
            }

            .actions>* {
                flex-basis: 40px;
            }

            .tag-list-item {
                cursor: help;
                text-overflow: ellipsis;
                overflow: hidden;
                max-width: 250px;
            }
        </style>
    @endpush

    <x-modals.delete />
    <x-modals.edit-user-ability :grouped-abilities="$groupedAbilities" />

    <div class="box-content nopadding regular-text">

        <div class="user-header">
            <h1 class="page-title">Lista de usuários</h1>
            @can('get.users.create')
                <a data-cy="btn-novo-usuario" href="{{ route('users.create') }}" class="btn btn-primary btn-large">Novo usuário</a>
            @endcan
        </div>

        <table style="width: 100%" class="table table-hover table-bordered dataTable" data-nosort="0" data-checkall="all" data-column_filter_dateformat="dd-mm-yy">
            <thead>
                <tr>
                    <th>Usuário</th>
                    <th>E-mail</th>
                    <th>Perfil</th>
                    <th>Habilidades específicas</th>
                    <th>Membro desde</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($users as $index => $user)
                    <tr>
                        <td>{{ $user->person->name }}</td>
                        <td>{{ $user->email }}</td>
                        <td>{{ $user->profile->name }}</td>
                        <td>
                            <div class="tag-list">
                                @forelse ($user->abilities as $ability)
                                    <span class="tag-list-item" data-bs-toggle='tooltip' data-bs-placement='top' data-bs-title="{{ $ability->description }}">
                                        {{ $ability->description }}
                                    </span>
                                @empty
                                    Padrões do perfil
                                @endforelse
                            </div>
                        </td>
                        <td>{{ $user->created_at->formatCustom('d/m/Y - H:i:s') }}</td>
                        <td>
                            <div class="actions">
                                <a data-cy="btn-editar-usuario-{{ $index }}" href="{{ route('users.edit', ['user' => $user]) }}" class="btn btn-mini btn-secondary"
                                    rel="tooltip">
                                    <i class="fa-solid fa-pen-to-square" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Editar dados usuário"></i>
                                </a>
                                @can('delete.api.users.destroy')
                                    <button data-route="api.users.destroy" data-name="{{ $user->person->name }}" data-id="{{ $user->id }}" rel="tooltip"
                                        class="btn btn-mini btn-secondary" data-bs-toggle="modal" data-bs-target="#modal-delete"
                                        data-cy="btn-modal-excluir-usuario-{{ $index }}">
                                        <i class="fa-solid fa-trash" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Excluir usuário"></i>
                                    </button>
                                @endcan
                                @can('get.api.users.show')
                                    <button class="btn btn-mini btn-secondary" data-bs-toggle="modal" data-bs-target="#modal-edit-user-ability" data-user-id={{ $user->id }}>
                                        <i class="fa-solid fa-sliders" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Editar habilidades do usuário"></i>
                                    </button>
                                @endcan
                                @can('get.users.show')
                                    <a href="{{ route('users.show', ['user' => $user]) }}" class="btn btn-mini btn-secondary">
                                        <i class="fa-solid fa-eye" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Visualizar cadastro de usuário"></i>
                                    </a>
                                @endcan
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

    </div>

</x-app>
