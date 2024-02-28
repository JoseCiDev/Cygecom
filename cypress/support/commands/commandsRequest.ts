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
import { ConditionalWrite, IsComexImportProduct, IsComexImportService, ObservationOfRequest, QuoteRequest, RequestType, ServiceName, SupportLinks } from '../../import';
import data from '../../fixtures/data.json';



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


// Cypress.Commands.add('createRequest', function (requestType: string) {
//     cy.getElementAndClick([requestType]);

//     const requestTypeMap = {
//         [RequestType.product]: 'product',
//         [RequestType.oneOffService]: 'oneOffService',
//         [RequestType.recurringService]: 'recurringService'
//     };
//     function setPaymentAndSupplier(element: string, searchParameterValue: string, highlightedElement: string, conditionalWrite: ConditionalWrite) {
//         if (conditionalWrite) {
//             for (const [key, [isTyped, value]] of Object.entries(conditionalWrite)) {
//                 if (isTyped) {
//                     cy.get(element)
//                         .click();
//                     cy.get(searchParameterValue)
//                         .type(value, { force: true })
//                         .get(highlightedElement)
//                         .should('be.visible')
//                         .contains(value)
//                         .click({ force: true });
//                 }
//             }
//         }
//     };
//     function setQuotation(request) {
//         const { quoteRequest } = request;
//         for (const [key, value] of Object.entries(quoteRequest)) {
//             if (value) {
//                 cy.getElementAndCheck([
//                     { element: key },
//                 ]);
//             }
//         }
//     };
//     function setApportionment(request) {
//         const { apportionmentPercentage, apportionmentValue } = dataParameters.Request.product;

//         if (apportionmentValue && apportionmentValue !== " ") {
//             cy.get(apportionmentValueElement)
//                 .type(dataParameters.Request.product.apportionmentValue.toString());
//         }
//         else if (apportionmentPercentage && apportionmentPercentage !== " ") {
//             cy.get(apportionmentPercentageElement)
//                 .type(dataParameters.Request.product.apportionmentPercentage.toString());
//         } else {
//             throw new Error("Valor não foi passado");
//         }
//     };
//     function saveRequest() {
//         const { product: { saveRequest } } = dataParameters.Request;
//         for (const [key, saveAs] of Object.entries(saveRequest)) {
//             if (saveAs) {
//                 cy.getElementAndClick([key]);
//             }
//         }
//     };

//     const optionsMap = {
//         [RequestType.oneOffService]: { selector: '[data-cy="service-title"]', property: 'oneOffService' },
//         [RequestType.recurringService]: { selector: '[data-cy="contract-title"]', property: 'recurringService' }
//     };
//     const comexMapping = {
//         product: {
//             [IsComexImportProduct.yes]: IsComexImportProduct.yes,
//             [IsComexImportProduct.no]: IsComexImportProduct.no
//         },
//         oneOffService: {
//             [IsComexImportService.yes]: IsComexImportService.yes,
//             [IsComexImportService.no]: IsComexImportService.no
//         },
//         recurringService: {
//             [IsComexImportService.yes]: IsComexImportService.yes,
//             [IsComexImportService.no]: IsComexImportService.no
//         }
//     };

//     if (optionsMap[requestType]) {
//         cy.get(optionsMap[requestType].selector)
//         .type(dataParameters.Request[optionsMap[requestType].property].serviceName);
//     };

//     if (requestTypeMap[requestType]) {
//         const requestKey = requestTypeMap[requestType];
//         if (dataParameters.Request[requestKey]) {
//             cy.getElementAutocompleteTypeAndClick(
//                 { [costCenter]: dataParameters.Request[requestKey].costCenter },
//                 highlightedOption
//             );
//         };
//     };

//     if (requestTypeMap[requestType]) {
//         const requestKey = requestTypeMap[requestType];
//         if (dataParameters.Request[requestKey]) {
//             cy.fixture('data.json').then((data) => {
//                 const requestKey = requestTypeMap[requestType];
//                 if (dataParameters.Request[requestKey]) {
//                     setApportionment(data.Request[requestKey]);
//                 }
//             });
//         }
//     };

//     if (requestTypeMap[requestType]) {
//         const requestKey = requestTypeMap[requestType];
//         if (dataParameters.Request[requestKey]) {
//             setQuotation(dataParameters.Request[requestKey]);
//         }
//     }

