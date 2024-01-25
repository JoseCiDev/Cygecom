/// <reference types="cypress" />

import { faker } from '@faker-js/faker';
import { elements as el } from '../../elements';
import { ValidationResult, dataParameters } from '../../DataParameters'
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


describe('Testes da página Inicio', () => {




    beforeEach(function () {

        cy.login(dataParameters.env.EMAIL_ADMIN, dataParameters.env.PASSWORD_ADMIN, messageContainer);
    })

    



    it(`Deve ser possível logar em vários dispositivos.`, () => {
        dataParameters.sizes.forEach((size) => {
            if (_.isArray(size)) {
                cy.loginLogoutWithViewport(size);

                cy.get(userProfile)
                    .click();

                cy.get(logout)
                    .click();

                cy.get(dataParameters.Autentication.email)
                    .type(dataParameters.env.EMAIL_ADMIN, { log: false })
                    .should('have.value', dataParameters.env.EMAIL_ADMIN);

                cy.get(dataParameters.Autentication.password)
                    .type(dataParameters.env.PASSWORD_ADMIN, { log: false })
                    .should('have.value', dataParameters.env.PASSWORD_ADMIN);

                cy.getElementAndClick(access);

                cy.url().should('contain', `${dataParameters.env.BASE_URL}`);

                cy.get(homeMenu, { timeout: 10000 })
                    .then((element) => {
                        if (Cypress.dom.isVisible(element)) {
                            cy.wrap(element)
                                .click();
                        } else {
                            cy.get("a.toggle-mobile")
                                .click();
                        }
                    });
            }
        });
    });



    it('Deve clicar na palavra inicio e ser direcionado para página inicio.', () => {

        cy.getElementAndClick(homeMenu);

        cy.url()
            .should('contain', `${dataParameters.env.BASE_URL}`);

    })



    it('Deve clicar no icone "Gecom" e ser direcionado para página inicio.', () => {

        cy.getElementAndClick(logoGecom);

        cy.url()
            .should('contain', `${dataParameters.env.BASE_URL}`);
    })



    it('Deve acessar cadastros de usuários.', () => {

        cy.getElementAndClick(registrationMenu);
        cy.getElementAndClick(registrationUserSubMenu);

        cy.getElementAndClick(createNewUser);

        cy.url()
            .should('contain', dataParameters.env.BASE_URL + '/users');
    })


})

