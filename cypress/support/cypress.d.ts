<<<<<<< HEAD
=======
<<<<<<< HEAD
>>>>>>> 7e26ae0ed00df99f6fe0236388fd5d6c2090292e
// load the global Cypress types
/// <reference types="cypress" />

import { mount } from 'cypress/react'
// load the 3rd party command definition
/// <reference types="cypress-wait-until" />

<<<<<<< HEAD
=======
=======
/// <reference types="cypress" />

>>>>>>> 66389675fb764448964dc7d97d8eb66f3d517bd5
>>>>>>> 7e26ae0ed00df99f6fe0236388fd5d6c2090292e
// import { mount } from 'cypress/react'

// Augment the Cypress namespace to include type definitions for
// your custom command.
// Alternatively, can be defined in cypress/support/component.d.ts
// with a <reference path="./component" /> at the top of your spec.
// cypress/support/index.ts

<<<<<<< HEAD

import { DataHora, dadosParametros } from '../dadosParametros'


=======
<<<<<<< HEAD

import { DataHora, dadosParametros } from '../dadosParametros'


=======
export interface DataHora {
    DATA_FORMATADA: string;
    HORA_FORMATADA: string;
}


export enum Perfil {
    Administrador = "profile_admin",
    Normal = "profile_normal",
    SuprimentosHKM = "profile_suprimentos_hkm",
    SuprimentosINP = "profile_suprimentos_inp",
    GestorUsuarios = "gestor_usuarios",
    GestorFornecedores = "gestor_fornecedores",
}


export enum OpcaoAutorizacao {
    Autorizado = '1',
    NaoAutorizado = '0',
}
>>>>>>> 66389675fb764448964dc7d97d8eb66f3d517bd5
>>>>>>> 7e26ae0ed00df99f6fe0236388fd5d6c2090292e




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
<<<<<<< HEAD
            loginLogoutWithViewport: (size: number | [number, number] | string,) => void;
=======
            loginLogoutWithViewport: (
                size: number | [number, number] | string,
                dadosAmbiente: {
                    EMAIL: string;
                    SENHA: string;
                    BASEURL: string;
                }
            ) => void;

>>>>>>> 66389675fb764448964dc7d97d8eb66f3d517bd5

            /**
            * comando customizado para inserir email no login Gecom.
            * @example cy.inserirEmailLogin()
            */
<<<<<<< HEAD
            inserirEmailLogin(element: string, credenciais: string | { value: string }): Chainable<Element>;
=======
<<<<<<< HEAD
            inserirEmailLogin(element: string, credenciais: string | { value: string }): Chainable<Element>;
=======
            inserirEmailLogin(element: string, credenciais: string | { value: string }): Chainable<Subject>;
>>>>>>> 66389675fb764448964dc7d97d8eb66f3d517bd5
>>>>>>> 7e26ae0ed00df99f6fe0236388fd5d6c2090292e

            /**
            * comando customizado para inserir senha no login Gecom.
            * @example cy.inserirSenhaLogin()
            */
<<<<<<< HEAD
            inserirSenhaLogin(element: string, credenciais: string | { value: string }): Chainable<Element>;
=======
<<<<<<< HEAD
            inserirSenhaLogin(element: string, credenciais: string | { value: string }): Chainable<Element>;
=======
            inserirSenhaLogin(element: string, credenciais: string | { value: string }): Chainable<Subject>;
>>>>>>> 66389675fb764448964dc7d97d8eb66f3d517bd5
>>>>>>> 7e26ae0ed00df99f6fe0236388fd5d6c2090292e

            /**
            * comando customizado para abrir a opcao de perfil de usuario em Gecom.
            * @example cy.abrirPerfilUsuario()
            */
<<<<<<< HEAD
            abrirPerfilUsuario(element: string): Chainable<Element>
=======
<<<<<<< HEAD
            abrirPerfilUsuario(element: string): Chainable<Element>
=======
            abrirPerfilUsuario(element: string): Chainable<Subject>
>>>>>>> 66389675fb764448964dc7d97d8eb66f3d517bd5
>>>>>>> 7e26ae0ed00df99f6fe0236388fd5d6c2090292e


            /**
            * comando customizado para acessar Gecom.
            * @example cy.entrarGecom()
            */
<<<<<<< HEAD
            entrarGecom(element: string): Chainable<Element>
=======
<<<<<<< HEAD
            entrarGecom(element: string): Chainable<Element>
=======
            entrarGecom(element: string): Chainable<Subject>
>>>>>>> 66389675fb764448964dc7d97d8eb66f3d517bd5
>>>>>>> 7e26ae0ed00df99f6fe0236388fd5d6c2090292e

            /**
             * comando customizado para sair Gecom.
             * @example cy.sairGecom()
            */
<<<<<<< HEAD
            sairGecom(element: string): Chainable<Element>
=======
<<<<<<< HEAD
            sairGecom(element: string): Chainable<Element>
=======
            sairGecom(element: string): Chainable<Subject>
