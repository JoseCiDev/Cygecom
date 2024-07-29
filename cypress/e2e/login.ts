/// <reference types="cypress" />

import {
    Given, When, Then,
    elements as el
} from '../import'

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
    requestGeneralSubMenu,

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

When('I run a simple action', () => {
    cy.login(dataEnvironment.BASE_URL_CI, dataEnvironment.EMAIL_ADMIN_CI, dataEnvironment.PASSWORD_ADMIN_CI, messageContainer)
        .then((result) => {
            assert.exists(result.success, result.error)
        });
    cy.log('Teste')
    cy.get('[data-cy="email"]').type('teste')
});

Then('I should see a result', () => {
    // Verificação simples
});

Then('I should see a result 2', () => {
    // Verificação simples
});



// Given('Estou na página de login', () => {
//     console.log('Given');
//     // cy.visit('/');
// });

// When('Eu insiro o usuário {string} e a senha {string}', (username, password) => {
//     console.log(`When`);
//     // cy.login(
//     //     dataEnvironment.BASE_URL_CI,
//     //     dataEnvironment.EMAIL_ADMIN_CI,
//     //     dataEnvironment.PASSWORD_ADMIN_CI,
//     //     messageContainer
//     // )
//     //     .then((result) => {
//     //         assert.exists(result.success, result.error)
//     //     });
// });

// Then('Eu devo ser redirecionado para a página inicial', () => {
//     console.log('Then');
//     // cy.url().should('eq', dataEnvironment.BASE_URL_CI);
// });

// Then('O nome do usuário deve ser exibido no canto superior direito', () => {
//     console.log('Then');
//     // cy.get('.user > .dropdown > .btn').should('be.visible');
// });