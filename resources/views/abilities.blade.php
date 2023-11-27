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
                        <th class="noColvis">Habilidade</th>
                        <th>E-mail</th>
                        <th>Perfil</th>
                        <th>Habilidades</th>
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
                                @forelse ($user->abilities as $ability)
                                    <span style="cursor: help" class="tag-list-item" data-bs-toggle='tooltip' data-bs-placement='top'
                                        data-bs-title="{{ $ability->description }}">{{ $ability->name }}</span>
                                @empty
                                    Padrões do perfil
                                @endforelse
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

        <div class="box-content nopadding regular-text">
            <h2>Lista de habilidades</h2>
            <table style="width: 100%" class="table table-hover table-bordered dataTable-abilities">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Habilidade</th>
                        <th>Descrição</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($abilities->sortBy('id') as $index => $ability)
                        <tr>
                            <td>{{ $ability->id }}</td>
                            <td>{{ $ability->name }}</td>
                            <td>{{ $ability->description ?? '---' }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

        </div>

        <div class="accordion accordion-flush" id="accordionFlushProfiles">
            <h2>Lista de perfis com suas habilidades</h2>
            @foreach ($profiles->sortBy('id') as $index => $profile)
                <div class="accordion-item">
                    <h2 class="accordion-header">
                        <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapse-{{ $index }}" aria-expanded="true"
                            aria-controls="flush-collapse-{{ $index }}">
                            ID: {{ $profile->id }} {{ $profile->name }}
                        </button>
                    </h2>
                    <div id="flush-collapse-{{ $index }}" class="accordion-collapse collapse show" data-bs-parent="#accordionFlushProfiles">
                        <div class="accordion-body">
                            <table class="table dataTable-abilities" style="width: 100%">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th class="noColvis">Habilidade</th>
                                        <th>Descrição</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($profile->abilities as $item)
                                        <tr>
                                            <td>{{ $item->id }}</td>
                                            <td>{{ $item->name }}</td>
                                            <td>{{ $item->description ?? '---' }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            @endforeach
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

                const $tooltipTriggerList = $('[data-bs-toggle="tooltip"]');
                $tooltipTriggerList.each((_, tooltipTriggerEl) => new bootstrap.Tooltip(tooltipTriggerEl));
            });
        </script>
    @endpush
</x-app>
