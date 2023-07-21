function openSupplierModalAndFocusInput() {
    $("#modal-supplier-register").modal("show");
    $("#select2-drop").hide();
}

$(() => {
    const elementsWithSupplierID = document.querySelectorAll(
        'select[name*="supplier_id"]'
    );

    elementsWithSupplierID.forEach(function (element) {
        $(element).select2({
            formatNoMatches: function (term) {
                return `
                    <button
                        type="button"
                        rel="tooltip"
                        title="Registrar novo fornecedor"
                        class="btn btn-primary"
                        onclick="openSupplierModalAndFocusInput();"
                    >
                        <i class="fa fa-plus"></i> Registar novo fornecedor
                    </button>
                `;
            },
        });
    });
});
