$(() => {
    const showSuccessAlertAndCloseModal = (response) => {
        bootbox.alert({
                title: "<i class='fa fa-check'></i> Registro feito com sucesso!",
                message: `<strong>CNPJ:</strong> ${response.cpf_cnpj} <br> ${response.message}`,
                className: 'bootbox-custom-success'
            });

        $("#modal-supplier-register").modal("hide");

        const $selectElement = $("select.select-supplier");
        $selectElement.trigger("focus");

        const newOption = new Option(`${response.cpf_cnpj} - ${response.corporate_name}`, response.id, true, true);
        $selectElement.append(newOption).trigger('change');

        const representative = response.representative ?? '';
        const phone_number = response.phone_number ?? '';
        const email = response.email ?? '';

        $('#attendant').val(`${representative}`);
        $('#phone-number').val(`${phone_number}`);
        $('#email').val(`${email}`);

        const form = $("#supplier-form");
        form[0].reset();
    };

    const showFailAlert = (response) => {
        alert('Não foi possível registrar novo fornecedor. Por favor, verifique novamente os campos do formulário.');
    };

    const submitFormToAPI = (event) => {
        event.preventDefault();
        const form = $("#supplier-form");
        const formData = form.serialize();

        $.ajax({
            url: '/api/suppliers/register',
            method: 'POST',
            data: formData,
            success: showSuccessAlertAndCloseModal,
            error: showFailAlert
        });
    };

    $("#supplier-form").on("submit", submitFormToAPI);
});
