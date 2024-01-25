/// <reference types="cypress" />
import * as faker from '@faker-js/faker';
import * as fakerBr from 'faker-br';
import { elements as el } from '../elements';
import { ValidationResult, dataParameters } from '../DataParameters'

const {
    logout,
    optionsMenu,
    menuReduced,
    breadcumbHome,
    breadcumbUser,
    showQuantityRecords,
    SearchRegisteredUser,
    nextPage,
    pagePrevious,
} = el.Shared

const {
    titleLogin,
    email,
    password,
    access,
    messageContainer,
} = el.Login

const {

} = el.CustomCommands

const {
    userProfile,
    homeMenu,
    logoGecom,
    homeScreen,
} = el.Start

const {
    registrationMenu,
    registrationMenuReduced,
    registrationUserSubMenu,
    createNewUser,
    username,
    birthdateUser,
    cpfCnpjUser,
    phoneUser,
    emailUser,
    userPassword,
    confirmUserPassword,
    sectorUser,
    optionUserSector,
    optionSelectUserSector,
    optionSelectedSectorUser,
    userApprover,
    optionUserApprover,
    limitUserApproval,
    centerPermittedCostUser,
    selectAllAllowedCostCenterUser,
    clearCenterPermittedCostUser,
    saveUserRegistration,
    cancelUserRegistration,
    registrationSupplierSubMenu,
    messageRequirementName,
    messageRequirementCpfCnpj,
    messageRequiredTelephone,
} = el.Register

const {
    requestMenu,
    newRequestSubMenu,
    myRequestSubMenu,
    requestGeneralSubMenu,
} = el.Request

const {
    supplyMenu,
    dashboardSubMenu,
    productSubMenu,
    serviceSubMenu,
    contractSubMenu,
} = el.Supply






