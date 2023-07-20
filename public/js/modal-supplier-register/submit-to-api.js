function showSuccessAlertAndCloseModal(response) {
    alert(response.message + " / CNPJ " + response.cpf_cnpj);

    $("#modal-supplier-register").modal("hide");
    $("#select-element").focus();
}

function submitFormToAPI() {
    const form = $("#supplier-form");
    const formData = form.serialize();

    $.ajax({
        url: "/api/suppliers/register",
        method: "POST",
        data: formData,
        success: function (response) {
            showSuccessAlertAndCloseModal(response);
        },
        error: function (error) {
            console.error(error);
        },
    });
}

$("#supplier-form").submit(function (event) {
    event.preventDefault();
    submitFormToAPI();
});
