/// <reference path="../support/cypress.d.ts" />

import fs from 'fs';
import { faker } from '@faker-js/faker';
import * as fakerBr from 'faker-br';
import { format } from 'date-fns';
import {
    AcquiringArea,
    AllowedApprovalCostCenter,
    AllowedRequestCostCenter,
    ApproveLimit,
    ApproverUser,
    AutorizedRequest,
    CostCenter,
    DataParameters,
    PaymentCondition,
    PaymentMethod,
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
    UserProfile,
    ConditionalWrite,
    RequestType,
    ObservationOfRequest,
    IsComexImportProduct,
    IsComexImportService,
} from '../import';



import data from '../fixtures/data.json';
import { elements } from './../elements';

const requestType = RequestType[data.Request.requestType as keyof typeof RequestType];

const filePath = data.file.filePath;
const sizes: Array<[number, number]> = data.viewport.sizes as Array<[number, number]>;
const url = data.Url.login;

const emailAutentication = data.Autentication.email;
const passwordAutentication = data.Autentication.password;

const name = data.Register.userRegistration.name;
const birthDate = data.Register.userRegistration.birthDate ? new Date() : new Date();
const cpf = data.Register.userRegistration.cpf;
const cnpj = data.Register.userRegistration.cnpj;
const telephone = data.Register.userRegistration.telephone;
const email = data.Register.userRegistration.email;
const password = data.Register.userRegistration.password;
const confirmPassword = data.Register.userRegistration.confirmPassword;
const userProfile = UserProfile[data.Register.userRegistration.userProfile as keyof typeof UserProfile];
const sector = Sector[data.Register.userRegistration.sector as keyof typeof Sector];

const costCenterProduct = data.Request.product.costCenter;
const apportionmentPercentageProduct = data.Request.product.apportionmentPercentage;
const apportionmentValueProduct = data.Request.product.apportionmentValue;
const quoteRequestProduct = data.Request.product.quoteRequest;
const acquiringAreaProduct = AcquiringArea[data.Request.product.acquiringArea as keyof typeof AcquiringArea];
const isComexProduct = data.Request.product.isComex;
const reasonForRequestProduct = data.Request.product.reasonForRequest;
const desiredDeliveryDateProduct = data.Request.product.desiredDeliveryDate;
const localDescriptionProduct = data.Request.product.localDescription;
const suggestionLinksProduct = data.Request.product.suggestionLinks;
const observationProduct = data.Request.product.observation;
const paymentConditionProduct: ConditionalWrite = {
    anticipatedPayment: data.Request.product.PaymentCondition.anticipatedPayment as [boolean, string],
    cashPayment: data.Request.product.PaymentCondition.cashPayment as [boolean, string],
    paymentInInstallments: data.Request.product.PaymentCondition.paymentInInstallments as [boolean, string],
};
const totalValueProduct = data.Request.product.totalValue;
const paymentMethodProduct: ConditionalWrite = {
    boleto: data.Request.product.paymentMethod.boleto as [boolean, string],
    creditCard: data.Request.product.paymentMethod.creditCard as [boolean, string],
    debitCard: data.Request.product.paymentMethod.debitCard as [boolean, string],
    cheque: data.Request.product.paymentMethod.cheque as [boolean, string],
    bankDeposit: data.Request.product.paymentMethod.bankDeposit as [boolean, string],
    cash: data.Request.product.paymentMethod.cash as [boolean, string],
    international: data.Request.product.paymentMethod.international as [boolean, string],
    pix: data.Request.product.paymentMethod.pix as [boolean, string],
};
const paymentInstallmentsProduct = data.Request.product.paymentInstallments;
const paymentDetailsProduct = data.Request.product.paymentDetails;
const supplierProduct: SupplierOfRequest = SupplierOfRequest[data.Request.product.supplier as keyof typeof SupplierOfRequest];
const productCategoryProduct: ProductCategory = ProductCategory[data.Request.product.productCategory as keyof typeof ProductCategory];
const productNameAndDescriptionProduct = data.Request.product.productNameAndDescription;
const productQuantityProduct = data.Request.product.productQuantity;
const productColorProduct = data.Request.product.productColor;
const productSizeProduct = data.Request.product.productSize;
const productModelProduct = data.Request.product.productModel;
const productLinkProduct = data.Request.product.productLink;
const attachedFileProduct = data.Request.product.attachedFile;
const saveRequestProduct: Record<SaveRequest, boolean> = {
    [SaveRequest.draft]: !!data.Request.product.saveRequest.draft,
    [SaveRequest.submit]: !!data.Request.product.saveRequest.submit,
};

