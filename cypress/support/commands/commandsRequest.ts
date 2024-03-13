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



import {
    ConditionalWrite,
    IsComexImportProduct,
    IsComexImportService,
    ObservationOfRequest,
    QuoteRequest,
    RequestType,
    ServiceName,
    SuggestionLinks,
    elements as el,
    faker,
    RequestKeys,
    Apportionment,
    Requests,
    data,
    requestTypeString,
    observationString,
    suggestionLinksString,
    ServiceAlreadyProvided,
    requestData,
    requestTyper,
    PaymentRecurrence,
    PaymentDueDate,
    SupplierOfRequest,
    ProductCategory,
    SupplierElement,
    dataParameters,
    serviceNameString,
    IsSavedRequest,
    SaveRequestDraft,
    SaveRequestSubmit,
    isSaved,
} from '../../import';


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
    localDescription,
    paymentCondition,
    paymentMethod,
    highlightedOption,
    searchPaymentMethodAndTerms,
    totalValue,
    paymentInstallments,
    paymentDetails,
    category,
    nameAndDescription,
    quantity,
    color,
    size,
    model,
    link,
    attachedFile,
    description,
    seller,
    telephone,
    initialPaymentEffectiveDate,
    finalPaymentEffectiveDate,
    paymentRecurrence,
    paymentDueDate,
    toAgreeModalSubmitRequest,
} = el.Request

const {
    supplyMenu,
    dashboardSubMenu,
    productSubMenu,
    serviceSubMenu,
    contractSubMenu,
} = el.Supply



function processAttribute(attributes: { [K in RequestKeys]?: (attributeValue: string) => void }) {

    for (const attribute of Object.entries(attributes)) {
        const [attributeKey, callback] = attribute;
        const attributeValue = dataParameters.request[attributeKey];
        callback(attributeValue)
    }
}
function handleRequestAttributes(attributeValue: string, types: RequestType[], action: (value: string) => void) {
    if (types.includes(requestTyper)) {
        action(attributeValue);
    }
}



