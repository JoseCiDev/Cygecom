import jQuery from 'jquery'; // v3.7.1
window.$ = jQuery;
window.jQuery = window.$

import "@fortawesome/fontawesome-free/js/all"; // v6.4.2

import * as bootstrap from "bootstrap"; // v5.3.2
window.bootstrap = bootstrap;

import select2 from 'select2';
select2();

import "datatables.net";

import IMask from "imask";

import moment from 'moment';
window.moment = moment;

$.fn.imask = function(options) {
    const maskedElements = this.map((_, input) => new IMask(input, options)).toArray();

    if (maskedElements.length === 1) {
        return maskedElements[0];
    }

    return maskedElements;
}

// adiciona required style em elemento jquery e torna required pra validacao
$.fn.makeRequired = function() {
    this.filter(function() {
        return $(this).closest('.form-group').find('label').first().find('sup').length === 0;
    }).each(function() {
        const $label = $(this).closest('.form-group').find('label').first();
        $label.append('<sup style="color:red">*</sup>');
        $(this).data('rule-required', true);
    });

    return $(this);
}

$.fn.removeRequired = function() {
    this.each(function() {
        const $sup = $(this).closest('.form-group').find('label').first().find('sup');
        $sup.remove();
        $(this).data('rule-required', false);
    });

    return $(this);
}

$.fn.showModalAlert = (title = '', message, callback = null) => {
    const modalAlert = new bootstrap.Modal('#modal-alert', { keyboard: false});
    $("#modal-alert-label").html(title);
    $("#modal-alert-message").html(message);
    $("#modal-alert-submit").on('click', () => {
        if(callback) {
            callback();
        }
        modalAlert.hide();
    })

    if(!callback) {
        $("#modal-alert-btn-secondary").hide();
    }

    modalAlert.show();
}

$(() => {
    // required style
    $('[data-rule-required]').each(function() {
        const $label = $(this).closest('.form-group').find('label').first();
        $label.append('<sup style="color:red">*</sup>');
    });

    $(".select2-me").each((_, element) => {
        const dropdownParent = $(element).data('dropdown-parent');
        const $parentElement = $(dropdownParent);

        const config = {
            width: "100%",
            placeholder: "Selecione uma ou mais opções",
            dropdownParent: $parentElement.length ? $parentElement : null
        }

        $(element).select2(config);

    });

    // autocomplete off
    $("form").attr('autocomplete', 'off');

    $('.dataTable').each((_, table) => $(table).DataTable({
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
        destroy: true
    }));

    $('.form-validate').each(function () {
        const id = $(this).attr('id');
        $("#" + id).validate({
            ignore: ".no-validation",
            errorElement: 'span',
            errorClass: 'help-block has-error',
            errorPlacement: (error, element) => {
                const $elementParent = element.parent();

                if (element.siblings('.input-group-text').length > 0) {
                    $elementParent.after(error);
                    return;
                }

                const elementType = element.attr('type');
                const radioCheckbox = ['radio', 'checkbox'];
                const elementTypeIsRadioOrCheckbox = radioCheckbox.includes(elementType);

                if (elementTypeIsRadioOrCheckbox) {
                    element.closest('.form-group').find('fieldset').first().after(error);
                    return;
                }

                if (element.prop('tagName').toLowerCase() === 'select') {
                    element.before(error);
                    return;
                }

                if (element.prop('type') === 'hidden' && error.text().length) {
                    element[0].parentElement.scrollIntoView({block: 'center'});
                    return;
                }

                element.after(error);
            },
            highlight: (label) => $(label).closest('.form-group').removeClass('has-error has-success').addClass('has-error'),
            success: (label) => label.addClass('valid').closest('.form-group').removeClass('has-error has-success'),
            onkeyup: (element) => $(element).valid(),
            onfocusout: (element) => $(element).valid(),
            rules: {
                password: {
                    minlength: 8
                },
                password_confirmation: {
                    minlength: 8,
                    equalTo: '#password'
                }
            },
        });
    });
});
