import setColvisConfig from '../utils/colvis-custom-user-preference.js'

$(() => {
    const $badgeColumnsQtd = $(`<span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-dark"></span>`);
    setColvisConfig();

    const $tableSupplies = $('table#table-supplies-list');
    const $tableSearchBarRow = $tableSupplies.find("tr.search-bar");

    $tableSupplies.dataTable({
        dom: 'Blfrtip',
        initComplete: () => $.fn.setStorageDtColumnConfig(),
        scrollY: '400px',
        scrollX: true,
        autoWidth: true,
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

        buttons: [
            {
                extend: 'colvis',
                columns: ':not(.noColvis)',
                text: `Mostrar / Ocultar colunas ${$badgeColumnsQtd[0].outerHTML}`,
            }
        ],

        pageLength: 25,
        columnDefs: [{
            orderable: false,
            "ordering": false,
        }],

        initComplete: function () {
            let index = 0;
            this.api().columns().every(function (e) {
                const column = this;
                const input = $('<input>', {
                    width: '100%',
                    placeholder: 'Buscar',
                });

                input.addClass('search-button');

                if (!column.header().classList.contains('ignore-search')) {
                    if (!column.header().classList.contains('no-search')) {
                        $tableSearchBarRow.children().eq(index).html(input);
                        input.on('keyup', (e) => {
                            const x = $(e.currentTarget);
                            if (column.search() !== x.val()) {
                                column.search(x.val()).draw();
                            }
                        });
                    }
                }
                index++;
            });
        },
        fnDrawCallback: () => {
            $tableSupplies.fadeIn("slow");
        }
    });
});
