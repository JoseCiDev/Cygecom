<x-app>
    @php
        $currentProfile = auth()->user()->profile->name;
    @endphp

    @push('styles')
        <style>
            .abilities {
                display: flex;
                flex-direction: column;
                gap: 40px;
            }

            .abilities #accordionFlushProfiles .accordion-item .accordion-collapse {
                padding-bottom: 50px;
            }

            .tag-list-item {
                cursor: help;
                text-overflow: ellipsis;
                overflow: hidden;
                max-width: 250px;
            }
        </style>
    @endpush

    <x-modals.edit-user-ability :abilities="$abilities" />

    <div class="abilities">
        <div class="box-content nopadding regular-text">
            <h2>Lista de usuários e suas habilidades</h2>
            <table style="width: 100%" class="table table-hover table-bordered dataTable-abilities">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th class="noColvis">Nome</th>
                        <th>E-mail</th>
                        <th>Perfil</th>
                        <th>Habilidades específicas</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($users->sortBy('id') as $index => $user)
                        <tr>
                            <td>{{ $user->id }}</td>
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
                            <td>
                                <button class="btn btn-mini btn-secondary" data-bs-toggle="modal" data-bs-target="#modal-edit-user-ability" data-user-id={{ $user->id }}>
                                    <i class="fa-solid fa-pen-to-square"></i> Editar habilidades</button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    @push('scripts')
        <script type="module">
            $(() => {
                const $abilitiesTables = $('.dataTable-abilities');
                $abilitiesTables.DataTable({
                    scrollY: '400px',
                    scrollX: true,
                    searching: true,
                    language: {
                        lengthMenu: "Mostrar _MENU_ registros",
                        zeroRecords: "Nenhum registro encontrado",
                        info: "Mostrando página _PAGE_ de _PAGES_",
                        infoEmpty: "Nenhum registro disponível",
                        infoFiltered: "(filtrado de _MAX_ registros no total)",
                        search: "Buscar:",
                        paginate: {
                            first: "Primeiro",
                            last: "Último",
                            next: "Próximo",
                            previous: "Anterior"
                        }
                    },
                });
            });
        </script>
    @endpush
</x-app>
