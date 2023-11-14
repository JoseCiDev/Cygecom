$(() => {
    const $tableSupplies = $('table#table-supplies-list');
    const $tableSearchBarRow = $tableSupplies.find("tr.search-bar");

    const tableSupplies = $tableSupplies.DataTable({
        initComplete: function () {
            let index = 0;
            this.api().columns().every(function (e) {
                const column = this;
                const input = $('<input>', {
                    width: '110px',
                    placeholder: 'Buscar',
                });
                input.addClass('search-button');

                if (!column.header().classList.contains('ignore-search')) {
                    $tableSearchBarRow.children().eq(index).html(input);
                    input.on('keyup', (e) => {
                        const x = $(e.currentTarget);
                        if (column.search() !== x.val()) {
                            column.search(x.val()).draw();
                        }
                    });
                }
                index++;
            });
        },
        fnDrawCallback: () => {
            $tableSupplies.fadeIn("slow");
        }
    });
});