const serviceNameOneOffService = data.Request.oneOffService.serviceName;
const costCenterOneOffService = data.Request.oneOffService.costCenter;
const apportionmentPercentageOneOffService = data.Request.oneOffService.apportionmentPercentage;
const apportionmentValueOneOffService = data.Request.oneOffService.apportionmentValue;
const quoteRequestOneOffService = data.Request.oneOffService.quoteRequest;
const acquiringAreaOneOffService = AcquiringArea[data.Request.oneOffService.acquiringArea as keyof typeof AcquiringArea];
const isComexOneOffService = data.Request.oneOffService.isComex;
const reasonForRequestOneOffService = data.Request.oneOffService.reasonForRequest;
const desiredDeliveryDateOneOffService = data.Request.oneOffService.desiredDeliveryDate;
const localDescriptionOneOffService = data.Request.oneOffService.localDescription;
const suggestionLinksOneOffService = data.Request.oneOffService.suggestionLinks;
const observationOneOffService = data.Request.oneOffService.observation;
const paymentConditionOneOffService: ConditionalWrite = {
    anticipatedPayment: data.Request.oneOffService.PaymentCondition.anticipatedPayment as [boolean, string],
    cashPayment: data.Request.oneOffService.PaymentCondition.cashPayment as [boolean, string],
    paymentInInstallments: data.Request.oneOffService.PaymentCondition.paymentInInstallments as [boolean, string],
};
const totalValueOneOffService = data.Request.oneOffService.totalValue;
// const paymentMethodOneOffService: ConditionalWrite = {
//     boleto: data.Request.OneOffService.paymentMethod.boleto as [boolean, string],
//     creditCard: data.Request.OneOffService.paymentMethod.creditCard as [boolean, string],
//     debitCard: data.Request.OneOffService.paymentMethod.debitCard as [boolean, string],
//     cheque: data.Request.OneOffService.paymentMethod.cheque as [boolean, string],
//     bankDeposit: data.Request.OneOffService.paymentMethod.bankDeposit as [boolean, string],
//     cash: data.Request.OneOffService.paymentMethod.cash as [boolean, string],
//     international: data.Request.OneOffService.paymentMethod.international as [boolean, string],
//     pix: data.Request.OneOffService.paymentMethod.pix as [boolean, string],
// };
// const paymentInstallmentsOneOffService = data.Request.OneOffService.paymentInstallments;
// const paymentDetailsOneOffService = data.Request.OneOffService.paymentDetails;
// const supplierOneOffService: SupplierOfRequest = SupplierOfRequest[data.Request.OneOffService.supplier as keyof typeof SupplierOfRequest];
// const sellerOneOffService: data.Request.OneOffService.seller
// const attachedFileOneOffService = data.Request.OneOffService.attachedFile;
// const saveRequestOneOffService: Record<SaveRequest, boolean> = {
//     [SaveRequest.draft]: !!data.Request.OneOffService.saveRequest.draft,
//     [SaveRequest.submit]: !!data.Request.OneOffService.saveRequest.submit,
// };

const serviceNamerecurringService = data.Request.recurringService.serviceName;
const costCenterRecurringService = data.Request.recurringService.costCenter;
const apportionmentPercentagerecurringService = data.Request.recurringService.apportionmentPercentage;
const apportionmentValuerecurringService = data.Request.recurringService.apportionmentValue;
const quoteRequestrecurringService = data.Request.recurringService.quoteRequest;
const acquiringArearecurringService = AcquiringArea[data.Request.recurringService.acquiringArea as keyof typeof AcquiringArea];
const isComexRecurringService = data.Request.product.isComex;
const reasonForRequestrecurringService = data.Request.recurringService.reasonForRequest;
const desiredDeliveryDaterecurringService = data.Request.recurringService.desiredDeliveryDate;
const localDescriptionRecurringService = data.Request.recurringService.localDescription;
const suggestionLinksrecurringService = data.Request.recurringService.suggestionLinks;
const observationRecurringService = data.Request.recurringService.observation;
const paymentConditionRecurringService: ConditionalWrite = {
    anticipatedPayment: data.Request.recurringService.PaymentCondition.anticipatedPayment as [boolean, string],
    cashPayment: data.Request.recurringService.PaymentCondition.cashPayment as [boolean, string],
    paymentInInstallments: data.Request.recurringService.PaymentCondition.paymentInInstallments as [boolean, string],
};
const totalValuerecurringService = data.Request.recurringService.totalValue;
// const paymentMethodRecurringService: ConditionalWrite = {
//     boleto: data.Request.RecurringService.paymentMethod.boleto as [boolean, string],
//     creditCard: data.Request.RecurringService.paymentMethod.creditCard as [boolean, string],
//     debitCard: data.Request.RecurringService.paymentMethod.debitCard as [boolean, string],
//     cheque: data.Request.RecurringService.paymentMethod.cheque as [boolean, string],
//     bankDeposit: data.Request.RecurringService.paymentMethod.bankDeposit as [boolean, string],
//     cash: data.Request.RecurringService.paymentMethod.cash as [boolean, string],
//     international: data.Request.RecurringService.paymentMethod.international as [boolean, string],
//     pix: data.Request.RecurringService.paymentMethod.pix as [boolean, string],
// };
// const paymentInstallmentsRecurringService = data.Request.RecurringService.paymentInstallments;
// const paymentDetailsRecurringService = data.Request.RecurringService.paymentDetails;
// const supplierRecurringService: SupplierOfRequest = SupplierOfRequest[data.Request.RecurringService.supplier as keyof typeof SupplierOfRequest];
// const sellerRecurringService: data.Request.RecurringService.seller
// const attachedFileRecurringService = data.Request.RecurringService.attachedFile;
// const saveRequestRecurringService: Record<SaveRequest, boolean> = {
//     [SaveRequest.draft]: !!data.Request.RecurringService.saveRequest.draft,
//     [SaveRequest.submit]: !!data.Request.RecurringService.saveRequest.submit,
// };



