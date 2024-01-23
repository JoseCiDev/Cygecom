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


import { DateTime, ValidationResult, dataParameters } from '../DataParameters'

declare global {
    namespace Cypress {
        interface Chainable<Subject = any> {
            // mount: typeof mount
            /**
             * Custom command para fazer login.
             * @example cy.login()
             */
            login(emailAccess: string, passwordAccess: string, elementError: string): ValidationResult;

            /**
            * comando customizado para selecinar elemento e verificar se esta visivel.
            * @example cy.getVisible()
            */
            loginLogoutWithViewport: (size: number | [number, number] | string,) => ValidationResult;

            /**
             * comando customizado para verificar se o campo tem obrigatoriedade de preenchimento em Gecom.
             * @example cy.verificarObrigatoriedadeCampo()
            */
            checkRequiredField(element: string, value: string, elementError: string, mensagemErro?: string): ValidationResult

            /**
            * comando customizado para inserir Data.
            * @example cy.inserirData()
            */
            insertDate(currentDate: Date): Chainable<DateTime>

            /**
           * comando customizado para inserir Data de nascimento.
           * @example cy.inserirData()
           */
            insertBirthDate(element: string): Chainable<Element>

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

            /**
             * comando customizado para verificar a quantidade máxima de caracteres.
             * @example cy.maximumNumberCharacters(element, value)
             */
            maximumNumberCharacters(element: string, value: string, quantidadeMinima: number, elementError: string): ValidationResult;

            /**
             * comando customizado para verificar a quantidade minima de caracteres.
             * @example cy.minimumNumberCharacters(element, value)
             */
            minimumNumberCharacters(element: string, value: string, minimumQuantity: number, elementError: string): ValidationResult;

            /**
           * * comando customizado para guardar modal e clicar.
           * @example cy.waitModalAndClick(orcamentista,atendente)
           */
            waitModalAndClick(jqueryElement: string, element: string): ValidationResult;

            /**
           * * comando customizado para selecionar elemento autocomplete apos digitar e capturar sugestão autocomplete clicando.
           * @example cy.getElementAutocompleteTypeAndClick(orcamentista,atendente)
           */
            getElementAutocompleteTypeAndClick(element: string, data: string | number | boolean, autocomplete: string): ValidationResult;

            /**
            * comando customizado para ler arquivos
            * @example cy.lerArquivo('orcamentoFilial.json')
            */
            readFile(nomeArquivo: string): ValidationResult;

            /**
            * comando customizado para inserir arquivos.
            * @example cy.insertFile('img/ReceitaJpeg(1).jpeg', el.importarImagem);
            */
            insertFile(fixturePath, elementoBotao): ValidationResult;

            /**
           * comando customizado para inserir arquivos.
           * @example cy.insertFile('img/ReceitaJpeg(1).jpeg', el.importarImagem);
           */
            validateCpfCnpj(element: string, value: string, elementError: string, errorMessage: string): ValidationResult;
        }

    }
}
