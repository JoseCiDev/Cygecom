@php
    use App\Enums\SupplierQualificationStatus;

    $supplierQualificationStatus = SupplierQualificationStatus::cases();

    $enumQualification = [];
    foreach ($supplierQualificationStatus as $enum) {
        $enumQualification[$enum->value] = $enum->label();
    }
@endphp
<x-app>

    <x-modals.delete />

    <div class="row">
        <div class="col-sm-12">
            <div class="box box-color box-bordered">
                <div class="row" style="margin: 0 0 30px">
                    <div class="col-md-6" style="padding: 0">
                        <h1 class="page-title">Todos os fornecedores</h1>
                    </div>
                    <div class="col-md-6" style="padding: 0">
                        <a data-cy="btn-cadastrar-novo" href="{{ route('suppliers.create') }}" class="btn btn-primary btn-large pull-right">Cadastrar novo</a>
                    </div>
                </div>

                <div class="box-content nopadding regular-text">

                    <label for="qualificationFilter" class="regular-text">Filtrar por situação:</label>
                    <select id="qualificationFilter">
                        <option value="">Todos</option>
                        @foreach ($supplierQualificationStatus as $qualification)
                            <option value="{{ $qualification->value }}">{{ $qualification->label() }}</option>
                        @endforeach
                    </select>

                    <span class="loader-box"></span>
                    <table id="supplierTable" class="table table-hover table-nomargin table-bordered" data-nosort="0" data-checkall="all" style="width:100%">
                        <thead>
                            <tr>
                                <th class="noColvis">CNPJ</th>
                                <th>Razão social</th>
                                <th>Nome fantasia</th>
                                <th>Indicação</th>
                                <th>Mercado</th>
                                <th>Situação</th>
                                <th class="noColvis">Ações</th>
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

<script type="module">
    $(() => {
        const $badgeColumnsQtd = $(`<span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-dark"></span>`);
        const table = $('#supplierTable').DataTable({
            dom: 'Blfrtip',
            scrollY: '400px',
            scrollX: true,
            autoWidth: true,
            serverSide: true,
            paging: true,
            lengthMenu: [10, 25, 50, 100],
            searching: true,
            searchDelay: 1000,
            processing: true,
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
                },
                processing: $('.loader-box').show(),
            },
            ajax: {
                url: @json(route('api.suppliers.index')),
                type: 'GET',
                error: (jqXHR, textStatus, errorThrown) => {
                    console.log('Erro na requisição do DataTable:', errorThrown);
                }
            },
            columns: [{
                    data: 'cpf_cnpj',
                    orderable: false,
                    render: (value) => {
                        const cnpjRegex = /^(\d{2})(\d{3})(\d{3})(\d{4})(\d{2})$/;
                        return cnpjRegex.test(value) ? value.replace(cnpjRegex,
                            '$1.$2.$3/$4-$5') : "---";
                    }
                },
                {
                    data: 'corporate_name',
                    orderable: false,
                },
                {
                    data: 'name',
                    orderable: false,
                    defaultContent: '---'
                },
                {
                    data: 'supplier_indication',
                    orderable: false,
                },
                {
                    data: 'market_type',
                    orderable: false,
                },
                {
                    data: 'qualification',
                    orderable: false,
                    render: (value) => {
                        const enumQualification = @json($enumQualification);
                        return enumQualification[value];
                    }
                },
                {
                    data: null,
                    orderable: false,
                    render: (data) => (
                        '<a href="suppliers/edit/' + data.id + '" ' +
                        'class="btn" rel="tooltip" title="Editar" data-cy="btn-edit-supplier-' +
                        data.id + '"><i class="fa fa-edit"></i></a>' +
                        '<button data-route="suppliers.destroy" data-name="' + data.corporate_name +
                        '" data-id="' + data.id +
                        '" rel="tooltip" title="Excluir" class="btn" data-bs-toggle="modal" data-bs-target="#modal-delete" data-cy="btn-modal-delete-supplier"><i class="fa fa-times"></i></button>'
                    )
                }
            ],
            initComplete: function() {
                $('#qualificationFilter').on('change', function() {
                    const selectedValue = $(this).val();
                    table.search(selectedValue).draw();
                });

                $.fn.setStorageDtColumnConfig();
            },
            buttons: [{
                extend: 'colvis',
                columns: ':not(.noColvis)',
                text: `Mostrar / Ocultar colunas ${$badgeColumnsQtd[0].outerHTML}`,
                columnText: (dt, idx, title) => title,
            }],
        });
    });
</script>
