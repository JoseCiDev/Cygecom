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

    function validateEmail(email: string): boolean {
        const re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
        return re.test(String(email).toLowerCase());
    }
    cy.get(email, { timeout: 20000 })
        .each(($input) => {
            cy.wrap($input)
                .type(emailAccess.toString(), { log: false })
                .should('have.value', emailAccess)
                .then(() => {
                    const $emailValue = String($input.val());
                    const $elementError = Cypress.$(elementError);
                    if ($emailValue.length < 1 && !$elementError.is(':visible')) {
                        throw new Error('Usuário não foi inserido, porém não é apresentado mensagem ao usuário.');
                    };

                    if (!$emailValue || $emailValue.length === 0 && !$elementError.is(':visible')) {
                        throw new Error('Há digitos que não foram preenchidos, porém não é apresentado mensagem ao usuário.');
                    };

                    if (!validateEmail(emailAccess)) {
                        throw new Error('Email inválido');
                    }

                });

        })

    function validatePassword(password: string): boolean {
        const re = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[a-zA-Z\d@]{8,}$/;
        return re.test(password);
    }
    cy.get(password, { timeout: 20000 })
        .each(($input) => {
            cy.wrap($input)
                .type(passwordAccess.toString(), { log: false })
                .should('have.value', passwordAccess)
                .then(($input) => {
                    const $passwordValue = String($input.val());
                    const $elementError = Cypress.$(elementError);

                    if (passwordAccess.length < 1 && !$elementError.is(':visible')) {
                        throw new Error('Senha não foi inserida, porém não é apresentado mensagem ao usuário.');
                    };

                    if (!$passwordValue || $passwordValue.length === 0 && !$elementError.is(':visible')) {
                        throw new Error('Alguns dígitos não foram preenchidos, porém não é apresentada mensagem de erro ao usuário.');
                    };



                });
        })

    cy.get(access)
        .click()
        .then(() => {
            if (!validatePassword(passwordAccess)) {
                cy.get(messageContainer).then(($modal) => {
                    const messageModal = $modal.text().trim();
                    if (messageModal.includes('As credenciais fornecidas não coincidem com nossos registros.')) {
                        throw new Error('Foi informado usuário ou senha incorretos na aplicação');
                    }
                })
            }

            cy.window().then((win) => {
                const $elementError = win.document.querySelector(messageContainer) as HTMLElement;

                if ($elementError && $elementError.style.display !== 'none') {
                    throw new Error('Usuário ou senha estão inválidos.');
                };

                function checkValidation(selector: string, errorMessage: string) {
                    const $element = win.document.querySelector(selector) as HTMLInputElement;
                    if ($element) {
                        const validationMessage = $element.validationMessage;
                        expect(validationMessage).to.contain(errorMessage);
                    }
                }

                checkValidation(email, 'Preencha este campo.');
                checkValidation(email, `Inclua um "@" no endereço de e-mail. "${emailAccess}" não contém um "@".`);
                checkValidation(email, `Insira uma parte após "@". O "${emailAccess}@" está incompleto.`);
                checkValidation(email, `Uma parte após '@' não deve conter o simbolo '${emailAccess}'`);
                checkValidation(email, `'.' foi usado em uma posição incorreta em '${emailAccess}'`);
                checkValidation(password, 'Preencha este campo.');
            });

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
