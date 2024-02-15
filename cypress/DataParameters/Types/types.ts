/// <reference path="../../support/cypress.d.ts" />

import { faker } from '@faker-js/faker';
import * as fakerBr from 'faker-br';
import { format } from 'date-fns';
import {
    PaymentCondition,
    PaymentMethod,
    SearchColumnGeneralRequests,
    SearchColumnMyRequests,
    SearchColumnOneOffServiceRequests,
    SearchColumnProductRequests,
    SearchColumnRecurringServiceRequests,
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
    TableColumnsGeneralRequests,
    TableColumnsMyRequests,
    TableColumnsOneOffServiceRequests,
    TableColumnsProductRequests,
    TableColumnsProductivityReport,
    TableColumnsProfilesTable,
    TableColumnsRecurringServiceRequests,
    TableColumnsRequestReport,
    TableColumnsSupplierRegistration,
    TableColumnsUserRegistration
} from '../../import';

const environment = Cypress.env('ENVIRONMENT');
const dataEnvironment = Cypress.env(environment);


export type ColumnEnums =
    ShowHideColumnsUserRegistration[keyof ShowHideColumnsUserRegistration] |
    ShowHideColumnsSupplierRegistration[keyof ShowHideColumnsSupplierRegistration] |
    ShowHideColumnsMyRequests[keyof ShowHideColumnsMyRequests] |
    ShowHideColumnsGeneralRequests[keyof ShowHideColumnsGeneralRequests] |
    ShowHideColumnsProductRequests[keyof ShowHideColumnsProductRequests] |
    ShowHideColumnsOneOffServiceRequests[keyof ShowHideColumnsOneOffServiceRequests] |
    ShowHideColumnsRecurringServiceRequests[keyof ShowHideColumnsRecurringServiceRequests] |
    ShowHideColumnsRequestReport[keyof ShowHideColumnsRequestReport] |
    ShowHideColumnsProductivityReport[keyof ShowHideColumnsProductivityReport] |
    ShowHideColumnsProfilesTable[keyof ShowHideColumnsProfilesTable] |

    TableColumnsUserRegistration[keyof TableColumnsUserRegistration] |
    TableColumnsSupplierRegistration[keyof TableColumnsSupplierRegistration] |
    TableColumnsMyRequests[keyof TableColumnsMyRequests] |
    TableColumnsGeneralRequests[keyof TableColumnsGeneralRequests] |
    TableColumnsProductRequests[keyof TableColumnsProductRequests] |
    TableColumnsOneOffServiceRequests[keyof TableColumnsOneOffServiceRequests] |
    TableColumnsRecurringServiceRequests[keyof TableColumnsRecurringServiceRequests] |
    TableColumnsRequestReport[keyof TableColumnsRequestReport] |
    TableColumnsProductivityReport[keyof TableColumnsProductivityReport] |
    TableColumnsProfilesTable[keyof TableColumnsProfilesTable] |

    SearchColumnMyRequests[keyof SearchColumnMyRequests] |
    SearchColumnGeneralRequests[keyof SearchColumnGeneralRequests] |
    SearchColumnProductRequests[keyof SearchColumnProductRequests] |
    SearchColumnOneOffServiceRequests[keyof SearchColumnOneOffServiceRequests] |
    SearchColumnRecurringServiceRequests[keyof SearchColumnRecurringServiceRequests];

export type ColumnSearchParameter =
    Record<SearchColumnMyRequests, [boolean, string]> |
    Record<SearchColumnGeneralRequests, [boolean, string]> |
    Record<SearchColumnProductRequests, [boolean, string]> |
    Record<SearchColumnOneOffServiceRequests, [boolean, string]> |
    Record<SearchColumnRecurringServiceRequests, [boolean, string]>;

export type ValidationResult = Cypress.Chainable<{ error?: string; success?: string; }>

export type DateTimeRecord = [string | Date, boolean];

export type ConditionalWrite =
    Record<PaymentCondition, [boolean, string]> |
    Record<PaymentMethod, [boolean, string]>



export type ElementTypeAndValueOpcional = {
    element: string,
    value?: string,
}[];