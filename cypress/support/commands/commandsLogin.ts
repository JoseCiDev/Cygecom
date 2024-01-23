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
    messageContainerIncorrectData,
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
    cy.visit(dataParameters.env.BASE_URL + '/login');

    cy.get(titleLogin);

    cy.wrap(null).then(() => {
        cy.get(email, { timeout: 20000 })
            .as('elementloginAlias')
            .each(($input) => {
                cy.wrap($input)
                    .type(emailAccess.toString(), { log: false })
                    .should('have.value', email)
                    .then(() => {
                        const $emailValue = String($input.val());
                        const $elementError = Cypress.$(elementError);

                        if ($emailValue.length < 1 && !$elementError.is(':visible')) {
                            throw new Error('Usuário não foi inserido, porém não é apresentado mensagem ao usuário.');
                        };

                        if (!$emailValue || $emailValue.length === 0 && !$elementError.is(':visible')) {
                            throw new Error('Há digitos que não foram preenchidos, porém não é apresentado mensagem ao usuário.');
                        };

                    })
            })
    });

    cy.wrap(null).then(() => {
        cy.get(password, { timeout: 20000 })
            .as('elementPasswordAlias')
            .each(($input) => {
                cy.wrap($input)
                    .type(password.toString(), { log: false })
                    .should('have.value', passwordAccess)
                    .then(() => {
                        const passwordValue = String($input.val());
                        const $elementError = Cypress.$(elementError);

                        if (password.length < 1 && !$elementError.is(':visible')) {
                            throw new Error('Senha não foi inserida, porém não é apresentado mensagem ao usuário.');
                        };

                        if (!passwordValue || passwordValue.length === 0 && !$elementError.is(':visible')) {
                            throw new Error('Alguns dígitos não foram preenchidos, porém não é apresentada mensagem de erro ao usuário.');
                        };

                    })
            })
    });



    // const $elementErrorEmailPreechido = Cypress.$(el.Login.email)
    //     .prop('prop', 'validationMessage')
    //     .prop((text) => {
    //         expect(text).to.contain('Preencha este campo.');
    //     });
    const $elementErrorEmailPreechido = Cypress.$(el.Login.email);
    const valorCampoelementErrorEmailPreechido = String($elementErrorEmailPreechido.val()).trim();
    const mensagemValidacaoelementErrorEmailPreechido = $elementErrorEmailPreechido.prop('validationMessage');
    const isValidationEmailFilledelementErrorEmailPreechido =
        valorCampoelementErrorEmailPreechido === '' || mensagemValidacaoelementErrorEmailPreechido.includes('Preencha este campo');

    // const $elementErrorEmailFormatoAt = Cypress.$(el.Login.email)
    //     .prop('prop', 'validationMessage')
    //     .prop((text) => {
    //         expect(text).to.contain('Inclua um "@" no endereço de e-mail. "a" está com um "@" faltando.');
    //     });
    const $elementErrorEmailFormatoAt = Cypress.$(el.Login.email);
    const valorCampoErrorEmailFormatoAt = String($elementErrorEmailFormatoAt.val()).trim();
    const mensagemValidacaoErrorEmailFormatoAt = $elementErrorEmailFormatoAt.prop('validationMessage');
    const isValidationEmailFilledErrorEmailFormatoAt =
        valorCampoErrorEmailFormatoAt === '' || mensagemValidacaoErrorEmailFormatoAt.includes('Preencha este campo');

    // const $elementErrorEmailArroba = Cypress.$(el.Login.email)
    //     .prop('prop', 'validationMessage')
    //     .prop((text) => {
    //         expect(text).to.contain(`insira uma parte depois de "@". "${text}@" está incompleto.`);
    //     });
    const $elementErrorEmailArroba = Cypress.$(el.Login.email);
    const valorCampoErrorEmailArroba = String($elementErrorEmailArroba.val()).trim();
    const mensagemValidacaoErrorEmailArroba = $elementErrorEmailArroba.prop('validationMessage');
    const isValidationEmailFilledErrorEmailArroba =
        valorCampoErrorEmailArroba === '' || mensagemValidacaoErrorEmailArroba.includes('Preencha este campo');

    // const $elementErrorEmailFormatServer = Cypress.$(el.Login.email)
    //     .prop('prop', 'validationMessage')
    //     .prop((text) => {
    //         expect(text).to.contain(`"." está sendo usado em uma posição incorreta em "${text}com`);
    //     });
    const $elementErrorEmailFormatServer = Cypress.$(el.Login.email);
    const valorCampoErrorEmailFormatServer = String($elementErrorEmailFormatServer.val()).trim();
    const mensagemValidacaoErrorEmailFormatServer = $elementErrorEmailFormatServer.prop('validationMessage');
    const isValidationEmailFilledErrorEmailFormatServer =
        valorCampoErrorEmailFormatServer === '' || mensagemValidacaoErrorEmailFormatServer.includes('Preencha este campo');

    // const $elementErrorPassword = Cypress.$(el.Login.email)
    //     .prop('prop', 'validationMessage')
    //     .prop((text) => {
    //         expect(text).to.contain('Preencha este campo.');
    //     });
    const $elementErrorPassword = Cypress.$(el.Login.email);
    const valorCampoErrorPassword = String($elementErrorPassword.val()).trim();
    const mensagemValidacaoErrorPassword = $elementErrorPassword.prop('validationMessage');
    const isValidationEmailFilledErrorPassword =
        valorCampoErrorPassword === '' || mensagemValidacaoErrorPassword.includes('Preencha este campo');


    // if ($elementErrorEmailPreechido) {
    //     return cy.wrap({ error: `Campo e-mail não foi preenchido.` });
    // };
    // if ($elementErrorEmailFormatoAt) {
    //     return cy.wrap({ error: `Inclua um "@" no endereço de e-mail. ${emailAccess} está com um "@" faltando.` });
    // };
    // if ($elementErrorEmailFormatServer) {
    //     return cy.wrap({ error: `Insira uma parte depois de "@". ${emailAccess} está incompleto.` });
    // };
    // if ($elementErrorPassword) {
    //     return cy.wrap({ error: `Preencha este campo.` });
    // };
    // if ($elementErrorEmailArroba) {
    //     return cy.wrap({ error: `Preencha este campo.` });
    // };


    const message: CheckAndThrowError[] = [
        {
            condition: isValidationEmailFilledelementErrorEmailPreechido.to.be.true,
            errorMessage: `Campo e-mail não foi preenchido.`,
        },
        {
            condition: isValidationEmailFilledErrorEmailFormatoAt.to.be.true,
            errorMessage: `Inclua um "@" no endereço de e-mail. ${emailAccess} está com um "@" faltando.`,
        },
        {
            condition: isValidationEmailFilledErrorEmailArroba.to.be.true,
            errorMessage: `Insira uma parte depois de "@". ${emailAccess} está incompleto.`,
        },
        {
            condition: isValidationEmailFilledErrorEmailFormatServer.to.be.true,
            errorMessage: `Preencha este campo.`,
        },
        {
            condition: isValidationEmailFilledErrorPassword.to.be.true,
            errorMessage: `Preencha este campo.`,
        },
    ]
    const checkAndThrowError = (params: CheckAndThrowError[], defaultMessage: string) => {
        const successMessage = ''
        for (const { condition, errorMessage } of params) {
            if (condition && errorMessage === defaultMessage || !condition && successMessage === defaultMessage) {
                throw new Error(`${errorMessage}`);
            } else {
                return cy.wrap({ success: 'Não foi identificado nenhum erro de condição ou requisito.' })
            }
        }
    }

    cy.get(access).as('access')
        .click();
    cy.wrap(null).then(() => {
        cy.get(messageContainerIncorrectData, { timeout: 20000 })
            .should('be.visible')
            .as('messageModalAlias')
            .then(($modal) => {
                const messageModal = $modal.text();
                cy.get('@access')
                    .click();
                checkAndThrowError(message, messageModal);
            })
    });

    cy.url()
        .should('contain', `${dataParameters.env.BASE_URL}`);
});


Cypress.Commands.add('loginLogoutWithViewport', (size: Cypress.ViewportPreset | [number, number]) => {
    if (_.isArray(size) && typeof size[0] === 'number' && typeof size[1] === 'number') {
        cy.viewport(size[0], size[1]);
        cy.log(`-Screen size: ${size[0]} x ${size[1]}-`);
    } else if (typeof size === 'string') {
        cy.viewport(size as Cypress.ViewportPreset);
        cy.log(`-Screen size: ${size}-`);
    }
});
