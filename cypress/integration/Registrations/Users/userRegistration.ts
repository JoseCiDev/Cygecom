/// <reference types="cypress" />
import * as faker from '@faker-js/faker';
import * as fakerBr from 'faker-br';
import { elements as el } from '../../../elements';
import { ValidationResult, dataParameters } from '../../../DataParameters'


const {
    logout,
    optionsMenu,
    menuReduced,
    breadcumbHome,
    breadcumbUser,
    showQuantityRecords,
    SearchRegisteredUser,
    nextPage,
    pagePrevious,
} = el.Shared

const {
    titleLogin,
    email,
    password,
    access,
    messageContainer,
} = el.Login

const {

} = el.CustomCommands

const {
    userProfile,
    homeMenu,
    logoGecom,
    homeScreen,
} = el.Start

const {
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
} = el.Register

const {
    requestMenu,
    newRequestSubMenu,
    myRequestSubMenu,
    requestGeneralSubMenu,
} = el.Request

const {
    supplyMenu,
    dashboardSubMenu,
    productSubMenu,
    serviceSubMenu,
    contractSubMenu,
} = el.Supply


describe('Testes da página Cadastro de Usuário', () => {


    beforeEach(function () {
        cy.login(dataParameters.env.EMAIL_ADMIN, dataParameters.env.PASSWORD_ADMIN, messageContainer)
            .then((result) => {
                assert.exists(result.success, result.error)
            });
    })

    it(`userRegistration`, () => {

    });

})


/*
searchPrescription
newUserRegistration
    VALIDACOES DE CAMPOS
    VALIDACAO CAMPO PASSWORD
    VALIDACAO CAMPO CNPJ
    VALIDACAO CAMPO TELEFONE CELULAR
    VALIDACAO CAMPO EMAIL
    OBRIGATORIEDADE DOS CAMPOS
    LIMITE DE CARACTERES NO CAMPOS
    TIPO DE DADO ACEITO NOS CAMPOS
    VALIDAR MENSAGENS DE RETORNO
    
    telefone
        pessoal
        comercial
    perfil
    setor
    usuárioAprovador
    limite aprovacao    
        valor de aprovacao definido
        sem limite de aprovacao
    autorizacao para solicitar
        nao autorizado
        autorizado
    Solicitar para outros usuarios
        sim
        nao
    centro de custo para solicitar
    centro de custo para aprovar
editNewUser
deleteNewUser

*/