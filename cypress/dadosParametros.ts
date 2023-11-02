import { faker } from '@faker-js/faker';
import * as fakerBr from 'faker-br';
import { format } from 'date-fns';


const ambiente = Cypress.env('AMBIENTE');
const dadosAmbiente = Cypress.env(ambiente);


export interface DataHora {
    DATA_FORMATADA: string;
    HORA_FORMATADA: string;
}

interface DadosParametros {

    sizes: Array<number | [number, number] | string>;

    env: {
        ENV: string;
        EMAILADMIN: string;
        SENHAADMIN: string;
        EMAILUSUARIO: string,
        SENHAUSUARIO: string,
        EMAILGESTORUSUARIO: string,
        SENHAGESTORUSUARIO: string,
        BASEURL: string;
        DB_NAME: string;
        DB_USER: string;
        DB_HOST: string;
        DB_PORT: string;
        DB_PASSWORD: string;
    };

    url: {

    };

    pedidoParams: {

    };

    enums: {
        Perfil: typeof Perfil;
        OpcaoAutorizacao: typeof OpcaoAutorizacao;
    };
}



export const getRandomValue = <T>(array: T[]): T => {
    const randomIndex = Math.floor(Math.random() * array.length);
    return array[randomIndex];
}

enum Perfil {
    Administrador = "profile_admin",
    Normal = "profile_normal",
    SuprimentosHKM = "profile_suprimentos_hkm",
    SuprimentosINP = "profile_suprimentos_inp",
    GestorUsuarios = "gestor_usuarios",
    GestorFornecedores = "gestor_fornecedores",
}


enum OpcaoAutorizacao {
    Autorizado = '1',
    NaoAutorizado = '0',
}



export const dadosParametros: DadosParametros = {

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
        [414, 736],
        [390, 844],
        [400, 550],
        [375, 812],
        [375, 667],
        [360, 760],
        [320, 568],
        [320, 480],
        [280, 653],
    ],

    env: dadosAmbiente,

    url: {

    },

    enums: {
        Perfil,
        OpcaoAutorizacao,
    },

    pedidoParams: {

    },

};

