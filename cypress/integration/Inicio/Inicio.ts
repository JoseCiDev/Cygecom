/// <reference types="cypress" />

import { faker } from '@faker-js/faker';
import { elements as el } from '../../elements';
import { dadosParametros } from '../../dadosParametros'


export const {
    perfilUsuario,
    inicioMenu,
    logoGecom,
    telaInicio,

} = el.Inicio;

export const {
    logout,
    opcoesMenu,
    menuReduzido,
    breadcumbHome,
    breadcumbUsuario,
    mostraQuantidadeRegistros,
    BuscaUsuarioCadastrado,
    proximaPagina,
    paginaAnterior,

} = el.Compartilhado;

export const {
    cadastroMenu,
    cadastroMenuReduzido,
    cadastroUsuarioSubMenu,
    cadastroFornecedorSubMenu,
    criaNovoUsuario,
    nomeUsuario,
    dataNascimentoUsuario,
    cpfCnpjUsuario,
    telefoneUsuario,
    emailUsuario,
    senhaUsuario,
    confirmarSenhaUsuario,
    setorUsuario,
    opcaoSetorUsuario,
    opcaoSelectSetorUsuario,
    opcaoSelecionadaSetorUsuario,
    usuarioAprovador,
    opcaoUsuarioAprovador,
    limiteAprovacaoUsuario,
    centroCustoPermitidoUsuario,
    selecionarTodosCentroCustoPermitidoUsuario,
    limparCentroCustoPermitidoUsuario,
    salvarCadastroUsuario,
    cancelarCadastroUsuario,
} = el.Cadastro;

export const {
    solicitacaoMenu,
    novaSolicitacaoSubMenu,
    minhaSolicitacaoSubMenu,
    solicitacaoGeralSubMenu,

} = el.Solicitacao;

export const {
    suprimentoMenu,
    dashboardSubMenu,
    produtoSubMenu,
    servicoSubMenu,
    contratoSubMenu,

} = el.Suprimento;

<<<<<<< HEAD
const ambiente = Cypress.env('AMBIENTE')
const dadosAmbiente = Cypress.env(ambiente)

