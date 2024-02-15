import { elements as el } from '../../elements';
import { dataParameters } from '../../dataParameters'
import { 
    ShowRecordsQuantityElement, 
    SortByColumnElement, 
    SearchColumnElement, 
    SearchParameterElement 
} from '../../import';




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
    searchColumn,
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

        cy.getElementAndClick(['[data-cy="dropdown-solicitacoes-minhas"]', ':nth-child(2) > .btn'])

        cy.getDataOnGrid(
            ShowRecordsQuantityElement.requestsTable, dataParameters.getDataOnGrid.showRecordsQuantity,
            SortByColumnElement.requestsTable, dataParameters.getDataOnGrid.tableColumnsMyRequests,
            SearchColumnElement.requestsTable, dataParameters.getDataOnGrid.searchColumnMyRequests,
            SearchParameterElement.requestsTable, dataParameters.getDataOnGrid.searchParameter,
        ).then((result) => {
            assert.exists(result.success, result.error)
        });

    });
})
