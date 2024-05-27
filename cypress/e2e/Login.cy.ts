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

    })

    it('Deve efetuar o login com sucesso.', () => {
        // cy.login('gecom_admin@essentia.com.br', 'essadmin@2023', messageContainer)
        cy.log('http://gerenciador-compras.docker.local:8085');

        cy.visit('http://gerenciador-compras.docker.local:8085');
        

    });
});




