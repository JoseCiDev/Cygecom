/// <reference types="cypress" />

import { faker } from '@faker-js/faker';
import { elements as el } from '../elements';
import { dataParameters } from '../DataParameters'
import { env } from 'process';
import { data } from 'cypress/types/jquery';





export const {
    email,
    password,
    access,
    titleLogin,
    messageContainerIncorrectData,

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

    // it(`Deve ser possível logar em vários dispositivos.`, () => {
    //     dadosParametros.sizes.forEach((size) => {

    //         cy.loginLogoutWithViewport(size);

    //         cy.login(env.EMAIL_ADMIN, env.PASSWORD_ADMIN, messageContainerIncorrectData);

    //         if (Cypress._.isArray(size)) {
    //             cy.get(el.Inicio.perfilUsuario).click();
    //             cy.get(el.Compartilhado.logout).click();
    //         }
    //     });
    // });



    // it('Deve verificar se existe validação para o campo e-mail.', () => {

    //     cy.visit(dadosParametros.env.BASEURL + '/login');

    //     cy.getElementAndType(emailUsuario, '{enter}');

    //     cy.on('window:alert', (mensagem) => {
    //         // Certifique-se de que a mensagem do alerta está correta
    //         expect(mensagem).to.include('Preencha este campo.');


    //     });

    // });



    // it('Deve verificar se a senha inserida não apresenta os caracteres.', () => {

    //     cy.get(titleLogin);

    //     cy.getVisible(password)
    //         .should('have.attr', 'type', 'password');
    // });



    // it.only('Deve realizar login inserindo dados corretos.', () => {

    //     cy.login(env.EMAIL_ADMIN, env.PASSWORD_ADMIN, messageContainerIncorrectData);

    //     cy.getElementAndClick(userProfile);

    //     cy.getElementAndClick(logout);

    // });



    // it('Deve falhar o login devido a dados incorretos.', () => {

    //     cy.login('Teste', 'senha');

    //     cy.url()
    //         .should('contain', `${dadosParametros.url.login}`);
    // });


    // it('Deve falhar o login devido a não inserção de dados.', () => {

    //     cy.entrarGecom(entrar)

    //     cy.url()
    //         .should('contain', `${dadosParametros.url.login}`);
    // });


    // it('Deve falhar o login devido ao preenchimento somente do e-mail.', () => {

    //     cy.getElementAndType(emailUsuario, dadosParametros.env.EMAILADMIN);

    //     cy.getElementAndClick(entrar);

    //     cy.on('window:alert', (message) => {
    //         expect(message).to.equal('Preencha este campo.');
    //     });
    // });


    // it('Deve falhar o login devido ao preenchimento somente da senha.', () => {

    //     cy.getElementAndType(senha, dadosParametros.env.SENHAADMIN);

    //     cy.getElementAndClick(entrar);

    //     cy.on('window:alert', (message) => {
    //         expect(message).to.equal('Preencha este campo.');
    //     });
    // })
})

