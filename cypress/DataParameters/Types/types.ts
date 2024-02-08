/// <reference path="../../support/cypress.d.ts" />

import { faker } from '@faker-js/faker';
import * as fakerBr from 'faker-br';
import { format } from 'date-fns';
//é biblico, não pode julgar pelas aparencias
import { SearchColumnGeneralRequests } from '../Enums/searchColumnGeneralRequests';
import { SearchColumnMyRequests } from '../Enums/searchColumnMyRequests';
import { SearchColumnOneOffServiceRequests } from '../Enums/searchColumnOneOffServiceRequests';
import { SearchColumnProductRequests } from '../Enums/searchColumnProductRequests';
import { SearchColumnRecurringServiceRequests } from '../Enums/searchColumnRecurringServiceRequests';
import { ShowHideColumnsGeneralRequests } from '../Enums/showHideColumnsGeneralRequests';
import { ShowHideColumnsMyRequests } from '../Enums/showHideColumnsMyRequests';
import { ShowHideColumnsOneOffServiceRequests } from '../Enums/showHideColumnsOneOffServiceRequests';
import { ShowHideColumnsProductRequests } from '../Enums/showHideColumnsProductRequests';
import { ShowHideColumnsProductivityReport } from '../Enums/showHideColumnsProductivityReport';
import { ShowHideColumnsProfilesTable } from '../Enums/showHideColumnsProfilesTable';
import { ShowHideColumnsRecurringServiceRequests } from '../Enums/showHideColumnsRecurringServiceRequests';
import { ShowHideColumnsRequestReport } from '../Enums/showHideColumnsRequestReport';
import { ShowHideColumnsSupplierRegistration } from '../Enums/showHideColumnsSupplierRegistration';
import { ShowHideColumnsUserRegistration } from '../Enums/showHideColumnsUserRegistration';
import { TableColumnsGeneralRequests } from '../Enums/tableColumnsGeneralRequests';
import { TableColumnsMyRequests } from '../Enums/tableColumnsMyRequests';
import { TableColumnsOneOffServiceRequests } from '../Enums/tableColumnsOneOffServiceRequests';
import { TableColumnsProductRequests } from '../Enums/tableColumnsProductRequests';
import { TableColumnsProductivityReport } from '../Enums/tableColumnsProductivityReport';
import { TableColumnsProfilesTable } from '../Enums/tableColumnsProfilesTable';
import { TableColumnsRecurringServiceRequests } from '../Enums/tableColumnsRecurringServiceRequests';
import { TableColumnsRequestReport } from '../Enums/tableColumnsRequestReport';
import { TableColumnsSupplierRegistration } from '../Enums/tableColumnsSupplierRegistration';
import { TableColumnsUserRegistration } from '../Enums/tableColumnsUserRegistration';
import { DataParameters, DateTime } from './../Interfaces/interfaces';
import { dataParameters } from './../../dataParameters';


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