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



Cypress.Commands.add('doLogin', (email: string, senha: string) => {
    cy.visit(dadosParametros.env.BASEURL + '/login');

    cy.getVisible(el.Login.tituloLogin);

    cy.getVisible(el.Login.email)
        .type(email, { log: false })
        .should('have.value', email);

    cy.getVisible(el.Login.senha)
        .type(senha, { log: false })
        .should('have.value', senha);

    cy.getVisible(el.Login.entrar)
        .click();

    cy.url()
        .should('contain', `${dadosParametros.env.BASEURL}`);
});
Cypress.Commands.add('login', (email: string, senha: string) => {
    // Verifica se o usuário já está logado
    const isLoggedIn = localStorage.getItem('user_logged_in');

    if (!isLoggedIn) {
        // Se não estiver logado, faz o login
        cy.doLogin(email, senha);
        // Define a variável para indicar que o usuário está logado
        localStorage.setItem('user_logged_in', 'true');
    } else {
        // Se já estiver logado, apenas visita a página novamente para carregar o estado de login corretamente
        cy.visit(dadosParametros.env.BASEURL);
    }
});



Cypress.Commands.add('inserirEmailLogin', (element: string, credenciais: string | { value: string }) => {
    let value = typeof credenciais === 'object' && credenciais !== null && credenciais.hasOwnProperty('value')
        ? credenciais.value
        : credenciais;

    cy.getVisible(element)
        .type(value as string)
        .should('have.value', value as string)
});



Cypress.Commands.add('inserirSenhaLogin', (element: string, credenciais: string | { value: string }) => {
    let value = typeof credenciais === 'object' && credenciais !== null && credenciais.hasOwnProperty('value')
        ? credenciais.value
        : credenciais;

    cy.getVisible(element)
        .type(value as string)
        .should('have.value', value as string)
});
