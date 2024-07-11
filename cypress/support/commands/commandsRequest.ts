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




// Cypress.Commands.add('createRequest', function (requestType: RequestType) {

//     function setApportionment() {
//         const { apportionmentPercentage, apportionmentValue } = dataParameters.request;

//         function typeAndValidate(element, value, warningElement, validations) {
//             cy.get(element)
//                 .type(value.toString())
//                 .then(($element) => {
//                     const $messageModal = Cypress.$(warningElement);
//                     validations.forEach(validation => {
//                         if (validation.condition($element.val())) {
//                             validateElement(
//                                 warningElement,
//                                 $element.val(),
//                                 validation.message,
//                                 validation.successMessage,
//                                 validation.failureMessage,
//                                 validation.additionalCondition
//                             );
//                         }
//                     });
//                     if (isNaN(Number($element.val())) && !$messageModal.is(':visible') && $messageModal.text() === Messages.validationMessages.VALID_VALUE) {
//                         throw new Error(Messages.returnMessages.differentValueOfNumbersMessageNotDisplayed)
//                     }
//                 });
//         }

//         if (apportionmentValue && apportionmentValue.trim()) {
//             typeAndValidate(apportionmentValueElement, apportionmentValue, firstWarningValueApportionment, [
//                 {
//                     condition: val => val === 'e' || val === '-',
//                     message: Messages.validationMessages.REQUIRE_FIELD,
//                     successMessage: Messages.returnMessages.fieldFilledAndMessageDisplayed,
//                     failureMessage: Messages.returnMessages.fieldNotFilledAndMessageNotDisplayed,
//                     additionalCondition: true
//                 }
//             ]);
//         } else if (apportionmentPercentage && apportionmentPercentage.trim()) {
//             typeAndValidate(apportionmentPercentageElement, apportionmentPercentage, firstWarningPercentageApportionment, [
//                 {
//                     condition: val => !isNaN(Number(val)) && Number(val) >= 1,
//                     message: Messages.validationMessages.PERCENTAGEM_SUM,
//                     successMessage: Messages.returnMessages.sumPercentagesIncorrectAndMessageNotDisplayed,
//                     failureMessage: Messages.returnMessages.sumPercentagesCorrectAndMessageDisplayed,
//                     additionalCondition: val => Number(val) < 100
//                 },
//                 {
//                     condition: val => Number(val) <= 0,
//                     message: Messages.validationMessages.GREATER_THAN_ONE,
//                     successMessage: Messages.returnMessages.valueLessThanOrEqualToZeroAndMessageNotDisplayed,
//                     failureMessage: Messages.returnMessages.valueGreaterOrThanEqualToZeroMessageNotDisplayed,
//                     additionalCondition: true
//                 }
//             ]);
//         }

//         return cy.wrap({ success: "Os avisos de obrigatoriedade são exibidos quando os campos não são preenchidos e quando são preenchidos incorretamente. Um aviso é exibido quando a porcentagem é menor que 100. Além disso, um aviso é exibido quando a porcentagem é preenchida com um valor menor ou igual a zero." });
//     }

//     processAttribute({
//         requestType: (attributeValue) => {
//             cy.getElementAndClick([requestType])
//             setApportionment();
//         },
//         'quoteRequest': (attributeValue) => {
//             if (attributeValue === "true") {
//                 cy.getElementAndCheck([{ element: quoteRequest },]);
//             }
//         },
//         'serviceName': (attributeValue) => {
//             handleRequestAttributes(attributeValue, [RequestType.oneOffService, RequestType.recurringService], (value) => {
//                 cy.getElementAndType({
//                     [serviceNameString]: attributeValue,
//                 });
//             });
//         },
//         //vazio e nao apresentar aviso - preenchido apresentando aviso 
//         'costCenter': (attributeValue) => {
//             cy.getElementAutocompleteTypeAndClick(
//                 { [costCenter]: attributeValue },
//                 highlightedOption
//             );
//         },
//         // //vazio e nao apresentar aviso - preenchido apresentando aviso 
//         'acquiringArea': (attributeValue) => {
//             cy.getElementAndCheck([{ element: attributeValue },]);
//         },
//         //vazio e nao apresentar aviso - preenchido apresentando aviso 
//         'isComex': (attributeValue) => {
//             cy.getElementAndCheck([{ element: attributeValue },]);
//         },
//         // //vazio e nao apresentar aviso - preenchido apresentando aviso 
//         'reasonForRequest': (attributeValue) => {
//             cy.getElementAndType({
//                 [reasonForRequest]: attributeValue
//             })
//         },
//         //vazio e nao apresentar aviso - preenchido apresentando aviso
//         //texto menor que 20 caracteres
//         'description': (attributeValue) => {
//             handleRequestAttributes(attributeValue, [RequestType.oneOffService, RequestType.recurringService], (value) => {
//                 cy.getElementAndType({
//                     [description]: attributeValue
//                 });
//             });
//         },
//         //vazio e nao apresentar aviso - preenchido apresentando aviso
//         //menor que 2 caracteres
//         'desiredDeliveryDate': (attributeValue) => {
//             cy.getElementAndType({
//                 [desiredDeliveryDate]: attributeValue
//             })
//         },
//         // //data menor que o dia atual e nao apresentar aviso
//         'localDescription': (attributeValue) => {
//             cy.getElementAndType({
//                 [localDescription]: attributeValue
//             })
//         },
//         'suggestionLinks': (attributeValue) => {
//             cy.getElementAndType({
//                 [suggestionLinksString]: attributeValue,
//             });
//         },
//         'observation': (attributeValue) => {
//             cy.getElementAndType({
//                 [observationString]: attributeValue,
//             });
//         },

