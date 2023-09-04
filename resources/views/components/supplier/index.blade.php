@php
    use App\Enums\SupplierQualificationStatus;

    $supplierQualificationStatus = SupplierQualificationStatus::cases();

    $enumQualification = [];
    foreach ($supplierQualificationStatus as $enum) {
       $enumQualification[$enum->value] = $enum->label();
    }
@endphp
<x-app>

    <x-modalDelete/>

        <div class="row">
            <div class="col-sm-12">
                <div class="box box-color box-bordered">
                    <div class="row" style="margin: 0 0 30px">
                        <div class="col-md-6" style="padding: 0">
                            <h1 class="page-title">Todos os fornecedores</h1>
                        </div>
                        <div class="col-md-6" style="padding: 0">
                            <a data-cy="btn-cadastrar-novo" href="{{ route('supplier.form') }}" class="btn btn-primary btn-large pull-right">Cadastrar novo</a>
                        </div>
                    </div>

                    <div class="box-content nopadding regular-text">

                        <table id="supplierTable" class="table table-hover table-nomargin table-bordered" data-nosort="0" data-checkall="all">
                            <thead>
                                <tr>
                                    <th >CNPJ</th>
                                    <th >Razão social</th>
                                    <th >Nome fantasia</th>
                                    <th >Indicação</th>
                                    <th >Mercado</th>
                                    <th >Situação</th>
                                    <th >Ações</th>
                                </tr>
                            </thead>
                            <tbody>
                                {{-- DINÂMICO --}}
                            </tbody>
                        </table>

                    </div>
                </div>
            </div>
        </div>

</x-app>

<script>
    $(() => {
        $('#supplierTable').DataTable({
            serverSide: true,
            paging: true,
            lengthMenu: [10, 25, 50, 100],
            searching: true,
            searchDelay: 1000,
            language: {
                lengthMenu: "Mostrar _MENU_ registros por página",
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
            ajax: {
                url: @json(route('api.suppliers.index')),
                type: 'GET',
                error: (jqXHR, textStatus, errorThrown) => {
                    console.log('Erro na requisição do DataTable:', errorThrown);
                }
            },
            columns: [
                {
                    data: 'cpf_cnpj',
                    render: (value) => {
                        const cnpjRegex = /^(\d{2})(\d{3})(\d{3})(\d{4})(\d{2})$/;
                        return cnpjRegex.test(value)  ? value.replace(cnpjRegex, '$1.$2.$3/$4-$5') : "---";
                    }
                },
                { data: 'corporate_name'},
                { data: 'name', defaultContent: '---' },
                { data: 'supplier_indication'},
                { data: 'market_type'},
                {
                    data: 'qualification',
                    render: (value) => {
                        const enumQualification = @json($enumQualification);
                        return enumQualification[value];
                    }
                },
                {
                    data: null,
                    render: (data) => (
                        '<a href="suppliers/view/' + data.id + '" ' + 'class="btn" rel="tooltip" title="Editar" data-cy="btn-edit-supplier-' + data.id + '"><i class="fa fa-edit"></i></a>'
                        + '<button data-route="supplier" data-name="' + data.corporate_name + '" data-id="' + data.id + '" rel="tooltip" title="Excluir" class="btn" data-toggle="modal" data-target="#modal" data-cy="btn-modal-delete-supplier"><i class="fa fa-times"></i></button>'
                    )
                }
            ]
        });
    });
</script>
