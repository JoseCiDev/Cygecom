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
import { dadosParametros } from '../../dadosParametros';



Cypress.Commands.add('login', (email: string, senha: string) => {
    cy.visit(dadosParametros.env.BASEURL + '/login');

    cy.get(el.Login.tituloLogin);

    cy.get(el.Login.email)
        .type(email, { log: false })
        .should('have.value', email);

    cy.get(el.Login.senha)
        .type(senha, { log: false })
        .should('have.value', senha);

    cy.get(el.Login.entrar)
        .click();

    cy.url()
        .should('contain', `${dadosParametros.env.BASEURL}`);
});


Cypress.Commands.add('loginLogoutWithViewport', (size: Cypress.ViewportPreset) => {
    if (Cypress._.isArray(size)) {
        (cy.viewport(size[0], size[1]))
        cy.log(`-Tamanho da tela: ${size[0]} x ${size[1]}-`);
    } else {
        cy.viewport(size);
        cy.log(`-Tamanho da tela: ${size}-`);
    }

});
