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


import { PaymentCondition } from '../../DataParameters/Enums/paymentCondition';
import { elements as el } from '../../elements'
import { dataParameters } from './../../dataParameters';

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
    costCenter,
    costCenterAutocomplete,
    apportionmentPercentage,
    apportionmentValue,
    quoteRequest,
    reasonForRequest,
    desiredDeliveryDate,
    productStorageLocation,
    suggestionLinks,
    observation,
    paymentCondition,
    paymentMethod,

} = el.Request

const {
    supplyMenu,
    dashboardSubMenu,
    productSubMenu,
    serviceSubMenu,
    contractSubMenu,
} = el.Supply


Cypress.Commands.add('createRequest', function () {
    //paymentData
    //attachedFiles

    // cy.getElementAutocompleteTypeAndClick(
    //     costCenter,
    //     dataParameters.Request.product.costCenter,
    //     costCenterAutocomplete
    // );

    // cy.getElementAndType(apportionmentPercentage, dataParameters.Request.product.apportionmentPercentage.toString());

    // cy.getElementAndType(apportionmentValue, dataParameters.Request.product.apportionmentPercentage.toString());

    // cy.getElementAndCheck(quoteRequest, dataParameters.Request.product.quoteRequest);

    // cy.getElementAndCheck(dataParameters.Request.product.acquiringArea);

    // cy.getElementAndCheck(dataParameters.Request.product.comexImport);

    // cy.getElementAndType(reasonForRequest, dataParameters.Request.product.reasonForRequest);

    cy.getElementAndType(desiredDeliveryDate, dataParameters.Request.product.desiredDeliveryDate[0].toString());

    // cy.getElementAndType(productStorageLocation, dataParameters.Request.product.productStorageLocation);

    // cy.getElementAndType(suggestionLinks, dataParameters.Request.product.suggestionLinks);

    // cy.getElementAndType(observation, dataParameters.Request.product.observation);
    // cy.getElementAutocompleteTypeAndClick('#select2-payment-terms-container','Antecipado','Antecipado');
    // Cypress.Commands.add('getElementAutocompleteTypeAndClick', (element: string, value: string | number, autocomplete: string) => {
    //     cy.get(element, { timeout: 20000 })
    //         .as('elementAlias')
    //         .each(($input) => {
    //             cy.wrap($input)
    //                 .type(value.toString())
    //                 .then(() => {
    //                     cy.contains(autocomplete, value)
    //                         .as('autocompleteAlias')
    //                         .click({ force: true });
    //                 });
    //         });
    // });
});

/*
data entrega
Data desejada do serviço
Data desejada da contratação

--
Descrição
Detalhes do serviço recorrente*





*/