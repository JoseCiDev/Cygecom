interface Elements<S = string> {

    Shared: {
        logout: S;
        optionsMenu: S;
        menuReduced: S;
        breadcumbHome: S;
        breadcumbUser: S;
        showQuantityRecords: S;
        SearchRegisteredUser: S;
        nextPage: S;
        pagePrevious: S;
    };

    Login: {
        titleLogin: S;
        email: S;
        password: S;
        access: S;
        messageContainer: S;
    };

    CustomCommands: {

    },

    Start: {
        userProfile: S;
        homeMenu: S;
        logoGecom: S;
        homeScreen: S;
    },

    Register: {
        registrationMenu: S;
        registrationMenuReduced: S;
        registrationUserSubMenu: S;
        createNewUser: S;
        username: S;
        birthdateUser: S;
        cpfCnpjUser: S;
        phoneUser: S;
        emailUser: S;
        userPassword: S;
        confirmUserPassword: S;
        sectorUser: S;
        optionUserSector: S;
        optionSelectUserSector: S;
        optionSelectedSectorUser: S;
        userApprover: S;
        optionUserApprover: S;
        limitUserApproval: S;
        centerPermittedCostUser: S;
        selectAllAllowedCostCenterUser: S;
        clearCenterPermittedCostUser: S;
        saveUserRegistration: S;
        cancelUserRegistration: S;
        registrationSupplierSubMenu: S;
        searchColumn: S;
    },

    Request: {
        requestMenu: S;
        newRequestSubMenu: S;
        myRequestSubMenu: S;
        requestGeneralSubMenu: S;
        serviceDescription: S;
        costCenter: S;
        apportionmentPercentageElement: S;
        apportionmentValueElement: S;
        quoteRequest: S;
        reasonForRequest: S;
        desiredDeliveryDate: S;
        localDescription: S;
        paymentCondition: S;
        paymentMethod: S;
        highlightedOption: S;
        searchPaymentMethodAndTerms: S;
        totalValue: S;
        paymentInstallments: S;
        paymentDetails: S;
        initialPaymentTerm: S;
        finalPaymentTerm: S;
        recurrence: S;
        dueDate: S;
        category: S;
        nameAndDescription: S;
        quantity: S;
        color: S;
        size: S;
        model: S;
        link: S;
        seller: S;
        telephone: S;
        email: S;
        attachedFile: S;
        description: S;
        initialPaymentEffectiveDate: S;
        finalPaymentEffectiveDate: S;
        paymentRecurrence: S;
        paymentDueDate: S;
        toAgreeModalSubmitRequest: S;
        firstWarningPercentageApportionment: S;
        secondWarningPercentageApportionment: S;
        firstWarningValueApportionment: S;
        secondWarningValueApportionment: S;
        productRequest: S;
        oneOffServiceRequest: S;
        recurringServiceRequest: S;
        errorMessageElementReasonForRequest: S;
        errorMessageElementLocalDescription: S;
        requestNumberRequestList: S;
    },

    Supply: {
        supplyMenu: S;
        dashboardSubMenu: S;
        productSubMenu: S;
        serviceSubMenu: S;
        contractSubMenu: S;
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
        messageContainer: '#login-form > div.alert.alert-danger',
    },

    CustomCommands: {

    },

    Start: {
        userProfile: '.user > .dropdown > .btn',
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
        searchColumn: 'tr.search-bar',
    },

    Request: {
        productRequest: ':nth-child(1) > .request-dashboard-requests-item-btn',
        oneOffServiceRequest: ":nth-child(2) > .request-dashboard-requests-item-btn",
        recurringServiceRequest: ":nth-child(3) > .request-dashboard-requests-item-btn",
        requestMenu: '.main-nav > :nth-child(3) > .btn',
        newRequestSubMenu: '[data-cy="dropdown-solicitacoes-novas"]',
        myRequestSubMenu: '[data-cy="dropdown-solicitacoes-minhas"]',
        requestGeneralSubMenu: '[data-cy="dropdown-solicitacoes-minhas"]',
        serviceDescription: '.col-sm-7 > .form-group > [data-cy="description"]',
        costCenter: '#select2-cost_center_apportionments0cost_center_id-container',
        highlightedOption: '[class="select2-results__option select2-results__option--highlighted"]',
        apportionmentPercentageElement: '[data-cy="cost_center_apportionments[0][apportionment_percentage]"]',
        apportionmentValueElement: '[data-cy="cost_center_apportionments[0][apportionment_currency]"]',
        quoteRequest: '[data-cy="checkbox-only-quotation"]',
        reasonForRequest: '[data-cy="reason"]',
        desiredDeliveryDate: '[data-cy="desired-date"]',
        localDescription: '[data-cy="local-description"]',
        paymentCondition: '#select2-payment-terms-container',
        paymentMethod: '#select2-payment-method-container > span',
        searchPaymentMethodAndTerms: '.select2-search__field',
        totalValue: '[data-cy="format-amount"]',
        paymentInstallments: '#request-form > div.full-product-line.product-form > div.payment-block > div:nth-child(2) > div.col-sm-1 > div > input.form-control.format-installments-number',
        paymentDetails: '[data-cy="payment-info-description"]',
        initialPaymentTerm: '[data-cy="contract[start_date]"]',
        finalPaymentTerm: '[data-cy="contract[end_date]"]',
        recurrence: '#select2-recurrence-container',
        dueDate: '#select2-contract-payday-container',
        category: '#request-form > div.full-product-line.product-form > div.supplier-container > div > div.row.mt-2 > div > div > div > div:nth-child(1) > div.col-sm-5 > div > span > span.selection > span',
        nameAndDescription: '[data-cy="purchase_request_products[0][products][0][name]"]',
        quantity: '[data-cy="purchase_request_products[0][products][0][quantity]"]',
        color: '[data-cy="purchase_request_products[0][products][0][color]"]',
        size: '[data-cy="purchase_request_products[0][products][0][size]"]',
        model: '[data-cy="purchase_request_products[0][products][0][model]"]',
        link: '[data-cy="purchase_request_products[0][products][0][link]"]',
        seller: '[data-cy="attendant"]',
        telephone: '[data-cy="phone-number"]',
        email: ':nth-child(4) > .form-group > [data-cy="email"]',
        attachedFile: '[data-cy="files"]',
        description: '.col-sm-7 > .form-group > [data-cy="description"]',
        initialPaymentEffectiveDate: '[data-cy="contract[start_date]"]',
        finalPaymentEffectiveDate: '[data-cy="contract[end_date]"]',
        paymentRecurrence: '#select2-recurrence-container',
        paymentDueDate: '#select2-contract-payday-container',
        toAgreeModalSubmitRequest: '#modal-alert-submit',
        firstWarningPercentageApportionment: '[id="cost_center_apportionments[0][apportionment_percentage]-error"]',
        secondWarningPercentageApportionment: '.percentage-span-warning',
        firstWarningValueApportionment: '[id="cost_center_apportionments[0][apportionment_currency]-error"]',
        secondWarningValueApportionment: '.currency-span-warning',
        errorMessageElementReasonForRequest: '#reason-error',
        errorMessageElementLocalDescription: '#local-description-error',
        requestNumberRequestList:'#requests-table_wrapper > div.dataTables_scroll > div.dataTables_scrollHead > div > table > thead > tr > th.noColvis.sorting > input'
    },

    Supply: {
        supplyMenu: '[data-cy="dropdown-suprimentos"]',
        dashboardSubMenu: '[data-cy="dropdown-supplimentos-dashboard"]',
        productSubMenu: '[data-cy="dropdown-supplimentos-produtos"]',
        serviceSubMenu: '[data-cy="dropdown-suprimentos-servicos"]',
        contractSubMenu: '[data-cy="dropdown-suprimentos-contratos"]',
    },
}
