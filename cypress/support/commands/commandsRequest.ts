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
import { ConditionalWrite } from '../../DataParameters/Types/types';
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
    highlightedOption,
    searchPaymentMethodAndTerms,
    totalValue,
    paymentInstallments,
    paymentDetails,
    supplier,

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

    function setPaymentAndSupplier(element: string, searchPaymentMethodAndTerms: string, highlightedElement: string, paymentCondition: ConditionalWrite) {
        for (const [key, [isTyped, value]] of Object.entries(paymentCondition)) {
            if (isTyped) {
                cy.get(element)
                    .click();
                cy.get(searchPaymentMethodAndTerms)
                    .type(value, { force: true })
                    .get(highlightedElement)
                    .should('be.visible')
                    .contains(value)
                    .click({ force: true });
            }
        }
    };

    // cy.getElementAutocompleteTypeAndClick(
    //     costCenter,
    //     dataParameters.Request.product.costCenter,
    //     costCenterAutocomplete
    // );

    // cy.getElementAndType(
    // apportionmentPercentage, 
    // dataParameters.Request.product.apportionmentPercentage.toString()
    // );

    // cy.getElementAndType(
    // apportionmentValue, 
    // dataParameters.Request.product.apportionmentPercentage.toString()
    // );

    // cy.getElementAndCheck(
    // quoteRequest, 
    // dataParameters.Request.product.quoteRequest
    // );

    // cy.getElementAndCheck(dataParameters.Request.product.acquiringArea);

    // cy.getElementAndCheck(dataParameters.Request.product.comexImport);

    // cy.getElementAndType(
    // reasonForRequest, 
    // dataParameters.Request.product.reasonForRequest
    // );

    // cy.getElementAndType(
    // desiredDeliveryDate, 
    // dataParameters.Request.product.desiredDeliveryDate[0].toString()
    // );

    // cy.getElementAndType(
    // productStorageLocation,
    //     dataParameters.Request.product.productStorageLocation
    //     );

    // cy.getElementAndType(
    // suggestionLinks,
    //     dataParameters.Request.product.suggestionLinks
    //         );

    // cy.getElementAndType(
    // observation,
    //     dataParameters.Request.product.observation
    //         );

    // setPaymentAndSupplier(
    //     paymentCondition,
    //     searchPaymentMethodAndTerms,
    //     highlightedOption,
    //     dataParameters.Request.product.paymentCondition
    // );

    // cy.getElementAndType(
    //     totalValue,
    //     dataParameters.Request.product.totalValue.toString()
    // );

    // setPaymentAndSupplier(
    //     paymentMethod,
    //     searchPaymentMethodAndTerms,
    //     highlightedOption,
    //     dataParameters.Request.product.paymentMethod
    // );

    // cy.getElementAndType(
    //     paymentInstallments,
    //     dataParameters.Request.product.paymentInstallments.toString()
    // );

    // cy.getElementAndType(
    //     paymentDetails,
    //     dataParameters.Request.product.paymentDetails
    // );

    cy.getElementAutocompleteTypeAndClick(
        supplier,
        dataParameters.Request.product.supplier,
        dataParameters.Request.product.supplier
    )


});







/*
data entrega
Data desejada do serviço
Data desejada da contratação

--
Descrição
Detalhes do serviço recorrente*





*/