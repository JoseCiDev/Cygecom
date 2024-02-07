/// <reference path="./support/cypress.d.ts" />

import { faker } from '@faker-js/faker';
import * as fakerBr from 'faker-br';
import { format } from 'date-fns';


import { DataParameters } from './DataParameters/Interfaces/interfaces';
import { Sector } from './DataParameters/Enums/sector';
import { UserProfile } from './DataParameters/Enums/userProfile';
import { ApproverUser } from './DataParameters/Enums/approverUser';
import { AutorizedRequest } from './DataParameters/Enums/autorizedRequest';
import { RequestOtherUsers } from './DataParameters/Enums/requestOtherUsers';
import { AllowedRequestCostCenter } from './DataParameters/Enums/allowedRequestCostCenter';
import { AllowedApprovalCostCenter } from './DataParameters/Enums/allowedApprovalCostCenter';
import { ShowHideColumnsUserRegistration } from './DataParameters/Enums/showHideColumnsUserRegistration';
import { ShowRecordsQuantity } from './DataParameters/Enums/showRecordsQuantity';
import { SearchColumnProductRequests } from './DataParameters/Enums/searchColumnProductRequests';
import { ShowHideColumnsSupplierRegistration } from './DataParameters/Enums/showHideColumnsSupplierRegistration';
import { ShowHideColumnsMyRequests } from './DataParameters/Enums/showHideColumnsMyRequests';
import { TelephoneType } from './DataParameters/Enums/telephoneType';
import { ApproveLimit } from './DataParameters/Enums/approveLimit';
import { ShowHideColumnsGeneralRequests } from './DataParameters/Enums/showHideColumnsGeneralRequests';
import { ShowHideColumnsProductRequests } from './DataParameters/Enums/showHideColumnsProductRequests';
import { ShowHideColumnsOneOffServiceRequests } from './DataParameters/Enums/showHideColumnsOneOffServiceRequests';
import { ShowHideColumnsRecurringServiceRequests } from './DataParameters/Enums/showHideColumnsRecurringServiceRequests';
import { ShowHideColumnsRequestReport } from './DataParameters/Enums/showHideColumnsRequestReport';
import { ShowHideColumnsProductivityReport } from './DataParameters/Enums/showHideColumnsProductivityReport';
import { ShowHideColumnsProfilesTable } from './DataParameters/Enums/showHideColumnsProfilesTable';
import { SearchColumnMyRequests } from './DataParameters/Enums/searchColumnMyRequests';
import { SearchColumnGeneralRequests } from './DataParameters/Enums/searchColumnGeneralRequests';
import { SearchColumnOneOffServiceRequests } from './DataParameters/Enums/searchColumnOneOffServiceRequests';
import { SearchColumnRecurringServiceRequests } from './DataParameters/Enums/searchColumnRecurringServiceRequests';
import { TableColumnsUserRegistration } from './DataParameters/Enums/tableColumnsUserRegistration';
import { TableColumnsGeneralRequests } from './DataParameters/Enums/tableColumnsGeneralRequests';
import { TableColumnsMyRequests } from './DataParameters/Enums/tableColumnsMyRequests';
import { TableColumnsOneOffServiceRequests } from './DataParameters/Enums/tableColumnsOneOffServiceRequests';
import { TableColumnsProductRequests } from './DataParameters/Enums/tableColumnsProductRequests';
import { TableColumnsProductivityReport } from './DataParameters/Enums/tableColumnsProductivityReport';
import { TableColumnsProfilesTable } from './DataParameters/Enums/tableColumnsProfilesTable';
import { TableColumnsRecurringServiceRequests } from './DataParameters/Enums/tableColumnsRecurringServiceRequests';
import { TableColumnsRequestReport } from './DataParameters/Enums/tableColumnsRequestReport';
import { TableColumnsSupplierRegistration } from './DataParameters/Enums/tableColumnsSupplierRegistration';
import { QuoteRequest } from './DataParameters/Enums/quoteRequest';
import { AcquiringArea } from './DataParameters/Enums/acquiringArea';
import { ComexImport } from './DataParameters/Enums/comexImport';
import { PaymentCondition } from './DataParameters/Enums/paymentCondition';
import { PaymentMethod } from './DataParameters/Enums/paymentMethod';
import { SupplierOfRequest } from './DataParameters/Enums/supplierOfRequest';
import { ProductCategory } from './DataParameters/Enums/productCategory';
import { DateTimeRecord } from './DataParameters/Types/types';
import { CostCenter } from './DataParameters/Enums/costCenter';

const environment = Cypress.env('ENVIRONMENT');
const dataEnvironment = Cypress.env(environment);

let domain = '@essentia.com.br';
let password = faker.number.int().toString();
let confirmPassword = password;

