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
        const erros = response.responseJSON.error;

        let errorMessage = "<ul>";
        $.each(erros, function(field, errors) {
            $.each(errors, function(index, error) {
                errorMessage += "<li>" + error + "</li>";
            });
        });
        errorMessage += "</ul>"

        bootbox.alert({
            title: "Não foi possível registrar novo fornecedor!",
            message: errorMessage,
            className: 'bootbox-custom-warning',
            callback: function() {
                const $modalSupplierRegister = $("#modal-supplier-register").first();
                const $firstInputSupplier = $modalSupplierRegister.find('.form-control:input').first();
                setTimeout(() => {
                    $firstInputSupplier.trigger("focus");
                    $("body").addClass("modal-open");
                }, 100)
            }
        });
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