>>>>>>> 66389675fb764448964dc7d97d8eb66f3d517bd5
>>>>>>> 7e26ae0ed00df99f6fe0236388fd5d6c2090292e

            /**
             * comando customizado para acessar o menu cadastro em Gecom.
             * @example cy.acessarMenuCadastro()
            */
<<<<<<< HEAD
            acessarMenuCadastro(element: string): Chainable<Element>
=======
<<<<<<< HEAD
            acessarMenuCadastro(element: string): Chainable<Element>
=======
            acessarMenuCadastro(element: string): Chainable<Subject>
>>>>>>> 66389675fb764448964dc7d97d8eb66f3d517bd5
>>>>>>> 7e26ae0ed00df99f6fe0236388fd5d6c2090292e

            /**
             * comando customizado para acessar o submenu cadastro em Gecom.
             * @example cy.acessarSubmenuCadastroUsuario()
            */
<<<<<<< HEAD
            acessarSubmenuCadastroUsuario(element: string): Chainable<Element>
=======
<<<<<<< HEAD
            acessarSubmenuCadastroUsuario(element: string): Chainable<Element>
=======
            acessarSubmenuCadastroUsuario(element: string): Chainable<Subject>
>>>>>>> 66389675fb764448964dc7d97d8eb66f3d517bd5
>>>>>>> 7e26ae0ed00df99f6fe0236388fd5d6c2090292e

            /**
             * comando customizado para acessar a tela de cadastro de usuarios em Gecom.
             * @example cy.acessarCadastroUsuario()
            */
<<<<<<< HEAD
            acessarCadastroUsuario(element: string): Chainable<Element>
=======
<<<<<<< HEAD
            acessarCadastroUsuario(): Chainable<Element>
=======
            acessarCadastroUsuario(element: string): Chainable<Subject>
>>>>>>> 66389675fb764448964dc7d97d8eb66f3d517bd5
>>>>>>> 7e26ae0ed00df99f6fe0236388fd5d6c2090292e

            /**
             * comando customizado para verificar se o campo tem obrigatoriedade de preenchimento em Gecom.
             * @example cy.verificarObrigatoriedadeCampo()
            */
<<<<<<< HEAD
            verificarObrigatoriedadeCampo(element: string): Chainable<Element>
=======
<<<<<<< HEAD
            verificarObrigatoriedadeCampo(element: string): Chainable<Element>
=======
            verificarObrigatoriedadeCampo(element: string): Chainable<Subject>
>>>>>>> 66389675fb764448964dc7d97d8eb66f3d517bd5
>>>>>>> 7e26ae0ed00df99f6fe0236388fd5d6c2090292e

            /**
            * comando customizado para inserir Data.
            * @example cy.inserirData()
            */
            inserirData(dataAtual: Date): Chainable<DataHora>

            /**
<<<<<<< HEAD
           * comando customizado para inserir Data de nascimento.
           * @example cy.inserirData()
           */
            inserirDataNascimento(element: string): Chainable<Element>

            /**
            * comando customizado para inserir nome.
            * @example cy.inserirNome()
            */
            inserirNome(element: string, nome: string): Chainable<Element>
=======
            * comando customizado para inserir nome.
            * @example cy.inserirNome()
            */
<<<<<<< HEAD
            inserirNome(element: string, nome: string): Chainable<Element>
=======
            inserirNome(element: string, nome: string): Chainable<Subject>
>>>>>>> 66389675fb764448964dc7d97d8eb66f3d517bd5
>>>>>>> 7e26ae0ed00df99f6fe0236388fd5d6c2090292e

            /**
            * comando customizado para inserir cpf.
            * @example cy.inserirCpf()
            */
<<<<<<< HEAD
            inserirCpf(element: string, cpf: string): Chainable<Element>
=======
<<<<<<< HEAD
            inserirCpf(element: string, cpf: string): Chainable<Element>
=======
            inserirCpf(element: string, cpf: string): Chainable<Subject>
>>>>>>> 66389675fb764448964dc7d97d8eb66f3d517bd5
>>>>>>> 7e26ae0ed00df99f6fe0236388fd5d6c2090292e

            /**
            * comando customizado para inserir telefone.
            * @example cy.inserirTelefone()
            */
<<<<<<< HEAD
            inserirTelefone(element: string, telefone: string): Chainable<Element>
=======
<<<<<<< HEAD
            inserirTelefone(element: string, telefone: string): Chainable<Element>
=======
            inserirTelefone(element: string, telefone: string): Chainable<Subject>
>>>>>>> 66389675fb764448964dc7d97d8eb66f3d517bd5
>>>>>>> 7e26ae0ed00df99f6fe0236388fd5d6c2090292e

            /**
            * comando customizado para inserir e-mail.
            * @example cy.inserirEmail()
            */
<<<<<<< HEAD
            inserirEmail(element: string, email: string): Chainable<Element>
=======
<<<<<<< HEAD
            inserirEmail(element: string, email: string): Chainable<Element>
=======
            inserirEmail(element: string, email: string): Chainable<Subject>
