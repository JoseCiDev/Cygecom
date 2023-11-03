/// <reference types="cypress" />

import { faker } from '@faker-js/faker';
import { elements as el } from '../elements';
import { dadosParametros } from '../dadosParametros'
<<<<<<< HEAD
=======
import { env } from 'process';
>>>>>>> 7e26ae0ed00df99f6fe0236388fd5d6c2090292e





export const {
    email,
    senha,
    entrar,
<<<<<<< HEAD

} = el.Login;



describe('Testes da página Login.', () => {
    const ambiente = Cypress.env('AMBIENTE');
    const dadosAmbiente = Cypress.env(ambiente);
    const dominio: string = '@essentia.com.br';
    const email: string = faker.internet.userName() + dominio;
    const senha: string = faker.number.int().toString()

=======
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
>>>>>>> 7e26ae0ed00df99f6fe0236388fd5d6c2090292e



    beforeEach(function () {
<<<<<<< HEAD
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
=======

        cy.visit(dadosParametros.env.BASEURL);

    })

    it(`Deve ser possível logar em vários dispositivos.`, () => {
        dadosParametros.sizes.forEach((size) => {

            cy.loginLogoutWithViewport(size);

            cy.login(dadosParametros.env.EMAILADMIN, dadosParametros.env.SENHAADMIN);
>>>>>>> 7e26ae0ed00df99f6fe0236388fd5d6c2090292e

            if (Cypress._.isArray(size)) {
                cy.get(el.Inicio.perfilUsuario).click();
                cy.get(el.Compartilhado.logout).click();
            }
        });
<<<<<<< HEAD
        cy.pause();
=======
>>>>>>> 7e26ae0ed00df99f6fe0236388fd5d6c2090292e
    });



<<<<<<< HEAD
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
=======
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
>>>>>>> 7e26ae0ed00df99f6fe0236388fd5d6c2090292e
})