//         'typeOfPaymentAmount': (attributeValue) => {
//             handleRequestAttributes(attributeValue, [RequestType.recurringService], (value) => {
//                 cy.getElementAndCheck([{ element: attributeValue },]);
//             });
//         },
//         'paymentCondition': (attributeValue) => {
//             cy.getElementAutocompleteTypeAndClick(
//                 { [paymentCondition]: attributeValue },
//                 highlightedOption);
//         },
//         'totalValue': (attributeValue) => {
//             cy.getElementAndType({
//                 [totalValue]: attributeValue,
//             });
//         },
//         'paymentMethod': (attributeValue) => {
//             cy.getElementAutocompleteTypeAndClick(
//                 { [paymentMethod]: attributeValue },
//                 highlightedOption);
//         },
//         'paymentInstallments': (attributeValue) => {
//             handleRequestAttributes(attributeValue, [RequestType.product, RequestType.oneOffService], (value) => {
//                 cy.getElementAndType({
//                     [paymentInstallments]: attributeValue,
//                 })
//             });
//         },

//         'initialPaymentEffectiveDate': (attributeValue) => {
//             handleRequestAttributes(attributeValue, [RequestType.recurringService], (value) => {
//                 cy.getElementAndType({
//                     [initialPaymentEffectiveDate]: attributeValue
//                 })
//             });
//         },
//         'finalPaymentEffectiveDate': (attributeValue) => {
//             handleRequestAttributes(attributeValue, [RequestType.recurringService], (value) => {
//                 cy.getElementAndType({
//                     [finalPaymentEffectiveDate]: attributeValue
//                 })
//             });
//         },
//         'paymentRecurrence': (attributeValue) => {
//             handleRequestAttributes(attributeValue, [RequestType.recurringService], (value) => {
//                 cy.getElementAutocompleteTypeAndClick(
//                     { [paymentRecurrence]: PaymentRecurrence.monthly },
//                     highlightedOption);
//             });
//         },
//         'paymentDueDate': (attributeValue) => {
//             handleRequestAttributes(attributeValue, [RequestType.recurringService], (value) => {
//                 cy.getElementAutocompleteTypeAndClick(
//                     { [paymentDueDate]: attributeValue },
//                     highlightedOption);
//             });
//         },
//         'paymentDetails': (attributeValue) => {
//             cy.getElementAndType({
//                 [paymentDetails]: attributeValue,
//             })

//         },
//         'supplier': (attributeValue) => {
//             cy.getElementAutocompleteTypeAndClick({
//                 ['.select-supplier-container > .select2 > .selection > .select2-selection']: attributeValue,
//             },
//                 highlightedOption
//             );
//         },
//         'category': (attributeValue) => {
//             handleRequestAttributes(attributeValue, [RequestType.product], (value) => {
//                 cy.getElementAutocompleteTypeAndClick({
//                     [category]: attributeValue,
//                 },
//                     highlightedOption
//                 )
//             });
//         },
//         //vazio e nao apresentar aviso - preenchido apresentando aviso 
//         'nameAndDescription': (attributeValue) => {
//             handleRequestAttributes(attributeValue, [RequestType.product], (value) => {
//                 cy.getElementAndType({
//                     [nameAndDescription]: attributeValue,
//                 });
//             });
//         },
//         //vazio e nao apresentar aviso - preenchido apresentando aviso 
//         'quantity': (attributeValue) => {
//             handleRequestAttributes(attributeValue, [RequestType.product], (value) => {
//                 cy.getElementAndType({
//                     [quantity]: attributeValue,
//                 });
//             });
//         },
//         //vazio e nao apresentar aviso - preenchido apresentando aviso 
//         'color': (attributeValue) => {
//             handleRequestAttributes(attributeValue, [RequestType.product], (value) => {
//                 cy.getElementAndType({
//                     [color]: attributeValue,
//                 });
//             });
//         },
//         'size': (attributeValue) => {
//             handleRequestAttributes(attributeValue, [RequestType.product], (value) => {
//                 cy.getElementAndType({
//                     [size]: attributeValue,
//                 });
//             });

