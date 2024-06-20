/// <reference types="cypress" />

import { faker } from '@faker-js/faker';

import { elements as el } from '../elements';
import { env } from 'process';
import { data } from 'cypress/types/jquery';
import { DataParameters } from '../import';
import { dataParameters } from '../DataParameters/dataParameters';

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
    searchColumn,
} = el.Register

const {
    requestMenu,
    newRequestSubMenu,
    myRequestSubMenu,
    requestGeneralSubMenu,
    costCenter,
    highlightedOption,
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

describe('Testes da página de criação de solicitação de produtos.', () => {

    beforeEach(function () {

    })

    it(`Solicitação de produtos`, () => {
        cy.login(dataEnvironment.BASE_URL_CI, dataEnvironment.EMAIL_ADMIN_CI, dataEnvironment.PASSWORD_ADMIN_CI, messageContainer)
            .then((result) => {
                assert.exists(result.success, result.error)
            });

        cy.getElementAndClick([
            requestMenu,
            newRequestSubMenu
        ]);
        cy.createRequeste();
        

    });
});