//     if (requestTypeMap[requestType]) {
//         const requestKey = requestTypeMap[requestType];
//         let comexValue = dataParameters.Request[requestKey].isComex;
//         if (comexMapping[requestKey] && comexMapping[requestKey][comexValue]) {
//             const selector = comexMapping[requestKey][comexValue];
//             if (typeof selector === 'string') {
//                 cy.get(selector)
//                     .should('be.visible')
//                     .check();
//             };
//         };
//     };

//     if (requestTypeMap[requestType]) {
//         const requestKey = requestTypeMap[requestType];
//         if (dataParameters.Request[requestKey]) {
//             cy.getElementAndType({
//                 [reasonForRequest]: dataParameters.Request[requestKey].reasonForRequest.trim() !== "" ? dataParameters.Request[requestKey].reasonForRequest : " ",
//                 [desiredDeliveryDate]: dataParameters.Request[requestKey].desiredDeliveryDate.trim() !== "" ? dataParameters.Request[requestKey].desiredDeliveryDate : new Date().toISOString().split('T')[0],
//                 [productStorageLocation]: dataParameters.Request[requestKey].localDescription.trim() !== "" ? dataParameters.Request[requestKey].localDescription : " ",
//             });
//         };
//     };

//     if (requestTypeMap[requestType]) {
//         const requestKey = requestTypeMap[requestType];
//         if (dataParameters.Request[requestKey]) {
//             cy.getElementAndType({
//                 [SupportLinks[requestKey]]: dataParameters.Request[requestKey].suggestionLinks,
//             });
//         };
//     };


//     if (requestTypeMap[requestType]) {
//         const requestKey = requestTypeMap[requestType];
//         if (dataParameters.Request[requestKey]) {
//             cy.getElementAndCheck([{ element: dataParameters.Request[requestKey].acquiringArea },]);
//         };
//     };


//     if (requestTypeMap[requestType]) {
//         const requestKey = requestTypeMap[requestType];
//         if (dataParameters.Request[requestKey]) {
//             cy.getElementAndType({
//                 [ObservationOfRequest[requestKey]]: dataParameters.Request[requestKey].observation,
//             });
//         };
//     };


//     if (requestTypeMap[requestType]) {
//         const requestKey = requestTypeMap[requestType]

//         if (dataParameters.Request[requestKey]) {
//             setPaymentAndSupplier(
//                 paymentCondition,
//                 searchPaymentMethodAndTerms,
//                 highlightedOption,
//                 dataParameters.Request[requestKey].paymentCondition
//             );

//         };
//     };


//     if (requestTypeMap[requestType]) {
//         const requestKey = requestTypeMap[requestType];
//         if (dataParameters.Request[requestKey]) {

//             cy.getElementAndType({
//                 [totalValue]: dataParameters.Request[requestKey].totalValue,
//             });
//         }
//     };


//     if (requestTypeMap[requestType]) {
//         const requestKey = requestTypeMap[requestType];
//         if (dataParameters.Request[requestKey]) {
//             setPaymentAndSupplier(
//                 paymentMethod,
//                 searchPaymentMethodAndTerms,
//                 highlightedOption,
//                 dataParameters.Request[requestKey].paymentMethod
//             );

//         };
//     };


//     cy.getElementAndType({
//         [paymentInstallments]: dataParameters.Request.product.paymentInstallments.toString(),
//         [paymentDetails]: dataParameters.Request.product.paymentDetails,
//     });

//     cy.getElementAutocompleteTypeAndClick({
//         [supplier]: dataParameters.Request.product.supplier,
//         [productCategory]: dataParameters.Request.product.productCategory,
//     },
//         highlightedOption
//     );

//     cy.getElementAndType({
//         [productNameAndDescription]: dataParameters.Request.product.productNameAndDescription,
//         [productQuantity]: dataParameters.Request.product.productQuantity.toString(),
//         [productColor]: dataParameters.Request.product.productColor,
//         [productSize]: dataParameters.Request.product.productSize.toString(),
//         [productModel]: dataParameters.Request.product.productModel,
//         [productLink]: dataParameters.Request.product.productLink,
//     });

//     cy.insertFile(dataParameters.Request.product.attachedFile, attachedFile);

//     saveRequest();
// });





