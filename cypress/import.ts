import * as loadash from 'lodash';
export { loadash };

import * as data from './fixtures/data.json';
export { data };

import * as dateFns from 'date-fns';
export { dateFns };

export { faker } from '@faker-js/faker'
export { elements } from './elements'

import { fakerBr } from '@js-brasil/fakerbr';
export { fakerBr };

export { mount } from 'cypress/react'

import { Given, When, Then } from '@badeball/cypress-cucumber-preprocessor';
export { Given, When, Then };

import 'cypress-wait-until';

export {
    validateEmail,
    validatePassword,
    checkInput,
} from './utils';

export {
    Request,
    DataParameters,
    // UserRegistration,
    ShowHideColumns,
    GetDataOnGrid,
    DateTime,
    CheckAndThrowError,
    ProductRequest,
    ServiceRequest,
    oneOffService,
    recurringService,
} from './DataParameters/Interfaces/interface';

export {
    ColumnEnums,
    ColumnSearchParameter,
    ValidationResult,
    ConditionalWrite,
    ElementTypeAndValueOpcional,
    RequestKeys,
    Requests,
} from './DataParameters/Types/types';

export {
    IsComexImportProduct,
    IsComexImportService
} from './DataParameters/Enums/isComexImport';

export {
    SaveRequestDraft,
    SaveRequestSubmit
} from './DataParameters/Enums/saveRequest';

export { Sector } from './DataParameters/Enums/sector';
export { UserProfile } from './DataParameters/Enums/userProfile';
export { ApproverUser } from './DataParameters/Enums/approverUser';
export { AutorizedRequest } from './DataParameters/Enums/autorizedRequest';
export { RequestOtherUsers } from './DataParameters/Enums/requestOtherUsers';
export { AllowedRequestCostCenter } from './DataParameters/Enums/allowedRequestCostCenter';
export { AllowedApprovalCostCenter } from './DataParameters/Enums/allowedApprovalCostCenter';
export { AcquiringArea } from './DataParameters/Enums/acquiringArea';
export { ApproveLimit } from './DataParameters/Enums/approveLimit';
export { CostCenter } from './DataParameters/Enums/costCenter';
export { PaymentCondition } from './DataParameters/Enums/paymentCondition';
export { PaymentMethod } from './DataParameters/Enums/paymentMethod';
export { ProductCategory } from './DataParameters/Enums/productCategory';
export { QuoteRequest } from './DataParameters/Enums/quoteRequest';
export { SearchColumnGeneralRequests } from './DataParameters/Enums/searchColumnGeneralRequests';
export { SearchColumnMyRequests } from './DataParameters/Enums/searchColumnMyRequests';
export { SearchColumnOneOffServiceRequests } from './DataParameters/Enums/searchColumnOneOffServiceRequests';
export { SearchColumnProductRequests } from './DataParameters/Enums/searchColumnProductRequests';
export { SearchColumnRecurringServiceRequests } from './DataParameters/Enums/searchColumnRecurringServiceRequests';
export { ShowHideColumnsGeneralRequests } from './DataParameters/Enums/showHideColumnsGeneralRequests';
export { ShowHideColumnsMyRequests } from './DataParameters/Enums/showHideColumnsMyRequests';
export { ShowHideColumnsOneOffServiceRequests } from './DataParameters/Enums/showHideColumnsOneOffServiceRequests';
export { ShowHideColumnsProductRequests } from './DataParameters/Enums/showHideColumnsProductRequests';
export { ShowHideColumnsProductivityReport } from './DataParameters/Enums/showHideColumnsProductivityReport';
export { ShowHideColumnsProfilesTable } from './DataParameters/Enums/showHideColumnsProfilesTable';
export { ShowHideColumnsRecurringServiceRequests } from './DataParameters/Enums/showHideColumnsRecurringServiceRequests';
export { ShowHideColumnsRequestReport } from './DataParameters/Enums/showHideColumnsRequestReport';
export { ShowHideColumnsSupplierRegistration } from './DataParameters/Enums/showHideColumnsSupplierRegistration';
export { ShowHideColumnsUserRegistration } from './DataParameters/Enums/showHideColumnsUserRegistration';
export { ShowRecordsQuantity } from './DataParameters/Enums/showRecordsQuantity';
export { SupplierOfRequest } from './DataParameters/Enums/supplierOfRequest';
export { SupplierElement } from './DataParameters/Enums/supplierElement';
export { TableColumnsGeneralRequests } from './DataParameters/Enums/tableColumnsGeneralRequests';
export { TableColumnsMyRequests } from './DataParameters/Enums/tableColumnsMyRequests';
export { TableColumnsOneOffServiceRequests } from './DataParameters/Enums/tableColumnsOneOffServiceRequests';
export { TableColumnsProductRequests } from './DataParameters/Enums/tableColumnsProductRequests';
export { TableColumnsProductivityReport } from './DataParameters/Enums/tableColumnsProductivityReport';
export { TableColumnsProfilesTable } from './DataParameters/Enums/tableColumnsProfilesTable';
export { TableColumnsRecurringServiceRequests } from './DataParameters/Enums/tableColumnsRecurringServiceRequests';
export { TableColumnsRequestReport } from './DataParameters/Enums/tableColumnsRequestReport';
export { TableColumnsSupplierRegistration } from './DataParameters/Enums/tableColumnsSupplierRegistration';
export { TableColumnsUserRegistration } from './DataParameters/Enums/tableColumnsUserRegistration';
export { TableTypesElements } from './DataParameters/Enums/tableTypesElements';
export { TelephoneType } from './DataParameters/Enums/telephoneType';
export { ShowRecordsQuantityElement } from './DataParameters/Enums/showRecordsQuantityElement'
export { SearchColumnElement } from './DataParameters/Enums/searchColumnElement';
export { SearchParameterElement } from './DataParameters/Enums/searchParameterElement';
export { SortByColumnElement } from './DataParameters/Enums/sortByColumnElement';
export { RequestType } from './DataParameters/Enums/requestType';
export { ServiceName } from './DataParameters/Enums/serviceName';
export { SuggestionLinks } from './DataParameters/Enums/suggestionLinks';
export { ObservationOfRequest } from './DataParameters/Enums/observationOfRequest';
export { recurringServiceValue } from './DataParameters/Enums/recurringServiceValue'
export { Apportionment } from './DataParameters/Enums/apportionment';
export { ServiceAlreadyProvided } from './DataParameters/Enums/serviceAlreadyProvided';
export { PaymentDueDate } from './DataParameters/Enums/paymentDueDate';
export { TypeOfPaymentAmount } from './DataParameters/Enums/typeOfPaymentAmount';
export { PaymentRecurrence } from './DataParameters/Enums/paymentRecurrence'

export {
    requestData,
    requestTypeString,
    dataParameters,
    requestTyper,
    suggestionLinksString,
    observationString,
    serviceNameString,
    isSaved,
    Messages,
} from './DataParameters/dataParameters';