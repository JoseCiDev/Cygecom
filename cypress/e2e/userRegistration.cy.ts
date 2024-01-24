/// <reference types="cypress" />
import * as faker from '@faker-js/faker';
import * as fakerBr from 'faker-br';
import { elements as el } from '../elements';
import { ValidationResult, dataParameters } from '../DataParameters'

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






describe('Testes da página Cadastro de Usuário', () => {


    beforeEach(function () {

        cy.login(dataParameters.env.EMAIL_ADMIN, dataParameters.env.PASSWORD_ADMIN, messageContainerIncorrectData);

        cy.getElementAndClick(registrationMenu);

    })



    // it(`Deve ser possível cadastrar em vários dispositivos.`, () => {
    //     sizes.forEach((size) => {
    //         if (Cypress._.isArray(size)) {
    //             cy.loginLogoutWithViewport(size, dadosAmbiente);

    //             // cy.getVisible(cadastroMenu)
    //             //     .click()
    //             cy.get(cadastroMenu, { timeout: 10000 })
    //                 .then((element) => {
    //                     if (Cypress.dom.isVisible(element)) {
    //                         cy.wrap(element)
    //                             .click();
    //                     } else {
    //                         cy.getVisible(menuReduzido)
    //                             .click()
    //                         cy.getVisible(cadastroMenuReduzido)
    //                             .scrollIntoView()
    //                             .click()
    //                     }
    //                 });
    //         }
    //     });
    // });


})