const currentDate: Date = new Date();
const year: number = currentDate.getFullYear();
const month: string = String(currentDate.getMonth() + 1).padStart(2, '0');
const day: string = String(currentDate.getDate()).padStart(2, '0');
const hour: string = String(currentDate.getHours()).padStart(2, '0');
const minutes: string = String(currentDate.getMinutes()).padStart(2, '0');
const seconds: string = String(currentDate.getSeconds()).padStart(2, '0');
export const FORMATTED_DATE: string = `${year}-${month}-${day}`;
export const FORMATTED_TIME: string = `${hour}:${minutes}:${seconds}`;


export const dataParameters: DataParameters = {

    env: dataEnvironment,

    filePath: '/',

    sizes: [
        [1536, 960],
        [1440, 900],
        [1366, 768],
        [1280, 800],
        [1280, 720],
        [1024, 768],
        [1024, 600],
        [820, 1180],
        [768, 1024],
        [412, 914],
        [414, 896],
        [414, 846],
        [414, 736],
    ],

    url: {
        login: 'http://192.168.0.66:9401/login',
    },

    Autentication: {
        domain: domain,
        email: faker.internet.userName() + domain,
        password: faker.number.int().toString(),
        giantPassword: faker.lorem.word({ length: { min: 100, max: 102 }, strategy: 'longest' }),
    },

    Register: {
        userRegistration: {
            name: faker.person.fullName(),
            birthDate: new Date(),
            cpf: fakerBr.br.cpf(),
            cnpj: fakerBr.br.cnpj(),
            telephone: faker.string.alphanumeric('(48) 9####-####'),
            email: faker.internet.userName() + domain,
            password: faker.number.int().toString(),
            confirmPassword: password,
            userProfile: UserProfile.normal,
            sector: Sector.HKM_SOFTWARE_E_SISTEMAS,
            approverUser: ApproverUser.diretorgecom,
            approvalLimit: 1500,
            authorizationRequest: AutorizedRequest.authorized,
            requestOtherUsers: RequestOtherUsers.canAssociate,
            allowedRequestCostCenter: AllowedRequestCostCenter.CGE_CONGRESSOS_E_EVENTOS,
            allowedApprovalCostCenter: AllowedApprovalCostCenter.CGE_DIRETORIA,

        },
        // supplierRegistration: {
        //     CNPJ: ,
        //     company: ,
        //     companyName: ,
        //     description: ,
        //     marketType: ,
        //     supplierIndication: ,
        //     cep: ,
        //     country: ,
        //     state: ,
        //     city: ,
        //     district: ,
        //     street: ,
        //     number: ,
        //     addressComplement: ,
        //     telephone: ,
        //     email: ,
        //     tradeRepresentative: ,
        // },
    },
    // ...
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
            //Adicione todas as outras propriedades necessárias aqui
        },
        tableColumnsSupplierRegistration: {
            [TableColumnsSupplierRegistration.CNPJ]: false,
            [TableColumnsSupplierRegistration.company]: false,
            [TableColumnsSupplierRegistration.companyName]: false,
            [TableColumnsSupplierRegistration.situation]: false,
        }, // Add the necessary properties for this object
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
            costCenter: CostCenter['06.354.562/0001-10 - HKM - Software e Sistemas'],
            apportionmentPercentage: faker.helpers.arrayElement([100]),
            apportionmentValue: faker.helpers.arrayElement([100, 350, 700]),
            quoteRequest: { [QuoteRequest.quoteRequest]: true, },
            acquiringArea:
                AcquiringArea.areaContract,
            comexImport:
                ComexImport.yes,
            reasonForRequest: faker.lorem.lines(),
            desiredDeliveryDate: [FORMATTED_DATE, true] as DateTimeRecord,
            productStorageLocation: faker.lorem.lines(),
            suggestionLinks: faker.lorem.lines(),
            observation: faker.lorem.lines(),
            paymentCondition: {
                [PaymentCondition.anticipatedPayment]: true,
                [PaymentCondition.cashPayment]: false,
                [PaymentCondition.paymentInInstallments]: false,
            },
            totalValue: faker.helpers.arrayElement([1750.36, 350.87, 700.04]),
            paymentMethod: {
                [PaymentMethod.boleto]: false,
                [PaymentMethod.creditCard]: false,
                [PaymentMethod.debitCard]: false,
                [PaymentMethod.cheque]: false,
                [PaymentMethod.bankDeposit]: false,
                [PaymentMethod.cash]: false,
                [PaymentMethod.international]: false,
                [PaymentMethod.pix]: true,
            },
            paymentInstallments: 3,
            paymentDetails: faker.lorem.lines(),
            supplier: SupplierOfRequest['00129393000138-AbelvolksComercioEServicosLtda'],
            productCategory: ProductCategory.instalacoes,
            productNameAndDescription: faker.lorem.lines(),
            productQuantity: 3,
            productColor: faker.lorem.word(),
            productSize: faker.lorem.word(),
            productModel: faker.lorem.word(),
            productLink: faker.internet.url(),
        },
        oneOffService: {},
        recurringService: {},
    },
    /*

}
    */

    // ...




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