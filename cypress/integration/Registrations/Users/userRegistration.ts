import * as faker from '@faker-js/faker';
import * as fakerBr from 'faker-br';
import { elements as el } from '../../../elements';
import { ValidationResult, dataParameters, TableTypes, ColumnEnums, SearchParameter, TableTypesElements } from '../../../DataParameters'
import { data } from 'cypress/types/jquery';


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

export function getColumnVisibilityCommand(table: TableTypesElements) {
    cy.wait(1000);
    cy.get(table, { timeout: 2000 })
        .as('btn')
        .click({ timeout: 2000, force: true })

    // Para cada coluna em columnVisibility, se o valor for true, clique para ocultar a coluna
    for (const idx of dataParameters.Register.searchParameter.showHideColumnsUserRegistration) {
        // nesse caso, idx é o seletor da coluna
        cy.get(`button[data-cv-idx="${idx}"]`).click();
    }
}

describe('Testes da página Cadastro de Usuário', () => {


    beforeEach(function () {
        cy.login(dataParameters.env.EMAIL_ADMIN, dataParameters.env.PASSWORD_ADMIN, messageContainer)
            .then((result) => {
                assert.exists(result.success, result.error)
            });
    })

    it(`userRegistration`, () => {
        cy.getElementAndClick(':nth-child(2) > .btn')
        cy.getElementAndClick('[data-cy="dropdown-cadastros-usuarios"]')

        getColumnVisibilityCommand(TableTypesElements.uSerTable);
        //criar um enum com a estrutura do menu,passar os elementos em um enum, criar um comando que clica no elemento do menu de acordo com o parametro passado, estudar essa estrutura.
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
    
    
editNewUser
deleteNewUser

*/