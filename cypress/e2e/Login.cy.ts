/// <reference types="cypress" />

import { faker } from '@faker-js/faker';
import { elements as el } from '../elements';
import { dadosParametros } from '../dadosParametros'
import { env } from 'process';





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



describe('Testes da página Login.', () => {



    beforeEach(function () {

        cy.visit(dadosParametros.env.BASEURL);

    })

    it(`Deve ser possível logar em vários dispositivos.`, () => {
        dadosParametros.sizes.forEach((size) => {

            cy.loginLogoutWithViewport(size);

            cy.login(dadosParametros.env.EMAILADMIN, dadosParametros.env.SENHAADMIN);

            if (Cypress._.isArray(size)) {
                cy.get(el.Inicio.perfilUsuario).click();
                cy.get(el.Compartilhado.logout).click();
            }
        });
    });



    it('Deve verificar se existe validação para o campo e-mail.', () => {

        cy.visit(dadosParametros.env.BASEURL + '/login');

        cy.getElementAndType(emailUsuario, '{enter}');

        cy.on('window:alert', (mensagem) => {
            // Certifique-se de que a mensagem do alerta está correta
            expect(mensagem).to.include('Preencha este campo.');


        });

    });



    it('Deve verificar se a senha inserida não apresenta os caracteres.', () => {

        cy.get(tituloLogin);

        cy.getVisible(senha)
            .should('have.attr', 'type', 'password');
    });



    it('Deve realizar login inserindo dados corretos.', () => {

        cy.login(dadosParametros.env.EMAILADMIN, dadosParametros.env.SENHAADMIN);

        cy.getElementAndClick(perfilUsuario);

        cy.getElementAndClick(logout);

    });



    it('Deve falhar o login devido a dados incorretos.', () => {

        cy.login('Teste', 'senha');

        cy.url()
            .should('contain', `${dadosParametros.url.login}`);
    });


    it('Deve falhar o login devido a não inserção de dados.', () => {

        cy.entrarGecom(entrar)

        cy.url()
            .should('contain', `${dadosParametros.url.login}`);
    });


    it.only('Deve falhar o login devido ao preenchimento somente do e-mail.', () => {

        cy.getElementAndType(emailUsuario, dadosParametros.env.EMAILADMIN);

        cy.getElementAndClick(entrar);

        cy.on('window:alert', (message) => {
            expect(message).to.equal('Preencha este campo.');
        });
    });


    it('Deve falhar o login devido ao preenchimento somente da senha.', () => {

        cy.getElementAndType(senha, dadosParametros.env.SENHAADMIN);

        cy.getElementAndClick(entrar);

        cy.on('window:alert', (message) => {
            expect(message).to.equal('Preencha este campo.');
        });
    })
})

