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
// /// <reference types="Cypress" />
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
    SaveRequestDraft,
    SaveRequestSubmit,
    isSaved,
    ValidationResult,
    Messages,
    CostCenter,
    AcquiringArea,
    PaymentCondition,
    PaymentMethod,
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
    errorMessageElementReasonForRequest,
    errorMessageElementLocalDescription,
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

function validateElement({ messageElement, elementValue, validationMessage, returnMessage1, returnMessage2, condition }) {
    const isFieldEmpty = !elementValue || elementValue.trim() === '';
    cy.get(messageElement).then(($messageElement) => {
        const isVisible = $messageElement.is(':visible');
        const textMatches = $messageElement.text().trim() === validationMessage.trim();

        if (isFieldEmpty) {
            if (isVisible && textMatches) {
                return;
            } else {
                return cy.wrap(returnMessage1);
            }
        } else {
            if (condition) {
                if (!isVisible || !textMatches) {
                    return cy.wrap(returnMessage1);
                }
            } else {
                if (isVisible && !textMatches) {
                    return cy.wrap(returnMessage2);
                }
            }
        }
    });
}

export function typeAndValidate(element, value, warningElement, validations) {
    cy.get(element)
        .type(value.toString())
        .then(($element) => {
            const elementValue = $element.val();
            validations.forEach(({ condition, message, successMessage, failureMessage, additionalCondition }) => {
                if (condition(elementValue)) {
                    validateElement({
                        messageElement: warningElement,
                        elementValue: elementValue,
                        validationMessage: message,
                        returnMessage1: successMessage,
                        returnMessage2: failureMessage,
                        condition: additionalCondition
                    });
                }
            });
        });
}


