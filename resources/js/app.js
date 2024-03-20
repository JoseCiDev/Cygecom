import jQuery from 'jquery'; // v3.7.1
window.$ = jQuery;
window.jQuery = window.$

import 'jquery-validation'; //  v1.20.0
import 'jquery-validation/dist/localization/messages_pt_BR';

import "@fortawesome/fontawesome-free/js/all"; // v6.4.2

import * as bootstrap from "bootstrap"; // v5.3.2
window.bootstrap = bootstrap;

import select2 from 'select2';
select2();

import "datatables.net";
import 'datatables.net-buttons-dt';
import 'datatables.net-buttons/js/buttons.colVis.mjs';

import IMask from "imask";

import moment from 'moment';
window.moment = moment;

import Chart from 'chart.js/auto';
window.Chart = Chart;
Chart.defaults.color = '#141414';

import { checkAbilityRelations } from './abilities-relations.js';
$.fn.checkAbilityRelations = checkAbilityRelations;

import setColvisConfig from '../../public/js/utils/colvis-custom-user-preference.js';

import {setSearchBarOnDt} from './dataTables-column-search.js';
$.fn.setSearchBarOnDt = setSearchBarOnDt;

import {createChartDoughnut, createChartBar} from './create-chart-functions.js'
window.createChartDoughnut = createChartDoughnut
window.createChartBar = createChartBar

import Enum from './enums/enum.js';
window.Enum = Enum;

$.fn.getUserIdLogged = () => $('meta[name="user-id"]').first().attr('content');
$.fn.getStorageItem = (itemName) => JSON.parse(localStorage.getItem(itemName));
$.fn.saveOnStorage = (itemName, object) => localStorage.setItem(itemName, JSON.stringify(object));

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

$.fn.showModalAlert = (title = '', message, callback = null, modalDialogClass = false) => {
    const modalAlert = new bootstrap.Modal('#modal-alert', { keyboard: false});
    $("#modal-alert-label").html(title);
    $("#modal-alert-message").html(message);

    if(modalDialogClass) {
        $('#modal-alert .modal-dialog').addClass(modalDialogClass);
    }

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

$.fn.createToast = (message, title = 'Sucesso!', className = null) => {
    const $toastContainer = $('.toast-container');
    const $toast = $('.toast');

    const $toastClone = $toast.first().clone();
    $toastContainer.append($toastClone);

    $toastClone.find('.toast-header').addClass(className);
    $toastClone.find('.toast-header-title').text(title);
    $toastClone.find('.toast-body').text(message);

    if(className === 'bg-success' || className === 'bg-danger') {
        $toastClone.find('.toast-header-title').css('color', '#fff')
    }

    bootstrap.Toast.getOrCreateInstance($toastClone).show();
}

// Renderiza menu -> Aciona botões -> Fecha menu
$.fn.setStorageDtColumnConfig = () =>{
    $('button.dt-button.buttons-collection.buttons-colvis').trigger('click').trigger('click')
};

$.fn.downloadCsv = (csv, name) => {
    const now = moment(new Date()).format('YYYY-MM-DD-HH-mm-ss-SSS');
    const fileName = `relatorio-gecom-${now}-${name}.csv`;
    const blob = new Blob([csv], { type: "text/csv" });
    const link = document.createElement("a");
    link.href = window.URL.createObjectURL(blob);
    link.download = fileName;
    link.click();

    window.URL.revokeObjectURL(link.href);
}

$.fn.setBootstrapTooltip = () => {
    $('[data-bs-toggle="tooltip"]').each((_, tooltipTriggerEl) => {
        const tooltip = bootstrap.Tooltip.getInstance(tooltipTriggerEl);

        if (tooltip) {
            tooltip.dispose();
        }

        new bootstrap.Tooltip(tooltipTriggerEl, {html: true})
    });
}

$.fn.setBootstrapToast = () => {
    $('.toast').each((_, toastTriggerEl) =>{
        const toast = bootstrap.Toast.getInstance(toastTriggerEl);

        if (toast) {
            toast.dispose();
        }

        new bootstrap.Toast(toastTriggerEl)
    });
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

    const $badgeColumnsQtd = $(`<span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-dark"></span>`);
    setColvisConfig();
    $('.dataTable').each((_, table) => $(table).dataTable({
        dom: 'Blfrtip',
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
        buttons: [
            {
                extend: 'colvis',
                columns: ':not(.noColvis)',
                text: `Mostrar / Ocultar colunas ${$badgeColumnsQtd[0].outerHTML}`,
            }
        ],
        drawCallback: (settings) => {
            $.fn.setBootstrapTooltip();
        },
        initComplete: (settings) => {
            $.fn.setStorageDtColumnConfig();
            $.fn.setSearchBarOnDt(settings.oInstance);

            $('.search-button').each((_, element) => {
                const $currentInput = $(element);
                if($currentInput.val()) {
                    $currentInput.trigger('keyup');
                }
            });
        },
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

    $.fn.setBootstrapTooltip();
    $.fn.setBootstrapToast();
});