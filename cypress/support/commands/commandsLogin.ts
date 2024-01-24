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
import { validateEmail, validatePassword, checkInput } from '../../utils';
import { CheckAndThrowError, ValidationResult, dataParameters } from '../../DataParameters';
import { data } from 'cypress/types/jquery';
import _ from 'lodash';


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




Cypress.Commands.add('login', (emailAccess: string, passwordAccess: string, elementError: string) => {

    cy.visit(dataParameters.url.login);

    cy.get(email, { timeout: 20000 })
        .each(($input) => {
            cy.wrap($input)
                .type(emailAccess.toString(), { log: false })
                .should('have.value', emailAccess)
                .then(() => {
                    checkInput($input, elementError, 'Usuário não foi inserido, porém não é apresentado mensagem ao usuário.');
                    if (!validateEmail(emailAccess)) {
                        throw new Error('Email com formato inválido');
                    }
                });
        })

    cy.get(password, { timeout: 20000 })
        .each(($input) => {
            cy.wrap($input)
                .type(passwordAccess.toString(), { log: false })
                .should('have.value', passwordAccess)
                .then(() => {
                    checkInput($input, elementError, 'Senha não foi inserida, porém não é apresentado mensagem ao usuário.');
                });
        })

    cy.get(access)
        .click()
        .then(() => {
            cy.checkValidation(emailAccess);

            if (!validatePassword(passwordAccess)) {
                cy.get('body').then(($body) => {
                    if ($body.find(messageContainer).length > 0) {
                        cy.get(messageContainer).then(($modal) => {
                            const messageModal = $modal.text().trim();
                            if (messageModal.includes('As credenciais fornecidas não coincidem com nossos registros.')) {
                                throw new Error('Foi informado usuário ou senha incorretos na aplicação');
                            }
                        });
                    } else {
                        console.log('Element not found');
                    }
                });
            }
            cy.url()
                .should('contain', `${dataParameters.env.BASE_URL}`);
        });
    return cy.wrap({ success: 'Login realizado com sucesso.' });
})


















Cypress.Commands.add('loginLogoutWithViewport', (size: Cypress.ViewportPreset | [number, number]) => {
    if (_.isArray(size) && typeof size[0] === 'number' && typeof size[1] === 'number') {
        cy.viewport(size[0], size[1]);
        cy.log(`-Screen size: ${size[0]} x ${size[1]}-`);
    } else if (typeof size === 'string') {
        cy.viewport(size as Cypress.ViewportPreset);
        cy.log(`-Screen size: ${size}-`);
    }
});



Cypress.Commands.add('checkValidation', (text: string) => {
    cy.window().then((win) => {
        function checkValidation(selector: string, errorMessage: string) {
            const $element = win.document.querySelector(selector) as HTMLInputElement;
            const $elementError = win.document.querySelector(messageContainer) as HTMLElement;
            if ($element && $elementError) {
                const validationMessage = $element.validationMessage;
                const isElementEmpty = $element.value === '';
                const isErrorMessageVisible = $elementError.style.display !== 'none';

                if ((isElementEmpty && !isErrorMessageVisible)) {
                    throw new Error(`Validation error for ${selector}`);
                } else {
                    console.log(`No validation errors found for ${selector}`);
                }
            }
        }

        checkValidation(email, 'Preencha este campo.');
        checkValidation(email, `Inclua um "@" no endereço de e-mail. "${text}" não contém um "@".`);
        checkValidation(email, `Insira uma parte após "@". O "${text}@" está incompleto.`);
        checkValidation(email, `Uma parte após '@' não deve conter o simbolo '${text}'`);
        checkValidation(email, `'.' foi usado em uma posição incorreta em '${text}'`);
        checkValidation(password, 'Preencha este campo.');
    });
})