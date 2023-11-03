/// <reference types="cypress" />

import { faker } from '@faker-js/faker';
import { ELEMENTS as el } from '../../../elements';
import { sizes } from '../../support/commands';




describe('Testes da página Inicio', () => {
    const ambiente = Cypress.env('AMBIENTE');
    const dadosAmbiente = Cypress.env(ambiente);
    const dominio: string = '@essentia.com.br';
    const email: string = faker.internet.userName() + dominio;
    const senha: string = faker.number.int().toString()




    beforeEach(function () {

        cy.login(dadosAmbiente.EMAILADMIN, dadosAmbiente.SENHAADMIN);
    })





    it(`Deve ser possível logar em vários dispositivos.`, () => {
        sizes.forEach((size) => {
            if (Cypress._.isArray(size)) {
                cy.loginLogoutWithViewport(size, dadosAmbiente);

                cy.get(el.perfilUsuario)
                    .click();

                cy.get(el.logout)
                    .click();

                cy.getVisible(el.email)
                    .type(dadosAmbiente.EMAILADMIN, { log: false })
                    .should('have.value', dadosAmbiente.EMAILADMIN);

                cy.getVisible(el.senha)
                    .type(dadosAmbiente.SENHAADMIN, { log: false })
                    .should('have.value', dadosAmbiente.SENHAADMIN);

                cy.getVisible(el.entrar)
                    .click();

                cy.url().should('contain', `${dadosAmbiente.BASEURL}`);

                cy.get(el.inicioMenu, { timeout: 10000 })
                    .then((element) => {
                        if (Cypress.dom.isVisible(element)) {
                            cy.wrap(element)
                                .click();
                        } else {
                            cy.get("a.toggle-mobile")
                                .click();
                        }
                    });
            }
        });
    });





    it('Deve clicar na palavra inicio e ser direcionado para página inicio.', () => {

        cy.getVisible(el.inicioMenu)
            .click()

        cy.url()
            .should('contain', `${dadosAmbiente.BASEURL}`);

    })



    it('Deve clicar no icone "Gecom" e ser direcionado para página inicio.', () => {

        cy.getVisible(el.logoGecom)
            .click()

        cy.url()
            .should('contain', `${dadosAmbiente.BASEURL}`);
    })



    it('Deve acessar cadastros de usuários.', () => {

        cy.acessarMenuCadastro(el.cadastroMenu)

        cy.get(el.cadastroUsuarioSubMenu)
            .click()

        cy.url()
            .should('contain', dadosAmbiente.BASEURL + '/users');
    })



    it('Deve acessar cadastros de fornecedores.', () => {

        cy.acessarMenuCadastro(el.cadastroMenu)

        cy.get(el.cadastroFornecedorSubMenu)
            .click()

        cy.url()
            .should('contain', dadosAmbiente.BASEURL + '/suppliers');
    })


    it('Deve acessar novas solicitações.', () => {

        cy.getVisible(el.solicitacaoMenu)
            .click()

        cy.get(el.novaSolicitacaoSubMenu)
            .click()

        cy.url()
            .should('contain', dadosAmbiente.BASEURL + '/request/links');

    })


    it('Deve acessar minhas solicitações.', () => {

        cy.getVisible(el.solicitacaoMenu)
            .click()

        cy.get(el.minhaSolicitacaoSubMenu)
            .click()

        cy.url()
            .should('contain', dadosAmbiente.BASEURL + '/requests/own');
    })


    it('Deve acessar solicitações gerais.', () => {

        cy.getVisible(el.solicitacaoMenu)
            .click()

        cy.get(el.solicitacaoGeralSubMenu)
            .click()

        cy.url()
            .should('contain', dadosAmbiente.BASEURL + '/requests');
    })



    it('Deve acessar dashboard dos suprimentos.', () => {

        cy.getVisible(el.solicitacaoMenu)
            .click()

        cy.get(el.solicitacaoGeralSubMenu)
            .click()

        cy.url()
            .should('contain', dadosAmbiente.BASEURL + '/requests');
    })



    it('Deve acessar produtos dos suprimentos.', () => {
        cy.getVisible(el.suprimentoMenu)
            .click()

        cy.get(el.dashboardSubMenu)
            .click()

        cy.url()
            .should('contain', dadosAmbiente.BASEURL + '/supplies/index');
    })



    it('Deve acessar serviços dos suprimentos.', () => {
        cy.getVisible(el.suprimentoMenu)
            .click()

        cy.get(el.servicoSubMenu)
            .click()

        cy.url()
            .should('contain', dadosAmbiente.BASEURL + '/supplies/service');
    })



    it('Deve acessar contratos dos suprimentos.', () => {
        cy.getVisible(el.suprimentoMenu)
            .click()

        cy.get(el.contratoSubMenu)
            .click()

        cy.url()
            .should('contain', dadosAmbiente.BASEURL + '/supplies/contract');
    })



    it('Somente perfil administrador pode cadastrar usuários e fornecedores.', () => {
        cy.acessarMenuCadastro(el.cadastroMenu)
        cy.getVisible(el.cadastroUsuarioSubMenu)
            .click()
        cy.url()
            .should('contain', dadosAmbiente.BASEURL + '/users');

        cy.acessarMenuCadastro(el.cadastroMenu)
        cy.getVisible(el.cadastroFornecedorSubMenu)
            .click()
        cy.url()
            .should('contain', dadosAmbiente.BASEURL + '/suppliers');

        cy.getVisible(el.perfilUsuario)
            .click();
        cy.getVisible(el.logout)
            .click();

        cy.getVisible(el.email)
            .type(dadosAmbiente.EMAILUSUARIO, { log: false })
            .should('have.value', dadosAmbiente.EMAILUSUARIO);
        cy.getVisible(el.senha)
            .type(dadosAmbiente.SENHAUSUARIO, { log: false })
            .should('have.value', dadosAmbiente.SENHAUSUARIO);
        cy.getVisible(el.entrar)
            .click();
        cy.url().should('contain', `${dadosAmbiente.BASEURL}`);

        cy.getVisible(el.opcoesMenu, { timeout: 10000 })
            .then(($ul) => {
                if (cy.get(el.cadastroMenu)
                    .should('not.exist')) {
                    cy.get(el.inicioMenu, { timeout: 10000 })
                        .click();
                } else {
                    cy.get(el.cadastroMenu)
                        .should('not.be.visible')
                        .click();
                }
            });

    })
})