let domain = '@essentia.com.br';
// let confirmPassword = password;
const currentDate: Date = new Date();
const year: number = currentDate.getFullYear();
const month: string = String(currentDate.getMonth() + 1).padStart(2, '0');
const day: string = String(currentDate.getDate()).padStart(2, '0');
const hour: string = String(currentDate.getHours()).padStart(2, '0');
const minutes: string = String(currentDate.getMinutes()).padStart(2, '0');
const seconds: string = String(currentDate.getSeconds()).padStart(2, '0');
export const FORMATTED_DATE: string = `${year}-${month}-${day}`;
export const FORMATTED_TIME: string = `${hour}:${minutes}:${seconds}`;

const environment = Cypress.env('ENVIRONMENT');
const dataEnvironment = Cypress.env(environment);


export const dataParameters: DataParameters = {

    env: dataEnvironment,

    filePath: filePath || '/',

    sizes: sizes ||
        [
            [
                1536,
                960
            ],
            [
                1440,
                900
            ],
            [
                1366,
                768
            ],
            [
                1280,
                800
            ],
            [
                1280,
                720
            ],
            [
                1024,
                768
            ],
            [
                1024,
                600
            ],
            [
                820,
                1180
            ],
            [
                768,
                1024
            ],
            [
                412,
                914
            ],
            [
                414,
                896
            ],
            [
                414,
                846
            ],
            [
                414,
                736
            ]
        ],

    url: url || 'http://192.168.0.66:9401/login',

    Autentication: {
        domain: domain,
        email: emailAutentication || faker.internet.userName() + domain,
        password: passwordAutentication || faker.number.int().toString(),
        giantPassword: faker.lorem.word({ length: { min: 100, max: 102 }, strategy: 'longest' }),
    },

    Register: {
        userRegistration: {
            name: name || faker.person.fullName(),
            birthDate: birthDate || new Date(),
            cpf: cpf || fakerBr.br.cpf(),
            cnpj: cnpj || fakerBr.br.cnpj(),
            telephone: telephone || faker.string.alphanumeric('(48) 9####-####'),
            email: email || faker.internet.userName() + domain,
            password: password || faker.number.int().toString(),
            confirmPassword: confirmPassword || password,
            userProfile: userProfile || UserProfile.normal,
            sector: sector || Sector.HKM_SOFTWARE_E_SISTEMAS,
            approverUser: ApproverUser.diretorgecom,
            approvalLimit: 1500,
            authorizationRequest: AutorizedRequest.authorized,
            requestOtherUsers: RequestOtherUsers.canAssociate,
            allowedRequestCostCenter: AllowedRequestCostCenter.CGE_CONGRESSOS_E_EVENTOS,
            allowedApprovalCostCenter: AllowedApprovalCostCenter.CGE_DIRETORIA,

        },

    },
    showHideColumns: {
        showHideColumnsUserRegistration: {
            [ShowHideColumnsUserRegistration.user]: false,
            [ShowHideColumnsUserRegistration.email]: true,
            [ShowHideColumnsUserRegistration.profile]: false,
            [ShowHideColumnsUserRegistration.specificSkills]: true,
            [ShowHideColumnsUserRegistration.memberSince]: true,
        },
        showHideColumnsSupplierRegistration: {
            [ShowHideColumnsSupplierRegistration.company]: true,
            [ShowHideColumnsSupplierRegistration.companyName]: true,
            [ShowHideColumnsSupplierRegistration.indication]: true,
            [ShowHideColumnsSupplierRegistration.marketType]: true,
            [ShowHideColumnsSupplierRegistration.situation]: true,
        },
        showHideColumnsMyRequests: {
            [ShowHideColumnsMyRequests.hiringBy]: true,
            [ShowHideColumnsMyRequests.reason]: true,
            [ShowHideColumnsMyRequests.type]: true,
            [ShowHideColumnsMyRequests.serviceName]: true,
            [ShowHideColumnsMyRequests.supplier]: true,
            [ShowHideColumnsMyRequests.status]: true,
            [ShowHideColumnsMyRequests.responsible]: true,
            [ShowHideColumnsMyRequests.desiredDate]: true,
            [ShowHideColumnsMyRequests.updatedAt]: true,
            [ShowHideColumnsMyRequests.totalValue]: true,
        },
        showHideColumnsGeneralRequests: {
            [ShowHideColumnsGeneralRequests.hiringBy]: true,
            [ShowHideColumnsGeneralRequests.reason]: true,
            [ShowHideColumnsGeneralRequests.type]: true,
            [ShowHideColumnsGeneralRequests.serviceName]: true,
            [ShowHideColumnsGeneralRequests.supplier]: true,
            [ShowHideColumnsGeneralRequests.status]: true,
            [ShowHideColumnsGeneralRequests.responsible]: true,
            [ShowHideColumnsGeneralRequests.desiredDate]: true,
            [ShowHideColumnsGeneralRequests.updatedAt]: true,
            [ShowHideColumnsGeneralRequests.totalValue]: true,
        },
        showHideColumnsProductRequests: {
            [ShowHideColumnsProductRequests.requester]: true,
            [ShowHideColumnsProductRequests.responsible]: true,
            [ShowHideColumnsProductRequests.categories]: true,
            [ShowHideColumnsProductRequests.status]: true,
            [ShowHideColumnsProductRequests.supplier]: true,
            [ShowHideColumnsProductRequests.hiringBy]: true,
            [ShowHideColumnsProductRequests.company]: true,
            [ShowHideColumnsProductRequests.desiredDate]: true,
            [ShowHideColumnsProductRequests.purchaseOrder]: true,
            [ShowHideColumnsProductRequests.totalValue]: true,
        },
        showHideColumnsOneOffServiceRequests: {
            [ShowHideColumnsOneOffServiceRequests.requester]: true,
            [ShowHideColumnsOneOffServiceRequests.responsible]: true,
            [ShowHideColumnsOneOffServiceRequests.status]: true,
            [ShowHideColumnsOneOffServiceRequests.supplier]: true,
            [ShowHideColumnsOneOffServiceRequests.hiringBy]: true,
            [ShowHideColumnsOneOffServiceRequests.company]: true,
            [ShowHideColumnsOneOffServiceRequests.desiredDate]: true,
            [ShowHideColumnsOneOffServiceRequests.purchaseOrder]: true,
        },
        showHideColumnsRecurringServiceRequests: {
            [ShowHideColumnsRecurringServiceRequests.requester]: true,
            [ShowHideColumnsRecurringServiceRequests.responsible]: true,
            [ShowHideColumnsRecurringServiceRequests.status]: true,
            [ShowHideColumnsRecurringServiceRequests.supplier]: true,
            [ShowHideColumnsRecurringServiceRequests.hiringBy]: true,
            [ShowHideColumnsRecurringServiceRequests.company]: true,
            [ShowHideColumnsRecurringServiceRequests.desiredDate]: true,
            [ShowHideColumnsRecurringServiceRequests.purchaseOrder]: true,
        },
        showHideColumnsRequestReport: {
            [ShowHideColumnsRequestReport.type]: true,
            [ShowHideColumnsRequestReport.requestedOn]: true,
            [ShowHideColumnsRequestReport.assignmentDate]: true,
            [ShowHideColumnsRequestReport.serviceName]: true,
            [ShowHideColumnsRequestReport.hiredBy]: true,
            [ShowHideColumnsRequestReport.requester]: true,
            [ShowHideColumnsRequestReport.systemRequester]: true,
            [ShowHideColumnsRequestReport.status]: true,
            [ShowHideColumnsRequestReport.responsible]: true,
            [ShowHideColumnsRequestReport.costCenter]: true,
            [ShowHideColumnsRequestReport.supplier]: true,
            [ShowHideColumnsRequestReport.paymentMethod]: true,
            [ShowHideColumnsRequestReport.paymentCondition]: true,
            [ShowHideColumnsRequestReport.totalValue]: true,
        },
        showHideColumnsProductivityReport: {
            [ShowHideColumnsProductivityReport.type]: true,
            [ShowHideColumnsProductivityReport.requestedOn]: true,
            [ShowHideColumnsProductivityReport.requester]: true,
            [ShowHideColumnsProductivityReport.systemRequester]: true,
            [ShowHideColumnsProductivityReport.status]: true,
            [ShowHideColumnsProductivityReport.responsible]: true,
            [ShowHideColumnsProductivityReport.costCenter]: true,
            [ShowHideColumnsProductivityReport.hiredBy]: true,
            [ShowHideColumnsProductivityReport.desiredDate]: true,
            [ShowHideColumnsProductivityReport.categories]: true,
        },
        showHideColumnsProfilesTable: {
            [ShowHideColumnsProfilesTable.number]: true,
            [ShowHideColumnsProfilesTable.name]: true,
            [ShowHideColumnsProfilesTable.userQuantity]: true,
            [ShowHideColumnsProfilesTable.skillsQuantity]: true,
        },
    },

    getDataOnGrid: {
        searchParameter: 'Pendente',
        showRecordsQuantity: ShowRecordsQuantity.oneHundred,

        searchColumnMyRequests: {
            [SearchColumnMyRequests.requestNumber]: [true, '3519'],
            [SearchColumnMyRequests.hiredBy]: [false, '---'],
            [SearchColumnMyRequests.reason]: [false, '---'],
            [SearchColumnMyRequests.type]: [false, '---'],
            [SearchColumnMyRequests.serviceName]: [false, '---'],
            [SearchColumnMyRequests.supplier]: [false, '---'],
            [SearchColumnMyRequests.status]: [false, '---'],
            [SearchColumnMyRequests.responsible]: [false, '---'],
            [SearchColumnMyRequests.desiredDate]: [false, '---'],
            [SearchColumnMyRequests.updatedAt]: [false, '---'],
            [SearchColumnMyRequests.totalValue]: [false, '---'],
        },
        searchColumnGeneralRequests: {
            [SearchColumnGeneralRequests.requestNumber]: [false, '---'],
            [SearchColumnGeneralRequests.hiredBy]: [false, '---'],
            [SearchColumnGeneralRequests.reason]: [false, '---'],
            [SearchColumnGeneralRequests.type]: [false, '---'],
            [SearchColumnGeneralRequests.serviceName]: [false, '---'],
            [SearchColumnGeneralRequests.supplier]: [false, '---'],
            [SearchColumnGeneralRequests.status]: [false, '---'],
            [SearchColumnGeneralRequests.responsible]: [false, '---'],
            [SearchColumnGeneralRequests.desiredDate]: [false, '---'],
            [SearchColumnGeneralRequests.updatedAt]: [false, '---'],
            [SearchColumnGeneralRequests.totalValue]: [false, '---'],
        },
        searchColumnProductRequests: {
            [SearchColumnProductRequests.requestNumber]: [false, '---'],
            [SearchColumnProductRequests.requester]: [false, '---'],
            [SearchColumnProductRequests.responsible]: [false, '---'],
            [SearchColumnProductRequests.category]: [false, '---'],
            [SearchColumnProductRequests.status]: [false, '---'],
            [SearchColumnProductRequests.supplier]: [false, '---'],
            [SearchColumnProductRequests.hiredBy]: [false, '---'],
            [SearchColumnProductRequests.company]: [false, '---'],
            [SearchColumnProductRequests.desiredDate]: [false, '---'],
            [SearchColumnProductRequests.purchaseOrder]: [false, '---'],
            [SearchColumnProductRequests.totalValue]: [false, '---'],
        },
        searchColumnOneOffServiceRequests: {
            [SearchColumnOneOffServiceRequests.requestNumber]: [false, '---'],
            [SearchColumnOneOffServiceRequests.requester]: [false, '---'],
            [SearchColumnOneOffServiceRequests.responsible]: [false, '---'],
            [SearchColumnOneOffServiceRequests.status]: [false, '---'],
            [SearchColumnOneOffServiceRequests.supplier]: [false, '---'],
            [SearchColumnOneOffServiceRequests.hiredBy]: [false, '---'],
            [SearchColumnOneOffServiceRequests.company]: [false, '---'],
            [SearchColumnOneOffServiceRequests.desiredDate]: [false, '---'],
            [SearchColumnOneOffServiceRequests.purchaseOrder]: [false, '---'],
        },
        searchColumnRecurringServiceRequests: {
            [SearchColumnRecurringServiceRequests.requestNumber]: [false, '---'],
            [SearchColumnRecurringServiceRequests.requester]: [false, '---'],
            [SearchColumnRecurringServiceRequests.responsible]: [false, '---'],
            [SearchColumnRecurringServiceRequests.status]: [false, '---'],
            [SearchColumnRecurringServiceRequests.supplier]: [false, '---'],
            [SearchColumnRecurringServiceRequests.hiredBy]: [false, '---'],
            [SearchColumnRecurringServiceRequests.company]: [false, '---'],
            [SearchColumnRecurringServiceRequests.desiredDate]: [false, '---'],
            [SearchColumnRecurringServiceRequests.purchaseOrder]: [false, '---'],
        },

        tableColumnsUserRegistration: {
            [TableColumnsUserRegistration.user]: false,
            [TableColumnsUserRegistration.email]: false,
            [TableColumnsUserRegistration.profile]: false,
            [TableColumnsUserRegistration.memberSince]: true,
        },
        tableColumnsSupplierRegistration: {
            [TableColumnsSupplierRegistration.CNPJ]: false,
            [TableColumnsSupplierRegistration.company]: false,
            [TableColumnsSupplierRegistration.companyName]: false,
            [TableColumnsSupplierRegistration.situation]: false,
        },
        tableColumnsMyRequests: {
            [TableColumnsMyRequests.requestNumber]: true,
            [TableColumnsMyRequests.hiredBy]: false,
            [TableColumnsMyRequests.reason]: true,
            [TableColumnsMyRequests.type]: false,
            [TableColumnsMyRequests.serviceName]: true,
            [TableColumnsMyRequests.supplier]: false,
            [TableColumnsMyRequests.status]: true,
            [TableColumnsMyRequests.responsible]: false,
            [TableColumnsMyRequests.desiredDate]: true,
            [TableColumnsMyRequests.updatedAt]: false,
            [TableColumnsMyRequests.totalValue]: false,
        }, // Add the necessary properties for this object
        tableColumnsGeneralRequests: {
            [TableColumnsGeneralRequests.requestNumber]: false,
            [TableColumnsGeneralRequests.hiredBy]: false,
            [TableColumnsGeneralRequests.reason]: false,
            [TableColumnsGeneralRequests.type]: false,
            [TableColumnsGeneralRequests.serviceName]: false,
            [TableColumnsGeneralRequests.supplier]: false,
            [TableColumnsGeneralRequests.status]: false,
            [TableColumnsGeneralRequests.responsible]: false,
            [TableColumnsGeneralRequests.desiredDate]: false,
            [TableColumnsGeneralRequests.updatedAt]: false,
            [TableColumnsGeneralRequests.totalValue]: false,
        }, // Add the necessary properties for this object
        tableColumnsProductRequests: {
            [TableColumnsProductRequests.requestNumber]: false,
            [TableColumnsProductRequests.requester]: false,
            [TableColumnsProductRequests.responsible]: false,
            [TableColumnsProductRequests.category]: false,
            [TableColumnsProductRequests.status]: false,
            [TableColumnsProductRequests.supplier]: false,
            [TableColumnsProductRequests.hiredBy]: false,
            [TableColumnsProductRequests.company]: false,
            [TableColumnsProductRequests.desiredDate]: false,
            [TableColumnsProductRequests.purchaseOrder]: false,
            [TableColumnsProductRequests.totalValue]: false,
        },
        tableColumnsOneOffServiceRequests: {
            [TableColumnsOneOffServiceRequests.requestNumber]: false,
            [TableColumnsOneOffServiceRequests.requester]: false,
            [TableColumnsOneOffServiceRequests.responsible]: false,
            [TableColumnsOneOffServiceRequests.status]: false,
            [TableColumnsOneOffServiceRequests.supplier]: false,
            [TableColumnsOneOffServiceRequests.hiredBy]: false,
            [TableColumnsOneOffServiceRequests.company]: false,
            [TableColumnsOneOffServiceRequests.desiredDate]: false,
            [TableColumnsOneOffServiceRequests.purchaseOrder]: false,

        },
        tableColumnsRecurringServiceRequests: {
            [TableColumnsRecurringServiceRequests.requestNumber]: false,
            [TableColumnsRecurringServiceRequests.requester]: false,
            [TableColumnsRecurringServiceRequests.responsible]: false,
            [TableColumnsRecurringServiceRequests.status]: false,
            [TableColumnsRecurringServiceRequests.supplier]: false,
            [TableColumnsRecurringServiceRequests.hiredBy]: false,
            [TableColumnsRecurringServiceRequests.company]: false,
            [TableColumnsRecurringServiceRequests.desiredDate]: false,
            [TableColumnsRecurringServiceRequests.purchaseOrder]: false,
        },
        tableColumnsRequestReport: {
            [TableColumnsRequestReport.requestNumber]: false,
            [TableColumnsRequestReport.type]: false,
            [TableColumnsRequestReport.requestedOn]: false,
            [TableColumnsRequestReport.assignmentDate]: false,
            [TableColumnsRequestReport.serviceName]: false,
            [TableColumnsRequestReport.hiredBy]: false,
            [TableColumnsRequestReport.requester]: false,
            [TableColumnsRequestReport.systemRequester]: false,
            [TableColumnsRequestReport.status]: false,
            [TableColumnsRequestReport.responsible]: false,
            [TableColumnsRequestReport.costCenter]: false,
            [TableColumnsRequestReport.supplier]: false,
            [TableColumnsRequestReport.paymentMethod]: false,
            [TableColumnsRequestReport.paymentCondition]: false,
            [TableColumnsRequestReport.totalValue]: false,
        },
        tableColumnsProductivityReport: {
            [TableColumnsProductivityReport.requestNumber]: false,
            [TableColumnsProductivityReport.type]: false,
            [TableColumnsProductivityReport.requestedOn]: false,
            [TableColumnsProductivityReport.requester]: false,
            [TableColumnsProductivityReport.systemRequester]: false,
            [TableColumnsProductivityReport.status]: false,
            [TableColumnsProductivityReport.responsible]: false,
            [TableColumnsProductivityReport.costCenter]: false,
            [TableColumnsProductivityReport.hiredBy]: false,
            [TableColumnsProductivityReport.desiredDate]: false,
            [TableColumnsProductivityReport.category]: false,
        },
        tableColumnsProfilesTable: {
            [TableColumnsProfilesTable.requestNumber]: false,
            [TableColumnsProfilesTable.name]: false,
            [TableColumnsProfilesTable.userQuantity]: false,
            [TableColumnsProfilesTable.skillQuantity]: false,
        }
    },

    Request: {
        requestType: requestType || RequestType.product,
        product: {
            costCenter: costCenterProduct || CostCenter['41.869.107/0001-58 - JML - Almoxarifado'],
            apportionmentPercentage: apportionmentPercentageProduct && apportionmentPercentageProduct !== " " ? apportionmentPercentageProduct : faker.helpers.arrayElement([100]),
            apportionmentValue: apportionmentValueProduct && apportionmentValueProduct !== " " ? apportionmentValueProduct : "",
            quoteRequest: {
                [QuoteRequest.quoteRequest]: typeof quoteRequestProduct === 'boolean'
                    ? quoteRequestProduct
                    : (quoteRequestProduct as string).trim().toLowerCase() === 'true' ? true : false
            },
            acquiringArea: acquiringAreaProduct || AcquiringArea.areaContract,
            isComex: isComexProduct === "yes" ? IsComexImportProduct.yes : IsComexImportProduct.no,
            reasonForRequest: reasonForRequestProduct.trim() !== "" ? reasonForRequestProduct : faker.lorem.lines(),
            desiredDeliveryDate: (!isNaN(Date.parse(desiredDeliveryDateProduct)) ? new Date(desiredDeliveryDateProduct) : new Date()).toISOString().split('T')[0],
            localDescription: localDescriptionProduct.trim() !== "" ? localDescriptionProduct : faker.lorem.lines(),
            suggestionLinks: suggestionLinksProduct && suggestionLinksProduct !== " " ? suggestionLinksProduct : faker.lorem.lines(),
            observation: observationProduct && observationProduct !== " " ? observationProduct : faker.lorem.lines(),

            paymentCondition: paymentConditionProduct && Object.values(paymentConditionProduct).some(([isEnabled]) => isEnabled)
                ? paymentConditionProduct
                : (paymentMethodProduct && Object.values(paymentMethodProduct).some(([isEnabled]) => isEnabled)
                    ? { [PaymentCondition.anticipatedPayment]: [true, PaymentCondition.paymentInInstallments] }
                    : { [PaymentCondition.anticipatedPayment]: [true, "Antecipado"] }),

            totalValue: totalValueProduct || totalValueProduct !== " "  ? totalValueProduct : faker.helpers.arrayElement([1]),
            paymentMethod: Object.values(paymentMethodProduct).some(([isEnabled]) => isEnabled) ? paymentMethodProduct : { [PaymentMethod.boleto]: [true, PaymentMethod.boleto] },
            paymentInstallments: paymentInstallmentsProduct | 3,
            paymentDetails: paymentDetailsProduct || faker.lorem.lines(),
            supplier: supplierProduct ? SupplierOfRequest[data.Request.product.supplier] : SupplierOfRequest['47.960.950/0897-85  - MAGAZINE LUIZA S/A'],
            productCategory: productCategoryProduct || ProductCategory['Maquinas E Equipamentos No Laboratorio'],
            productNameAndDescription: productNameAndDescriptionProduct || faker.lorem.lines(),
            productQuantity: productQuantityProduct || 3,
            productColor: productColorProduct || faker.lorem.word(),
            productSize: productSizeProduct || faker.lorem.word(),
            productModel: productModelProduct || faker.lorem.word(),
            productLink: productLinkProduct || faker.internet.url(),
            attachedFile: attachedFileProduct || '../fixtures/attachedFile.png',
            saveRequest: saveRequestProduct || {
                [SaveRequest.draft]: true,
                [SaveRequest.submit]: false,
            },
        },
        oneOffService: {
            serviceName: serviceNameOneOffService || `Teste_servico_pontual${new Date().getTime()}`,
            costCenter: costCenterOneOffService || CostCenter['11.847.299/0003-00 - SMART FILIAL 2 - Tele Atendimento'],
            apportionmentPercentage: apportionmentPercentageOneOffService !== "" ? data.Request.product.apportionmentPercentage : faker.helpers.arrayElement([100]),
            apportionmentValue: apportionmentValueOneOffService || faker.helpers.arrayElement([100, 350, 700]),
            quoteRequest: {
                [QuoteRequest.quoteRequest]: typeof quoteRequestOneOffService === 'boolean'
                    ? quoteRequestOneOffService
                    : (quoteRequestOneOffService as string).trim().toLowerCase() === 'true' ? true : false
            },
            acquiringArea: acquiringAreaOneOffService || AcquiringArea.areaContract,
            isComex: isComexOneOffService === "yes" ? IsComexImportService.yes : IsComexImportService.no,
            reasonForRequest: reasonForRequestOneOffService.trim() !== "" ? reasonForRequestOneOffService : faker.lorem.lines(),
            desiredDeliveryDate: (!isNaN(Date.parse(desiredDeliveryDateOneOffService)) ? new Date(desiredDeliveryDateOneOffService) : new Date()).toISOString().split('T')[0],
            localDescription: localDescriptionOneOffService.trim() !== "" ? localDescriptionOneOffService : faker.lorem.lines(),
            suggestionLinks: suggestionLinksOneOffService && suggestionLinksOneOffService !== " " ? suggestionLinksOneOffService : faker.lorem.lines(),
            observation: observationOneOffService || faker.lorem.lines(),

            paymentCondition: paymentConditionOneOffService && Object.values(paymentConditionOneOffService).some(([isEnabled]) => isEnabled)
                ? paymentConditionOneOffService
                : (paymentConditionOneOffService && Object.values(paymentConditionOneOffService).some(([isEnabled]) => isEnabled)
                    ? { [PaymentCondition.anticipatedPayment]: [true, PaymentCondition.paymentInInstallments] }
                    : { [PaymentCondition.anticipatedPayment]: [true, "Antecipado"] }),

                    totalValue: totalValueOneOffService ? totalValueOneOffService : faker.helpers.arrayElement([2]),
        },
        recurringService: {
            serviceName: serviceNamerecurringService || `Teste_servico_recorrente${new Date().getTime()}`,
            costCenter: costCenterRecurringService || CostCenter['06.354.562/0001-10 - HKM - P&d'],
            apportionmentPercentage: apportionmentPercentagerecurringService !== "" ? data.Request.product.apportionmentPercentage : faker.helpers.arrayElement([100]),
            apportionmentValue: apportionmentValuerecurringService || faker.helpers.arrayElement([100, 350, 700]),
            quoteRequest: {
                [QuoteRequest.quoteRequest]: typeof quoteRequestrecurringService === 'boolean'
                    ? quoteRequestrecurringService
                    : (quoteRequestrecurringService as string).trim().toLowerCase() === 'true' ? true : false
            },
            acquiringArea: acquiringArearecurringService || AcquiringArea.areaContract,
            isComex: isComexRecurringService === "yes" ? IsComexImportService.yes : IsComexImportService.no,
            reasonForRequest: reasonForRequestrecurringService.trim() !== "" ? reasonForRequestrecurringService : faker.lorem.lines(),
            desiredDeliveryDate: (!isNaN(Date.parse(desiredDeliveryDaterecurringService)) ? new Date(desiredDeliveryDaterecurringService) : new Date()).toISOString().split('T')[0],
            localDescription: localDescriptionRecurringService.trim() !== "" ? localDescriptionRecurringService : faker.lorem.lines(),
            suggestionLinks: suggestionLinksrecurringService && suggestionLinksrecurringService !== " " ? suggestionLinksrecurringService : faker.lorem.lines(),
            observation: observationRecurringService || faker.lorem.lines(),
            
            paymentCondition: paymentConditionRecurringService && Object.values(paymentConditionRecurringService).some(([isEnabled]) => isEnabled)
                ? paymentConditionRecurringService
                : (paymentConditionRecurringService && Object.values(paymentConditionRecurringService).some(([isEnabled]) => isEnabled)
                    ? { [PaymentCondition.anticipatedPayment]: [true, PaymentCondition.paymentInInstallments] }
                    : { [PaymentCondition.anticipatedPayment]: [true, "Antecipado"] }),

                    totalValue: totalValuerecurringService ? totalValuerecurringService : faker.helpers.arrayElement([3]),
        },
    },

    telephoneType: TelephoneType,
    userProfile: UserProfile,
    sector: Sector,
    approverUser: ApproverUser,
    approveLimit: ApproveLimit,
    autorizedRequest: AutorizedRequest,
    requestOtherUsers: RequestOtherUsers,
    allowedCostCenter: AllowedRequestCostCenter,
    allowedApprovalCostCenter: AllowedApprovalCostCenter,
    showHideColumnsUserRegistration: ShowHideColumnsUserRegistration,
    showHideColumnsSupplierRegistration: ShowHideColumnsSupplierRegistration,
    showHideColumnsMyRequests: ShowHideColumnsMyRequests,
    showHideColumnsGeneralRequests: ShowHideColumnsGeneralRequests,
    showHideColumnsProductRequests: ShowHideColumnsProductRequests,
    showHideColumnsOneOffServiceRequests: ShowHideColumnsOneOffServiceRequests,
    showHideColumnsRecurringServiceRequests: ShowHideColumnsRecurringServiceRequests,
    showHideColumnsRequestReport: ShowHideColumnsRequestReport,
    showHideColumnsProductivityReport: ShowHideColumnsProductivityReport,
    showHideColumnsProfilesTable: ShowHideColumnsProfilesTable,
    tableColumnsUserRegistration: TableColumnsUserRegistration,
    tableColumnsSupplierRegistration: TableColumnsSupplierRegistration,
    tableColumnsMyRequests: TableColumnsMyRequests,
    tableColumnsGeneralRequests: TableColumnsGeneralRequests,
    tableColumnsProductRequests: TableColumnsProductRequests,
    tableColumnsOneOffServiceRequests: TableColumnsOneOffServiceRequests,
    tableColumnsRecurringServiceRequests: TableColumnsRecurringServiceRequests,
    tableColumnsRequestReport: TableColumnsRequestReport,
    tableColumnsProductivityReport: TableColumnsProductivityReport,
    tableColumnsProfilesTable: TableColumnsProfilesTable,

    searchColumnMyRequests: SearchColumnMyRequests,
    searchColumnGeneralRequests: SearchColumnGeneralRequests,
    searchColumnProductRequests: SearchColumnProductRequests,
    searchColumnOneOffServiceRequests: SearchColumnOneOffServiceRequests,
    searchColumnRecurringServiceRequests: SearchColumnRecurringServiceRequests,
};



/*

if (requestTypeMap[requestType]) {
        const requestKey = requestTypeMap[requestType];
        if (dataParameters.Request[requestKey]) {
            acao
        };
    };


*/