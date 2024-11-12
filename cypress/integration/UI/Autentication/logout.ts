// /home/jose/projetos/Cygecom/cypress/e2e/logout.ts

/// <reference types="cypress" />

/// <reference types="cypress" />

import {
    Given, When, Then,
    elements as el,

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

Given('que eu estou logado como administrador', () => {
    cy.login(
        dataEnvironment.BASE_URL_CI,
        dataEnvironment.EMAIL_ADMIN_CI,
        dataEnvironment.PASSWORD_ADMIN_CI,
    )
        .then((result) => {
            assert.exists(result.success, result.error)
        });
});

When('eu faço logout', () => {
    cy.getElementAndClick([userProfile]);
    cy.getElementAndClick([logout])
});

Then('eu devo visualizar a tela de login', () => {
    cy.url().should('eq', dataEnvironment.BASE_URL_CI + 'login');
});