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
    messageContainerIncorrectData,
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

        cy.login(dataParameters.env.EMAIL_ADMIN, dataParameters.env.PASSWORD_ADMIN, messageContainerIncorrectData);

        cy.getElementAndClick(registrationMenu);

    })



    // it(`Deve ser possível cadastrar em vários dispositivos.`, () => {
    //     sizes.forEach((size) => {
    //         if (Cypress._.isArray(size)) {
    //             cy.loginLogoutWithViewport(size, dadosAmbiente);

    //             // cy.getVisible(cadastroMenu)
    //             //     .click()
    //             cy.get(cadastroMenu, { timeout: 10000 })
    //                 .then((element) => {
    //                     if (Cypress.dom.isVisible(element)) {
    //                         cy.wrap(element)
    //                             .click();
    //                     } else {
    //                         cy.getVisible(menuReduzido)
    //                             .click()
    //                         cy.getVisible(cadastroMenuReduzido)
    //                             .scrollIntoView()
    //                             .click()
    //                     }
    //                 });
    //         }
    //     });
    // });



    // it('Deve ser possível navegar pelo breadcumb Home.', () => {

    //     cy.getElementAndClick(breadcumbHome);

    //     cy.url()
    //         .should('contain', `${dadosParametros.env.BASEURL}`);

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
    //     cy.acessarCadastroUsuario();

    //     cy.getElementAndClick(criaNovoUsuario);

    //     cy.quantidadeMinimaCaracteres(nomeUsuario, 'x', 2, mensagemObrigatoriedadeCpfCnpj).then((result) => {

    //         assert.exists(result.success, result.error)// se não existe

    //     });

    // });


    // it('Deve verificar a obrigatoriedade de preenchimento do campo "Nome".', () => {
    //     cy.acessarCadastroUsuario();

    //     cy.getElementAndClick(criaNovoUsuario);

    //     cy.verificarObrigatoriedadeCampo(cpfCnpjUsuario, '', mensagemObrigatoriedadeCpfCnpj).then((result) => {

    //         assert.exists(result.success, result.error)// se não existe

    //     });

    // });


    // it('Deve validar se o campo "Data de nascimento" aceita somente números.', () => {
    //     cy.acessarCadastroUsuario();

    //     cy.getElementAndClick(criaNovoUsuario);

    //     cy.getVisible(dataNascimentoUsuario)
    //         .should('have.attr', 'type', 'date');
    // });


    // it('Deve verificar a obrigatoriedade de preenchimento do campo "N° CPF/CNPJ".', () => {
    //     cy.acessarCadastroUsuario();
    //     cy.getElementAndClick(criaNovoUsuario);

    //     cy.verificarObrigatoriedadeCampo(cpfCnpjUsuario, '', mensagemObrigatoriedadeCpfCnpj).then((result) => {

    //         assert.exists(result.success, result.error)// se não existe

    //     });
    // });


    // it('Deve verificar se o campo "N° CPF/CNPJ" está preenchido com um valor de CPF válido.', () => {
    //     cy.acessarCadastroUsuario();
    //     cy.getElementAndClick(criaNovoUsuario);

    //     cy.verificarObrigatoriedadeCampo(cpfCnpjUsuario, 'x', mensagemObrigatoriedadeCpfCnpj).then((result) => {

    //         assert.exists(result.success, result.error)// se não existe

    //     });

    //     cy.getElementAndType(cpfCnpjUsuario, dadosParametros.cadastroParams.cpf.toString());
    //     // Validar CNPJ e usar o erro ou sucesso resultante

    //     cy.validarCpfCnpj(cpfCnpjUsuario, dadosParametros.cadastroParams.cpf.toString(), mensagemObrigatoriedadeCpfCnpj).then((result) => {

    //         assert.exists(result.success, result.error)// se não existe

    //     });

    // })



    // it.only('Deve verificar se o campo "N° CPF/CNPJ" está preenchido com um valor de CNPJ válido.', () => {
    //     cy.acessarCadastroUsuario();

    //     cy.getElementAndClick(criaNovoUsuario);

    //     //dadosParametros.cadastroParams.cnpj.toString()

    //     // Validar CNPJ e usar o erro ou sucesso resultante
    //     cy.validarCpfCnpj(cpfCnpjUsuario, '123456789', mensagemObrigatoriedadeCpfCnpj).then((result) => {

    //         assert.exists(result.success, result.error)// se não existe

    //     });

    // })


    // it('Deve verificar a obrigatoriedade de preenchimento do campo "Telefone/Celular".', () => {
    //     cy.acessarCadastroUsuario();

    //     cy.getElementAndClick(criaNovoUsuario);

    //     cy.verificarObrigatoriedadeCampo(nomeUsuario, 'x', mensagemObrigatoriedadeCpfCnpj).then((result) => {

    //         assert.exists(result.success, result.error)// se não existe

    //     });
    // })


    // it('Deve verificar se o campo "Telefone/Celular" contém máscara de preenchimento.', () => {
    //     cy.acessarCadastroUsuario();

    //     cy.getElementAndClick(criaNovoUsuario);

    //     cy.getVisible(telefoneUsuario)
    //         .clear()
    //         .type(dadosParametros.Cadastro.telefone.slice(0, -3))
    //         .should('have.attr', 'aria-invalid', 'true')
    //         .clear()
    //         .type(dadosParametros.Cadastro.telefone)


    // })


    // it('Deve verificar se o campo "Telefone/Celular" tem validação para números iguais.', () => {
    //     cy.acessarCadastroUsuario()

    //     cy.getVisible(telefoneUsuario)
    //         .clear()
    //         .type('11111111111')
    //         .should('have.value', '(11) 11111-1111')
    // })


    // it('Deve verificar se o campo "Telefone/Celular" tem validação para preenchimento com número "0".', () => {
    //     cy.acessarCadastroUsuario()

    //     cy.getVisible(telefoneUsuario)
    //         .clear()
    //         .type('0000000000')
    //         .should('have.value', '(00) 0000-0000')
    // })


    // it('Deve verificar se o campo "Telefone/Celular" tem validação para preenchimento com número "9".', () => {
    //     cy.acessarCadastroUsuario()

    //     cy.getVisible(telefoneUsuario)
    //         .clear()
    //         .type('99999999999')
    //         .should('have.value', '(99) 99999-9999')
    // })


    // it('Deve verificar a obrigatoriedade de preenchimento do campo "E-mail".', () => {
    //     cy.acessarCadastroUsuario()

    //     cy.verificarObrigatoriedadeCampo(nomeUsuario, 'x', mensagemObrigatoriedadeCpfCnpj).then((result) => {

    //         assert.exists(result.success, result.error)// se não existe

    //     });
    // })


    // it('Deve verificar se há validação após o "@", no campo "E-mail".', () => {
    //     cy.acessarCadastroUsuario()

    //     cy.get(emailUsuario)
    //         .type(dadosParametros.Autenticacao.email)
    //         .should('have.attr', 'aria-invalid', 'true');


    // })

    // it('Deve verificar a obrigatoriedade de preenchimento e tipo do campo "Senha".', () => {
    //     cy.acessarCadastroUsuario()

    //     cy.verificarObrigatoriedadeCampo(nomeUsuario, 'x', mensagemObrigatoriedadeCpfCnpj).then((result) => {

    //         assert.exists(result.success, result.error)// se não existe

    //     });

    //     cy.getVisible(senhaUsuario)
    //         .should('have.attr', 'type', 'password');
    // })


    // it('Deve verificar o tamanho mínimo do campo "Senha".', () => {
    //     cy.acessarCadastroUsuario()

    //     cy.getVisible(senhaUsuario)
    //         .should('have.attr', 'data-rule-minlength')

    //     cy.getVisible(senhaUsuario)
    //         .invoke('attr', 'data-rule-minlength')
    //         .then((minlengthValue) => {
    //             cy.log(`Valor da propriedade data-rule-minlength: ${minlengthValue}`);
    //         });
    // })


    // it('Deve verificar o tamanho máximo do campo "Senha".', () => {
    //     cy.acessarCadastroUsuario()

    //     cy.getVisible(senhaUsuario)
    //         .type(dadosParametros.Autenticacao.senhaGigante)
    // })


    // it('Deve verificar o tamanho mínimo do campo "Confirmar Senha".', () => {
    //     cy.acessarCadastroUsuario()

    //     cy.getVisible(confirmarSenhaUsuario)
    //         .should('have.attr', 'data-rule-minlength')

    //     cy.getVisible(confirmarSenhaUsuario)
    //         .invoke('attr', 'data-rule-minlength')
    //         .then((minlengthValue) => {
    //             cy.log(`Valor da propriedade data-rule-minlength: ${minlengthValue}`);
    //         });
    // })


    // it('Deve verificar o tamanho máximo do campo "Confirmar Senha".', () => {
    //     cy.acessarCadastroUsuario()

    //     cy.getVisible(confirmarSenhaUsuario)
    //         .type(dadosParametros.Autenticacao.senhaGigante)
    // })


    // it('Deve verificar se o conteúdo de "Senha" e "Confirmar Senha" é igual.', () => {
    //     cy.acessarCadastroUsuario()

    //     cy.getVisible(senhaUsuario)
    //         .type(dadosParametros.Autenticacao.senhaGigante)
    //         .should('have.value', dadosParametros.Autenticacao.senhaGigante);

    //     cy.getVisible(confirmarSenhaUsuario)
    //         .type(dadosParametros.Autenticacao.senhaGigante)
    //         .should('have.value', dadosParametros.Autenticacao.senhaGigante);

    //     cy.getVisible(senhaUsuario)
    //         .invoke('val')
    //         .then((senhaDigitada) => {
    //             cy.getVisible(confirmarSenhaUsuario)
    //                 .invoke('val')
    //                 .should('eq', senhaDigitada);
    //         });
    // })


    // it('Deve verificar se o botão de opção está alinhado com a label de "Perfil de usuário".', () => {
    //     cy.acessarCadastroUsuario()

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
    //     cy.acessarCadastroUsuario()

    //     cy.getVisible(setorUsuario)
    //         .click()

    //     cy.get(opcaoSetorUsuario)
    //         .eq(0)
    //         .invoke('attr', 'style', 'display: block')

    //     cy.get(opcaoSelectSetorUsuario)
    //         .invoke('removeAttr', 'style')
    //         .then(() => {
    //             cy.getVisible('#cost_center_id')
    //                 .should('have.attr', 'aria-required', 'true');
    //         });
    // })


    // it('Deve verificar a obrigatoriedade de preenchimento do campo "Limite de Aprovação".', () => {
    //     cy.acessarCadastroUsuario()

    //     cy.verificarObrigatoriedadeCampo(nomeUsuario, 'x', mensagemObrigatoriedadeCpfCnpj).then((result) => {

    //         assert.exists(result.success, result.error)// se não existe

    //     });
    // })


    // it('Deve verificar a possibilidade de inserção de letras no campo "Limite de Aprovação".', () => {
    //     cy.acessarCadastroUsuario()

    //     cy.get(limiteAprovacaoUsuario)
    //         .type(dadosParametros.Cadastro.nome)
    //         .should('have.value', '');

    // })


    // it('Deve verificar a possibilidade de inserção de valores negativos no campo "Limite de Aprovação".', () => {
    //     cy.acessarCadastroUsuario()

    //     cy.get(limiteAprovacaoUsuario)
    //         .type('-')

    //     cy.get('#form-register > div.user-information > div:nth-child(4) > div.col-sm-2 > div')
    //         .should('have.class', 'form-group has-error');
    // })












    // it('Deve ser possível criar usuário de perfil "padrão", "Autorizado para solicitar".', () => {

    //     cy.inserirNome(nomeUsuario, dadosParametros.Cadastro.nome)


    //     cy.inserirDataNascimento(dataNascimentoUsuario);


    //     cy.inserirCpf(cpfCnpjUsuario, dadosParametros.Cadastro.cpf)


    //     cy.inserirTelefone(telefoneUsuario, dadosParametros.Cadastro.telefone)


    //     cy.inserirEmail(emailUsuario, dadosParametros.Autenticacao.email)


    //     cy.inserirSenha(senhaUsuario, dadosParametros.Autenticacao.senha)


    //     cy.inserirSenha(confirmarSenhaUsuario, dadosParametros.Autenticacao.senha)


    //     cy.selecionarPerfil(dadosParametros.cadastroParams.perfilUsuario);


    //     cy.selecionarAutorizacaoParaSolicitar(dadosParametros.cadastroParams.autorizacaoSolicitar);


    //     cy.inserirSetorUsuario(setorUsuario, opcaoSetorUsuario, opcaoSelectSetorUsuario, opcaoSelecionadaSetorUsuario);


    //     cy.inserirUsuarioAprovador(usuarioAprovador, opcaoUsuarioAprovador);


    //     cy.inserirLimiteAprovacao('175', limiteAprovacaoUsuario)


    //     cy.inserirCentroCustoPermitido(selecionarTodosCentroCustoPermitidoUsuario)


    //     cy.getVisible(salvarCadastroUsuario)
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

