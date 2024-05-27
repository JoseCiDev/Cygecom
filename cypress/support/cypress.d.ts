// load the global Cypress types
/// <reference types="cypress" />


import { mount } from 'cypress/react'
import {
    DateTime,
    ElementTypeAndValueOpcional,
    RequestKeys,
    TableTypesElements,
    ValidationResult
} from '../import';

declare global {
    namespace Cypress {
        interface Chainable<Subject = any> {
            // mount: typeof mount
            /**
             * Custom command para fazer login.
             * @example cy.login()
             */
            login(baseUrl: string, emailAccess: string, passwordAccess: string, elementError: string): ValidationResult;

            /**
            * comando customizado para selecinar elemento e verificar se esta visivel.
            * @example cy.getVisible()
            */
            loginLogoutWithViewport: (size: Cypress.ViewportPreset | [number, number], elementAction: string, elementSubmit: string) => ValidationResult;

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
            insertBirthDate(element: string): ValidationResult

            /**
             * comando customizado para selecionar o elemento e clicar.
             * @example cy.getElementAndClick(el.elemento)
             */
            getElementAndClick(elements: string[]): ValidationResult;

            /**
            * comando customizado de login.
            * @example cy.getElementAndClick(el.elemento)
            */
            getElementAndType(elements: { [key: string]: string }): ValidationResult

            /**
             * comando customizado para capturar elemento e marcar checkbox.
             * @example cy.getElementAndCheck(el.elemento)
             */
            getElementAndCheck(elements: ElementTypeAndValueOpcional): ValidationResult;

            /**
             * comando customizado para selecionar a opcao radio.
             * @example cy.getRadioOptionByValue(element,valor)
             */
            getRadioOptionByValue(elements: ElementTypeAndValueOpcional): ValidationResult

            /**
             * comando customizado para selecionar opção do select.
             * @example cy.getSelectOptionByValue(el.elemento)
             */
            getSelectOptionByValue(elements: ElementTypeAndValueOpcional): ValidationResult;

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
            getElementAutocompleteTypeAndClick(elements: { [key: string]: string }, autocomplete: string): ValidationResult;

            /**
            * comando customizado para ler arquivos
            * @example cy.lerArquivo('orcamentoFilial.json')
            */
            readFileFromFixture(fileName: string): ValidationResult;

            /**
            * comando customizado para inserir arquivos.
            * @example cy.insertFile('img/ReceitaJpeg(1).jpeg', el.importarImagem);
            */
            insertFile(element, filePath): ValidationResult;

            /**
           * comando customizado para inserir arquivos.
           * @example cy.insertFile();
           */
            validateCpfCnpj(element: string, value: string, elementError: string, errorMessage: string): ValidationResult;

            /**
           * comando customizado para checar mensagens de erro nativas do navegador.
           * @example cy.checkValidation();
           */
            checkValidation(text: string): ValidationResult;

            /**
           * comando customizado para ocultar ou mostrar colunas das grids.
           * @example cy.getColumnVisibility();
           */
            getColumnVisibility(table: TableTypesElements): ValidationResult;

            /**
           * comando customizado para ordenar dados pelas colunas da grid.
           * @example cy.getDataOnGrid();
           */
            getDataOnGrid(searchParameterElement?, searchParameterValue?, showRecordsQuantityElement?, showRecordsQuantityValue?, sortByColumnElement?, sortByColumnValue?, searchColumnElement?, searchColumnValue?): ValidationResult;

            /**
           * comando customizado para criar solicitações seja de produtos, serviços pontuais ou serviços recorrentes.
           * @example cy.createRequest();
           */
            createRequest(requestType: string): ValidationResult;

            /**
           * comando customizado para ocultar/mostrar colunas selecionadas.
           * @example cy.getColumnVisibilityCommand();
           */
            getColumnVisibilityCommand(table: TableTypesElements): ValidationResult;

        }

    }
}
