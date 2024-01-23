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



import { elements as el } from '../../elements'
import { dataParameters } from '../../DataParameters'

import '../commands/commandsLogin';
import './commandsUserRegistration';
import './commandsStart';


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
    messageContainerIncorrectData,
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



Cypress.Commands.add('insertFile', (filePath, element): void => {
    cy.fixture(filePath, 'base64').then((conteudo_arquivo) => {
        const nome = filePath.split('/').pop(); // Extract the file name from the fixture path
        const mimeType = 'image/jpeg';

        const blob = Cypress.Blob.base64StringToBlob(conteudo_arquivo, mimeType);
        const file = new File([blob], nome, { type: mimeType });

        cy.get(element).then(($element) => {
            const event = new Event('change', { bubbles: true });
            Object.defineProperty($element[0], 'files', {
                value: [file],
                writable: false,
            });
            $element[0].dispatchEvent(event);
        });
    });
});


Cypress.Commands.add('readFile', (fileName) => {
    const caminhoArquivo = `${dataParameters.filePath}${fileName}`;
    return cy.fixture(caminhoArquivo);
});

Cypress.Commands.add('getElementAndClick', (...elements: string[]): void => {
    cy.wrap(null).then(() => {
        elements.forEach(element => {
            cy.get(element, { timeout: 20000 })
                .each(($input) => {
                    cy.wrap($input)
                        .then($elements => {

                            if ($elements.length > 0) {
                                cy.wrap($elements.first())
                                    .click({ timeout: 20000, force: true });
                            } else {
                                cy.wrap($elements.eq(0))
                                    .click({ timeout: 20000, force: true });
                            }

                        });
                })
        })
    })
});

Cypress.Commands.add('getElementAndCheck', (element: string): void => {
    cy.wrap(null).then(() => {
        cy.get(element, { timeout: 20000 })
            .as('element')
            .each(($element) => {
                cy.wrap($element)
                    .then($elements => {
                        cy.get('@element')

                        if ($elements.length > 0) {
                            cy.wrap($elements.first())
                                .check({ timeout: 20000, force: true });
                        } else {
                            cy.wrap($elements.eq(0))
                                .check({ timeout: 20000, force: true });
                        }
                    });
            })
    })
});

Cypress.Commands.add('getElementAndType', (element: string, text?: string): void => {
    cy.wrap(null).then(() => {
        cy.get(element, { timeout: 20000 })
            .each(($input) => {
                cy.wrap($input)
                    .then(() => {
                        if ($input.length > 1) {
                            cy.wrap($input.first())
                                .clear()
                                .type(text, { timeout: 1000 })
                        } else {
                            cy.wrap($input.eq(0))
                                .clear()
                                .type(text, { timeout: 1000 })
                        }
                    })
            })
    });
});

Cypress.Commands.add('getRadioOptionByValue', (elemento: string, value): void => {
    cy.get(elemento, { timeout: 20000 })
        .should('be.visible')
        .find(`input[type="radio"][value="${value}"]`)
        .check({ force: true })
});

Cypress.Commands.add('getSelectOptionByValue', (element: string, value: any): void => {
    cy.wrap(null).then(() => {
        cy.get(element, { timeout: 20000 })
            .each(($select) => {
                cy.wrap($select)
                    .then(() => {
                        if ($select.length > 0 && $select.is(':visible')) {
                            cy.get(element, { timeout: 20000 })
                                .select(value, { force: true })
                        }

                    })
            })
    });
});

Cypress.Commands.add('getElementAutocompleteTypeAndClick', (element: string, data: string | number, autocomplete: string) => {
    cy.wrap(null).then(() => {
        cy.get(element, { timeout: 20000 })
            .as('elementAlias')
            .each(($input) => {
                cy.wrap($input)
                    .type(data.toString())
                    .then(() => {
                        if (cy.contains(autocomplete, data).as('autocompleteAlias')) {
                            cy.get('@autocompleteAlias')
                                .click({ force: true })
                        }

                    })
            })
    });
});

Cypress.Commands.add('waitModalAndClick', (jqueryElement: string, element: string) => {
    cy.wrap(null).then(() => {
        const $aliasModal = Cypress.$(jqueryElement)
        if (!$aliasModal.each) {
            cy.log('O teste será prosseguido, uma vez que o elemento esperado não foi exibido na tela.')

        }
        else {
            cy.get(element, { timeout: 60000 })
                .as('elementAlias')
            cy.get('@elementAlias', { timeout: 60000 })
                .invoke('removeAttr', 'readonly' || 'hidden' || 'scroll' || 'auto', { force: true })
                .click({ force: true, multiple: true, timeout: 5000 })
        }
    });
})



Cypress.Commands.add('checkRequiredField', (element: string, value: string, elementError: string, errorMessage = 'Este campo é obrigatório.') => {
    cy.get(element)
        .click()
        .blur()
        .then(() => {
            const $elementError = Cypress.$(elementError)

            if (!$elementError.is(':visible')) {
                return cy.wrap({ error: "Erro! Hmm, não vejo a mensagem que deve ser apresentada ao usuário." });
            }

            if (value.length > 0) {
                cy.get(element)
                    .type(value)
                    .then(() => {
                        const $elementError = Cypress.$(elementError)
                        if (value.length > 0 && $elementError.is(':visible') && $elementError.text() === errorMessage) {
                            return cy.wrap({ error: "Erro! O campo está preenchido, porém a mensagem de obrigatoriedade é apresentada." });
                        }
                    });
            }

            return cy.wrap({ success: "Ok! Mensagem de campo obrigatório está funcionando como esperado." });
        })
});


Cypress.Commands.add("insertDate", (currentDate: Date = new Date()) => {
    // Obtém os componentes individuais da data e hora
    const year: number = currentDate.getFullYear();
    const month: string = String(currentDate.getMonth() + 1).padStart(2, '0');
    const day: string = String(currentDate.getDate()).padStart(2, '0');
    const hour: string = String(currentDate.getHours()).padStart(2, '0');
    const minutes: string = String(currentDate.getMinutes()).padStart(2, '0');
    const seconds: string = String(currentDate.getSeconds()).padStart(2, '0');

    // Formata a data e hora no formato desejado
    const FORMATTED_DATE: string = `${year}-${month}-${day}`;
    const FORMATTED_TIME: string = `${hour}:${minutes}:${seconds}`;

    // Retorna um objeto contendo a data e hora formatadas
    return cy.wrap({ FORMATTED_DATE, FORMATTED_TIME })
});


Cypress.Commands.add('insertBirthDate', (element: string) => {

    cy.insertDate(dataParameters.registrationParams.birthDate)
        .then(({ FORMATTED_DATE }: { FORMATTED_DATE: string }) => {
            const currentDate = `${FORMATTED_DATE}`;

            cy.getElementAndType(element)
                .as('element')
                .type(currentDate.toString())
                .then(() => {
                    cy.get('@element')
                        .should('have.value', currentDate);
                });
        })
})







