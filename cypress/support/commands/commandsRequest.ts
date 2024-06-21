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
    ValidationResult,
    Messages,
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
    firstWarningPercentageApportionment,
    secondWarningPercentageApportionment,
    firstWarningValueApportionment,
    secondWarningValueApportionment,
    productRequest,
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
};
function handleRequestAttributes(attributeValue: string, types: RequestType[], action: (value: string) => void) {
    if (types.includes(requestTyper)) {
        action(attributeValue);
    }
};

function validateElement(messageElement, elementValue, validationMessage, returnMessage1, returnMessage2, condition) {
    cy.get(messageElement).then(($messageElement) => {
        if (condition && $messageElement.is(':visible') && $messageElement.text() === validationMessage) {
            throw new Error(returnMessage1);
        } else if (!condition && !$messageElement.is(':visible')) {
            throw new Error(returnMessage2);
        }
    });
};


Cypress.Commands.add('createRequest', () => {
    cy.getElementAndClick([dataParameters.request.requestType])
})

/*
=>porcentagem
--------
valor inserido => -
mensagem => Por favor, forneça um número válido. 
elemento => #cost_center_apportionments\[0\]\[apportionment_percentage\]-error
--------
valor inserido => >=1 e <=99
mensagem =>A soma da porcentagem deve ser 100%.
elemento =>#request-form > div:nth-child(6) > div:nth-child(3) > span
--------
valor inserido => <=0
mensagem => Por favor, forneça um valor maior ou igual a 1.
elemento => #cost_center_apportionments\[0\]\[apportionment_percentage\]-error

mensagem => A soma da porcentagem deve ser 100%.
elemento => #request-form > div:nth-child(6) > div:nth-child(3) > span
--------



=>valor
--------
valor inserido => -
mensagem => Por favor, forneça um número válido.
elemento => #cost_center_apportionments\[0\]\[apportionment_currency\]-error
--------
valor inserido => <=0
mensagem => Por favor, forneça um valor maior ou igual a 1.
elemento => #cost_center_apportionments\[0\]\[apportionment_currency\]-error

mensagem => Todos campos de rateio (R$) devem ser preenchidos.
elemento => #request-form > div:nth-child(6) > div:nth-child(4) > span
--------
*/