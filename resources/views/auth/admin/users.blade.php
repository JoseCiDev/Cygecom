<x-app>
     <x-modalDelete/>

        <div class="row">
            <div class="col-sm-12">
                <div class="box box-color box-bordered">
                    <div class="row" style="margin: 20px 0 30px;">
                        <div class="col-md-6" style="padding: 0">
                            <h1 class="page-title">Lista de usuários</h1>
                        </div>
                        <div class="col-md-6" style="padding: 0">
                            <a data-cy="btn-novo-usuario" href="{{route('register')}}" class="btn btn-primary btn-large pull-right">Novo usuário</a>
                        </div>
                    </div>

                    <div class="box-content nopadding">

                        <table
                            class="table table-hover table-nomargin table-bordered dataTable"
                            data-column_filter_dateformat="dd-mm-yy" data-nosort="0" data-checkall="all">
                            <thead>
                                <tr>
                                    <th class="col-md-3">Usuário</th>
                                    <th class="col-md-3">E-mail</th>
                                    <th class='hidden-350 col-md-2'>Perfil</th>
                                    <th class='hidden-1024 col-md-3'>Membro desde</th>
                                    <th class='hidden-480 col-md-1' >Opções</th>
                                </tr>
                            </thead>
                            <tbody>

                                @foreach ($users as $index => $user)
                                <tr>
                                    <td>{{$user->person->name}}</td>
                                    <td >{{$user->email}}</td>
                                    <td class='hidden-350'>{{$user->profile->name}}</td>
                                    <td class='hidden-1024'>{{\Carbon\Carbon::parse($user->created_at)->format('d/m/Y - H:m:s')}}</td>
                                    <td class='hidden-480'>
                                        <a data-cy="btn-editar-usuario-{{$index}}" href="{{route('user' , ['id' => $user->id ])}}" class="btn" rel="tooltip" title="Edit"><i class="fa fa-edit"></i></a>
                                        <button data-route="user" data-name="{{$user->person->name}}" data-id="{{$user->id}}" rel="tooltip" title="Excluir"
                                                class="btn" data-toggle="modal" data-target="#modal" data-cy="btn-modal-excluir-usuario-{{$index}}" >
                                                <i class="fa fa-times"></i>
                                        </button>
                                    </td>
                                </tr>
                                @endforeach

                        </table>

                    </div>
                </div>
            </div>
        </div>

</x-app>
