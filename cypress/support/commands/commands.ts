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
import { dadosParametros } from '../../dadosParametros'

import '../commands/commandsLogin';
import '../commands/commandsCadastroUsuario';
import '../commands/commandsInicio';





Cypress.Commands.add('getVisible', (element: string, options: Partial<Cypress.Loggable & Cypress.Timeoutable & Cypress.Withinable>) => {
    const defaultOptions = { timeout: 20000 };
    const combinedOptions = { ...defaultOptions, ...options };
    return cy.get(element, combinedOptions);
})



Cypress.Commands.add('getElementAndClick', (element: string): void => {
    cy.get(element, { timeout: 10000 })
        .should('be.visible')
        .as('element')
        .then($elements => {
            if ($elements.length > 0) {
                cy.wrap($elements.first())
                    .click({ timeout: 10000, force: true });
            } else {
                cy.wrap($elements.eq(0))
                    .click({ timeout: 10000, force: true });
            }
        });
});



Cypress.Commands.add('getElementAndType', (element: string, text?: string): void => {
    if (typeof text !== 'string') {
        throw new Error('O texto a ser escrito deve ser uma string.');
    }
    cy.get(element, { timeout: 10000 })
        .should('be.visible')
        .then($elements => {
            if ($elements.length > 1) {
                cy.wrap($elements.first())
                    .clear()
                    .type(text, { timeout: 1000 })
            } else {
                cy.wrap($elements.eq(0))
                    .clear()
                    .type(text, { timeout: 1000 })
            }
        });
});



Cypress.Commands.add('getElementAndCheck', (elemento: string): void => {
    cy.get(elemento, { timeout: 20000 })
        .as('element')
        .then($elements => {
            cy.get('@element')
                .invoke('removeAttr', 'readonly' || 'hidden' || 'scroll' || 'auto')

            if ($elements.length > 0) {
                cy.wrap($elements.first())
                    .check({ timeout: 20000, force: true });
            } else {
                cy.wrap($elements.eq(0))
                    .check({ timeout: 20000, force: true });
            }
            cy.get('@element')
                .invoke('attr', 'readonly' || 'hidden' || 'scroll' || 'auto');
        });

});



Cypress.Commands.add('getRadioOptionByValue', (dataCy: string, value): void => {
    cy.get(`[data-cy="${dataCy}"]`, { timeout: 10000 })
        .should('be.visible')
        .find(`input[type="radio"][value="${value}"]`)
        .check({ force: true })
});



Cypress.Commands.add('getSelectOptionByValue', (dataCy: string, value) => {
    cy.get(`[data-cy="${dataCy}"]`, { timeout: 10000 })
        .should('be.visible')
        .select(value, { force: true })
});



Cypress.Commands.add('getRadioOptionByValue', (elemento: string, value): void => {
    cy.get(elemento, { timeout: 20000 })
        .should('be.visible')
        .find(`input[type="radio"][value="${value}"]`)
        .check({ force: true })
});



Cypress.Commands.add('verificarObrigatoriedadeCampo', (element: string) => {
    cy.get(element)
        .should('have.attr', 'aria-required', 'true')
});


Cypress.Commands.add("inserirData", (dataAtual: Date = new Date()) => {
    // Obtém os componentes individuais da data e hora
    const ano: number = dataAtual.getFullYear();
    const mes: string = String(dataAtual.getMonth() + 1).padStart(2, '0');
    const dia: string = String(dataAtual.getDate()).padStart(2, '0');
    const hora: string = String(dataAtual.getHours()).padStart(2, '0');
    const minutos: string = String(dataAtual.getMinutes()).padStart(2, '0');
    const segundos: string = String(dataAtual.getSeconds()).padStart(2, '0');

    // Formata a data e hora no formato desejado
    const DATA_FORMATADA: string = `${ano}-${mes}-${dia}`;
    const HORA_FORMATADA: string = `${hora}:${minutos}:${segundos}`;

    // Retorna um objeto contendo a data e hora formatadas
    return cy.wrap({ DATA_FORMATADA, HORA_FORMATADA })
});


Cypress.Commands.add('inserirDataNascimento', (element: string) => {

    cy.inserirData(dadosParametros.cadastroParams.dataNascimento)
        .then(({ DATA_FORMATADA }: { DATA_FORMATADA: string }) => {
            const dataAtual = `${DATA_FORMATADA}`;

            cy.getVisible(element)
                .type(dataAtual.toString())
                .then(() => {
                    cy.getVisible(element)
                        .should('have.value', dataAtual);
                });
        })
})







