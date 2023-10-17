$(() => {
    const $buttonAddSupplier = $(`
        <button
            rel="tooltip"
            title="Registrar novo fornecedor"
            class="btn btn-secondary btn-small add-btn-supplier"
            onclick="openSupplierModalAndFocusInput(event)"
        >
            <i class="fa fa-plus"></i> Registar novo fornecedor
        </button>
    `);

    window.openSupplierModalAndFocusInput = function() {
        $("#modal-supplier-register").modal("show");
        $("#select2-drop").hide();
    }

    window.addBtnSupplierSelect = (element) => $(element).select2({ formatNoMatches: () => $buttonAddSupplier[0].outerHTML });

    const elementsWithSupplierID = $('select[name*="supplier_id"]');
    elementsWithSupplierID.select2( { formatNoMatches: () => $buttonAddSupplier[0].outerHTML } );
});

