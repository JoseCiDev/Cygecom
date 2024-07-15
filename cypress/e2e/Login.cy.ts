/// <reference types="cypress" />

import { faker } from '@faker-js/faker';

import { elements as el } from '../elements';
import { env } from 'process';
import { data } from 'cypress/types/jquery';
import { DataParameters } from '../import';
import { dataParameters } from '../DataParameters/dataParameters';






export const {
    email,
    password,
    access,
    titleLogin,
    messageContainer,

} = el.Login;

export const {
    userProfile,
    homeMenu,
    logoGecom,
    homeScreen,

} = el.Start;

export const {
    logout,
    optionsMenu,
    menuReduced,
    breadcumbHome,
    breadcumbUser,
    showQuantityRecords,
    SearchRegisteredUser,
    nextPage,
    pagePrevious,

} = el.Shared;

export const {
    registrationMenu,
    registrationMenuReduced,
    registrationUserSubMenu,
    createNewUser,
    username,
    birthdateUser,
    cpfCnpjUser,
    phoneUser,
    emailUser,
    userPassword,
    confirmUserPassword,
    sectorUser,
    optionUserSector,
    optionSelectUserSector,
    optionSelectedSectorUser,
    userApprover,
    optionUserApprover,
    limitUserApproval,
    centerPermittedCostUser,
    selectAllAllowedCostCenterUser,
    clearCenterPermittedCostUser,
    saveUserRegistration,
    cancelUserRegistration,
    registrationSupplierSubMenu,
} = el.Register;

export const {
    requestMenu,
    newRequestSubMenu,
    myRequestSubMenu,
    requestGeneralSubMenu,

} = el.Request;

export const {
    supplyMenu,
    dashboardSubMenu,
    productSubMenu,
    serviceSubMenu,
    contractSubMenu,

} = el.Supply;

const environment = Cypress.env('ENVIRONMENT');
const dataEnvironment = Cypress.env(environment);

describe('Testes da página Login.', () => {

    beforeEach(function () {

    })

    it('Deve efetuar o login com sucesso.', () => {
        cy.login(dataEnvironment.BASE_URL_CI, dataEnvironment.EMAIL_ADMIN_CI, dataEnvironment.PASSWORD_ADMIN_CI, messageContainer)
            .then((result) => {
                assert.exists(result.success, result.error)
            });
    });

    it('Deve falhar ao tentar efetuar o login com credenciais inválidas.', () => {
        cy.login(dataEnvironment.BASE_URL_CI, 'email_invalido@example.com', 'senha_incorreta', messageContainer)
            .then((result) => {
                assert.exists(result.success, 'Foi informado usuário ou senha incorretos na aplicação');
            });
    });

    it('Deve falhar ao tentar efetuar o login com campos vazios', () => {

        cy.visit(dataEnvironment.BASE_URL_CI);

        cy.getElementAndType({ [email]: ' ' })
        cy.getElementAndType({ [password]: ' ' })

        return cy.wrap({ error: 'Não é possível realizar o login com campos vazios' });
    });


    it('Deve falhar ao tentar efetuar o login com senha incorreta.', () => {
        cy.login(dataEnvironment.BASE_URL_CI, dataEnvironment.EMAIL_ADMIN_CI, 'senha_incorreta', messageContainer)
            .then((result) => {
                assert.exists(result.success, 'Não é possível realizar o login com o usuário e a senha incorretos.');
            });
    });

    it('Deve falhar ao tentar efetuar o login com um usuário não existente.', () => {
        cy.login(dataEnvironment.BASE_URL_CI, 'nao_existente@example.com', 'qualquer_senha', messageContainer)
            .then((result) => {
                assert.exists(result.success, 'Não é possível realizar o login com o usuário inexistente.');
            });
    });

    it('Deve efetuar o logout com sucesso.', () => {
        cy.login(dataEnvironment.BASE_URL_CI, dataEnvironment.EMAIL_ADMIN_CI, dataEnvironment.PASSWORD_ADMIN_CI, messageContainer)
        cy.logout()
            .then((result) => {
                assert.exists(result.success, 'Realizado logout com sucesso.');
            });
    });
});