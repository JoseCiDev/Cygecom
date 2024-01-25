/// <reference types="cypress" />
import * as faker from '@faker-js/faker';
import * as fakerBr from 'faker-br';
import { elements as el } from '../../../elements';



// const acessarCadastroUsuario = () => {
//     cy.acessarMenuCadastro(el.cadastroMenu);

//     cy.acessarSubmenuCadastroUsuario(el.cadastroUsuarioSubMenu);

//     cy.acessarCadastroUsuario(el.criaNovoUsuario);
// }



// const inserirDataNascimentoUsuario = async (element: string, dataAtual: Date = new Date()): Promise<void> => {
//     cy.inserirData(dataAtual)
//         .then(({ DATA_FORMATADA }: { DATA_FORMATADA: string }) => {
//             const dataAtual = `${DATA_FORMATADA}`;

//             cy.getVisible(element)
//                 .type(dataAtual.toString())
//                 .then(() => {
//                     cy.getVisible(element)
//                         .should('have.value', dataAtual);
//                 });
//         })
// }

describe('Testes da página Cadastro de Usuário', () => {
    const ambiente = Cypress.env('AMBIENTE');
    const dadosAmbiente = Cypress.env(ambiente);
    const email: string = faker.faker.internet.userName() + '@'
    const dominio: string = '@essentia.com.br';
    const emailCompleto: string = faker.faker.internet.userName() + dominio;
    const senha: string = faker.faker.number.int().toString();
    const senhaGigante: string = faker.faker.lorem.word({ length: { min: 100, max: 102 }, strategy: 'longest' });
    const nome: string = faker.faker.person.fullName();
    const letraUnica: string = faker.faker.string.alpha();
    const cpfAleatorio: string = fakerBr.br.cpf();
    const cnpjAleatorio: string = fakerBr.br.cnpj();
    const telefoneAleatorio: string = faker.faker.phone.number('(48) 9####-####')
    const telefoneIncompleto: string = telefoneAleatorio.slice(0, -3)




    beforeEach(function () {

        // cy.login(dadosAmbiente.EMAILGESTORUSUARIO, dadosAmbiente.SENHAGESTORUSUARIO);

        // acessarCadastroUsuario()
    })



})