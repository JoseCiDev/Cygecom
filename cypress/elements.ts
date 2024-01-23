interface Elements<T = string> {

    Shared: {
        logout: T;
        optionsMenu: T;
        menuReduced: T;
        breadcumbHome: T;
        breadcumbUser: T;
        showQuantityRecords: T;
        SearchRegisteredUser: T;
        nextPage: T;
        pagePrevious: T;
    };

    Login: {
        titleLogin: T;
        email: T;
        password: T;
        access: T;
        messageContainerIncorrectData: T;
    };

    CustomCommands: {

    },

    Start: {
        userProfile: T;
        homeMenu: T;
        logoGecom: T;
        homeScreen: T;
    },

    Register: {
        registrationMenu: T;
        registrationMenuReduced: T;
        registrationUserSubMenu: T;
        createNewUser: T;
        username: T;
        birthdateUser: T;
        cpfCnpjUser: T;
        phoneUser: T;
        emailUser: T;
        userPassword: T;
        confirmUserPassword: T;
        sectorUser: T;
        optionUserSector: T;
        optionSelectUserSector: T;
        optionSelectedSectorUser: T;
        userApprover: T;
        optionUserApprover: T;
        limitUserApproval: T;
        centerPermittedCostUser: T;
        selectAllAllowedCostCenterUser: T;
        clearCenterPermittedCostUser: T;
        saveUserRegistration: T;
        cancelUserRegistration: T;
        registrationSupplierSubMenu: T;
        messageRequirementName: T;
        messageRequirementCpfCnpj: T;
        messageRequiredTelephone: T;
    },

    Request: {
        requestMenu: T;
        newRequestSubMenu: T;
        myRequestSubMenu: T;
        requestGeneralSubMenu: T;
    },

    Supply: {
        supplyMenu: T;
        dashboardSubMenu: T;
        productSubMenu: T;
        serviceSubMenu: T;
        contractSubMenu: T;
    },
}



export const elements: Elements = {

    Shared: {
        logout: '[data-cy="btn-logout"]',
        optionsMenu: 'ul.main-nav li',
        menuReduced: '.toggle-mobile',
        breadcumbHome: '[data-cy="breadcrumb-0"]',
        breadcumbUser: '[data-cy="breadcrumb-1"]',
        showQuantityRecords: 'select',
        SearchRegisteredUser: 'label > input',
        nextPage: '#DataTables_Table_0_next',
        pagePrevious: '#DataTables_Table_0_previous',
    },

    Login: {
        titleLogin: '.login-logo',
        email: '[data-cy="email"]',
        password: '[data-cy="password"]',
        access: '[data-cy="btn-login-entrar"]',
        messageContainerIncorrectData: '#login-form > div.alert.alert-danger',
    },

    CustomCommands: {

    },

    Start: {
        userProfile: '[data-cy="profile-dropdown"]',
        homeMenu: '[data-cy="route-home"]',
        logoGecom: '[data-cy="logo-gecom"]',
        homeScreen: '#main',
    },

    Register: {
        registrationMenu: '[data-cy="dropdown-cadastros"]',
        registrationMenuReduced: '.mobile-nav > :nth-child(2) > [href="#"]',
        registrationUserSubMenu: '[data-cy="dropdown-cadastros-usuarios"]',
        createNewUser: '[data-cy="btn-new-user"]',
        username: '[data-cy="name"]',
        birthdateUser: '[data-cy="birthdate"]',
        cpfCnpjUser: '[data-cy="cpf_cnpj"]',
        phoneUser: '[data-cy="number"]',
        emailUser: '[data-cy="email"]',
        userPassword: '[data-cy="password"]',
        confirmUserPassword: '[data-cy="password-confirm"]',
        sectorUser: '#cost_center_id_chosen > .chosen-single',
        optionUserSector: 'select#cost_center_id.chosen-select.form-control>',
        optionSelectUserSector: 'select#cost_center_id.chosen-select.form-control',
        optionSelectedSectorUser: 'ul.chosen-results li.active-result:nth-child(2)',
        userApprover: '#approve_user_id_chosen > a',
        optionUserApprover: 'ul.chosen-results li.active-result',
        limitUserApproval: '[data-cy="format-approve-limit"]',
        centerPermittedCostUser: '.chosen-choices',
        selectAllAllowedCostCenterUser: '[data-cy="btn-select-all-cost-centers"]',
        clearCenterPermittedCostUser: '[data-cy="btn-clear-cost-centers"]',
        saveUserRegistration: '[data-cy="btn-submit-salvar"]',
        cancelUserRegistration: '[data-cy="btn-cancel"]',
        registrationSupplierSubMenu: '[data-cy="dropdown-cadastros-vencedores"]',
        messageRequirementName: '#name-error',
        messageRequirementCpfCnpj: '#cpf_cnpj-error',
        messageRequiredTelephone: '#number-error',
    },

    Request: {
        requestMenu: '[data-cy="dropdown-solicitacoes"]',
        newRequestSubMenu: '[data-cy="dropdown-solicitacoes-novas"]',
        myRequestSubMenu: '[data-cy="dropdown-solicitacoes-minhas"]',
        requestGeneralSubMenu: '[data-cy="dropdown-solicitacoes-minhas"]',
    },

    Supply: {
        supplyMenu: '[data-cy="dropdown-suprimentos"]',
        dashboardSubMenu: '[data-cy="dropdown-supplimentos-dashboard"]',
        productSubMenu: '[data-cy="dropdown-supplimentos-produtos"]',
        serviceSubMenu: '[data-cy="dropdown-suprimentos-servicos"]',
        contractSubMenu: '[data-cy="dropdown-suprimentos-contratos"]',
    },


}
