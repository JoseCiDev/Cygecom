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
    ConditionalWrite,
    RequestType,
    ObservationOfRequest,
    IsComexImportProduct,
    IsComexImportService,
    elements,
    Request,
    Apportionment,
    SuggestionLinks,
    data,
    ProductRequest,
    Requests,
    ServiceAlreadyProvided,
    PaymentRecurrence,
    ServiceName,
    TypeOfPaymentAmount,
    PaymentDueDate
} from '../import';

const environment = Cypress.env('ENVIRONMENT');
const dataEnvironment = Cypress.env(environment);


const baseUrlCi = 'http://gerenciador-compras.docker.local:8085';
const emailAdminCi = "gecom_admin@essentia.com.br";
const passwordAdminCi = "essadmin@2023";

export const requestType = RequestType.product;

const costCenter = CostCenter['06.354.562/0001-10 - HKM - Software e Sistemas'];

const apportionmentPercentage = faker.helpers.arrayElement(['100']);

const apportionmentValue = faker.helpers.arrayElement([' ']);

const quoteRequest =  "true"
    

const acquiringArea = AcquiringArea.areaContract;

let isComex = IsComexImportProduct.no;
const IsComexImport = IsComexImportProduct.no
  


const reasonForRequest = faker.lorem.lines(1);

const desiredDeliveryDate = new Date().toISOString().split('T')[0];

const localDescription = faker.lorem.lines(1);

export const suggestionLinksString = SuggestionLinks.product
    

const suggestion = faker.internet.url();

export const observationString = ObservationOfRequest.productAndRecurringService

const observation = faker.lorem.lines(1);

const paymentCondition = PaymentCondition.cashPayment;

const totalValue = faker.helpers.arrayElement([1750.85, 325.90, 1025]);

const paymentMethod = PaymentMethod.pix;

const paymentInstallments = faker.helpers.arrayElement([3, 8]);

const paymentDetails = faker.lorem.lines(1);

const supplier = SupplierOfRequest['17.895.646/0001-87  - UBER DO BRASIL TECNOLOGIA LTDA'];

const category = ProductCategory['Brinde - Mercadoria distribuida gratuitamente para nossos clientes e que não podemos vender. Ex. Toalha, Necessaire, etc...'];

const attachedFile = '../fixtures/attachedFile.png';

const    isSaved = '.btn-success';


const nameAndDescription = faker.commerce.productName();

const quantity = faker.helpers.arrayElement([3, 8]);

const color = faker.helpers.arrayElement(['red', 'blue', 'green', 'yellow']);

const size = faker.helpers.arrayElement(['P', 'M', 'G', 'GG']);

const model = faker.helpers.arrayElement(['BASIC', 'ADVANCED']);

const link = faker.internet.url();


const serviceName = faker.lorem.lines(1).trim();

const description = faker.lorem.lines(1);

const seller = faker.person.fullName();

const sellerTelephone = fakerBr.phone.phoneNumber();

const sellerEmail = faker.internet.email();

const serviceAlreadyProvided = ServiceAlreadyProvided.no;

const typeOfPaymentAmount = TypeOfPaymentAmount.variable;

const initialPaymentEffectiveDate = new Date().toISOString().split('T')[0];

const finalPaymentEffectiveDate = new Date().toISOString().split('T')[0];

const paymentRecurrence = PaymentRecurrence.monthly;

const paymentDueDate = PaymentDueDate.one;



const request: Requests = {
    requestType: requestType,
    costCenter,
    apportionmentPercentage,
    apportionmentValue,
    quoteRequest,
    acquiringArea,
    isComex: isComex,
    reasonForRequest,
    desiredDeliveryDate,
    localDescription,
    suggestionLinks: suggestion,
    observation,
    paymentCondition,
    totalValue,
    paymentMethod,
    paymentInstallments,
    paymentDetails,
    supplier,
    attachedFile,
    isSaved,

    category,
    nameAndDescription,
    quantity,
    color,
    size,
    model,
    link,

    serviceName,
    description,
    seller,
    sellerTelephone,
    sellerEmail,

    serviceAlreadyProvided,

    initialPaymentEffectiveDate,
    finalPaymentEffectiveDate,
    paymentRecurrence,
    paymentDueDate,
    typeOfPaymentAmount,
}



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



export const dataParameters: DataParameters = {
    baseUrlCi: baseUrlCi,
    emailAdminCi:emailAdminCi,
    passwordAdminCi:passwordAdminCi,

    env: dataEnvironment,

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

    request: request,

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

export const Messages = {
    validationMessages: {
        REQUIRE_FIELD: 'Este campo é obrigatório.',
        GREATER_THAN_ONE: 'Por favor, forneça um valor maior ou igual a 1.',
        PERCENTAGEM_SUM: 'A soma da porcentagem deve ser 100%.',
        GREATER_THEN_CURRENT_DATE: `Por favor, forneça um valor maior ou igual a ${new Date().toISOString().split('T')[0]}`,
        VALID_VALUE: `Por favor, forneça um número válido.`
    },
    returnMessages: {
        fieldFilledAndMessageDisplayed:'Lamentamos informar que ocorreu um problema no preenchimento do campo, pois a mensagem de obrigatoriedade está sendo exibida mesmo com o campo já preenchido.',
        fieldNotFilledAndMessageNotDisplayed:'O campo em questão não foi preenchido corretamente. No entanto, gostaríamos de ressaltar que a mensagem de obrigatoriedade não está sendo exibida conforme o esperado.',
        sumPercentagesCorrectAndMessageDisplayed:'A soma total das porcentagens é igual a 100%. No entanto, a mensagem que indica que a porcentagem deve ser igual a 100% é exibida.',
        sumPercentagesIncorrectAndMessageNotDisplayed:'Lamentamos informar que a soma das porcentagens é inferior a 100%. No entanto, a mensagem que indica que a porcentagem deve ser 100% não está sendo exibida.',
        valueLessThanOrEqualToZeroAndMessageNotDisplayed:'Foi observado que um valor menor ou igual a zero foi informado, no entanto, não foi exibida uma mensagem informando que é necessário fornecer um valor maior ou igual a um.',
        valueGreaterOrThanEqualToZeroMessageNotDisplayed:'Foi observado que um valor maior que zero foi informado, no entanto, é exibida uma mensagem informando que é necessário fornecer um valor maior ou igual a um.',
        differentValueOfNumbersMessageNotDisplayed:'Foi observado que um valor diferente de número foi informado, no entanto, não foi exibida uma mensagem informando que é necessário fornecer um valor numérico.',
        
    },

    //Por favor, forneça um número válido.

};