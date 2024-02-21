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
    ComexImport,
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
} from '../import';


import data from '../fixtures/data.json';
import { UserRegistration } from './Interfaces/interfaces';
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
const emailUserRegistration = data.Register.userRegistration.email;
const passwordUserRegistration = data.Register.userRegistration.password;
const userProfile = UserProfile[data.Register.userRegistration.userProfile as keyof typeof UserProfile];
const sector = Sector[data.Register.userRegistration.sector as keyof typeof Sector];
const costCenter = data.Request.product.costCenter;
const apportionmentPercentage = data.Request.product.apportionmentPercentage;
const apportionmentValue = data.Request.product.apportionmentValue;
const quoteRequest = data.Request.product.quoteRequest;
const acquiringArea = AcquiringArea[data.Request.product.acquiringArea as keyof typeof AcquiringArea];
const comexImport = ComexImport[data.Request.product.comexImport as keyof typeof ComexImport];
const reasonForRequest = data.Request.product.reasonForRequest;
const desiredDeliveryDate = data.Request.product.desiredDeliveryDate;
const productStorageLocation = data.Request.product.productStorageLocation;
const suggestionLinks = data.Request.product.suggestionLinks;
const observation = data.Request.product.observation;
const paymentCondition: ConditionalWrite = {
    anticipatedPayment: data.Request.product.PaymentCondition.anticipatedPayment as [boolean, string],
    cashPayment: data.Request.product.PaymentCondition.cashPayment as [boolean, string],
    paymentInInstallments: data.Request.product.PaymentCondition.paymentInInstallments as [boolean, string],
};
const totalValue = data.Request.product.totalValue;
const paymentMethod: ConditionalWrite = {
    boleto: data.Request.product.paymentMethod.boleto as [boolean, string],
    creditCard: data.Request.product.paymentMethod.creditCard as [boolean, string],
    debitCard: data.Request.product.paymentMethod.debitCard as [boolean, string],
    cheque: data.Request.product.paymentMethod.cheque as [boolean, string],
    bankDeposit: data.Request.product.paymentMethod.bankDeposit as [boolean, string],
    cash: data.Request.product.paymentMethod.cash as [boolean, string],
    international: data.Request.product.paymentMethod.international as [boolean, string],
    pix: data.Request.product.paymentMethod.pix as [boolean, string],
};
const paymentInstallments = data.Request.product.paymentInstallments;
const paymentDetails = data.Request.product.paymentDetails;
const supplier: SupplierOfRequest = SupplierOfRequest[data.Request.product.supplier as keyof typeof SupplierOfRequest];
const productCategory: ProductCategory = ProductCategory[data.Request.product.productCategory as keyof typeof ProductCategory];
const productNameAndDescription = data.Request.product.productNameAndDescription;
const productQuantity = data.Request.product.productQuantity;
const productColor = data.Request.product.productColor;
const productSize = data.Request.product.productSize;
const productModel = data.Request.product.productModel;
const productLink = data.Request.product.productLink;
const attachedFile = data.Request.product.attachedFile;
const saveRequest: Record<SaveRequest, boolean> = {
    [SaveRequest.draft]: !!data.Request.product.saveRequest.draft,
    [SaveRequest.submit]: !!data.Request.product.saveRequest.submit,
};




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
            email: emailUserRegistration || faker.internet.userName() + domain,
            password: passwordUserRegistration || faker.number.int().toString(),
            confirmPassword: passwordUserRegistration,
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
        product: {
            costCenter: costCenter || CostCenter['06.354.562/0001-10 - HKM - Software e Sistemas'],
            apportionmentPercentage: apportionmentPercentage | faker.helpers.arrayElement([100]),
            apportionmentValue: apportionmentValue | faker.helpers.arrayElement([100, 350, 700]),
            quoteRequest: { [QuoteRequest.quoteRequest]: quoteRequest !== undefined ? quoteRequest : true },
            acquiringArea: acquiringArea || AcquiringArea.areaContract,
            comexImport: comexImport || ComexImport.yes,
            reasonForRequest: reasonForRequest || faker.lorem.lines(),
            desiredDeliveryDate: (new Date(data.Request.product.desiredDeliveryDate || new Date())).toISOString().split('T')[0],
            productStorageLocation: productStorageLocation || faker.lorem.lines(),
            suggestionLinks: suggestionLinks || faker.lorem.lines(),
            observation: observation || faker.lorem.lines(),
            paymentCondition: Object.values(paymentMethod).some(([isEnabled]) => isEnabled) ? paymentCondition : { [PaymentCondition.anticipatedPayment]: [true, PaymentCondition.anticipatedPayment] },
            totalValue: totalValue | faker.helpers.arrayElement([1750.36, 350.87, 700.04]),
            paymentMethod: Object.values(paymentMethod).some(([isEnabled]) => isEnabled) ? paymentMethod : { [PaymentMethod.boleto]: [true, PaymentMethod.boleto] },
            paymentInstallments: paymentInstallments | 3,
            paymentDetails: paymentDetails || faker.lorem.lines(),
            supplier: supplier ? SupplierOfRequest[data.Request.product.supplier] : SupplierOfRequest['47.960.950/0347-00  - MAGAZINE LUIZA SA'],
            productCategory: productCategory || ProductCategory['Maquinas E Equipamentos No Laboratorio'],
            productNameAndDescription: productNameAndDescription || faker.lorem.lines(),
            productQuantity: productQuantity || 3,
            productColor: productColor || faker.lorem.word(),
            productSize: productSize || faker.lorem.word(),
            productModel: productModel || faker.lorem.word(),
            productLink: productLink || faker.internet.url(),
            attachedFile: attachedFile || '../fixtures/attachedFile.png',
            saveRequest: saveRequest || {
                [SaveRequest.draft]: true,
                [SaveRequest.submit]: false,
            },
        },
        oneOffService: {},
        recurringService: {},
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