// --------------------------------------------------------------------------------
Cypress.Commands.add('createRequest', function (requestType: string) {
    const requestTypeMap = {
        [RequestType.product]: 'product',
        [RequestType.oneOffService]: 'oneOffService',
        [RequestType.recurringService]: 'recurringService'
    };
    function processRequestType(requestType, callback) {
        if (requestTypeMap[requestType]) {
            const requestKey = requestTypeMap[requestType];
            if (dataParameters.Request[requestKey]) {
                callback(requestKey);
            }
        }
    };
    const optionsMap = {
        [RequestType.oneOffService]: { selector: '[data-cy="service-title"]', property: 'oneOffService' },
        [RequestType.recurringService]: { selector: '[data-cy="contract-title"]', property: 'recurringService' }
    };
    const comexMapping = {
        product: {
            [IsComexImportProduct.yes]: IsComexImportProduct.yes,
            [IsComexImportProduct.no]: IsComexImportProduct.no
        },
        oneOffService: {
            [IsComexImportService.yes]: IsComexImportService.yes,
            [IsComexImportService.no]: IsComexImportService.no
        },
        recurringService: {
            [IsComexImportService.yes]: IsComexImportService.yes,
            [IsComexImportService.no]: IsComexImportService.no
        }
    };

    // function setPaymentAndSupplier(element: string, searchParameterValue: string, highlightedElement: string, conditionalWrite: ConditionalWrite) {
    //     if (conditionalWrite) {
    //         for (const [key, [isTyped, value]] of Object.entries(conditionalWrite)) {
    //             if (isTyped) {
    //                 cy.get(element)
    //                     .click();
    //                 cy.get(searchParameterValue)
    //                     .type(value, { force: true })
    //                     .get(highlightedElement)
    //                     .should('be.visible')
    //                     .contains(value)
    //                     .click({ force: true });
    //             }
    //         }
    //     }
    // };
    function setPaymentAndSupplier(element: string, searchParameterValue: string, highlightedElement: string, conditionalWrite: ConditionalWrite) {
        if (conditionalWrite) {
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
        }
    };
    // function setQuotation(requestKey: string) {
    //     const quoteRequest = dataParameters.Request[requestKey];
    //     for (const [key, value] of Object.entries(quoteRequest)) {
    //         if (value) {
    //             cy.getElementAndCheck([
    //                 { element: key },
    //             ]);
    //         }
    //     }
    // };
    function setQuotation(request) {
        const { quoteRequest } = request;
        for (const [key, value] of Object.entries(quoteRequest)) {
            if (value) {
                cy.getElementAndCheck([
                    { element: key },
                ]);
            }
        }
    };
    // function setApportionment(requestKey: string) {
    //     const { apportionmentPercentage, apportionmentValue } = dataParameters.Request[requestKey];

    //     if (apportionmentValue && apportionmentValue !== " ") {
    //         cy.get(apportionmentValueElement)
    //             .type(apportionmentValue.toString());
    //     }
    //     else if (apportionmentPercentage && apportionmentPercentage !== " ") {
    //         cy.get(apportionmentPercentageElement)
    //             .type(apportionmentPercentage.toString());
    //     } else {
    //         throw new Error("Valor não foi passado");
    //     }
    // };
    function setApportionment(request) {
        const { apportionmentPercentage, apportionmentValue } = dataParameters.Request.product;

        if (apportionmentValue && apportionmentValue !== " ") {
            cy.get(apportionmentValueElement)
                .type(dataParameters.Request.product.apportionmentValue.toString());
        }
        else if (apportionmentPercentage && apportionmentPercentage !== " ") {
            cy.get(apportionmentPercentageElement)
                .type(dataParameters.Request.product.apportionmentPercentage.toString());
        } else {
            throw new Error("Valor não foi passado");
        }
    };
    function saveRequest() {
        const { product: { saveRequest } } = dataParameters.Request;
        for (const [key, saveAs] of Object.entries(saveRequest)) {
            if (saveAs) {
                cy.getElementAndClick([key]);
            }
        }
    };



    processRequestType(requestType, (requestKey) => {
        cy.getElementAndClick([requestType]);
    });

    processRequestType(requestType, (requestKey) => {
        if (optionsMap[requestKey]) {
            cy.get(optionsMap[requestKey].selector)
                .type(dataParameters.Request[optionsMap[requestKey].property].serviceName);
        }
    });

    processRequestType(requestType, (requestKey) => {
        if (dataParameters.Request[requestKey]) {
            cy.getElementAutocompleteTypeAndClick(
                { [costCenter]: dataParameters.Request[requestKey].costCenter },
                highlightedOption
            );
        };
    });

    // processRequestType('product', setApportionment);
    if (requestTypeMap[requestType]) {
        const requestKey = requestTypeMap[requestType];
        if (dataParameters.Request[requestKey]) {
            cy.fixture('data.json').then((data) => {
                const requestKey = requestTypeMap[requestType];
                if (dataParameters.Request[requestKey]) {
                    setApportionment(data.Request[requestKey]);
                }
            });
        }
    };

    // processRequestType('quoteRequest', setQuotation);
    if (requestTypeMap[requestType]) {
        const requestKey = requestTypeMap[requestType];
        if (dataParameters.Request[requestKey]) {
            setQuotation(dataParameters.Request[requestKey]);
        }
    }

    processRequestType(requestType, (requestKey) => {
        let comexValue = dataParameters.Request[requestKey].isComex;
        if (comexMapping[requestKey] && comexMapping[requestKey][comexValue]) {
            const selector = comexMapping[requestKey][comexValue];
            if (typeof selector === 'string') {
                cy.get(selector)
                    .should('be.visible')
                    .check();
            };
        };
    });

    processRequestType(requestType, (requestKey) => {
        cy.getElementAndType({
            [reasonForRequest]: dataParameters.Request[requestKey].reasonForRequest.trim() !== "" ? dataParameters.Request[requestKey].reasonForRequest : " ",
            [desiredDeliveryDate]: dataParameters.Request[requestKey].desiredDeliveryDate.trim() !== "" ? dataParameters.Request[requestKey].desiredDeliveryDate : new Date().toISOString().split('T')[0],
            [productStorageLocation]: dataParameters.Request[requestKey].localDescription.trim() !== "" ? dataParameters.Request[requestKey].localDescription : " ",
        });
    });

    processRequestType(requestType, (requestKey) => {
        cy.getElementAndType({
            [SupportLinks[requestKey]]: dataParameters.Request[requestKey].suggestionLinks,
        });
    });

    processRequestType(requestType, (requestKey) => {
        cy.getElementAndCheck([{ element: dataParameters.Request[requestKey].acquiringArea },]);
    });

    processRequestType(requestType, (requestKey) => {
        cy.getElementAndType({
            [ObservationOfRequest[requestKey]]: dataParameters.Request[requestKey].observation,
        });
    });

    // setPaymentAndSupplier('conditionalWrite', paymentCondition, searchPaymentMethodAndTerms, highlightedOption);
    if (requestTypeMap[requestType]) {
        const requestKey = requestTypeMap[requestType];
        if (dataParameters.Request[requestKey]) {
            setPaymentAndSupplier(
                paymentCondition,
                searchPaymentMethodAndTerms,
                highlightedOption,
                dataParameters.Request[requestKey].paymentCondition as ConditionalWrite
            );
        }
    };

    processRequestType(requestType, (requestKey) => {
        cy.getElementAndType({
            [totalValue]: dataParameters.Request[requestKey].totalValue,
        });
    });

    if (requestTypeMap[requestType]) {
        const requestKey = requestTypeMap[requestType];
        if (dataParameters.Request[requestKey]) {
            setPaymentAndSupplier(
                paymentMethod,
                searchPaymentMethodAndTerms,
                highlightedOption,
                dataParameters.Request[requestKey].paymentMethod as ConditionalWrite
            );
        }
    };
    // function setPaymentAndSupplierWrapper(requestKey: string) {
    //     setPaymentAndSupplier(paymentMethod, searchPaymentMethodAndTerms, highlightedOption, requestKey);
    // }
    // processRequestType('setPaymentAndSupplier', setPaymentAndSupplierWrapper);

    processRequestType(requestType, (requestKey) => {
        cy.getElementAndType({
            [paymentInstallments]: dataParameters.Request[requestKey].paymentInstallments.toString(),
            [paymentDetails]: dataParameters.Request[requestKey].paymentDetails,
        });
    });

    processRequestType(requestType, (requestKey) => {
        cy.getElementAutocompleteTypeAndClick({
            [supplier]: dataParameters.Request[requestKey].supplier,
            [productCategory]: dataParameters.Request[requestKey].productCategory,
        },
            highlightedOption
        );
    });

    processRequestType(requestType, (requestKey) => {
        cy.getElementAndType({
            [productNameAndDescription]: dataParameters.Request[requestKey].productNameAndDescription,
            [productQuantity]: dataParameters.Request[requestKey].productQuantity.toString(),
            [productColor]: dataParameters.Request[requestKey].productColor,
            [productSize]: dataParameters.Request[requestKey].productSize.toString(),
            [productModel]: dataParameters.Request[requestKey].productModel,
            [productLink]: dataParameters.Request[requestKey].productLink,
        });
    });

    processRequestType(requestType, (requestKey) => {
        cy.insertFile(dataParameters.Request[requestKey].attachedFile, attachedFile);
    });

    saveRequest();

});