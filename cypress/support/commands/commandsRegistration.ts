// ***********************************************
// This example commands.js shows you how to
// create various custom commands and overwrite
// existing commands.
//
// For more comprehensive examples of custom
// commands please read more here:
// https://on.cypress.io/custom-commands
// ***********************************************
//
//
// -- This is a parent command --
// Cypress.Commands.add('login', (email, password) => { ... })
//
//
// -- This is a child command --
// Cypress.Commands.add('drag', { prevSubject: 'element'}, (subject, options) => { ... })
//
//
// -- This is a dual command --
// Cypress.Commands.add('dismiss', { prevSubject: 'optional'}, (subject, options) => { ... })
//
//
// -- This will overwrite an existing command --
// Cypress.Commands.overwrite('visit', (originalFn, url, options) => { ... })
/// <reference types="Cypress" />
/// <reference path="../cypress.d.ts" />



import { dataParameters } from '../../DataParameters/dataParameters'
import { elements as el } from '../../elements'
import {
    ColumnSearchParameter,
    SearchColumnElement,
    SearchParameterElement,
    ShowRecordsQuantity,
    ShowRecordsQuantityElement,
    SortByColumnElement,
    TableColumnsMyRequests,
    TableTypesElements
} from '../../import'


const {
    logout,
    optionsMenu,
    menuReduced,
    breadcumbHome,
    breadcumbUser,
    showQuantityRecords,
    SearchRegisteredUser,
    nextPage,
    pagePrevious,
} = el.Shared

const {
    titleLogin,
    email,
    password,
    access,
    messageContainer,
} = el.Login

const {

} = el.CustomCommands

const {
    userProfile,
    homeMenu,
    logoGecom,
    homeScreen,
} = el.Start

const {
    registrationMenu,
    registrationMenuReduced,
    registrationUserSubMenu,
    createNewUser,
    username,
    birthdateUser,
    cpfCnpjUser,
    phoneUser,
    emailUser,
    userPassword,
    confirmUserPassword,
    sectorUser,
    optionUserSector,
    optionSelectUserSector,
    optionSelectedSectorUser,
    userApprover,
    optionUserApprover,
    limitUserApproval,
    centerPermittedCostUser,
    selectAllAllowedCostCenterUser,
    clearCenterPermittedCostUser,
    saveUserRegistration,
    cancelUserRegistration,
    registrationSupplierSubMenu,
    messageRequirementName,
    messageRequirementCpfCnpj,
    messageRequiredTelephone,
} = el.Register

const {
    requestMenu,
    newRequestSubMenu,
    myRequestSubMenu,
    requestGeneralSubMenu,
} = el.Request

const {
    supplyMenu,
    dashboardSubMenu,
    productSubMenu,
    serviceSubMenu,
    contractSubMenu,
} = el.Supply


Cypress.Commands.add('minimumNumberCharacters', function (element: string, value: string, minimumQuantity: number, elementError: string) {
    cy.get(element)
        .clear()
        .type(value)
        .then(() => {
            const $elementError = Cypress.$(elementError)
            if (value.length < minimumQuantity && !$elementError.is(':visible')) {
                return cy.wrap({ error: "Erro! Valor informado é menor que o obrigatório, porém aviso não é apresentado ao usuário." });
            }

            if (value.length > minimumQuantity && $elementError.is(':visible')) {
                return cy.wrap({ error: "Erro! Valor informado está correto, porém é apresentado mensagem de erro." });
            }
            return cy.wrap({ success: "Sucesso!" });
        });
});

Cypress.Commands.add('maximumNumberCharacters', function (element: string, value: string, maximumQuantity: number, elementError: string) {
    cy.get(element)
        .clear()
        .type(value)
        .then(() => {
            const $elementError = Cypress.$(elementError)
            if (value.length > maximumQuantity && !$elementError.is(':visible')) {
                return cy.wrap({ error: "Erro! Valor informado é maior que o obrigatório, porém aviso não é apresentado ao usuário." });
            }

            if (value.length < maximumQuantity && $elementError.is(':visible')) {
                return cy.wrap({ error: "Erro! Valor informado está correto, porém é apresentado mensagem de erro." });
            }
            return cy.wrap({ success: "Sucesso!" });
        });
});

Cypress.Commands.add('validateCpfCnpj', (
    element: string, value: string,
    elementError: string,
    errorMessage: string = 'Este campo é obrigatório.',) => {
    // Remove caracteres não numéricos
    const formattedText = value.replace(/[^\d]/g, '');

    cy.get(element)
        .clear()
        .type(formattedText)
        .then(() => {

            const $elementError = Cypress.$(elementError)
            if (formattedText.length < 11 && !$elementError.is(':visible') && $elementError.text() === errorMessage) {
                return cy.wrap({ error: `${formattedText} é um CPF incompleto. Porém não é apresentado mensagem ao usuário.` });
            }

            // Verifica se o CNPJ possui 14 dígitos
            if (formattedText.length > 11 && formattedText.length < 14 && !$elementError.is(':visible')) {
                return cy.wrap({ error: `${formattedText} é um CNPJ incompleto. Porém não é apresentado mensagem ao usuário.` });
            }

            // Verifica se todos os dígitos são iguais, o que tornaria o CNPJ inválido
            if (/^(\d)\1+$/.test(formattedText) && !$elementError.is(':visible')) {
                return cy.wrap({ error: `${formattedText} são números iguais. Porém não é apresentado mensagem ao usuário.` });
            }

            return cy.wrap({ success: `${formattedText} é um CPF/CNPJ Ok.` });
        })

});

