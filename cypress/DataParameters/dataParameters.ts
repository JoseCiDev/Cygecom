///home/jose/projetos/Cygecom/cypress/DataParameters/dataParameters.ts
/// <reference path="../support/cypress.d.ts" />

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
    elements as el,
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
    PaymentDueDate,
    faker,
    fakerBr,
    dateFns
} from '../import';


const environment = Cypress.env('ENVIRONMENT');
const dataEnvironment = Cypress.env(environment);

export const requestTypeString = data.Request.requestType || 'product';
export const requestData = data.Request[requestTypeString];

const baseUrlCi = 'http://gerenciador-compras.docker.local:8085/';
const emailAdminCi = "gecom_admin@essentia.com.br";
const passwordAdminCi = "essadmin@2023";

export const requestTyper = RequestType.product;

const costCenter = requestData.costCenter && requestData.costCenter !== " "
    ? CostCenter[requestData.costCenter]
    : CostCenter['06.354.562/0001-10 - HKM - Software e Sistemas'];

const apportionmentPercentage = requestData.apportionmentPercentage && requestData.apportionmentPercentage !== " "
    ? requestData.apportionmentPercentage
    : faker.helpers.arrayElement([' ']);

const apportionmentValue = requestData.apportionmentValue && requestData.apportionmentValue !== " "
    ? requestData.apportionmentPercentage
    : faker.helpers.arrayElement(['100']);

const quoteRequest = requestData.quoteRequest && requestData.quoteRequest !== " " && requestData.quoteRequest.toLowerCase() === "true"
    ? "true"
    : "false";

const acquiringArea = requestData.acquiringArea && requestData.acquiringArea !== " "
    ? AcquiringArea[requestData.acquiringArea]
    : AcquiringArea.suppliesContract;

let isComex;
const IsComexImport = requestTypeString === 'product'
    ? IsComexImportProduct
    : IsComexImportService;
if (requestData.isComex && requestData.isComex !== " ") {
    const isComexString = requestData.isComex;
    isComex = IsComexImport[isComexString]
}
else {
    isComex = IsComexImport.no
}

const reasonForRequest = requestData.reasonForRequest && requestData.reasonForRequest !== " "
    ? requestData.reasonForRequest
    : faker.lorem.lines(1);

const desiredDeliveryDate = requestData.desiredDeliveryDate && requestData.desiredDeliveryDate !== " "
    ? requestData.desiredDeliveryDate
    : new Date().toISOString().split('T')[0];

const localDescription = requestData.localDescription && requestData.localDescription !== " " ? requestData.localDescription : faker.lorem.lines(1);

export const suggestionLinksString = requestTypeString === 'product'
    ? SuggestionLinks.product
    : SuggestionLinks.service;

const suggestion = requestData.suggestionLinks && requestData.suggestionLinks !== " "
    ? requestData.suggestionLinks
    : faker.internet.url();

export const observationString = requestTypeString === 'product' || requestTypeString === 'recurringService'
    ? ObservationOfRequest.productAndRecurringService
    : ObservationOfRequest.oneOffService;

const observation = requestData.observation && requestData.observation !== " "
    ? requestData.observation
    : faker.lorem.lines(1);

const paymentCondition = requestData.paymentCondition && requestData.paymentCondition !== " "
    ? PaymentCondition[requestData.paymentCondition]
    : PaymentCondition.cashPayment;

const totalValue = requestData.totalValue && requestData.totalValue !== " "
    ? requestData.totalValue
    : faker.helpers.arrayElement([1750.85, 325.90, 1025]);

const paymentMethod = requestData.paymentMethod && requestData.paymentMethod !== " "
    ? PaymentMethod[requestData.paymentMethod]
    : PaymentMethod.pix;

const paymentInstallments = requestData.paymentInstallments && requestData.paymentInstallments !== " "
    ? requestData.paymentInstallments
    : faker.helpers.arrayElement([3, 8]);

const paymentDetails = requestData.paymentDetails && requestData.paymentDetails !== " "
    ? requestData.paymentDetails
    : faker.lorem.lines(1);

const supplier = requestData.supplier && requestData.supplier !== " "
    ? SupplierOfRequest[requestData.supplier]
    : SupplierOfRequest['05.876.012/0032-02  - PBTECH COM. E SERVIÇOS DE REVEST. CERAMICOS LTDA'];

const category = requestData.category && requestData.category !== " "
    ? ProductCategory[requestData.category]
    : ProductCategory['Brinde - Mercadoria distribuida gratuitamente para nossos clientes e que não podemos vender. Ex. Toalha, Necessaire, etc...'];

const attachedFile = requestData.file && requestData.file !== " "
    ? requestData.file
    : '../fixtures/attachedFile.png';

const nameAndDescription = requestData.nameAndDescription && requestData.nameAndDescription !== " "
    ? requestData.nameAndDescription
    : faker.commerce.productName();

const quantity = requestData.quantity && requestData.quantity !== " "
    ? requestData.quantity
    : faker.helpers.arrayElement([3, 8]);

const color = requestData.color && requestData.color !== " "
    ? requestData.color
    : faker.helpers.arrayElement(['red', 'blue', 'green', 'yellow']);

const size = requestData.size && requestData.size !== " "
    ? requestData.size
    : faker.helpers.arrayElement(['P', 'M', 'G', 'GG']);

const model = requestData.model && requestData.model !== " "
    ? requestData.model
    : faker.helpers.arrayElement(['BASIC', 'ADVANCED']);