describe('Testes da página Cadastro de Usuário', () => {


    beforeEach(function () {

        cy.login(dataParameters.env.EMAIL_ADMIN, dataParameters.env.PASSWORD_ADMIN, messageContainer);

        cy.getElementAndClick(registrationMenu);

    })






    // it(`Deve ser possível cadastrar em vários dispositivos.`, () => {
    //     sizes.forEach((size) => {
    //         if (Cypress._.isArray(size)) {
    //             cy.loginLogoutWithViewport(size, dadosAmbiente);

    //             // cy.getVisible(el.cadastroMenu)
    //             //     .click()
    //             cy.get(el.cadastroMenu, { timeout: 10000 })
    //                 .then((element) => {
    //                     if (Cypress.dom.isVisible(element)) {
    //                         cy.wrap(element)
    //                             .click();
    //                     } else {
    //                         cy.getVisible(el.menuReduzido)
    //                             .click()
    //                         cy.getVisible(el.cadastroMenuReduzido)
    //                             .scrollIntoView()
    //                             .click()
    //                     }
    //                 });
    //         }
    //     });
    // });



    // it('Deve ser possível navegar pelos breadcumbs.', () => {

    // })


    // it('Deve apresentar o nome do usuário cadastrado, em coluna usuário.', () => { })


    // it('Deve apresentar o e-mail do usuário cadastrado, em coluna usuário.', () => { })


    // it('Deve apresentar o perfil do usuário cadastrado, em coluna usuário.', () => { })


    // it('Deve ser possível usar a paginação para visualizar resultados.', () => { })


    // it('Deve ser possível selecionar a quantidade de resultados que são apresentados em tela.', () => { })


    // it('Deve buscar por usuários cadastrados usando o campo de pesquisa.', () => { })


    // it('Deve verificar os tipos de perfis disponíveis para cadastro.', () => { })


    // it('Deve verificar a quantidade mínima de caracteres aceitos no campo "Nome".', () => {
    //     // Campo deve aceitar minimo 2 caracteres, ex: "Eu"
    //     acessarCadastroUsuario()

    //     cy.getVisible(el.nomeUsuario)
    //         .type(letraUnica)
    //         .blur();

    //     cy.getVisible('.help-block.has-error')
    //         .should('contain', 'Valor inválido!');

    //     cy.getVisible(el.nomeUsuario)
    //         .clear()
    //         .type(nome)
    //         .blur();

    //     cy.get('#name-error')
    //         .should('have.class', 'help-block has-error valid');
    // })


    // it('Deve verificar a obrigatoriedade de preenchimento do campo "Nome".', () => {
    //     acessarCadastroUsuario()

    //     cy.verificarObrigatoriedadeCampo(el.nomeUsuario);

    // })


    // it('Deve verificar a obrigatoriedade de preenchimento do campo "Data de nascimento".', () => {
    //     acessarCadastroUsuario()

    //     cy.verificarObrigatoriedadeCampo(el.nomeUsuario);
    // })


    // it('Deve validar se o campo "Data de nascimento" aceita somente números.', () => {
    //     acessarCadastroUsuario()

    //     cy.getVisible(el.dataNascimentoUsuario)
    //         .should('have.attr', 'type', 'date');
    // })


    // it('Deve verificar a obrigatoriedade de preenchimento do campo "N° CPF/CNPJ".', () => {
    //     acessarCadastroUsuario()

    //     cy.verificarObrigatoriedadeCampo(el.cpfCnpjUsuario);
    // })


    // it('Deve verificar se o campo "N° CPF/CNPJ" está preenchido com um valor de CPF válido.', () => {
    //     acessarCadastroUsuario()

    //     cy.getVisible(el.cpfCnpjUsuario)
    //         .clear()
    //         .type(cpfAleatorio)
    //         .should('have.attr', 'aria-invalid', 'true');

    // })


    // it('Deve verificar se o campo "N° CPF/CNPJ" está preenchido com um valor de CNPJ válido.', () => {
    //     acessarCadastroUsuario()

    //     cy.getVisible(el.cpfCnpjUsuario)
    //         .clear()
    //         .type(cnpjAleatorio)
    //         .should('have.attr', 'aria-invalid', 'true');
    // })


    // it('Deve verificar a obrigatoriedade de preenchimento do campo "Telefone/Celular".', () => {
    //     acessarCadastroUsuario()

    //     cy.verificarObrigatoriedadeCampo(el.telefoneUsuario);
    // })


    // it('Deve verificar se o campo "Telefone/Celular" contém máscara de preenchimento.', () => {
    //     acessarCadastroUsuario()

    //     cy.getVisible(el.telefoneUsuario)
    //         .clear()
    //         .type(telefoneIncompleto)
    //         .should('have.attr', 'aria-invalid', 'true')
    //         .clear()
    //         .type(telefoneAleatorio)


    // })


    // it('Deve verificar se o campo "Telefone/Celular" tem validação para números iguais.', () => {
    //     acessarCadastroUsuario()

    //     cy.getVisible(el.telefoneUsuario)
    //         .clear()
    //         .type('11111111111')
    //         .should('have.value', '(11) 11111-1111')
    // })


    // it('Deve verificar se o campo "Telefone/Celular" tem validação para preenchimento com número "0".', () => {
    //     acessarCadastroUsuario()

    //     cy.getVisible(el.telefoneUsuario)
    //         .clear()
    //         .type('0000000000')
    //         .should('have.value', '(00) 0000-0000')
    // })


    // it('Deve verificar se o campo "Telefone/Celular" tem validação para preenchimento com número "9".', () => {
    //     acessarCadastroUsuario()

    //     cy.getVisible(el.telefoneUsuario)
    //         .clear()
    //         .type('99999999999')
    //         .should('have.value', '(99) 99999-9999')
    // })


    // it('Deve verificar a obrigatoriedade de preenchimento do campo "E-mail".', () => {
    //     acessarCadastroUsuario()

    //     cy.verificarObrigatoriedadeCampo(el.emailUsuario);
    // })


    // it('Deve verificar se há validação após o "@", no campo "E-mail".', () => {
    //     acessarCadastroUsuario()

    //     cy.get(el.emailUsuario)
    //         .type(email)
    //         .should('have.attr', 'aria-invalid', 'true');


    // })

    // it('Deve verificar a obrigatoriedade de preenchimento e tipo do campo "Senha".', () => {
    //     acessarCadastroUsuario()

    //     cy.verificarObrigatoriedadeCampo(el.senhaUsuario)

    //     cy.getVisible(el.senhaUsuario)
    //         .should('have.attr', 'type', 'password');
    // })


    // it('Deve verificar o tamanho mínimo do campo "Senha".', () => {
    //     acessarCadastroUsuario()

    //     cy.getVisible(el.senhaUsuario)
    //         .should('have.attr', 'data-rule-minlength')

    //     cy.getVisible(el.senhaUsuario)
    //         .invoke('attr', 'data-rule-minlength')
    //         .then((minlengthValue) => {
    //             cy.log(`Valor da propriedade data-rule-minlength: ${minlengthValue}`);
    //         });
    // })


    // it('Deve verificar o tamanho máximo do campo "Senha".', () => {
    //     acessarCadastroUsuario()

    //     cy.getVisible(el.senhaUsuario)
    //         .type(senhaGigante)
    // })


    // it('Deve verificar o tamanho mínimo do campo "Confirmar Senha".', () => {
    //     acessarCadastroUsuario()

    //     cy.getVisible(el.confirmarSenhaUsuario)
    //         .should('have.attr', 'data-rule-minlength')

    //     cy.getVisible(el.confirmarSenhaUsuario)
    //         .invoke('attr', 'data-rule-minlength')
    //         .then((minlengthValue) => {
    //             cy.log(`Valor da propriedade data-rule-minlength: ${minlengthValue}`);
    //         });
    // })


    // it('Deve verificar o tamanho máximo do campo "Confirmar Senha".', () => {
    //     acessarCadastroUsuario()

    //     cy.getVisible(el.confirmarSenhaUsuario)
    //         .type(senhaGigante)
    // })


    // it('Deve verificar se o conteúdo de "Senha" e "Confirmar Senha" é igual.', () => {
    //     acessarCadastroUsuario()

    //     cy.getVisible(el.senhaUsuario)
    //         .type(senhaGigante)
    //         .should('have.value', senhaGigante);

    //     cy.getVisible(el.confirmarSenhaUsuario)
    //         .type(senhaGigante)
    //         .should('have.value', senhaGigante);

    //     cy.getVisible(el.senhaUsuario)
    //         .invoke('val')
    //         .then((senhaDigitada) => {
    //             cy.getVisible(el.confirmarSenhaUsuario)
    //                 .invoke('val')
    //                 .should('eq', senhaDigitada);
    //         });
    // })


    // it('Deve verificar se o botão de opção está alinhado com a label de "Perfil de usuário".', () => {
    //     acessarCadastroUsuario()

    //     cy.get('.form-check')  // Seletor que captura o elemento pai das opções
    //         .each((formCheck, index) => {
    //             // Captura o input do rádio e a label da opção
    //             const inputRadio = cy.wrap(formCheck).find('.icheck-me');
    //             const labelOption = cy.wrap(formCheck).find('.form-check-label');

    //             // Obtém as coordenadas do input do rádio
    //             inputRadio.invoke('offset').then((radioOffset) => {
    //                 // Obtém as coordenadas da label da opção
    //                 labelOption.invoke('offset').then((labelOffset) => {
    //                     // Verifica se as coordenadas estão próximas, considerando uma tolerância
    //                     const tolerancia = 5; // Tolerância em pixels
    //                     expect(Math.abs(radioOffset.top - labelOffset.top)).to.be.lessThan(tolerancia);
    //                     expect(Math.abs(radioOffset.left - labelOffset.left)).to.be.lessThan(tolerancia);
    //                     expect(radioOffset.top).to.be.closeTo(labelOffset.top, tolerancia);
    //                 });
    //             });
    //         })
    // })

    // it('Deve verificar a obrigatoriedade de preenchimento do campo "Setor".', () => {
    //     acessarCadastroUsuario()

    //     cy.getVisible(el.setorUsuario)
    //         .click()

    //     cy.get(el.opcaoSetorUsuario)
    //         .eq(0)
    //         .invoke('attr', 'style', 'display: block')

    //     cy.get(el.opcaoSelectSetorUsuario)
    //         .invoke('removeAttr', 'style')
    //         .then(() => {
    //             cy.getVisible('#cost_center_id')
    //                 .should('have.attr', 'aria-required', 'true');
    //         });
    // })


    // it('Deve verificar a obrigatoriedade de preenchimento do campo "Limite de Aprovação".', () => {
    //     acessarCadastroUsuario()

    //     cy.verificarObrigatoriedadeCampo(el.limiteAprovacaoUsuario);
    // })


    // it('Deve verificar a possibilidade de inserção de letras no campo "Limite de Aprovação".', () => {
    //     acessarCadastroUsuario()

    //     cy.get(el.limiteAprovacaoUsuario)
    //         .type(nome)
    //         .should('have.value', '');

    // })


    // it('Deve verificar a possibilidade de inserção de valores negativos no campo "Limite de Aprovação".', () => {
    //     acessarCadastroUsuario()

    //     cy.get(el.limiteAprovacaoUsuario)
    //         .type('-')

    //     cy.get('#form-register > div.user-information > div:nth-child(4) > div.col-sm-2 > div')
    //         .should('have.class', 'form-group has-error');
    // })












    // it.only('Deve ser possível criar usuário de perfil "padrão", "Autorizado para solicitar".', () => {

    //     cy.inserirNome(el.nomeUsuario,nome)


    //     inserirDataNascimentoUsuario(el.dataNascimentoUsuario);


    //     cy.inserirCpf(el.cpfCnpjUsuario,cpfAleatorio)


    //     cy.inserirTelefone(el.telefoneUsuario,telefoneAleatorio)


    //     cy.inserirEmail(el.emailUsuario,emailCompleto)


    //     cy.inserirSenha(el.senhaUsuario,senha)


    //     cy.inserirSenha(el.confirmarSenhaUsuario,senha)


    //     cy.selecionarPerfil(Perfil.Administrador);


    //     cy.selecionarAutorizacaoParaSolicitar(OpcaoAutorizacao.Autorizado);


    //     cy.inserirSetorUsuario(el.setorUsuario,el.opcaoSetorUsuario,el.opcaoSelectSetorUsuario,el.opcaoSelecionadaSetorUsuario);


    //     cy.inserirUsuarioAprovador(el.usuarioAprovador,el.opcaoUsuarioAprovador);


    //     cy.inserirLimiteAprovacao('175',el.limiteAprovacaoUsuario)


    //     cy.inserirCentroCustoPermitido(el.selecionarTodosCentroCustoPermitidoUsuario)


    //     cy.getVisible(el.salvarCadastroUsuario)
    //         .click()


    // })

    // it('Deve ser possível criar usuário de perfil "Administrador", "Não Autorizado para solicitar".', () => { })


    // it('Deve ser possível criar usuário de perfil "Padrão", "Autorizado para solicitar".', () => { })

    // it('Deve ser possível criar usuário de perfil "Padrão", "Não Autorizado para solicitar".', () => { })

    // it('Deve ser possível criar usuário de perfil "Padrão", "Não Autorizado para solicitar" e "Sem limite de aprovação".', () => { })


    // it('Deve ser possível criar usuário de perfil "Suprimentos HKM", "Autorizado para solicitar".', () => { })

    // it('Deve ser possível criar usuário de perfil "Suprimentos HKM", "Não Autorizado para solicitar".', () => { })


    // it('Deve ser possível criar usuário de perfil "Suprimentos HKM", "Autorizado para solicitar".', () => { })

    // it('Deve ser possível criar usuário de perfil "Suprimentos HKM", "Não   Autorizado para solicitar".', () => { })

    // it('Deve ser possível criar usuário de perfil "Padrão" com senha maior que 255 caracteres.', () => { })

    // it('Deve retornar mensagem de erro ao tentar cadastrar usuário com e-mail já cadastrado.', () => { })

    // it('Deve retornar mensagem de erro ao tentar cadastrar usuário com Cpf já cadastrado.', () => { })

    // it('Deve retornar mensagem de erro ao tentar cadastrar usuário com Cnpj já cadastrado.', () => { })




})