Cypress.Commands.add('getColumnVisibility', (element: TableTypesElements) => {
    cy.wait(1000);
    cy.get(element, { timeout: 4000 })
        .as('btn')
        .click({ timeout: 2000, force: true });
    for (const [key, isVisible] of Object.entries(dataParameters.showHideColumns.showHideColumnsUserRegistration)) {
        const elementSelector = Number(key);
        const $columnGrid = Cypress.$(`table th:contains("${elementSelector}")`);
        if (!isVisible) {
            cy.get(`button[data-cv-idx="${elementSelector}"]`, { timeout: 4000 })
                .click();
            cy.wait(1000);
            cy.get(`table th:contains("${elementSelector}")`, { timeout: 4000 })
                .should('not.exist');
            if ($columnGrid.is(':visible')) {
                throw new Error("A coluna foi ocultada ou exibida na tela, no entanto, não houve nenhuma alteração ou ocorreu o oposto na tela.");
            }
        }
    }
    return cy.wrap({ success: `Coluna(s) foi mostrada/ocultada na grid com sucesso.` });
})




Cypress.Commands.add('getDataOnGrid', (searchParameterElement?, searchParameterValue?, showRecordsQuantityElement?, showRecordsQuantityValue?, sortByColumnElement?, sortByColumnValue?, searchColumnElement?, searchColumnValue?) => {
    function searchByParameter(element: SearchParameterElement, value: string | number) {
        cy.getElementAndType({ [element]: value.toString() });
    }
    function showRecordsQuantityByParameter(elementSelector: ShowRecordsQuantityElement, quantity: ShowRecordsQuantity) {
        const dropdownValueMap = {
            [ShowRecordsQuantity.ten]: '10',
            [ShowRecordsQuantity.twentyFive]: '25',
            [ShowRecordsQuantity.fifty]: '50',
            [ShowRecordsQuantity.oneHundred]: '100',
        };
        const dropdownValue = dropdownValueMap[quantity];
        cy.get(elementSelector)
            .select(dropdownValue);
    }//quando o valor apresentado for diferente do valor selecionado
    function sortByColumn(element: SortByColumnElement, columnVisibility: Record<TableColumnsMyRequests, boolean>) {
        for (const [key, isOrderedBy] of Object.entries(columnVisibility)) {
            if (isOrderedBy) {
                const columnSelector = Number(key);
                if (!isNaN(columnSelector)) {
                    const columnElements = cy.get(`${element} > th:nth-child(${columnSelector})`);
                    columnElements.eq(1).click({ force: true });
                }
            }
        }
    }
    function searchColumnsByParameter(element: SearchColumnElement, searchInformation: ColumnSearchParameter) {
        for (const [key, [isSearched, value]] of Object.entries(searchInformation)) {
            if (isSearched) {
                const elementSelector = Number(key);
                cy.get(`${element} th:nth-child(${elementSelector})`)
                    .each(($input, index) => {
                        if ($input.find('.search-button').length > 0) {
                            cy.get(`${element} th:nth-child(${elementSelector})`)
                                .eq(index)
                                .find('.search-button')
                                .then(($btn) => {
                                    if ($btn.length > 1) {
                                        $btn.each((el) => {
                                            const $el = cy.wrap(el);
                                            $el.type(value, { force: true })
                                                .invoke('val') // Use invoke('val') instead of accessing val property
                                                .then((val) => {
                                                    if (val === '') {
                                                        throw new Error('Após inserir os dados, o campo fica vazio.');
                                                    }
                                                });
                                        });
                                    } else {
                                        cy.wrap($btn)
                                            .type(value, { force: true })
                                            .then(() => {
                                                if ($btn.val() === '') {
                                                    throw new Error('Após inserir os dados, o campo fica vazio.');
                                                }
                                            });
                                    }
                                });
                        }
                    });
            }
        }
    }

    showRecordsQuantityByParameter(ShowRecordsQuantityElement.requestsTable, dataParameters.getDataOnGrid.showRecordsQuantity)
    sortByColumn(sortByColumnElement, sortByColumnValue);
    searchColumnsByParameter(SearchColumnElement.requestsTable, dataParameters.getDataOnGrid.searchColumnMyRequests,)
    searchByParameter(SearchParameterElement.requestsTable, dataParameters.getDataOnGrid.searchParameter);
    return cy.wrap({ success: `Coluna(s) foi mostrada/ocultada na grid com sucesso.` });
})

