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
import { ValidationResult, dadosParametros } from '../../dadosParametros'

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

});


Cypress.Commands.add('inserirNome', (element: string, nome: string) => {
    cy.get(element)
        .type(nome)
        .should('have.value', nome)
});


Cypress.Commands.add('inserirCpf', (element: string, cpf: string) => {
    cy.get(element)
        .should('exist')
        .clear()
        .type(cpf)
        .should('have.value', cpf)
});


Cypress.Commands.add('inserirTelefone', (element: string, telefone: string) => {
    cy.get(element)
        .clear()
        .type(telefone)
        .should('have.value', telefone);
});


Cypress.Commands.add('inserirEmail', (element: string, email: string) => {
    cy.get(element)
        .type(email)
        .should('have.value', email);
});


Cypress.Commands.add('inserirSenha', (element: string, senha: string) => {
    cy.get(element)
        .type(senha)
        .should('have.value', senha);
});


Cypress.Commands.add('selecionarPerfil', (perfil) => {
    cy.get(`[data-cy="${perfil}"]`)
        .check()
        .should('be.checked');
});


Cypress.Commands.add('selecionarAutorizacaoParaSolicitar', (opcao) => {
    const inputId = opcao === dadosParametros.cadastroParams.autorizacaoSolicitar ? 'is_buyer_true' : 'is_buyer_false';

    cy.get(`input#${inputId}`)
        .trigger('click', { force: true });
});



Cypress.Commands.add('inserirSetorUsuario', (setorUsuario: string, opcaoSetorUsuario: string, opcaoSelectSetorUsuario: string, opcaoSelecionadaSetorUsuario: string) => {

    cy.get(setorUsuario)
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
    cy.get(usuarioAprovador)
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
    cy.get(element)
        .click()
});


Cypress.Commands.add('quantidadeMinimaCaracteres', function (element: string, value: string, quantidadeMinima: number, elementError: string) {
    cy.get(element)
        .clear()
        .type(value)
        .then(() => {
            const $elementError = Cypress.$(elementError)
            if (value.length < quantidadeMinima && !$elementError.is(':visible')) {
                return cy.wrap({ error: "Erro! Valor informado é menor que o obrigatório, porém aviso não é apresentado ao usuário." });
            }

            if (value.length > quantidadeMinima && $elementError.is(':visible')) {
                return cy.wrap({ error: "Erro! Valor informado está correto, porém é apresentado mensagem de erro." });
            }
            return cy.wrap({ success: "Sucesso!" });
        });
});






Cypress.Commands.add('validarCpfCnpj', (
    element: string, value: string,
    elementError: string, 
    mensagemErro = 'Este campo é obrigatório.',
    mensagemErroCpf = 'Este campo é obrigatório.') => {
    // Remove caracteres não numéricos
    const valorLimpo = value.replace(/[^\d]/g, '');

    cy.get(element)
        .clear()
        .type(valorLimpo)
        .then(() => {

            const $elementError = Cypress.$(elementError)
            if (valorLimpo.length < 11 && !$elementError.is(':visible') && $elementError.text() === mensagemErroCpf) {
                return cy.wrap({ error: `${valorLimpo} é um CPF incompleto. Porém não é apresentado mensagem ao usuário.` });
            }

            // Verifica se o CNPJ possui 14 dígitos
            if (valorLimpo.length > 11 && valorLimpo.length < 14 && !$elementError.is(':visible')) {
                return cy.wrap({ error: `${valorLimpo} é um CNPJ incompleto. Porém não é apresentado mensagem ao usuário.` });
            }

            // Verifica se todos os dígitos são iguais, o que tornaria o CNPJ inválido
            if (/^(\d)\1+$/.test(valorLimpo) && !$elementError.is(':visible')) {
                return cy.wrap({ error: `${valorLimpo} são números iguais. Porém não é apresentado mensagem ao usuário.` });
            }

            return cy.wrap({ success: `${valorLimpo} é um CPF/CNPJ Ok.` });
        })

});
