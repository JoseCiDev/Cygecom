import {
    ConditionalWrite,
    IsComexImportProduct,
    IsComexImportService,
    ObservationOfRequest,
    QuoteRequest,
    RequestType,
    ServiceName,
    SuggestionLinks,
    Request,
    // ProductRequest,
    // data,
    elements as el,
    DataParameters,
    faker,
    dataParameters
} from '../../../import';
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


describe('Testes da página de criação de solicitação de produtos', () => {


    beforeEach(function () {

        // cy.login('http://gerenciador-compras.docker.local:8085', 'gecom_admin@essentia.com.br', 'essadmin@2023', messageContainer)
        //     .then((result) => {
        //         assert.exists(result.success, result.error)
        //     });
            //http://192.168.0.66:9402/login
            //gecom_admin@essentia.com.br
            //admin123
    });

    it(`Solicitação de produtos`, () => {

        cy.login('http://gerenciador-compras.docker.local:8085', 'gecom_admin@essentia.com.br', 'essadmin@2023', messageContainer)

        // cy.getElementAndClick([
        //     '.main-nav > :nth-child(3) > .btn',
        //     '[data-cy="dropdown-solicitacoes-novas"]',
        //     '.main-nav > :nth-child(3) > .btn',
        //     '[data-cy="dropdown-solicitacoes-novas"]',
        // ]);
        // cy.createRequest(RequestType.product);

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