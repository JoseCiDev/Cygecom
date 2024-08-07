
/// <reference path="../cypress.d.ts" />

import {
    elements as el,
    dataParameters,
    validateEmail,
    validatePassword,
    checkInput,
    loadash,
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
} = el.Register

const {
    requestMenu,
    newRequestSubMenu,
    myRequestSubMenu,
} = el.Request

const {
    supplyMenu,
    dashboardSubMenu,
    productSubMenu,
    serviceSubMenu,
    contractSubMenu,
} = el.Supply


Cypress.Commands.add('login', (baseUrl: string, emailAccess: string, passwordAccess: string, elementError?: string) => {
    cy.visit(baseUrl);

    cy.get(email, { timeout: 20000 })
        .each(($input) => {
            cy.wrap($input)
                .type(String(emailAccess), { log: false })
                .should('have.value', emailAccess, { log: false })
                .then(() => {
                    checkInput($input, elementError, 'Usuário não foi inserido, porém não é apresentado mensagem ao usuário.');
                    const emailError = validateEmail(emailAccess);
                    if (emailError) {
                        return cy.wrap({ error: emailError });
                    }
                });
        })

    cy.get(password, { timeout: 20000 })
        .each(($input) => {
            cy.wrap($input)
                .type(String(passwordAccess), { log: false })
                .should('have.value', passwordAccess, { log: false })
                .then(() => {
                    checkInput($input, elementError, 'Senha não foi inserida, porém não é apresentado mensagem ao usuário.');
                });
        })

    cy.getElementAndClick([access])
        .then(() => {

            cy.checkValidation(emailAccess);

            if (!validatePassword(passwordAccess)) {
                cy.get('body').then(($body) => {
                    if ($body.find(messageContainer).length > 0) {
                        cy.get(messageContainer).then(($modal) => {
                            const messageModal = $modal.text().trim();
                            if (messageModal.includes('As credenciais fornecidas não coincidem com nossos registros.')) {
                                return cy.wrap({ error: 'Foi informado usuário ou senha incorretos na aplicação' });
                            }
                            if (messageModal.includes('The password field is required.')) {
                                return cy.wrap({ error: 'Foi inserida uma senha incorreta na aplicação ou não foi fornecida nenhuma senha na aplicação.' });
                            }
                        });
                    } else {
                        console.log('Element not found');
                    }
                });
            }
        });
    return cy.wrap({ success: 'Login realizado com sucesso.' });
});

Cypress.Commands.add('logout', () => {
    cy.getElementAndClick(['.user > .dropdown > .btn']);

    cy.getElementAndClick([logout]);

    return cy.wrap({ success: 'Logout realizado com sucesso.' });
})

Cypress.Commands.add('loginLogoutWithViewport', (size: Cypress.ViewportPreset | [number, number], elementAction: string, elementSubmit: string) => {
    if (Array.isArray(size) && typeof size[0] === 'number' && typeof size[1] === 'number') {
        cy.viewport(size[0], size[1]);
        cy.log(`-Screen size: ${size[0]} x ${size[1]}-`);
        cy.get(elementAction, { timeout: 20000 }).each(($el) => {
            cy.wrap($el).click({ timeout: 20000 });
        });
        cy.get(elementSubmit, { timeout: 20000 }).each(($el) => {
            cy.wrap($el).click({ timeout: 20000 });
        });
    } else if (typeof size === 'string') {
        cy.viewport(size as Cypress.ViewportPreset);
        cy.log(`-Screen size: ${size}-`);
        cy.get(elementAction, { timeout: 20000 }).each(($el) => {
            cy.wrap($el).click({ timeout: 20000 });
        });
        cy.get(elementSubmit, { timeout: 20000 }).each(($el) => {
            cy.wrap($el).click({ timeout: 20000 });
        });
    }
    return cy.wrap({ success: `Login realizado com sucesso na resolução ${size}` });
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
                    return cy.wrap({ error: `Validation error for ${selector}` });
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