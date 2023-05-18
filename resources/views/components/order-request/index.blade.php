<x-app>
    <x-slot name="title">
        <h1>Solicitações de Compra/Serviço</h1>
    </x-slot>

    <x-modalDelete/>

        <div class="row">
            <div class="col-sm-12">
                <div class="box box-color box-bordered">

                    <div class="box-title">
                        <div class="row">
                            <div class="col-md-6">
                                <h3 class="pull-left">Todas as solicitações</h3>
                            </div>
                            <div class="col-md-6">
                                <a href="{{ route('requestRegister') }}" class="btn pull-right btn-large" style="margin-right: 15px">Nova Solicitação</a>
                            </div>
                        </div>
                    </div>

                    <div class="box-content nopadding">

                        <table
                            class="table table-hover table-nomargin table-bordered dataTable"
                            data-column_filter_dateformat="dd-mm-yy" data-nosort="0" data-checkall="all">
                            <thead>
                                <tr>
                                    <th class="col-md-3">Solicitante</th>
                                    <th class="col-md-5">Produto</th>
                                    <th class="col-md-3">Cnpj</th>
                                    <th class='hidden-350 col-md-2'>Status</th>
                                    <th class='hidden-1024col-md-2'>Atualizado em</th>
                                    <th class='hidden-480 col-md-1' >Opções</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>Cesar Luiz de Sousa Júnior</td>
                                    <td>Relógio de parede grande ou médio</td>
                                    <td>12.345.678/0001-00</td>
                                    <td class='hidden-350 col-md-2'>Em aprovação</td>
                                    <td class='hidden-1024 col-md-2'>10/05/2023</td>
                                    <td class='hidden-480'>
                                        <a href="" class="btn" rel="tooltip" title="Edit"><i class="fa fa-edit"></i></a>
                                        <button class="btn">
                                                <i class="fa fa-times"></i>
                                        </button>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Luis Pedro Piuma</td>
                                    <td>Dispenser para caixa de luva c/ 1 unidade</td>
                                    <td>12.345.678/0001-00</td>
                                    <td class='hidden-350 col-md-2'>Em cotação</td>
                                    <td class='hidden-1024 col-md-2'>10/04/2023</td>
                                    <td class='hidden-480'>
                                        <a href="" class="btn" rel="tooltip" title="Edit"><i class="fa fa-edit"></i></a>
                                        <button class="btn">
                                                <i class="fa fa-times"></i>
                                        </button>
                                    </td>
                                </tr>
                                <tr>
                                    <td>José Djalma</td>
                                    <td>Calice de plastico graduado 250ml</td>
                                    <td>92.475.678/0001-00</td>
                                    <td class='hidden-350 col-md-2'>Finalizado</td>
                                    <td class='hidden-1024 col-md-2'>10/03/2023</td>
                                    <td class='hidden-480'>
                                        <a href="" class="btn" rel="tooltip" title="Edit"><i class="fa fa-edit"></i></a>
                                        <button class="btn">
                                                <i class="fa fa-times"></i>
                                        </button>
                                    </td>
                                </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>

</x-app>


<script>
    $(() => {
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
