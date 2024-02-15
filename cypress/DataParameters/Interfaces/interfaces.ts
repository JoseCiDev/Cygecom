/// <reference path="../../support/cypress.d.ts" />

import { faker } from '@faker-js/faker';
import * as fakerBr from 'faker-br';
import { format } from 'date-fns';
import {
    AllowedApprovalCostCenter,
    AllowedRequestCostCenter,
    ApproveLimit,
    ApproverUser,
    AutorizedRequest,
    ColumnSearchParameter,
    ComexImport,
    ConditionalWrite,
    DateTimeRecord,
    ProductCategory,
    QuoteRequest,
    RequestOtherUsers,
    SaveRequest,
    SearchColumnGeneralRequests,
    SearchColumnMyRequests,
    SearchColumnOneOffServiceRequests,
    SearchColumnProductRequests,
    SearchColumnRecurringServiceRequests,
    Sector,
    ShowHideColumnsGeneralRequests,
    ShowHideColumnsMyRequests,
    ShowHideColumnsOneOffServiceRequests,
    ShowHideColumnsProductRequests,
    ShowHideColumnsProductivityReport,
    ShowHideColumnsProfilesTable,
    ShowHideColumnsRecurringServiceRequests,
    ShowHideColumnsRequestReport,
    ShowHideColumnsSupplierRegistration,
    ShowHideColumnsUserRegistration,
    ShowRecordsQuantity,
    SupplierOfRequest,
    TableColumnsGeneralRequests,
    TableColumnsMyRequests,
    TableColumnsOneOffServiceRequests,
    TableColumnsProductRequests,
    TableColumnsProductivityReport,
    TableColumnsProfilesTable,
    TableColumnsRecurringServiceRequests,
    TableColumnsRequestReport,
    TableColumnsSupplierRegistration,
    TableColumnsUserRegistration,
    TelephoneType,
    UserProfile
} from '../../import';



const environment = Cypress.env('ENVIRONMENT');
const dataEnvironment = Cypress.env(environment);


export interface UserRegistration<S = string> {
    name: S;
    birthDate: Date;
    cpf: number;
    cnpj: number;
    telephone: S;
    email: S;
    password: S;
    confirmPassword: S;
    userProfile: UserProfile;
    sector: Sector;
    approverUser: ApproverUser;
    approvalLimit: number;
    authorizationRequest: S;
    requestOtherUsers: S;
    allowedRequestCostCenter: AllowedRequestCostCenter;
    allowedApprovalCostCenter: AllowedApprovalCostCenter;
};

export interface ShowHideColumns<S = string> {
    showHideColumnsUserRegistration: Record<ShowHideColumnsUserRegistration, boolean>,
    showHideColumnsSupplierRegistration: Record<ShowHideColumnsSupplierRegistration, boolean>,
    showHideColumnsMyRequests: Record<ShowHideColumnsMyRequests, boolean>,
    showHideColumnsGeneralRequests: Record<ShowHideColumnsGeneralRequests, boolean>,
    showHideColumnsProductRequests: Record<ShowHideColumnsProductRequests, boolean>,
    showHideColumnsOneOffServiceRequests: Record<ShowHideColumnsOneOffServiceRequests, boolean>,
    showHideColumnsRecurringServiceRequests: Record<ShowHideColumnsRecurringServiceRequests, boolean>,
    showHideColumnsRequestReport: Record<ShowHideColumnsRequestReport, boolean>,
    showHideColumnsProductivityReport: Record<ShowHideColumnsProductivityReport, boolean>,
    showHideColumnsProfilesTable: Record<ShowHideColumnsProfilesTable, boolean>,
}

export interface GetDataOnGrid<S = string> {
    searchParameter: S;
    showRecordsQuantity: ShowRecordsQuantity;


    searchColumnMyRequests: ColumnSearchParameter;
    searchColumnGeneralRequests: ColumnSearchParameter;
    searchColumnProductRequests: ColumnSearchParameter;
    searchColumnOneOffServiceRequests: ColumnSearchParameter;
    searchColumnRecurringServiceRequests: ColumnSearchParameter;

    tableColumnsUserRegistration: Record<TableColumnsUserRegistration, boolean>
    tableColumnsSupplierRegistration: Record<TableColumnsSupplierRegistration, boolean>,
    tableColumnsMyRequests: Record<TableColumnsMyRequests, boolean>,
    tableColumnsGeneralRequests: Record<TableColumnsGeneralRequests, boolean>,
    tableColumnsProductRequests: Record<TableColumnsProductRequests, boolean>,
    tableColumnsOneOffServiceRequests: Record<TableColumnsOneOffServiceRequests, boolean>,
    tableColumnsRecurringServiceRequests: Record<TableColumnsRecurringServiceRequests, boolean>,
    tableColumnsRequestReport: Record<TableColumnsRequestReport, boolean>,
    tableColumnsProductivityReport: Record<TableColumnsProductivityReport, boolean>,
    tableColumnsProfilesTable: Record<TableColumnsProfilesTable, boolean>,

}
export interface DateTime<S = string> {
    FORMATTED_DATE: S;
    FORMATTED_TIME: S;
}
export interface CheckAndThrowError<S = string> {
    condition: boolean;
    errorMessage: S;
}

