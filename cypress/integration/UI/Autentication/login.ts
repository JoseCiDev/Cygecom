// /home/jose/projetos/Cygecom/cypress/e2e/login.ts
/// <reference types="cypress" />

import {
    Given, When, Then,
    elements as el,
    validateEmail
} from '../../../import'

export const {
    email,
    password,
    access,
    titleLogin,
    messageContainer,

} = el.Login;

export const {
    userProfile,
    homeMenu,
    logoGecom,
    homeScreen,

} = el.Start;

export const {
    logout,
    optionsMenu,
    menuReduced,
    breadcumbHome,
    breadcumbUser,
    showQuantityRecords,
    SearchRegisteredUser,
    nextPage,
    pagePrevious,

} = el.Shared;

export const {
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
} = el.Register;

export const {
    requestMenu,
    newRequestSubMenu,
    myRequestSubMenu,

} = el.Request;

export const {
    supplyMenu,
    dashboardSubMenu,
    productSubMenu,
    serviceSubMenu,
    contractSubMenu,

} = el.Supply;


const environment = Cypress.env('ENVIRONMENT');
const dataEnvironment = Cypress.env(environment);



Given('Estou na página de login', () => {
    cy.visit('/');
});

When('Eu insiro o usuário {string} e a senha {string}', () => {
    cy.login(
        dataEnvironment.BASE_URL_CI,
        dataEnvironment.EMAIL_ADMIN_CI,
        dataEnvironment.PASSWORD_ADMIN_CI,
        messageContainer
    )
        .then((result) => {
            assert.exists(result.success, result.error)
        });
});

Then('Eu devo ser redirecionado para a página inicial', () => {
    cy.url().should('eq', dataEnvironment.BASE_URL_CI);
});

Then('O nome do usuário deve ser exibido no canto superior direito', () => {
    cy.get(userProfile).should('be.visible');
    
});

When('eu tento fazer login com {string} e {string}', (email, password) => {
    cy.getElementAndType({ [el.Login.email]: 'email@gecom' })
    cy.getElementAndType({ [el.Login.password]: 'password' })
    cy.get(access).click();
    
});

Then('eu devo ver uma mensagem de erro {string}', (mensagemErro) => {
    validateEmail(el.Login.email)
    
});

When('eu tento fazer login com campos vazios', () => {
    cy.get(el.Login.email).clear();
    cy.get(el.Login.password).clear();
    cy.get(access).click();
    validateEmail(el.Login.email)
    
});