describe('Testes da página Inicio', () => {

    const dominio: string = '@essentia.com.br';
    const email: string = faker.internet.userName() + dominio;
    const senha: string = faker.number.int().toString()

=======

describe('Testes da página Inicio', () => {

>>>>>>> 7e26ae0ed00df99f6fe0236388fd5d6c2090292e



    beforeEach(function () {

        cy.login(dadosParametros.env.EMAILADMIN, dadosParametros.env.SENHAADMIN);
    })





    it(`Deve ser possível logar em vários dispositivos.`, () => {
        dadosParametros.sizes.forEach((size) => {
            if (Cypress._.isArray(size)) {
<<<<<<< HEAD
                cy.loginLogoutWithViewport(size, dadosAmbiente);
=======
                cy.loginLogoutWithViewport(size);
>>>>>>> 7e26ae0ed00df99f6fe0236388fd5d6c2090292e

                cy.get(perfilUsuario)
                    .click();

                cy.get(logout)
                    .click();

<<<<<<< HEAD
                cy.getVisible(email)
                    .type(dadosParametros.env.EMAILADMIN, { log: false })
                    .should('have.value', dadosParametros.env.EMAILADMIN);

                cy.getVisible(senha)
=======
                cy.getVisible(dadosParametros.Autenticacao.email)
                    .type(dadosParametros.env.EMAILADMIN, { log: false })
                    .should('have.value', dadosParametros.env.EMAILADMIN);

                cy.getVisible(dadosParametros.Autenticacao.senha)
>>>>>>> 7e26ae0ed00df99f6fe0236388fd5d6c2090292e
                    .type(dadosParametros.env.SENHAADMIN, { log: false })
                    .should('have.value', dadosParametros.env.SENHAADMIN);

                cy.getVisible(el.Login.entrar)
                    .click();

                cy.url().should('contain', `${dadosParametros.env.BASEURL}`);

                cy.get(inicioMenu, { timeout: 10000 })
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

        cy.getVisible(inicioMenu)
            .click()

        cy.url()
            .should('contain', `${dadosParametros.env.BASEURL}`);

    })



    it('Deve clicar no icone "Gecom" e ser direcionado para página inicio.', () => {

        cy.getVisible(logoGecom)
            .click()

        cy.url()
            .should('contain', `${dadosParametros.env.BASEURL}`);
    })



    it('Deve acessar cadastros de usuários.', () => {

        cy.acessarMenuCadastro(cadastroMenu)

        cy.get(cadastroUsuarioSubMenu)
            .click()

        cy.url()
            .should('contain', dadosParametros.env.BASEURL + '/users');
    })



    it('Deve acessar cadastros de fornecedores.', () => {

        cy.acessarMenuCadastro(cadastroMenu)

        cy.get(cadastroFornecedorSubMenu)
            .click()

        cy.url()
            .should('contain', dadosParametros.env.BASEURL + '/suppliers');
    })


    it('Deve acessar novas solicitações.', () => {

        cy.getVisible(solicitacaoMenu)
            .click()

        cy.get(novaSolicitacaoSubMenu)
            .click()

        cy.url()
            .should('contain', dadosParametros.env.BASEURL + '/request/links');

    })


    it('Deve acessar minhas solicitações.', () => {

        cy.getVisible(solicitacaoMenu)
            .click()

        cy.get(minhaSolicitacaoSubMenu)
            .click()

        cy.url()
            .should('contain', dadosParametros.env.BASEURL + '/requests/own');
    })


    it('Deve acessar solicitações gerais.', () => {

        cy.getVisible(solicitacaoMenu)
            .click()

        cy.get(solicitacaoGeralSubMenu)
            .click()

        cy.url()
            .should('contain', dadosParametros.env.BASEURL + '/requests');
    })



    it('Deve acessar dashboard dos suprimentos.', () => {

        cy.getVisible(solicitacaoMenu)
            .click()

        cy.get(solicitacaoGeralSubMenu)
            .click()

        cy.url()
            .should('contain', dadosParametros.env.BASEURL + '/requests');
    })



    it('Deve acessar produtos dos suprimentos.', () => {
        cy.getVisible(suprimentoMenu)
            .click()

        cy.get(dashboardSubMenu)
            .click()

        cy.url()
            .should('contain', dadosParametros.env.BASEURL + '/supplies/index');
    })



    it('Deve acessar serviços dos suprimentos.', () => {
        cy.getVisible(suprimentoMenu)
            .click()

        cy.get(servicoSubMenu)
            .click()

        cy.url()
            .should('contain', dadosParametros.env.BASEURL + '/supplies/service');
    })



    it('Deve acessar contratos dos suprimentos.', () => {
        cy.getVisible(suprimentoMenu)
            .click()

        cy.get(contratoSubMenu)
            .click()

        cy.url()
            .should('contain', dadosParametros.env.BASEURL + '/supplies/contract');
    })



    it('Somente perfil administrador pode cadastrar usuários e fornecedores.', () => {
        cy.acessarMenuCadastro(cadastroMenu)
        cy.getVisible(cadastroUsuarioSubMenu)
            .click()
        cy.url()
            .should('contain', dadosParametros.env.BASEURL + '/users');

        cy.acessarMenuCadastro(cadastroMenu)
        cy.getVisible(cadastroFornecedorSubMenu)
            .click()
        cy.url()
            .should('contain', dadosParametros.env.BASEURL + '/suppliers');

        cy.getVisible(perfilUsuario)
            .click();
        cy.getVisible(logout)
            .click();

<<<<<<< HEAD
        cy.getVisible(email)
            .type(dadosParametros.env.EMAILUSUARIO, { log: false })
            .should('have.value', dadosParametros.env.EMAILUSUARIO);
        cy.getVisible(senha)
=======
        cy.getVisible(dadosParametros.Autenticacao.email)
            .type(dadosParametros.env.EMAILUSUARIO, { log: false })
            .should('have.value', dadosParametros.env.EMAILUSUARIO);
        cy.getVisible(dadosParametros.Autenticacao.senha)
>>>>>>> 7e26ae0ed00df99f6fe0236388fd5d6c2090292e
            .type(dadosParametros.env.SENHAUSUARIO, { log: false })
            .should('have.value', dadosParametros.env.SENHAUSUARIO);
        cy.getVisible(el.Login.entrar)
            .click();
        cy.url().should('contain', `${dadosParametros.env.BASEURL}`);

        cy.getVisible(opcoesMenu, { timeout: 10000 })
            .then(($ul) => {
                if (cy.get(el.Cadastro.cadastroMenu)
                    .should('not.exist')) {
                    cy.get(inicioMenu, { timeout: 10000 })
                        .click();
                } else {
                    cy.get(el.Cadastro.cadastroMenu)
                        .should('not.be.visible')
                        .click();
                }
            });

    })
})

