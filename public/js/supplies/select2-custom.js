$(() => {
    const $buttonAddSupplier = $(`
        <button
            rel="tooltip"
            title="Registrar novo fornecedor"
            class="btn btn-secondary btn-small add-btn-supplier"
            data-bs-toggle="modal" data-bs-target="#modal-supplier-register"
        >
            <i class="fa fa-plus"></i> Registar novo fornecedor
        </button>
    `);

    window.addBtnSupplierSelect = (element) => $(element).select2( { language: { noResults: () => $buttonAddSupplier[0] } } );

    const elementsWithSupplierID = $('select[name*="supplier_id"]');
    addBtnSupplierSelect(elementsWithSupplierID);
});

