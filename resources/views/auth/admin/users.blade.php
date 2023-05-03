<x-app>
    <x-slot name="title">
        <h1>Usuários</h1>
    </x-slot>

     <x-modalDelete/>

        <div class="row">
            <div class="col-sm-12">
                <div class="box box-color box-bordered">

                    <div class="box-title">
                        <div class="row">
                            <div class="col-md-6">
                                <h3 class="pull-left">Lista de usuários</h3>
                            </div>
                            <div class="col-md-6">
                                <a href="{{route('register')}}" class="btn pull-right btn-large" style="margin-right: 15px">Novo usuário</a>
                            </div>
                        </div>
                    </div>

                    <div class="box-content nopadding">

                        <table
                            class="table table-hover table-nomargin table-bordered dataTable"
                            data-column_filter_dateformat="dd-mm-yy" data-nosort="0" data-checkall="all">
                            <thead>
                                <tr>
                                    <th class='with-checkbox'>
                                        <input type="checkbox" name="check_all" class="dataTable-checkall">
                                    </th>
                                    <th class="col-md-3">Usuário</th>
                                    <th class="col-md-3">E-mail</th>
                                    <th class='hidden-350 col-md-2'>Perfil</th>
                                    <th class='hidden-1024 col-md-3'>Membro desde</th>
                                    <th class='hidden-480 col-md-1' >Opções</th>
                                </tr>
                            </thead>
                            <tbody>

                                @foreach ($users as $user)
                                <tr>
                                    <td class="with-checkbox">
                                        <input type="checkbox" name="check" value="1">
                                    </td>
                                    <td>{{$user['person']['name']}}</td>
                                    <td >{{$user['email']}}</td>
                                    <td class='hidden-350'>{{$user['profile']['name']}}</td>
                                    <td class='hidden-1024'>{{\Carbon\Carbon::parse($user['created_at'])->format('d/m/Y - H:m:s')}}</td>
                                    <td class='hidden-480'>
                                        <a href="{{route('user' , ['id' => $user['id']])}}" class="btn" rel="tooltip" title="Edit"><i class="fa fa-edit"></i></a>
                                        <button data-user-name="{{$user['person']['name']}}" data-user-id="{{$user['id']}}" rel="tooltip" title="Excluir"
                                                class="btn" data-toggle="modal" data-target="#user-modal"  ><i class="fa fa-times"></i>
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

<script>
    $(document).ready(function() {
        $('#DataTables_Table_0').DataTable({
            "language": {
            "lengthMenu": "Mostrar _MENU_ registros",
            "zeroRecords": "Nenhum registro encontrado",
            "info": "Mostrando página _PAGE_ de _PAGES_",
            "infoEmpty": "Nenhum registro disponível",
            "infoFiltered": "(filtrado de _MAX_ registros no total)",
            "search": "Buscar:",
            "paginate": {
                "first": "Primeiro",
                "last": "Último",
                "next": "Próximo",
                "previous": "Anterior"
            }
        },
        "destroy": true
        });
    })
</script>
