// load the global Cypress types
/// <reference types="cypress" />

import { mount } from 'cypress/react'
// load the 3rd party command definition
/// <reference types="cypress-wait-until" />

// import { mount } from 'cypress/react'

// Augment the Cypress namespace to include type definitions for
// your custom command.
// Alternatively, can be defined in cypress/support/component.d.ts
// with a <reference path="./component" /> at the top of your spec.
// cypress/support/index.ts


import { DataHora, dadosParametros } from '../dadosParametros'






declare global {
    namespace Cypress {
        interface Chainable<Subject = any> {
            // mount: typeof mount
            /**
             * Custom command para fazer login.
             * @example cy.login()
             */
            login(email: string, senha: string): Chainable;
            doLogin(email: string, senha: string): Chainable;

            /**
            * comando customizado para selecinar elemento e verificar se esta visivel.
            * @example cy.getVisible()
            */
            getVisible(element: string, options?: Partial<Cypress.Loggable & Cypress.Timeoutable & Cypress.Withinable>): Chainable<Subject>;

            /**
            * comando customizado para selecinar elemento e verificar se esta visivel.
            * @example cy.getVisible()
            */
            loginLogoutWithViewport: (
                size: number | [number, number] | string,
                dadosAmbiente: {
                    EMAIL: string;
                    SENHA: string;
                    BASEURL: string;
                }
            ) => void;


            /**
            * comando customizado para inserir email no login Gecom.
            * @example cy.inserirEmailLogin()
            */
            inserirEmailLogin(element: string, credenciais: string | { value: string }): Chainable<Element>;

            /**
            * comando customizado para inserir senha no login Gecom.
            * @example cy.inserirSenhaLogin()
            */
            inserirSenhaLogin(element: string, credenciais: string | { value: string }): Chainable<Element>;

            /**
            * comando customizado para abrir a opcao de perfil de usuario em Gecom.
            * @example cy.abrirPerfilUsuario()
            */
            abrirPerfilUsuario(element: string): Chainable<Element>


            /**
            * comando customizado para acessar Gecom.
            * @example cy.entrarGecom()
            */
            entrarGecom(element: string): Chainable<Element>

            /**
             * comando customizado para sair Gecom.
             * @example cy.sairGecom()
            */
            sairGecom(element: string): Chainable<Element>

            /**
             * comando customizado para acessar o menu cadastro em Gecom.
             * @example cy.acessarMenuCadastro()
            */
            acessarMenuCadastro(element: string): Chainable<Element>

            /**
             * comando customizado para acessar o submenu cadastro em Gecom.
             * @example cy.acessarSubmenuCadastroUsuario()
            */
            acessarSubmenuCadastroUsuario(element: string): Chainable<Element>

            /**
             * comando customizado para acessar a tela de cadastro de usuarios em Gecom.
             * @example cy.acessarCadastroUsuario()
            */
            acessarCadastroUsuario(element: string): Chainable<Element>

            /**
             * comando customizado para verificar se o campo tem obrigatoriedade de preenchimento em Gecom.
             * @example cy.verificarObrigatoriedadeCampo()
            */
            verificarObrigatoriedadeCampo(element: string): Chainable<Element>

            /**
            * comando customizado para inserir Data.
            * @example cy.inserirData()
            */
            inserirData(dataAtual: Date): Chainable<DataHora>

            /**
            * comando customizado para inserir nome.
            * @example cy.inserirNome()
            */
            inserirNome(element: string, nome: string): Chainable<Element>

            /**
            * comando customizado para inserir cpf.
            * @example cy.inserirCpf()
            */
            inserirCpf(element: string, cpf: string): Chainable<Element>

            /**
            * comando customizado para inserir telefone.
            * @example cy.inserirTelefone()
            */
            inserirTelefone(element: string, telefone: string): Chainable<Element>

            /**
            * comando customizado para inserir e-mail.
            * @example cy.inserirEmail()
            */
            inserirEmail(element: string, email: string): Chainable<Element>

            /**
            * comando customizado para inserir senha.
            * @example cy.inserirSenha()
            */
            inserirSenha(element: string, senha: string): Chainable<Element>

            /**
            * comando customizado para selecionar perfil do usuario.
            * @example cy.selecionarPerfil()
            */
            selecionarPerfil(perfil): Chainable<Element>

            /**
            * comando customizado para selecionar se usuario é autorizado ou não para solicitar.
            * @example cy.selecionarAutorizacaoParaSolicitar()
            */
            selecionarAutorizacaoParaSolicitar(opcao): Chainable<Element>

            /**
            * comando customizado para inserir setor do usuário.
            * @example cy.inserirSetorUsuario()
            */
            inserirSetorUsuario(setorUsuario: string, opcaoSetorUsuario: string, opcaoSelectSetorUsuario: string, opcaoSelecionadaSetorUsuario: string): Chainable<Element>;

            /**
            * comando customizado para inserir usuario aprovador.
            * @example cy.inserirUsuarioAprovador()
            */
            inserirUsuarioAprovador(usuarioAprovador: string, opcaoUsuarioAprovador: string): Chainable<Element>;

            /**
            * comando customizado para inserir limite de aprovação do usuário.
            * @example cy.inserirLimiteAprovacao()
            */
            inserirLimiteAprovacao(value: string, element: string): Chainable<Element>;

            /**
            * comando customizado para inserir centros de custos permitidos para o usuario.
            * @example cy.inserirCentroCustoPermitido()
            */
            inserirCentroCustoPermitido(element: string): Chainable<Element>;

            /**
             * comando customizado para selecionar o elemento e clicar.
             * @example cy.getElementAndClick(el.elemento)
             */
            getElementAndClick(element: string): Chainable<Element>;

            /**
             * comando customizado para pegar elemento e digitar.
             * @example cy.getElementAndType(el.elemento,texto)
             */
            getElementAndType(element: string, text?: string): Chainable<Element>;

            /**
             * comando customizado para capturar elemento e marcar checkbox.
             * @example cy.getElementAndCheck(el.elemento)
             */
            getElementAndCheck(element: string): Chainable<Element>;

            /**
             * comando customizado para selecionar a opcao radio.
             * @example cy.getRadioOptionByValue(element,valor)
             */
            getRadioOptionByValue(dataCy: string, value: any): Chainable<Element>

            /**
             * comando customizado para selecionar opção do select.
             * @example cy.getSelectOptionByValue(el.elemento)
             */
            getSelectOptionByValue(dataCy: string, value: any): Chainable<Element>;
        }

    }
}
