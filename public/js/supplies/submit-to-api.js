$(() => {
    const showSuccessAlertAndCloseModal = (response) => {
        bootbox.alert({
                title: "<i class='fa fa-check'></i> Registro feito com sucesso!",
                message: `<strong>CNPJ:</strong> ${response.cpf_cnpj} <br> ${response.message}`,
                className: 'bootbox-custom-success'
            });
        
        $("#modal-supplier-register").modal("hide");
        $("#cpf_cnpj").trigger("focus");

        const selectElement = $('select[name="service[supplier_id]"]');
       const newOption = new Option(`${response.cpf_cnpj} - ${response.corporate_name}`, response.id, true, true);
        selectElement.append(newOption).trigger('change');

    };

    const showFailAlert = (response) => {
        alert('Não foi possível registrar novo fornecedor. Por favor, verifique novamente os campos do formulário.');
    };

    const submitFormToAPI = (event) => {
        event.preventDefault();
        const form = $("#supplier-form");
        const formData = form.serialize();

        $.post("/api/suppliers/register", formData, showSuccessAlertAndCloseModal).fail(showFailAlert)
    };

    $("#supplier-form").on("submit", submitFormToAPI);
});
