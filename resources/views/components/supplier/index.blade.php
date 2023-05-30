<x-app>
    <x-slot name="title">
        <h1>Fornecedores</h1>
    </x-slot>

    <x-modalDelete/>

        <div class="row">
            <div class="col-sm-12">
                <div class="box box-color box-bordered">

                    <div class="box-title">
                        <div class="row">
                            <div class="col-md-6">
                                <h3 class="pull-left">Todos os fornecedores</h3>
                            </div>
                            <div class="col-md-6">
                                <a href="{{ route('supplierRegister') }}" class="btn pull-right btn-large" style="margin-right: 15px">Cadastrar novo</a>
                            </div>
                        </div>
                    </div>

                    <div class="box-content nopadding">

                        <table
                            class="table table-hover table-nomargin table-bordered dataTable"
                            data-column_filter_dateformat="dd-mm-yy" data-nosort="0" data-checkall="all">
                            <thead>
                                <tr>
                                    <th class="col-md-1">CNPJ</th>
                                    <th class="col-md-3">Razão Social</th>
                                    <th class="col-md-2">Tipo</th>
                                    <th class="col-md-4">E-mail</th>
                                    <th class='hidden-350 col-md-2'>Situação</th>
                                    <th class='hidden-1024 col-md-1'>Criado em</th>
                                    <th class='hidden-480 col-md-1' >Ações</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>12.345.678/0001-01</td>
                                    <td>FORNECEDOR 01</td>
                                    <td>Serviços</td>
                                    <td>fornecedor01@empresa.com.br</td>
                                    <td class='hidden-350 col-md-2'>Qualificado</td>
                                    <td class='hidden-1024 col-md-1'>10/05/2023</td>
                                    <td class='hidden-480'>
                                        <a href="" class="btn" rel="tooltip" title="Edit"><i class="fa fa-edit"></i></a>
                                        <button class="btn">
                                                <i class="fa fa-times"></i>
                                        </button>
                                    </td>
                                </tr>
                                <tr>
                                    <td>12.345.678/0002-02</td>
                                    <td>FORNECEDOR 02</td>
                                    <td>Serviços</td>
                                    <td>fornecedor02@empresa.com.br</td>
                                    <td class='hidden-350 col-md-2'>Qualificado</td>
                                    <td class='hidden-1024 col-md-1'>10/04/2023</td>
                                    <td class='hidden-480'>
                                        <a href="" class="btn" rel="tooltip" title="Edit"><i class="fa fa-edit"></i></a>
                                        <button class="btn">
                                                <i class="fa fa-times"></i>
                                        </button>
                                    </td>
                                </tr>
                                <tr>
                                    <td>12.345.678/0003-03</td>
                                    <td>FORNECEDOR 03</td>
                                    <td>Produtos</td>
                                    <td>fornecedor03@empresa.com.br</td>
                                    <td class='hidden-350 col-md-2'>Não Qualificado</td>
                                    <td class='hidden-1024 col-md-1'>10/03/2023</td>
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