Cypress.Commands.add('createRequest', function (requestType: string) {

    function setApportionment() {
        const { apportionmentPercentage, apportionmentValue } = dataParameters.request;

        if (apportionmentValue && apportionmentValue !== " ") {
            cy.get(apportionmentValueElement)
                .type(apportionmentValue.toString());
        }
        else if (apportionmentPercentage && apportionmentPercentage !== " ") {
            cy.get(apportionmentPercentageElement)
                .type(apportionmentPercentage.toString());
        } else {
            throw new Error("Valor não foi passado");
        }
    };

    processAttribute({
        requestType: (attributeValue) => {
            cy.getElementAndClick([requestType])
            setApportionment();
        },
        //vazio e nao apresentar aviso - preenchido apresentando aviso 
        //valor menor que 100% e nao apresentar aviso - valor igual a 100% e apresentar aviso
        'quoteRequest': (attributeValue) => {
            if (attributeValue === "true") {
                cy.log(attributeValue);
                cy.getElementAndCheck([{ element: quoteRequest },]);
            }
        },
        'serviceName': (attributeValue) => {
            handleRequestAttributes(attributeValue, [RequestType.oneOffService, RequestType.recurringService], (value) => {
                cy.getElementAndType({
                    [serviceNameString]: attributeValue,
                });
            });
        },
        //vazio e nao apresentar aviso - preenchido apresentando aviso 
        'costCenter': (attributeValue) => {
            cy.getElementAutocompleteTypeAndClick(
                { [costCenter]: attributeValue },
                highlightedOption
            );
        },
        //vazio e nao apresentar aviso - preenchido apresentando aviso 
        'acquiringArea': (attributeValue) => {
            cy.getElementAndCheck([{ element: attributeValue },]);
        },
        //vazio e nao apresentar aviso - preenchido apresentando aviso 
        'isComex': (attributeValue) => {
            cy.getElementAndCheck([{ element: attributeValue },]);
        },
        //vazio e nao apresentar aviso - preenchido apresentando aviso 
        'reasonForRequest': (attributeValue) => {
            cy.getElementAndType({
                [reasonForRequest]: attributeValue
            })
        },
        //vazio e nao apresentar aviso - preenchido apresentando aviso 
        'description': (attributeValue) => {
            handleRequestAttributes(attributeValue, [RequestType.oneOffService, RequestType.recurringService], (value) => {
                cy.getElementAndType({
                    [description]: attributeValue
                });
            });
        },
        //vazio e nao apresentar aviso - preenchido apresentando aviso 
        'desiredDeliveryDate': (attributeValue) => {
            cy.getElementAndType({
                [desiredDeliveryDate]: attributeValue
            })
        },
        //data menor que o dia atual e nao apresentar aviso
        'localDescription': (attributeValue) => {
            cy.getElementAndType({
                [localDescription]: attributeValue
            })
        },
        'suggestionLinks': (attributeValue) => {
            cy.getElementAndType({
                [suggestionLinksString]: attributeValue,
            });
        },
        'observation': (attributeValue) => {
            cy.getElementAndType({
                [observationString]: attributeValue,
            });
        },

        'typeOfPaymentAmount': (attributeValue) => {
            handleRequestAttributes(attributeValue, [RequestType.recurringService], (value) => {
                cy.getElementAndCheck([{ element: attributeValue },]);
            });
        },
        'paymentCondition': (attributeValue) => {
            cy.getElementAutocompleteTypeAndClick(
                { [paymentCondition]: attributeValue },
                highlightedOption);
        },
        'totalValue': (attributeValue) => {
            cy.getElementAndType({
                [totalValue]: attributeValue,
            });
        },
        'paymentMethod': (attributeValue) => {
            cy.getElementAutocompleteTypeAndClick(
                { [paymentMethod]: attributeValue },
                highlightedOption);
        },
        'paymentInstallments': (attributeValue) => {
            handleRequestAttributes(attributeValue, [RequestType.product, RequestType.oneOffService], (value) => {
                cy.getElementAndType({
                    [paymentInstallments]: attributeValue,
                })
            });
        },

        'initialPaymentEffectiveDate': (attributeValue) => {
            handleRequestAttributes(attributeValue, [RequestType.recurringService], (value) => {
                cy.getElementAndType({
                    [initialPaymentEffectiveDate]: attributeValue
                })
            });
        },
        'finalPaymentEffectiveDate': (attributeValue) => {
            handleRequestAttributes(attributeValue, [RequestType.recurringService], (value) => {
                cy.getElementAndType({
                    [finalPaymentEffectiveDate]: attributeValue
                })
            });
        },
        'paymentRecurrence': (attributeValue) => {
            handleRequestAttributes(attributeValue, [RequestType.recurringService], (value) => {
                cy.getElementAutocompleteTypeAndClick(
                    { [paymentRecurrence]: PaymentRecurrence.monthly },
                    highlightedOption);
            });
        },
        'paymentDueDate': (attributeValue) => {
            handleRequestAttributes(attributeValue, [RequestType.recurringService], (value) => {
                cy.getElementAutocompleteTypeAndClick(
                    { [paymentDueDate]: attributeValue },
                    highlightedOption);
            });
        },
        'paymentDetails': (attributeValue) => {
            cy.getElementAndType({
                [paymentDetails]: attributeValue,
            })
        },
        'supplier': (attributeValue) => {
            cy.getElementAutocompleteTypeAndClick({
                [SupplierElement[requestTypeString]]: attributeValue,
            },
                highlightedOption
            );
        },
        'category': (attributeValue) => {
            handleRequestAttributes(attributeValue, [RequestType.product], (value) => {
                cy.getElementAutocompleteTypeAndClick({
                    [category]: attributeValue,
                },
                    highlightedOption
                )
            });
        },
        'nameAndDescription': (attributeValue) => {
            handleRequestAttributes(attributeValue, [RequestType.product], (value) => {
                cy.getElementAndType({
                    [nameAndDescription]: attributeValue,
                });
            });
        },
        'quantity': (attributeValue) => {
            handleRequestAttributes(attributeValue, [RequestType.product], (value) => {
                cy.getElementAndType({
                    [quantity]: attributeValue,
                });
            });
        },
        'color': (attributeValue) => {
            handleRequestAttributes(attributeValue, [RequestType.product], (value) => {
                cy.getElementAndType({
                    [color]: attributeValue,
                });
            });
        },
        'size': (attributeValue) => {
            handleRequestAttributes(attributeValue, [RequestType.product], (value) => {
                cy.getElementAndType({
                    [size]: attributeValue,
                });
            });

        },
        'model': (attributeValue) => {
            handleRequestAttributes(attributeValue, [RequestType.product], (value) => {
                cy.getElementAndType({
                    [model]: attributeValue,
                });
            });
        },
        'link': (attributeValue) => {
            handleRequestAttributes(attributeValue, [RequestType.product], (value) => {
                cy.getElementAndType({
                    [link]: attributeValue,
                });
            });
        },
        'attachedFile': (attributeValue) => {
            cy.insertFile(attachedFile, attributeValue);
        },
        'seller': (attributeValue) => {
            handleRequestAttributes(attributeValue, [RequestType.oneOffService, RequestType.recurringService], (value) => {
                cy.getElementAndType({ [seller]: value });
            });
        },
        'sellerTelephone': (attributeValue) => {
            handleRequestAttributes(attributeValue, [RequestType.oneOffService, RequestType.recurringService], (value) => {
                cy.getElementAndType({ [telephone]: attributeValue });
            });
        },
        'sellerEmail': (attributeValue) => {
            handleRequestAttributes(attributeValue, [RequestType.oneOffService, RequestType.recurringService], (value) => {
                cy.getElementAndType({ [':nth-child(4) > .form-group > [data-cy="email"]']: attributeValue });
            });

        },
        'serviceAlreadyProvided': (attributeValue) => {
            handleRequestAttributes(attributeValue, [RequestType.oneOffService], (value) => {
                cy.getElementAndCheck([{ element: attributeValue },]);
            });
        },
        'isSaved': (attributeValue) => {
            cy.getElementAndClick([attributeValue])
            cy.log(isSaved);
            if (Object.values(SaveRequestSubmit).includes(isSaved)) {
                cy.wait(1000);
                cy.get(toAgreeModalSubmitRequest)
                    .should('be.visible')
                    .click({ force: true })
            };
        },
    });
});
