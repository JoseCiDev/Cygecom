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
/// <reference path="./cypress.d.ts" />



import { ELEMENTS as el } from '../elements'
import { Perfil, OpcaoAutorizacao } from './cypress.d';


const ambiente = Cypress.env('AMBIENTE');
const dadosAmbiente = Cypress.env(ambiente);
const sizes: Array<number | [number, number] | string> = [
    [1536, 960],
    [1440, 900],
    [1366, 768],
    [1280, 800],
    [1280, 720],
    [1024, 768],
    [1024, 600],
    [820, 1180],
    [768, 1024],
    [412, 914],
    [414, 896],
    [414, 846],
    [414, 736],
    [414, 736],
    [390, 844],
    [400, 550],
    [375, 812],
    [375, 667],
    [360, 760],
    [320, 568],
    [320, 480],
    [280, 653],
];




Cypress.Commands.add('doLogin', (email: string, senha: string) => {
    cy.visit(dadosAmbiente.BASEURL + '/login');

    cy.getVisible(el.tituloLogin);

    cy.getVisible(el.email)
        .type(email, { log: false })
        .should('have.value', email);

    cy.getVisible(el.senha)
        .type(senha, { log: false })
        .should('have.value', senha);

    cy.getVisible(el.entrar)
        .click();

    cy.url()
        .should('contain', `${dadosAmbiente.BASEURL}`);
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
        cy.visit(dadosAmbiente.BASEURL);
    }
});



Cypress.Commands.add('getVisible', (element: string, options: Partial<Cypress.Loggable & Cypress.Timeoutable & Cypress.Withinable>) => {
    const defaultOptions = { timeout: 20000 };
    const combinedOptions = { ...defaultOptions, ...options };
    return cy.getVisible(element, combinedOptions);
})



export { sizes };
Cypress.Commands.add('loginLogoutWithViewport', (size: Cypress.ViewportPreset, dadosAmbiente) => {
    if (Cypress._.isArray(size)) {
        (cy.viewport(size[0], size[1]))
        cy.log(`-Tamanho da tela: ${size[0]} x ${size[1]}-`);
    } else {
        cy.viewport(size);
        cy.log(`-Tamanho da tela: ${size}-`);
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



Cypress.Commands.add('abrirPerfilUsuario', (element: string) => {
    cy.getVisible(element).click();
});



Cypress.Commands.add('entrarGecom', (element: string) => {
    cy.getVisible(element)
        .click();
})



Cypress.Commands.add('sairGecom', (element: string) => {
    cy.getVisible(element)
        .click();
})


Cypress.Commands.add('acessarMenuCadastro', (element: string) => {
    cy.getVisible(element)
        .click();
})


Cypress.Commands.add('acessarSubmenuCadastroUsuario', (element: string) => {
    cy.getVisible(element)
        .click();
})


Cypress.Commands.add('acessarCadastroUsuario', (element: string) => {
    cy.getVisible(element)
        .click();
})


Cypress.Commands.add('verificarObrigatoriedadeCampo', (element: string) => {
    cy.getVisible(element)
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


Cypress.Commands.add('inserirNome', (element: string, nome: string) => {
    cy.getVisible(element)
        .type(nome)
        .should('have.value', nome)
})


Cypress.Commands.add('inserirCpf', (element: string, cpf: string) => {
    cy.getVisible(element)
        .should('exist')
        .clear()
        .type(cpf)
        .should('have.value', cpf)
})


Cypress.Commands.add('inserirTelefone', (element: string, telefone: string) => {
    cy.getVisible(element)
        .clear()
        .type(telefone)
        .should('have.value', telefone);
})


Cypress.Commands.add('inserirEmail', (element: string, email: string) => {
    cy.getVisible(element)
        .type(email)
        .should('have.value', email);
})


Cypress.Commands.add('inserirSenha', (element: string, senha: string) => {
    cy.getVisible(element)
        .type(senha)
        .should('have.value', senha);
})


Cypress.Commands.add('selecionarPerfil', (perfil: Perfil) => {
    cy.getVisible(`[data-cy="${perfil}"]`)
        .check()
        .should('be.checked');
})


Cypress.Commands.add('selecionarAutorizacaoParaSolicitar', (opcao: OpcaoAutorizacao) => {
    const inputId = opcao === OpcaoAutorizacao.Autorizado ? 'is_buyer_true' : 'is_buyer_false';

    cy.getVisible(`input#${inputId}`)
        .trigger('click', { force: true });
})



Cypress.Commands.add('inserirSetorUsuario', (setorUsuario: string, opcaoSetorUsuario: string, opcaoSelectSetorUsuario: string, opcaoSelecionadaSetorUsuario: string) => {

    cy.getVisible(setorUsuario)
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
    cy.getVisible(usuarioAprovador)
        .click();

    cy.get(opcaoUsuarioAprovador)
        .eq(1)
        .click({ force: true });
})


Cypress.Commands.add('inserirLimiteAprovacao', (value: string, element: string) => {
    cy.get(element)
        .type(value)
})


Cypress.Commands.add('inserirCentroCustoPermitido' , (element:string) => {
    cy.getVisible(element)
        .click()
})
