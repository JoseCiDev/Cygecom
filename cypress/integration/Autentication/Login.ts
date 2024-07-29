/// <reference types="cypress" />

import {
    faker,
    elements as el,
    DataParameters,
} from '../../import';

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

describe('Testes da página Login.', () => {

    beforeEach(function () {

    })

    it('Deve efetuar o login com sucesso.', () => {
        cy.login(dataEnvironment.BASE_URL, dataEnvironment.EMAIL_ADMIN, dataEnvironment.PASSWORD_ADMIN, messageContainer)
            .then((result) => {
                assert.exists(result.success, result.error)
            });

    });
});