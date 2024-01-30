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



import { elements as el } from '../../elements'
import { ValidationResult, dataParameters, TableTypesElements } from '../../DataParameters'

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


Cypress.Commands.add('getColumnVisibilityCommand', (table: TableTypesElements) => {
    cy.wait(1000);
    cy.get(table, { timeout: 2000 })
        .as('btn')
        .click({ timeout: 2000, force: true })

    // Para cada coluna em columnVisibility, se o valor for true, clique para ocultar a coluna
    for (const [key, isVisible] of Object.entries(dataParameters.Register.searchParameter.showHideColumnsUserRegistration)) {
        // nesse caso, idx é o seletor da coluna
        if (!isVisible) {
            const idx = Number(key);
            cy.get(`button[data-cv-idx="${idx}"]`).click();
        }
    }

})