export interface DataParameters<S = string> {

    Autentication: {
        domain;
        email: S;
        password: S;
        giantPassword: S;
    };
    Register: {
        userRegistration: UserRegistration<S>;
    };
    Request: {
        product: {
            costCenter: S;
            apportionmentPercentage: S | number;
            apportionmentValue: S | number;
            quoteRequest: Record<QuoteRequest, boolean>;
            acquiringArea: string;
            comexImport: ComexImport;
            reasonForRequest: string;
            desiredDeliveryDate: DateTimeRecord;
            productStorageLocation: S;
            suggestionLinks: S;
            observation: S;
            paymentCondition: ConditionalWrite;
            totalValue: S | number;
            paymentMethod: ConditionalWrite;
            paymentInstallments: S | number;
            paymentDetails: S;
            supplier: SupplierOfRequest;
            productCategory: ProductCategory;
            productNameAndDescription: S;
            productQuantity: S | number;
            productColor: S;
            productSize: S | number;
            productModel: S;
            productLink: S;
            attachedFile: S;
            saveRequest: Record<SaveRequest, boolean>;

        },
        oneOffService: {},
        recurringService: {},
    },

    showHideColumns: ShowHideColumns;
    getDataOnGrid: GetDataOnGrid;
    env: {
        ENV: S;
        EMAIL_ADMIN: S;
        PASSWORD_ADMIN: S;
        EMAIL_USER_PADRAO: S;
        PASSWORD_USER_PADRAO: S;
        EMAIL_GESTOR_USUARIO: S;
        PASSWORD_GESTOR_USUARIO: S;
        BASE_URL: S;
        DB_NAME: S;
        DB_USER: S;
        DB_HOST: S;
        DB_PORT: S;
        DB_PASSWORD: S;
    };

    url: {
        login: S;
    };

    sizes: Array<number | [number, number] | S>;

    filePath: S;


    telephoneType: typeof TelephoneType;
    userProfile: typeof UserProfile;
    sector: typeof Sector;
    approverUser: typeof ApproverUser;
    approveLimit: typeof ApproveLimit;
    autorizedRequest: typeof AutorizedRequest;
    requestOtherUsers: typeof RequestOtherUsers;
    allowedCostCenter: typeof AllowedRequestCostCenter;
    allowedApprovalCostCenter: typeof AllowedApprovalCostCenter;

    showHideColumnsUserRegistration: typeof ShowHideColumnsUserRegistration;
    showHideColumnsSupplierRegistration: typeof ShowHideColumnsSupplierRegistration;
    showHideColumnsMyRequests: typeof ShowHideColumnsMyRequests;
    showHideColumnsGeneralRequests: typeof ShowHideColumnsGeneralRequests;
    showHideColumnsProductRequests: typeof ShowHideColumnsProductRequests;
    showHideColumnsOneOffServiceRequests: typeof ShowHideColumnsOneOffServiceRequests;
    showHideColumnsRecurringServiceRequests: typeof ShowHideColumnsRecurringServiceRequests;
    showHideColumnsRequestReport: typeof ShowHideColumnsRequestReport;
    showHideColumnsProductivityReport: typeof ShowHideColumnsProductivityReport;
    showHideColumnsProfilesTable: typeof ShowHideColumnsProfilesTable;

    tableColumnsUserRegistration: typeof TableColumnsUserRegistration;
    tableColumnsSupplierRegistration: typeof TableColumnsSupplierRegistration;
    tableColumnsMyRequests: typeof TableColumnsMyRequests;
    tableColumnsGeneralRequests: typeof TableColumnsGeneralRequests;
    tableColumnsProductRequests: typeof TableColumnsProductRequests;
    tableColumnsOneOffServiceRequests: typeof TableColumnsOneOffServiceRequests;
    tableColumnsRecurringServiceRequests: typeof TableColumnsRecurringServiceRequests;
    tableColumnsRequestReport: typeof TableColumnsRequestReport;
    tableColumnsProductivityReport: typeof TableColumnsProductivityReport;
    tableColumnsProfilesTable: typeof TableColumnsProfilesTable;

    searchColumnMyRequests: typeof SearchColumnMyRequests;
    searchColumnGeneralRequests: typeof SearchColumnGeneralRequests;
    searchColumnProductRequests: typeof SearchColumnProductRequests;
    searchColumnOneOffServiceRequests: typeof SearchColumnOneOffServiceRequests;
    searchColumnRecurringServiceRequests: typeof SearchColumnRecurringServiceRequests;
}