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


Cypress.Commands.add('createRequest', function (requestType: string) {

    function setApportionment() {
        const { apportionmentPercentage, apportionmentValue } = dataParameters.request;

        if (apportionmentValue && apportionmentValue !== " ") {
            cy.get(apportionmentValueElement)
                .type(apportionmentValue.toString())
                .then(($element) => {
                    const $messageModal = Cypress.$(firstWarningValueApportionment);
                    if (isNaN(Number($element.val())) && !$messageModal.is(':visible') && $messageModal.text() === Messages.validationMessages.VALID_VALUE) {
                        throw new Error(Messages.returnMessages.differentValueOfNumbersMessageNotDisplayed)
                    } 
                    validateElement(
                        firstWarningValueApportionment,
                        $element.val(),
                        Messages.validationMessages.VALID_VALUE,
                        Messages.returnMessages.fieldFilledAndMessageDisplayed,
                        Messages.returnMessages.fieldNotFilledAndMessageNotDisplayed,
                        $element.val() === 'e' || $element.val() === '-'
                    );
                    validateElement(
                        firstWarningValueApportionment,
                        $element.val(),
                        Messages.validationMessages.REQUIRE_FIELD,
                        Messages.returnMessages.fieldFilledAndMessageDisplayed,
                        Messages.returnMessages.fieldNotFilledAndMessageNotDisplayed,
                        $element.val() === ''
                    );
                })
        }
        if (apportionmentPercentage && apportionmentPercentage !== " ") {
            cy.get(apportionmentPercentageElement)
                .type(apportionmentPercentage.toString())
                .then(($elementValue) => {
                    const $messageModal = Cypress.$(firstWarningValueApportionment);
                    if (isNaN(Number($elementValue.val())) && !$messageModal.is(':visible') && $messageModal.text() === Messages.validationMessages.VALID_VALUE) {
                        throw new Error(Messages.returnMessages.differentValueOfNumbersMessageNotDisplayed)
                    } 
                    validateElement(
                        firstWarningPercentageApportionment,
                        $elementValue.val(),
                        Messages.validationMessages.REQUIRE_FIELD,
                        Messages.returnMessages.fieldFilledAndMessageDisplayed,
                        Messages.returnMessages.fieldNotFilledAndMessageNotDisplayed,
                        $elementValue.val() !== ''
                    );
                    // if((Number($elementValue.val().toString()) >= 1)){
                    //     validateElement(
                    //         firstWarningPercentageApportionment,
                    //         Number($elementValue.val().toString()),
                    //         Messages.validationMessages.PERCENTAGEM_SUM,
                    //         Messages.returnMessages.sumPercentagesIncorrectAndMessageNotDisplayed,
                    //         Messages.returnMessages.sumPercentagesCorrectAndMessageDisplayed,
                    //         Number($elementValue.val().toString()) < 100
                    //     );
                    // }
                    // if((Number($elementValue.val().toString()) >= 1)){
                    //     validateElement(
                    //         secondWarningPercentageApportionment,
                    //         Number($elementValue.val().toString()),
                    //         Messages.validationMessages.PERCENTAGEM_SUM,
                    //         Messages.returnMessages.sumPercentagesIncorrectAndMessageNotDisplayed,
                    //         Messages.returnMessages.sumPercentagesCorrectAndMessageDisplayed,
                    //         Number($elementValue.val().toString()) < 100
                    //     );
                    // }
                    validateElement(
                        firstWarningPercentageApportionment,
                        Number($elementValue.val().toString()),
                        Messages.validationMessages.GREATER_THAN_ONE,
                        Messages.returnMessages.valueLessThanOrEqualToZeroAndMessageNotDisplayed,
                        Messages.returnMessages.valueGreaterOrThanEqualToZeroMessageNotDisplayed,
                        Number($elementValue.val().toString()) <= 0
                    );
                })
        }
        return cy.wrap({ success: "Os avisos de obrigatoriedade são exibidos quando os campos não são preenchidos e quando são preenchidos incorretamente. Um aviso é exibido quando a porcentagem é menor que 100. Além disso, um aviso é exibido quando a porcentagem é preenchida com um valor menor ou igual a zero." });
    }
    cy.getElementAndClick([':nth-child(1) > .request-dashboard-requests-item-btn'])
    // processAttribute({
    //     requestType: (attributeValue) => {
    //         cy.getElementAndClick([':nth-child(1) > .request-dashboard-requests-item-btn'])
            // setApportionment();
        // },
    //     'quoteRequest': (attributeValue) => {
    //         if (attributeValue === "true") {
    //             cy.getElementAndCheck([{ element: quoteRequest },]);
    //         }
    //     },
    //     'serviceName': (attributeValue) => {
    //         handleRequestAttributes(attributeValue, [RequestType.oneOffService, RequestType.recurringService], (value) => {
    //             cy.getElementAndType({
    //                 [serviceNameString]: attributeValue,
    //             });
    //         });
    //     },
    //     //vazio e nao apresentar aviso - preenchido apresentando aviso 
    //     'costCenter': (attributeValue) => {
    //         cy.getElementAutocompleteTypeAndClick(
    //             { [costCenter]: attributeValue },
    //             highlightedOption
    //         );
    //     },
    //     // //vazio e nao apresentar aviso - preenchido apresentando aviso 
    //     'acquiringArea': (attributeValue) => {
    //         cy.getElementAndCheck([{ element: attributeValue },]);
    //     },
    //     //vazio e nao apresentar aviso - preenchido apresentando aviso 
    //     'isComex': (attributeValue) => {
    //         cy.getElementAndCheck([{ element: attributeValue },]);
    //     },
    //     // //vazio e nao apresentar aviso - preenchido apresentando aviso 
    //     'reasonForRequest': (attributeValue) => {
    //         cy.getElementAndType({
    //             [reasonForRequest]: attributeValue
    //         })
    //     },
    //     // //vazio e nao apresentar aviso - preenchido apresentando aviso
    //     // //texto menor que 20 caracteres
    //     'description': (attributeValue) => {
    //         handleRequestAttributes(attributeValue, [RequestType.oneOffService, RequestType.recurringService], (value) => {
    //             cy.getElementAndType({
    //                 [description]: attributeValue
    //             });
    //         });
    //     },
    //     // //vazio e nao apresentar aviso - preenchido apresentando aviso
    //     // //menor que 2 caracteres
    //     'desiredDeliveryDate': (attributeValue) => {
    //         cy.getElementAndType({
    //             [desiredDeliveryDate]: attributeValue
    //         })
    //     },
    //     // //data menor que o dia atual e nao apresentar aviso
    //     'localDescription': (attributeValue) => {
    //         cy.getElementAndType({
    //             [localDescription]: attributeValue
    //         })
    //     },
    //     'suggestionLinks': (attributeValue) => {
    //         cy.getElementAndType({
    //             [suggestionLinksString]: attributeValue,
    //         });
    //     },
    //     'observation': (attributeValue) => {
    //         cy.getElementAndType({
    //             [observationString]: attributeValue,
    //         });
    //     },

    //     'typeOfPaymentAmount': (attributeValue) => {
    //         handleRequestAttributes(attributeValue, [RequestType.recurringService], (value) => {
    //             cy.getElementAndCheck([{ element: attributeValue },]);
    //         });
    //     },
    //     'paymentCondition': (attributeValue) => {
    //         cy.getElementAutocompleteTypeAndClick(
    //             { [paymentCondition]: attributeValue },
    //             highlightedOption);
    //     },
    //     'totalValue': (attributeValue) => {
    //         cy.getElementAndType({
    //             [totalValue]: attributeValue,
    //         });
    //     },
    //     'paymentMethod': (attributeValue) => {
    //         cy.getElementAutocompleteTypeAndClick(
    //             { [paymentMethod]: attributeValue },
    //             highlightedOption);
    //     },
    //     'paymentInstallments': (attributeValue) => {
    //         handleRequestAttributes(attributeValue, [RequestType.product, RequestType.oneOffService], (value) => {
    //             cy.getElementAndType({
    //                 [paymentInstallments]: attributeValue,
    //             })
    //         });
    //     },

    //     'initialPaymentEffectiveDate': (attributeValue) => {
    //         handleRequestAttributes(attributeValue, [RequestType.recurringService], (value) => {
    //             cy.getElementAndType({
    //                 [initialPaymentEffectiveDate]: attributeValue
    //             })
    //         });
    //     },
    //     'finalPaymentEffectiveDate': (attributeValue) => {
    //         handleRequestAttributes(attributeValue, [RequestType.recurringService], (value) => {
    //             cy.getElementAndType({
    //                 [finalPaymentEffectiveDate]: attributeValue
    //             })
    //         });
    //     },
    //     'paymentRecurrence': (attributeValue) => {
    //         handleRequestAttributes(attributeValue, [RequestType.recurringService], (value) => {
    //             cy.getElementAutocompleteTypeAndClick(
    //                 { [paymentRecurrence]: PaymentRecurrence.monthly },
    //                 highlightedOption);
    //         });
    //     },
    //     'paymentDueDate': (attributeValue) => {
    //         handleRequestAttributes(attributeValue, [RequestType.recurringService], (value) => {
    //             cy.getElementAutocompleteTypeAndClick(
    //                 { [paymentDueDate]: attributeValue },
    //                 highlightedOption);
    //         });
    //     },
    //     'paymentDetails': (attributeValue) => {
    //         cy.getElementAndType({
    //             [paymentDetails]: attributeValue,
    //         })
    //         cy.pause();
    //     },
    //     'supplier': (attributeValue) => {
    //         cy.getElementAutocompleteTypeAndClick({
    //             ['.select-supplier-container > .select2 > .selection > .select2-selection']: attributeValue,
    //         },
    //             highlightedOption
    //         );
    //     },
    //     'category': (attributeValue) => {
    //         handleRequestAttributes(attributeValue, [RequestType.product], (value) => {
    //             cy.getElementAutocompleteTypeAndClick({
    //                 [category]: attributeValue,
    //             },
    //                 highlightedOption
    //             )
    //         });
    //     },
    //     //vazio e nao apresentar aviso - preenchido apresentando aviso 
    //     'nameAndDescription': (attributeValue) => {
    //         handleRequestAttributes(attributeValue, [RequestType.product], (value) => {
    //             cy.getElementAndType({
    //                 [nameAndDescription]: attributeValue,
    //             });
    //         });
    //     },
    //     //vazio e nao apresentar aviso - preenchido apresentando aviso 
    //     'quantity': (attributeValue) => {
    //         handleRequestAttributes(attributeValue, [RequestType.product], (value) => {
    //             cy.getElementAndType({
    //                 [quantity]: attributeValue,
    //             });
    //         });
    //     },
    //     //vazio e nao apresentar aviso - preenchido apresentando aviso 
    //     'color': (attributeValue) => {
    //         handleRequestAttributes(attributeValue, [RequestType.product], (value) => {
    //             cy.getElementAndType({
    //                 [color]: attributeValue,
    //             });
    //         });
    //     },
    //     'size': (attributeValue) => {
    //         handleRequestAttributes(attributeValue, [RequestType.product], (value) => {
    //             cy.getElementAndType({
    //                 [size]: attributeValue,
    //             });
    //         });

    //     },
    //     'model': (attributeValue) => {
    //         handleRequestAttributes(attributeValue, [RequestType.product], (value) => {
    //             cy.getElementAndType({
    //                 [model]: attributeValue,
    //             });
    //         });
    //     },
    //     'link': (attributeValue) => {
    //         handleRequestAttributes(attributeValue, [RequestType.product], (value) => {
    //             cy.getElementAndType({
    //                 [link]: attributeValue,
    //             });
    //         });
    //     },
    //     //nao e url
    //     'attachedFile': (attributeValue) => {
    //         cy.insertFile(attachedFile, attributeValue);
    //     },
    //     // 'seller': (attributeValue) => {
    //     //     handleRequestAttributes(attributeValue, [RequestType.oneOffService, RequestType.recurringService], (value) => {
    //     //         cy.getElementAndType({ [seller]: value });
    //     //     });
    //     // },
    //     // 'sellerTelephone': (attributeValue) => {
    //     //     handleRequestAttributes(attributeValue, [RequestType.oneOffService, RequestType.recurringService], (value) => {
    //     //         cy.getElementAndType({ [telephone]: attributeValue });
    //     //     });
    //     // },
    //     // 'sellerEmail': (attributeValue) => {
    //     //     handleRequestAttributes(attributeValue, [RequestType.oneOffService, RequestType.recurringService], (value) => {
    //     //         cy.getElementAndType({ [':nth-child(4) > .form-group > [data-cy="email"]']: attributeValue });
    //     //     });

    //     // },
    //     'serviceAlreadyProvided': (attributeValue) => {
    //         handleRequestAttributes(attributeValue, [RequestType.oneOffService], (value) => {
    //             cy.getElementAndCheck([{ element: attributeValue },]);
    //         });
    //     },
    //     'isSaved': (attributeValue) => {
    //         cy.getElementAndClick([attributeValue])
    //         if (Object.values(SaveRequestSubmit).includes(isSaved)) {
    //             cy.wait(1000);
    //             cy.get(toAgreeModalSubmitRequest)
    //                 .should('be.visible')
    //                 .click({ force: true })
    //         };
    //     },
    });
    // return cy.wrap({ success: "Processo realizado com sucesso!" });
// });


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