Cypress.Commands.add('createRequest', function (requestType: RequestType) {
    const MIN_PERCENTAGE = 1;
    const MAX_PERCENTAGE = 100;
    const MIN_VALUE = 1;

    function setApportionment() {
        const { apportionmentPercentage, apportionmentValue } = dataParameters.request;

        if (apportionmentPercentage && apportionmentPercentage.trim()) {
            typeAndValidate(apportionmentPercentageElement, apportionmentPercentage, firstWarningPercentageApportionment, [
                {
                    condition: val => !isNaN(Number(val)) && Number(val) >= MIN_PERCENTAGE && Number(val) <= MAX_PERCENTAGE,
                    message: Messages.validation.PERCENTAGE_SUM,
                    failureMessage: Messages.return.failure.SUM_PERCENTAGES_INCORRECT_BUT_NO_MESSAGE,
                    successMessage: Messages.return.success.PERCENTAGE_SUM_CORRECT,
                    additionalCondition: true
                },
                {
                    condition: val => Number(val) < MIN_PERCENTAGE,
                    message: Messages.validation.GREATER_THAN_ONE,
                    failureMessage: Messages.return.failure.VALUE_LESS_THAN_OR_EQUAL_TO_ZERO_BUT_NO_MESSAGE,
                    successMessage: Messages.return.success.FIELD_CORRECTLY_FILLED,
                    additionalCondition: false
                }
            ]);
        } else if (apportionmentValue && apportionmentValue.trim()) {
            typeAndValidate(apportionmentValueElement, apportionmentValue, firstWarningValueApportionment, [
                {
                    condition: val => isNaN(Number(val)),
                    message: Messages.validation.VALID_VALUE,
                    failureMessage: Messages.return.failure.DIFFERENT_VALUE_THAN_NUMBER_BUT_NO_MESSAGE,
                    successMessage: Messages.return.success.FIELD_CORRECTLY_FILLED,
                    additionalCondition: false
                },
                {
                    condition: val => !isNaN(Number(val)) && Number(val) < MIN_VALUE,
                    message: Messages.validation.GREATER_THAN_ONE,
                    failureMessage: Messages.return.failure.VALUE_LESS_THAN_OR_EQUAL_TO_ZERO_BUT_NO_MESSAGE,
                    successMessage: Messages.return.success.FIELD_CORRECTLY_FILLED,
                    additionalCondition: false
                }
            ]);
        }
        return cy.wrap({ success: "Os avisos de obrigatoriedade são exibidos quando os campos não são preenchidos e quando são preenchidos incorretamente. Um aviso é exibido quando a porcentagem é menor que 100. Além disso, um aviso é exibido quando a porcentagem é preenchida com um valor menor ou igual a zero." });
    }



    processAttribute({
        requestType: (attributeValue) => {
            cy.getElementAndClick([requestType])
            setApportionment();
        },
        'costCenter': (attributeValue) => {
            cy.getElementAutocompleteTypeAndClick(
                { [costCenter]: attributeValue },
                highlightedOption
            );
        },
        'quoteRequest': (attributeValue) => {
            if (attributeValue === "true") {
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

        'acquiringArea': (attributeValue) => {
            cy.getElementAndCheck([{ element: attributeValue },]);
        },

        'isComex': (attributeValue) => {
            cy.getElementAndCheck([{ element: attributeValue },]);
        },

        'reasonForRequest': (attributeValue) => {
            const MIN_LENGTH_FOR_REASON = 20;
            const EMPTY_LENGTH = 0;
            const validationsForReasonForRequest = [
                {
                    condition: (elementValue) => elementValue.trim().length === EMPTY_LENGTH,
                    message: 'Este campo é obrigatório.',
                    successMessage: 'Campo não preenchido e aviso apresentado:',
                    failureMessage: 'Campo não preenchido e aviso não apresentado: Erro',
                    additionalCondition: false
                },
                {
                    condition: (elementValue) => {
                        const trimmedLength = elementValue.trim().length;
                        return trimmedLength >= 1 && trimmedLength < MIN_LENGTH_FOR_REASON;
                    },
                    message: `Por favor, forneça ao menos ${MIN_LENGTH_FOR_REASON} caracteres.`,
                    successMessage: 'Campo preenchido com menos de 20 caracteres e aviso apresentado:',
                    failureMessage: 'Campo preenchido com menos de 20 caracteres e aviso não apresentado: Erro',
                    additionalCondition: false
                }
            ];
            typeAndValidate(reasonForRequest, attributeValue, errorMessageElementReasonForRequest, validationsForReasonForRequest);
        },

        'description': (attributeValue) => {
            handleRequestAttributes(attributeValue, [RequestType.oneOffService, RequestType.recurringService], (value) => {
                cy.getElementAndType({
                    [description]: attributeValue
                });
            });
        },

        'desiredDeliveryDate': (attributeValue) => {
            cy.getElementAndType({
                [desiredDeliveryDate]: attributeValue
            })
        },

        'localDescription': (attributeValue) => {
            const validationsForLocalDescription = [
                {
                    condition: (elementValue) => !elementValue || elementValue.trim().length === 0,
                    message: Messages.validation.REQUIRE_FIELD,
                    successMessage: Messages.return.success.FIELD_CORRECTLY_FILLED,
                    failureMessage: Messages.return.failure.FIELD_NOT_FILLED_BUT_NO_MESSAGE,
                    additionalCondition: false
                },
                {
                    condition: (elementValue) => {
                        const trimmedLength = elementValue.trim().length;
                        return trimmedLength > 0 && trimmedLength < 2;
                    },
                    message: Messages.validation.MIN_TWO_CHARACTERS,
                    successMessage: Messages.return.success.FIELD_CORRECTLY_FILLED,
                    failureMessage: Messages.return.failure.FIELD_FILLED_BUT_MESSAGE_DISPLAYED,
                    additionalCondition: false
                }
            ];
            typeAndValidate(localDescription, attributeValue, errorMessageElementLocalDescription, validationsForLocalDescription);
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
                ['.select-supplier-container > .select2 > .selection > .select2-selection']: attributeValue,
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
        //vazio e nao apresentar aviso - preenchido apresentando aviso 
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
            if (Object.values(SaveRequestSubmit).includes(isSaved)) {
                cy.wait(1000);
                cy.waitUntil(() => cy.get(toAgreeModalSubmitRequest).should('be.visible'), {
                    errorMsg: 'Modal de confirmação não apareceu',
                    timeout: 10000,
                    interval: 500
                }).click()

                cy.waitUntil(() =>
                    cy.url().then(url => url.includes('/requests/own'))
                )
            };
        }
    });
    return cy.wrap({ success: "Processo realizado com sucesso!" });
});
