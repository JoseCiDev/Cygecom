/// <reference types="cypress" />

import { faker } from '@faker-js/faker';
import { elements as el } from '../elements';
import { dadosParametros } from '../dadosParametros'





export const {
    email,
    senha,
    entrar,

} = el.Login;



describe('Testes da página Login.', () => {
    const ambiente = Cypress.env('AMBIENTE');
    const dadosAmbiente = Cypress.env(ambiente);
    const dominio: string = '@essentia.com.br';
    const email: string = faker.internet.userName() + dominio;
    const senha: string = faker.number.int().toString()




    beforeEach(function () {
        cy.pause();
        cy.visit(dadosAmbiente.env.BASEURL + '/login');

    })

    it.only(`Deve ser possível logar em vários dispositivos.`, () => {
        dadosParametros.sizes.forEach((size) => {
            cy.loginLogoutWithViewport(size, dadosAmbiente);

            cy.inserirEmailLogin(email, dadosAmbiente.EMAILADMIN);

            cy.inserirSenhaLogin(senha, dadosAmbiente.SENHAADMIN);

            cy.getVisible(entrar).click();

            cy.url().should('contain', `${dadosAmbiente.BASEURL}`);

            if (Cypress._.isArray(size)) {
                cy.get(el.Inicio.perfilUsuario).click();
                cy.get(el.Compartilhado.logout).click();
            }
        });
        cy.pause();
    });



    // it('Deve verificar se existe validação para o campo e-mail.', () => {

    //     cy.visit(dadosAmbiente.BASEURL + '/login');

    //     cy.inserirEmailLogin(el.email, 'jose.djalma');

    //     cy.entrarGecom(el.entrar)

    //     cy.on('window:alert', (message) => {
    //         expect(message).to.equal('Inclua um "@" no endereço de e-mail. "jose.djalma" está com um "@" faltando.');
    //     });
    //     cy.pause();
    // })



    // it('Deve verificar se a senha inserida não apresenta os caracteres.', () => {

    //     cy.getVisible(el.tituloLogin);

    //     cy.inserirEmailLogin(el.email, (dadosAmbiente.EMAILADMIN));

    //     cy.inserirSenhaLogin(el.senha, (dadosAmbiente.SENHAADMIN))

    //     cy.getVisible(el.senha)
    //         .should('have.attr', 'type', 'password');
    // })



    // it('Deve realizar login inserindo dados corretos.', () => {

    //     cy.login(dadosAmbiente.EMAILADMIN, dadosAmbiente.SENHAADMIN);

    //     cy.abrirPerfilUsuario(el.perfilUsuario)

    //     cy.sairGecom(el.logout)
    // })



    // it('Deve falhar o login devido a dados incorretos.', () => {

    //     cy.getVisible(el.tituloLogin);

    //     cy.inserirEmailLogin(el.email, email);

    //     cy.inserirSenhaLogin(el.senha, senha)

    //     cy.entrarGecom(el.entrar)

    //     cy.getVisible(el.msgDadosIncorretosLogin)
    // })


    // it('Deve falhar o login devido a não inserção de dados.', () => {

    //     cy.entrarGecom(el.entrar)

    //     cy.on('window:alert', (message) => {
    //         expect(message).to.equal('Preencha este campo.');
    //     });
    // })


    // it('Deve falhar o login devido ao preenchimento somente do e-mail.', () => {

    //     cy.inserirEmailLogin(el.email, email);

    //     cy.entrarGecom(el.entrar)

    //     cy.on('window:alert', (message) => {
    //         expect(message).to.equal('Preencha este campo.');
    //     });
    // })


    // it('Deve falhar o login devido ao preenchimento somente da senha.', () => {

    //     cy.inserirSenhaLogin(el.senha, senha)

    //     cy.entrarGecom(el.entrar)

    //     cy.on('window:alert', (message) => {
    //         expect(message).to.equal('Preencha este campo.');
    //     });
    // })
})

