function openSupplierModalAndFocusInput() {
    $("#modal-supplier-register").modal("show");
    $("#select2-drop").hide();
}

// adiciona botão de cadastro de fornecedor em selects dinamicos (chamar no evento)
function addBtnSupplierSelect(element) {
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
}

$(() => {
    const elementsWithSupplierID = document.querySelectorAll(
        'select[name*="supplier_id"]'
    );

    addBtnSupplierSelect(elementsWithSupplierID);
});