//         },
//         'model': (attributeValue) => {
//             handleRequestAttributes(attributeValue, [RequestType.product], (value) => {
//                 cy.getElementAndType({
//                     [model]: attributeValue,
//                 });
//             });
//         },
//         'link': (attributeValue) => {
//             handleRequestAttributes(attributeValue, [RequestType.product], (value) => {
//                 cy.getElementAndType({
//                     [link]: attributeValue,
//                 });
//             });
//         },
//         //nao e url
//         'attachedFile': (attributeValue) => {
//             cy.insertFile(attachedFile, attributeValue);
//         },
//         'seller': (attributeValue) => {
//             handleRequestAttributes(attributeValue, [RequestType.oneOffService, RequestType.recurringService], (value) => {
//                 cy.getElementAndType({ [seller]: value });
//             });
//         },
//         'sellerTelephone': (attributeValue) => {
//             handleRequestAttributes(attributeValue, [RequestType.oneOffService, RequestType.recurringService], (value) => {
//                 cy.getElementAndType({ [telephone]: attributeValue });
//             });
//         },
//         'sellerEmail': (attributeValue) => {
//             handleRequestAttributes(attributeValue, [RequestType.oneOffService, RequestType.recurringService], (value) => {
//                 cy.getElementAndType({ [':nth-child(4) > .form-group > [data-cy="email"]']: attributeValue });
//             });

//         },
//         'serviceAlreadyProvided': (attributeValue) => {
//             handleRequestAttributes(attributeValue, [RequestType.oneOffService], (value) => {
//                 cy.getElementAndCheck([{ element: attributeValue },]);
//             });
//         },
//         'isSaved': (attributeValue) => {
//             cy.getElementAndClick([attributeValue]);
//         },
//     });
//     cy.getElementAndClick([toAgreeModalSubmitRequest])

//     return cy.wrap({ success: "Processo realizado com sucesso!" });
// });

// Custom command to log in and get CSRF token
Cypress.Commands.add('loginAndGetCsrfToken', () => {
    cy.request('GET', '/login')
        .then((response) => {
            const $html = Cypress.$(response.body);
            const csrfToken = $html.find('input[name=_token]').val();
            cy.wrap(csrfToken).as('csrfToken'); // Armazena o token como um alias para uso posterior
        });
});

Cypress.Commands.add('createRequest', function (requestType: RequestType) {
   

    
        cy.getElementAndClick([productRequest]);

        cy.getElementAutocompleteTypeAndClick(
            { [costCenter]: CostCenter['06.354.562/0001-10 - HKM - Software e Sistemas'] },
            highlightedOption
        );

        cy.getElementAndType({
            [apportionmentPercentageElement]: '100',
        });

        cy.getElementAndCheck([{ element: AcquiringArea.areaContract },]);

        cy.getElementAndCheck([{ element: IsComexImportProduct.no },]);

        cy.getElementAndType({ [reasonForRequest]: faker.lorem.lines(1) })

        cy.getElementAndType({
            [desiredDeliveryDate]: new Date().toISOString().split('T')[0]
        })

        cy.getElementAndType({
            [localDescription]: faker.lorem.lines(1)
        })

        cy.getElementAndType({
            [suggestionLinksString]: faker.internet.url(),
        });

        cy.getElementAndType({
            [observationString]: faker.lorem.lines(1),
        });

        cy.getElementAutocompleteTypeAndClick(
            { [paymentCondition]: PaymentCondition.cashPayment },
            highlightedOption);

        cy.getElementAndType({
            [totalValue]: faker.helpers.arrayElement(['1750.85']),
        });

        cy.getElementAutocompleteTypeAndClick(
            { [paymentMethod]: PaymentMethod.pix },
            highlightedOption);

        cy.getElementAndType({
            ['[style="margin-bottom: -50;"] > .col-sm-1 > .form-group > .form-control']: '2',
        })


        cy.getElementAndType({
            [paymentDetails]: faker.lorem.lines(1),
        })

        cy.getElementAutocompleteTypeAndClick({
            ['.select-supplier-container > .select2 > .selection > .select2-selection']: SupplierOfRequest['00.020.788/0001-06  - MADER COMERCIAL IMPORTADORA QUIM.FARMACEUTICA LTDA'],
        },
            highlightedOption
        );

        cy.getElementAutocompleteTypeAndClick({
            [category]: ProductCategory['Brinde - Mercadoria distribuida gratuitamente para nossos clientes e que não podemos vender. Ex. Toalha, Necessaire, etc...'],
        },
            highlightedOption
        );

        cy.getElementAndType({
            [nameAndDescription]: faker.lorem.lines(1)
        });

        cy.getElementAndType({
            [quantity]: faker.helpers.arrayElement(['3']),
        });

        cy.getElementAndType({
            [color]: faker.helpers.arrayElement(['red', 'blue', 'green', 'yellow']),
        });

        cy.getElementAndType({
            [size]: faker.helpers.arrayElement(['P', 'M', 'G', 'GG']),
        });

        cy.getElementAndType({
            [model]: faker.helpers.arrayElement(['BASIC', 'ADVANCED']),
        });

        cy.getElementAndType({
            [link]: faker.internet.url(),
        });

       

        cy.get(SaveRequestSubmit.product).click().then(() => {
            cy.log('Clique no botão de salvar realizado');
        });

        cy.wait(3000);

        cy.get(toAgreeModalSubmitRequest).click().then(() => {
            cy.log('Clique no modal de confirmação realizado');
        });

        cy.url().should('include', '/requests/own');
        cy.get('[id="status-filter-btn"]').should('exist');

    
});