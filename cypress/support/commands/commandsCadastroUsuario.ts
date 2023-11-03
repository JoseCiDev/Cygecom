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

<<<<<<< HEAD


Cypress.Commands.add('acessarMenuCadastro', (element: string) => {
    cy.getVisible(element)
        .click();
});


Cypress.Commands.add('acessarSubmenuCadastroUsuario', (element: string) => {
    cy.getVisible(element)
        .click();
});


Cypress.Commands.add('acessarCadastroUsuario', (element: string) => {
    cy.getVisible(element)
        .click();
=======
export const {
    email,
    senha,
    entrar,
    tituloLogin,
    msgDadosIncorretosLogin,

} = el.Login;

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

Cypress.Commands.add('acessarCadastroUsuario', () => {

    cy.getElementAndClick(cadastroMenu);

    cy.getElementAndClick(cadastroUsuarioSubMenu);

>>>>>>> 7e26ae0ed00df99f6fe0236388fd5d6c2090292e
});


Cypress.Commands.add('inserirNome', (element: string, nome: string) => {
<<<<<<< HEAD
    cy.getVisible(element)
=======
    cy.get(element)
>>>>>>> 7e26ae0ed00df99f6fe0236388fd5d6c2090292e
        .type(nome)
        .should('have.value', nome)
});


Cypress.Commands.add('inserirCpf', (element: string, cpf: string) => {
<<<<<<< HEAD
    cy.getVisible(element)
=======
    cy.get(element)
>>>>>>> 7e26ae0ed00df99f6fe0236388fd5d6c2090292e
        .should('exist')
        .clear()
        .type(cpf)
        .should('have.value', cpf)
});


Cypress.Commands.add('inserirTelefone', (element: string, telefone: string) => {
<<<<<<< HEAD
    cy.getVisible(element)
=======
    cy.get(element)
>>>>>>> 7e26ae0ed00df99f6fe0236388fd5d6c2090292e
        .clear()
        .type(telefone)
        .should('have.value', telefone);
});


Cypress.Commands.add('inserirEmail', (element: string, email: string) => {
<<<<<<< HEAD
    cy.getVisible(element)
=======
    cy.get(element)
>>>>>>> 7e26ae0ed00df99f6fe0236388fd5d6c2090292e
        .type(email)
        .should('have.value', email);
});


Cypress.Commands.add('inserirSenha', (element: string, senha: string) => {
<<<<<<< HEAD
    cy.getVisible(element)
=======
    cy.get(element)
>>>>>>> 7e26ae0ed00df99f6fe0236388fd5d6c2090292e
        .type(senha)
        .should('have.value', senha);
});


Cypress.Commands.add('selecionarPerfil', (perfil) => {
<<<<<<< HEAD
    cy.getVisible(`[data-cy="${perfil}"]`)
=======
    cy.get(`[data-cy="${perfil}"]`)
>>>>>>> 7e26ae0ed00df99f6fe0236388fd5d6c2090292e
        .check()
        .should('be.checked');
});


Cypress.Commands.add('selecionarAutorizacaoParaSolicitar', (opcao) => {
<<<<<<< HEAD
    const inputId = opcao === dadosParametros.enums.OpcaoAutorizacao.Autorizado ? 'is_buyer_true' : 'is_buyer_false';

    cy.getVisible(`input#${inputId}`)
=======
    const inputId = opcao === dadosParametros.cadastroParams.autorizacaoSolicitar ? 'is_buyer_true' : 'is_buyer_false';

    cy.get(`input#${inputId}`)
>>>>>>> 7e26ae0ed00df99f6fe0236388fd5d6c2090292e
        .trigger('click', { force: true });
});



Cypress.Commands.add('inserirSetorUsuario', (setorUsuario: string, opcaoSetorUsuario: string, opcaoSelectSetorUsuario: string, opcaoSelecionadaSetorUsuario: string) => {

<<<<<<< HEAD
    cy.getVisible(setorUsuario)
=======
    cy.get(setorUsuario)
>>>>>>> 7e26ae0ed00df99f6fe0236388fd5d6c2090292e
        .click();

    cy.get(opcaoSetorUsuario)
        .eq(0)
        .invoke('attr', 'style', 'display: block');

    cy.get(opcaoSelectSetorUsuario)
        .invoke('removeAttr', 'style')
        .then(() => {
            cy.get(opcaoSelecionadaSetorUsuario)
                .click({ force: true });
        });
});


Cypress.Commands.add('inserirUsuarioAprovador', (usuarioAprovador: string, opcaoUsuarioAprovador: string) => {
<<<<<<< HEAD
    cy.getVisible(usuarioAprovador)
=======
    cy.get(usuarioAprovador)
>>>>>>> 7e26ae0ed00df99f6fe0236388fd5d6c2090292e
        .click();

    cy.get(opcaoUsuarioAprovador)
        .eq(1)
        .click({ force: true });
});


Cypress.Commands.add('inserirLimiteAprovacao', (value: string, element: string) => {
    cy.get(element)
        .type(value)
});


Cypress.Commands.add('inserirCentroCustoPermitido', (element: string) => {
<<<<<<< HEAD
    cy.getVisible(element)
        .click()
});
=======
    cy.get(element)
        .click()
});


>>>>>>> 7e26ae0ed00df99f6fe0236388fd5d6c2090292e
