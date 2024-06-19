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
    ConditionalWrite,
    ProductCategory,
    QuoteRequest,
    RequestOtherUsers,
    RequestType,
    SaveRequestDraft,
    SaveRequestSubmit,
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
    UserProfile,
    ObservationOfRequest,
    IsComexImportProduct,
    IsComexImportService,
    recurringServiceValue,
    ServiceName,
    PaymentCondition,
    Requests,
    ServiceAlreadyProvided,
    PaymentDueDate,
    TypeOfPaymentAmount
} from '../../import';
import { PaymentRecurrence } from '../Enums/paymentRecurrence';




export interface Request<S = string> {
    requestType: RequestType;
    costCenter: S;
    apportionmentPercentage: S | number;
    apportionmentValue: S | number;
    quoteRequest: S | Record<QuoteRequest, boolean>;
    acquiringArea: string;
    isComex: S | IsComexImportProduct | IsComexImportService;
    reasonForRequest: string;
    desiredDeliveryDate: S;
    localDescription: S;
    suggestionLinks: S;
    observation: S;
    paymentCondition: PaymentCondition;
    totalValue: S | number;
    paymentMethod: S;
    paymentInstallments: S | number;
    paymentDetails: S;
    supplier: SupplierOfRequest;
    attachedFile: S;
    isSaved: S;
};
export interface ProductRequest<S = string> extends Request<S> {
    category: ProductCategory;
    nameAndDescription: S;
    quantity: S | number;
    color: S;
    size: S | number;
    model: S;
    link: S;
};
export interface ServiceRequest<S = string> extends Request<S> {
    serviceName: S;
    description: S;
    seller: S;
    sellerTelephone: S | number;
    sellerEmail: S;
}
export interface oneOffService<S = string> extends ServiceRequest<S> {
    serviceAlreadyProvided: ServiceAlreadyProvided
}
export interface recurringService<S = string> extends ServiceRequest<S> {
    initialPaymentEffectiveDate: S;
    finalPaymentEffectiveDate: S;
    paymentRecurrence: PaymentRecurrence;
    paymentDueDate: PaymentDueDate;
    typeOfPaymentAmount: TypeOfPaymentAmount;
}
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
    env: {
        ENV: S;
        BASE_URL: S;
        EMAIL_ADMIN: S;
        PASSWORD_ADMIN: S;
        BASE_URL_CI: S;
        EMAIL_ADMIN_CI: S;
        PASSWORD_ADMIN_CI: S;
        EMAIL_USER_PADRAO: S;
        PASSWORD_USER_PADRAO: S;
        EMAIL_GESTOR_USUARIO: S;
        PASSWORD_GESTOR_USUARIO: S;
        DB_NAME: S;
        DB_USER: S;
        DB_HOST: S;
        DB_PORT: S;
        DB_PASSWORD: S;
    };

    // filePath: S;

    // sizes: Array<number | [number, number] | S>;

    baseUrlCi: S;
    emailAdminCi: S;
    passwordAdminCi: S;

    // Autentication: {
    //     domain;
    //     email: S;
    //     password: S;
    //     giantPassword: S;
    // };
    // Register: {
    //     userRegistration: UserRegistration<S>;
    // };

    request: Requests;


    showHideColumns: ShowHideColumns;
    getDataOnGrid: GetDataOnGrid;



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
