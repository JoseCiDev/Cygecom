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


import { faker } from '@faker-js/faker';

import { elements as el } from '../../elements'
import { dataParameters } from '../../DataParameters/dataParameters';
import { ConditionalWrite } from '../../import';

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
    apportionmentPercentageElement,
    apportionmentValueElement,
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
    productCategory,
    productNameAndDescription,
    productQuantity,
    productColor,
    productSize,
    productModel,
    productLink,
    attachedFile,

} = el.Request

const {
    supplyMenu,
    dashboardSubMenu,
    productSubMenu,
    serviceSubMenu,
    contractSubMenu,
} = el.Supply



Cypress.Commands.add('createRequest', function () {

    function setPaymentAndSupplier(element: string, searchParameterValue: string, highlightedElement: string, conditionalWrite: ConditionalWrite) {
        for (const [key, [isTyped, value]] of Object.entries(conditionalWrite)) {
            if (isTyped) {
                cy.get(element)
                    .click();
                cy.get(searchParameterValue)
                    .type(value, { force: true })
                    .get(highlightedElement)
                    .should('be.visible')
                    .contains(value)
                    .click({ force: true });
            }
        }
    };

    function setQuotation() {
        const { product: { quoteRequest } } = dataParameters.Request;
        for (const [key, value] of Object.entries(quoteRequest)) {
            if (value) {
                cy.getElementAndCheck([
                    { element: key },
                ]);
            }
        }
    };

    function setApportionment() {
        const { apportionmentPercentage, apportionmentValue } = dataParameters.Request.product;
        cy.get(apportionmentPercentageElement)
            .invoke('val')
            .then((percentageVal) => {
                cy.get(apportionmentValueElement)
                    .invoke('val')
                    .then((valueVal) => {
                        if (!percentageVal && !valueVal) {
                            cy.get(apportionmentPercentageElement)
                                .type(apportionmentPercentage.toString());
                        }
                        else if (!percentageVal) {
                            cy.get(apportionmentPercentageElement)
                                .type(apportionmentPercentage.toString());
                        }
                        else if (!valueVal) {
                            cy.get(apportionmentValueElement)
                                .type(apportionmentValue.toString());
                        }
                    });
            });
    };

    function saveRequest() {
        const { product: { saveRequest } } = dataParameters.Request;
        for (const [key, saveAs] of Object.entries(saveRequest)) {
            if (saveAs) {
                cy.getElementAndClick([key]);
            }
        }
    };

    cy.getElementAutocompleteTypeAndClick(
        { [costCenter]: dataParameters.Request.product.costCenter },
        highlightedOption
    );

    setApportionment();

    setQuotation();

    cy.getElementAndCheck([
        { element: dataParameters.Request.product.acquiringArea },
        { element: dataParameters.Request.product.comexImport },
    ]);

    cy.getElementAndType({
        [reasonForRequest]: dataParameters.Request.product.reasonForRequest,
        [desiredDeliveryDate]: dataParameters.Request.product.desiredDeliveryDate[0].toString(),
        [productStorageLocation]: dataParameters.Request.product.productStorageLocation,
        [suggestionLinks]: dataParameters.Request.product.suggestionLinks,
        [observation]: dataParameters.Request.product.observation,
    });

    setPaymentAndSupplier(
        paymentCondition,
        searchPaymentMethodAndTerms,
        highlightedOption,
        dataParameters.Request.product.paymentCondition
    );

    cy.getElementAndType({
        [totalValue]: dataParameters.Request.product.totalValue.toString(),
    });

    setPaymentAndSupplier(
        paymentMethod,
        searchPaymentMethodAndTerms,
        highlightedOption,
        dataParameters.Request.product.paymentMethod
    );

    cy.getElementAndType({
        [paymentInstallments]: dataParameters.Request.product.paymentInstallments.toString(),
        [paymentDetails]: dataParameters.Request.product.paymentDetails,
    });

    cy.getElementAutocompleteTypeAndClick({
        [supplier]: dataParameters.Request.product.supplier,
        [productCategory]: dataParameters.Request.product.productCategory,
    },
        highlightedOption
    );

    cy.getElementAndType({
        [productNameAndDescription]: dataParameters.Request.product.productNameAndDescription,
        [productQuantity]: dataParameters.Request.product.productQuantity.toString(),
        [productColor]: dataParameters.Request.product.productColor,
        [productSize]: dataParameters.Request.product.productSize.toString(),
        [productModel]: dataParameters.Request.product.productModel,
        [productLink]: dataParameters.Request.product.productLink,
    });

    cy.insertFile(dataParameters.Request.product.attachedFile, attachedFile);

    saveRequest();
});







/*
data entrega
Data desejada do serviço
Data desejada da contratação

--
Descrição
Detalhes do serviço recorrente*





*/