>>>>>>> 66389675fb764448964dc7d97d8eb66f3d517bd5
>>>>>>> 7e26ae0ed00df99f6fe0236388fd5d6c2090292e

            /**
            * comando customizado para inserir senha.
            * @example cy.inserirSenha()
            */
<<<<<<< HEAD
            inserirSenha(element: string, senha: string): Chainable<Element>
=======
<<<<<<< HEAD
            inserirSenha(element: string, senha: string): Chainable<Element>
=======
            inserirSenha(element: string, senha: string): Chainable<Subject>
>>>>>>> 66389675fb764448964dc7d97d8eb66f3d517bd5
>>>>>>> 7e26ae0ed00df99f6fe0236388fd5d6c2090292e

            /**
            * comando customizado para selecionar perfil do usuario.
            * @example cy.selecionarPerfil()
            */
<<<<<<< HEAD
            selecionarPerfil(perfil): Chainable<Element>
=======
<<<<<<< HEAD
            selecionarPerfil(perfil): Chainable<Element>
=======
            selecionarPerfil(perfil: Perfil): Chainable<Subject>
>>>>>>> 66389675fb764448964dc7d97d8eb66f3d517bd5
>>>>>>> 7e26ae0ed00df99f6fe0236388fd5d6c2090292e

            /**
            * comando customizado para selecionar se usuario é autorizado ou não para solicitar.
            * @example cy.selecionarAutorizacaoParaSolicitar()
            */
<<<<<<< HEAD
            selecionarAutorizacaoParaSolicitar(opcao): Chainable<Element>
=======
<<<<<<< HEAD
            selecionarAutorizacaoParaSolicitar(opcao): Chainable<Element>
=======
            selecionarAutorizacaoParaSolicitar(opcao: OpcaoAutorizacao): Chainable<Subject>
>>>>>>> 66389675fb764448964dc7d97d8eb66f3d517bd5
>>>>>>> 7e26ae0ed00df99f6fe0236388fd5d6c2090292e

            /**
            * comando customizado para inserir setor do usuário.
            * @example cy.inserirSetorUsuario()
            */
<<<<<<< HEAD
            inserirSetorUsuario(setorUsuario: string, opcaoSetorUsuario: string, opcaoSelectSetorUsuario: string, opcaoSelecionadaSetorUsuario: string): Chainable<Element>;
=======
<<<<<<< HEAD
            inserirSetorUsuario(setorUsuario: string, opcaoSetorUsuario: string, opcaoSelectSetorUsuario: string, opcaoSelecionadaSetorUsuario: string): Chainable<Element>;
=======
            inserirSetorUsuario(setorUsuario: string, opcaoSetorUsuario: string, opcaoSelectSetorUsuario: string, opcaoSelecionadaSetorUsuario: string): Chainable<Subject>;
>>>>>>> 66389675fb764448964dc7d97d8eb66f3d517bd5
>>>>>>> 7e26ae0ed00df99f6fe0236388fd5d6c2090292e

            /**
            * comando customizado para inserir usuario aprovador.
            * @example cy.inserirUsuarioAprovador()
            */
<<<<<<< HEAD
            inserirUsuarioAprovador(usuarioAprovador: string, opcaoUsuarioAprovador: string): Chainable<Element>;
=======
<<<<<<< HEAD
            inserirUsuarioAprovador(usuarioAprovador: string, opcaoUsuarioAprovador: string): Chainable<Element>;
=======
            inserirUsuarioAprovador(usuarioAprovador: string, opcaoUsuarioAprovador: string): Chainable<Subject>;
>>>>>>> 66389675fb764448964dc7d97d8eb66f3d517bd5
>>>>>>> 7e26ae0ed00df99f6fe0236388fd5d6c2090292e

            /**
            * comando customizado para inserir limite de aprovação do usuário.
            * @example cy.inserirLimiteAprovacao()
            */
<<<<<<< HEAD
            inserirLimiteAprovacao(value: string, element: string): Chainable<Element>;
=======
<<<<<<< HEAD
            inserirLimiteAprovacao(value: string, element: string): Chainable<Element>;
=======
            inserirLimiteAprovacao(value: string, element: string): Chainable<Subject>;
>>>>>>> 66389675fb764448964dc7d97d8eb66f3d517bd5
>>>>>>> 7e26ae0ed00df99f6fe0236388fd5d6c2090292e

            /**
            * comando customizado para inserir centros de custos permitidos para o usuario.
            * @example cy.inserirCentroCustoPermitido()
            */
<<<<<<< HEAD
=======
<<<<<<< HEAD
>>>>>>> 7e26ae0ed00df99f6fe0236388fd5d6c2090292e
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
<<<<<<< HEAD
=======
=======
            inserirCentroCustoPermitido(element:string): Chainable<Subject>;
>>>>>>> 66389675fb764448964dc7d97d8eb66f3d517bd5
>>>>>>> 7e26ae0ed00df99f6fe0236388fd5d6c2090292e
        }

    }
}
