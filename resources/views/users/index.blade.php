<x-app>
    <x-modals.delete />

    <div class="row">
        <div class="col-sm-12">
            <div class="box box-color box-bordered">
                <div class="row" style="margin: 0 0 30px;">
                    <div class="col-md-6" style="padding: 0">
                        <h1 class="page-title">Lista de usuários</h1>
                    </div>
                    <div class="col-md-6" style="padding: 0">
                        <a data-cy="btn-novo-usuario" href="{{ route('register') }}" class="btn btn-primary btn-large pull-right">Novo usuário</a>
                    </div>
                </div>

                <div class="box-content nopadding regular-text">

                    <table style="width: 100%" class="table table-hover table-bordered dataTable" data-nosort="0" data-checkall="all" data-column_filter_dateformat="dd-mm-yy">
                        <thead>
                            <tr>
                                <th>Usuário</th>
                                <th>E-mail</th>
                                <th>Perfil</th>
                                <th>Membro desde</th>
                                <th>Opções</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($users as $index => $user)
                                <tr>
                                    <td>{{ $user->person->name }}</td>
                                    <td>{{ $user->email }}</td>
                                    <td class='hidden-350'>{{ $user->profile->name }}</td>
                                    <td class='hidden-1024'>{{ $user->created_at->formatCustom('d/m/Y - H:i:s') }}</td>
                                    <td class='hidden-480'>
                                        <a data-cy="btn-editar-usuario-{{ $index }}" href="{{ route('user', ['id' => $user->id]) }}" class="btn" rel="tooltip"
                                            title="Edit"><i class="fa fa-edit"></i></a>
                                        <button data-route="user" data-name="{{ $user->person->name }}" data-id="{{ $user->id }}" rel="tooltip" title="Excluir" class="btn"
                                            data-bs-toggle="modal" data-bs-target="#modal-delete" data-cy="btn-modal-excluir-usuario-{{ $index }}">
                                            <i class="fa fa-times"></i>
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                </div>
            </div>
        </div>
    </div>

</x-app>