const link = requestData.link && requestData.link !== " "
    ? requestData.link
    : faker.internet.url();

export const serviceNameString = requestTypeString === 'oneOffService'
    ? ServiceName.oneOffService
    : ServiceName.recurringService;

const serviceName = requestData.serviceName && requestData.serviceName !== " "
    ? requestData.serviceName
    : faker.lorem.lines(1).trim();

const description = requestData.description && requestData.description !== " "
    ? requestData.description
    : faker.lorem.lines(1);

const seller = requestData.seller && requestData.seller !== " "
    ? requestData.seller
    : faker.person.fullName();

const sellerTelephone = requestData.sellerTelephone && requestData.sellerTelephone !== " "
    ? requestData.sellerTelephone
    : fakerBr.celular();

const sellerEmail = requestData.sellerEmail && requestData.sellerEmail !== " "
    ? requestData.sellerEmail
    : faker.internet.email();

const serviceAlreadyProvided = requestData.serviceAlreadyProvided && requestData.serviceAlreadyProvided !== " "
    ? ServiceAlreadyProvided[requestData.serviceAlreadyProvided]
    : ServiceAlreadyProvided.no;

const typeOfPaymentAmount = requestData.typeOfPaymentAmount && requestData.typeOfPaymentAmount !== " "
    ? TypeOfPaymentAmount[requestData.typeOfPaymentAmount]
    : TypeOfPaymentAmount.variable;

const initialPaymentEffectiveDate = requestData.initialPaymentEffectiveDate && requestData.initialPaymentEffectiveDate !== " "
    ? requestData.initialPaymentEffectiveDate
    : new Date().toISOString().split('T')[0];

const finalPaymentEffectiveDate = requestData.finalPaymentEffectiveDate && requestData.finalPaymentEffectiveDate !== " "
    ? requestData.finalPaymentEffectiveDate
    : new Date().toISOString().split('T')[0];

const paymentRecurrence = requestData.paymentRecurrence && requestData.paymentRecurrence !== " "
    ? PaymentRecurrence[requestData.paymentRecurrence]
    : PaymentRecurrence.monthly;

const paymentDueDate = requestData.paymentDueDate && requestData.paymentDueDate !== " "
    ? PaymentDueDate[requestData.paymentDueDate]
    : PaymentDueDate.one;

export let isSaved;
export let IsSavedRequest;
if (requestData.saveRequest && requestData.saveRequest !== " ") {
    const isSavedString = requestData.saveRequest;
    IsSavedRequest = isSavedString !== "submit" ? SaveRequestDraft : SaveRequestSubmit;
    isSaved = IsSavedRequest[requestTypeString];
}
else {
    isSaved = SaveRequestSubmit[requestTypeString];
}


const request: Requests = {
    requestType: requestTyper,
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
    emailAdminCi: emailAdminCi,
    passwordAdminCi: passwordAdminCi,

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
    validation: {
        REQUIRE_FIELD: 'Este campo é obrigatório.',
        GREATER_THAN_ONE: 'Por favor, forneça um valor maior ou igual a 1.',
        PERCENTAGE_SUM: 'A soma das porcentagens deve ser igual ou menor que 100% e maior ou igual a 1%.',
        GREATER_THAN_CURRENT_DATE: `Por favor, forneça um valor maior ou igual a ${new Date().toISOString().split('T')[0]}`,
        VALID_VALUE: 'Por favor, forneça um número válido.',
        MIN_TWO_CHARACTERS: 'Por favor, forneça ao menos 2 caracteres.'
    },
    return: {
        failure: {
            FIELD_FILLED_BUT_MESSAGE_DISPLAYED: 'Lamentamos informar que ocorreu um problema no preenchimento do campo, pois a mensagem de obrigatoriedade está sendo exibida mesmo com o campo já preenchido.',
            FIELD_NOT_FILLED_BUT_NO_MESSAGE: 'O campo em questão não foi preenchido corretamente. No entanto, gostaríamos de ressaltar que a mensagem de obrigatoriedade não está sendo exibida conforme o esperado.',
            SUM_PERCENTAGES_CORRECT_BUT_MESSAGE_DISPLAYED: 'A soma total das porcentagens é igual a 100%. No entanto, a mensagem que indica que a porcentagem deve ser igual a 100% é exibida.',
            SUM_PERCENTAGES_INCORRECT_BUT_NO_MESSAGE: 'Lamentamos informar que a soma das porcentagens é inferior a 100%. No entanto, a mensagem que indica que a porcentagem deve ser 100% não está sendo exibida.',
            VALUE_LESS_THAN_OR_EQUAL_TO_ZERO_BUT_NO_MESSAGE: 'Foi observado que um valor menor ou igual a zero foi informado, no entanto, não foi exibida uma mensagem informando que é necessário fornecer um valor maior ou igual a um.',
            VALUE_GREATER_THAN_ZERO_BUT_MESSAGE_DISPLAYED: 'Foi observado que um valor maior que zero foi informado, no entanto, é exibida uma mensagem informando que é necessário fornecer um valor maior ou igual a um.',
            DIFFERENT_VALUE_THAN_NUMBER_BUT_NO_MESSAGE: 'Foi observado que um valor diferente de número foi informado, no entanto, não foi exibida uma mensagem informando que é necessário fornecer um valor numérico.'
        },
        success: {
            FIELD_CORRECTLY_FILLED: 'Campo corretamente preenchido.',
            PERCENTAGE_SUM_CORRECT: 'A soma total das porcentagens é igual a 100%.',
        }
    }
};