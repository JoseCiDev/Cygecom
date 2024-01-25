/// <reference types="cypress" />

import { faker } from '@faker-js/faker';
import { elements as el } from '../elements';
import { ValidationResult, dataParameters } from '../DataParameters'
import { env } from 'process';
import { data } from 'cypress/types/jquery';





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
    messageRequirementName,
    messageRequirementCpfCnpj,
    messageRequiredTelephone,
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



describe('Testes da página Login.', () => {



    beforeEach(function () {

        cy.visit(dataParameters.env.BASE_URL);

    })

    it(`Deve ser possível logar em vários dispositivos.`, () => {
        dataParameters.sizes.forEach((size) => {
            cy.loginLogoutWithViewport(size);

            cy.login(dataParameters.env.EMAIL_ADMIN, dataParameters.env.PASSWORD_ADMIN, messageContainer);

            if (Cypress._.isArray(size)) {
                cy.getElementAndClick(userProfile);
                cy.getElementAndClick(logout);
            }
        });
    });



    it('Deve falhar quando o "@" está ausente no campo de e-mail.', () => {
        cy.login('a', 'a', messageContainer)
            .then((result) => {
                assert.exists(result.success, result.error)
            });
    });
    it('Deve falhar quando a parte após "@" está ausente no campo de e-mail.', () => {
        cy.login('admin@ ', 'b', messageContainer)
            .then((result) => {
                assert.exists(result.success, result.error)
            });
    });
    it('Deve falhar quando "@" é usado mais de uma vez no campo de e-mail.', () => {
        cy.login('admin@@', 'b', messageContainer)
            .then((result) => {
                assert.exists(result.success, result.error)
            });
    });
    it('Deve falhar quando "." é usado imediatamente após "@" no campo de e-mail.', () => {
        cy.login('admin@.', 'b', messageContainer)
            .then((result) => {
                assert.exists(result.success, result.error)
            });
    });
    it('Deve falhar quando um caractere inválido é usado após "@" no campo de e-mail.', () => {
        cy.login('admin@&', 'b', messageContainer)
            .then((result) => {
                assert.exists(result.success, result.error)
            });
    });
    it('Deve falhar quando o formato do e-mail é inválido.', () => {
        cy.login('admin@.com', 'b', messageContainer)
            .then((result) => {
                assert.exists(result.success, result.error)
            });
    });

    it('Deve verificar se o campo de senha está configurado como tipo "password" e se a senha digitada não é exibida na tela.', () => {
        cy.get(password).should('have.attr', 'type', 'password');
        cy.get(password).should('have.value', '');

        cy.login(dataParameters.env.EMAIL_ADMIN, dataParameters.env.PASSWORD_ADMIN, messageContainer)
            .then((result) => {
                assert.exists(result.success, result.error)
            });
        return cy.wrap({ success: 'Campo senha é do tipo password e ao digitar senha no campo não é possivel visualiza-la.' });
    });

    it('Deve efetuar o login utilizando as informações corretas.', () => {
        cy.login(dataParameters.env.EMAIL_ADMIN, dataParameters.env.PASSWORD_ADMIN, messageContainer)
            .then((result) => {
                assert.exists(result.success, result.error)
            });
    });

    it('Deve retornar falha no login devido à inserção de dados incorretos.', () => {
        cy.login('dataParameters.env.EMAIL_ADMIN', 'dataParameters.env.PASSWORD_ADMIN', messageContainer)
            .then((result) => {
                assert.exists(result.success, result.error)
            });
    });

    it('Deve informar que o acesso não foi autorizado devido à ausência de dados de login', () => {

        cy.get(password)
            .type(' ')
            .then(($password) => {
                if ($password.val() === '') {
                    throw new Error('Acesso não foi autorizado devido à ausência de dados de login.');
                }
            });
        cy.get(email)
            .type(' ')
            .then(($email) => {
                if ($email.val() === '') {
                    throw new Error('Acesso não foi autorizado devido à ausência de dados de login.');
                }
            });

    });

    it('Deve retornar falha no login devido ao preenchimento exclusivo do campo de e-mail.', () => {
        cy.login(dataParameters.env.EMAIL_ADMIN, '  ', messageContainer)
            .then((result) => {
                assert.exists(result.success, result.error)
            });
    });

    it('Deve retornar falha no login devido ao preenchimento exclusivo do campo de senha.', () => {
        cy.get(password)
            .type(' ')
            .then(($password) => {
                if ($password.val() === '') {
                    throw new Error('Falha no login devido ao preenchimento exclusivo do campo de senha');
                }
            });
        cy.get(email)
            .type(' ')
            .then(($email) => {
                if ($email.val() === '') {
                    throw new Error('Acesso não foi autorizado devido à ausência de dados de login.');
                }
            });
    })
})

