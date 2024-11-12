// /home/jose/projetos/Cygecom/cypress/e2e/createRequest.ts

/// <reference types="cypress" />

import {
    DataParameters,
    RequestType,
    dataParameters,
    faker,
    elements as el,
    Given, When, Then,

} from '../../../import';

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
    searchColumn,
} = el.Register

const {
    requestMenu,
    newRequestSubMenu,
    myRequestSubMenu,
    costCenter,
    highlightedOption,
    productRequest,
    requestNumberRequestList,
} = el.Request

const {
    supplyMenu,
    dashboardSubMenu,
    productSubMenu,
    serviceSubMenu,
    contractSubMenu,
} = el.Supply


const environment = Cypress.env('ENVIRONMENT');
const dataEnvironment = Cypress.env(environment);


Given('que estou na página de login', () => {
    cy.visit('/');
});

When('eu faço login com email {string} e senha {string}', (email, password) => {
    cy.login(dataEnvironment.BASE_URL_CI, dataEnvironment.EMAIL_ADMIN_CI, dataEnvironment.PASSWORD_ADMIN_CI, messageContainer)
        .then((result) => {
            assert.exists(result.success, result.error);
        });
});

Then('eu devo ser redirecionado para a página inicial', () => {
    cy.url().should('include', dataEnvironment.BASE_URL_CI);
});

Given('que estou na página inicial', () => {
    cy.url().should('include', dataEnvironment.BASE_URL_CI);
});

When('eu navego para o menu de novas solicitações', () => {
    cy.getElementAndClick([requestMenu, newRequestSubMenu]);
});

When('eu crio uma nova solicitação de produto', () => {
    cy.createRequest(productRequest);
});

Then('a solicitação deve ser criada com sucesso', () => {

    cy.waitUntil(() =>
        cy.get('.fade > .toast-body').should('be.visible')
    )
});

Then('eu devo visualizar a solicitação na lista de solicitações', () => {
    cy.waitUntil(() => cy.get('.fade > .toast-body').invoke('text').then((text) => {
        const requestNumber = text.match(/nº (\d+)/)[1];
        cy.get(requestNumberRequestList).type(`${requestNumber}{enter}`);
        cy.get('#requests-table > tbody > tr > td.sorting_1').should('contain', requestNumber);
    }), {
        errorMsg: 'Modal de confirmação não apareceu',
        timeout: 10000,
        interval: 500
    })
});

