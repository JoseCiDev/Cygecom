/// <reference types="cypress" />
import * as faker from '@faker-js/faker';
import * as fakerBr from 'faker-br';
import { elements as el } from '../elements';
<<<<<<< HEAD
import { dadosParametros } from '../dadosParametros';
=======
import { dadosParametros } from '../dadosParametros'
>>>>>>> 7e26ae0ed00df99f6fe0236388fd5d6c2090292e


export const {
    perfilUsuario,
    inicioMenu,
    logoGecom,
    telaInicio,

} = el.Inicio;

export const {
    logout,
    opcoesMenu,
    menuReduzido,
    breadcumbHome,
    breadcumbUsuario,
    mostraQuantidadeRegistros,
    BuscaUsuarioCadastrado,
    proximaPagina,
<<<<<<< HEAD
    ,
=======
    paginaAnterior,
>>>>>>> 7e26ae0ed00df99f6fe0236388fd5d6c2090292e

} = el.Compartilhado;

export const {
    cadastroMenu,
    cadastroMenuReduzido,
    cadastroUsuarioSubMenu,
    cadastroFornecedorSubMenu,
    criaNovoUsuario,
    nomeUsuario,
    dataNascimentoUsuario,
    cpfCnpjUsuario,
    telefoneUsuario,
    emailUsuario,
    senhaUsuario,
    confirmarSenhaUsuario,
    setorUsuario,
    opcaoSetorUsuario,
    opcaoSelectSetorUsuario,
    opcaoSelecionadaSetorUsuario,
    usuarioAprovador,
    opcaoUsuarioAprovador,
    limiteAprovacaoUsuario,
    centroCustoPermitidoUsuario,
    selecionarTodosCentroCustoPermitidoUsuario,
    limparCentroCustoPermitidoUsuario,
    salvarCadastroUsuario,
    cancelarCadastroUsuario,
} = el.Cadastro;

export const {
    solicitacaoMenu,
    novaSolicitacaoSubMenu,
    minhaSolicitacaoSubMenu,
    solicitacaoGeralSubMenu,

} = el.Solicitacao;

export const {
    suprimentoMenu,
    dashboardSubMenu,
    produtoSubMenu,
    servicoSubMenu,
    contratoSubMenu,

} = el.Suprimento;


<<<<<<< HEAD
const acessarCadastroUsuario = () => {
    cy.acessarMenuCadastro(cadastroMenu);

    cy.acessarSubmenuCadastroUsuario(cadastroUsuarioSubMenu);

    cy.acessarCadastroUsuario(criaNovoUsuario);
}



const inserirDataNascimentoUsuario = async (element: string, dataAtual: Date = new Date()): Promise<void> => {
    cy.inserirData(dataAtual)
        .then(({ DATA_FORMATADA }: { DATA_FORMATADA: string }) => {
            const dataAtual = `${DATA_FORMATADA}`;

            cy.getVisible(element)
                .type(dataAtual.toString())
                .then(() => {
                    cy.getVisible(element)
                        .should('have.value', dataAtual);
                });
        })
}

describe('Testes da página Cadastro de Usuário', () => {
  
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


=======


describe('Testes da página Cadastro de Usuário', () => {
>>>>>>> 7e26ae0ed00df99f6fe0236388fd5d6c2090292e


    beforeEach(function () {

        cy.login(dadosParametros.env.EMAILGESTORUSUARIO, dadosParametros.env.SENHAGESTORUSUARIO);

<<<<<<< HEAD
        acessarCadastroUsuario()
=======
        cy.acessarCadastroUsuario();

>>>>>>> 7e26ae0ed00df99f6fe0236388fd5d6c2090292e
    })



<<<<<<< HEAD




=======
>>>>>>> 7e26ae0ed00df99f6fe0236388fd5d6c2090292e
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



<<<<<<< HEAD
    it('Deve ser possível navegar pelos breadcumbs.', () => {
=======
    it('Deve ser possível navegar pelo breadcumb Home.', () => {

        cy.getElementAndClick(breadcumbHome);

        cy.url()
            .should('contain', `${dadosParametros.env.BASEURL}`);
>>>>>>> 7e26ae0ed00df99f6fe0236388fd5d6c2090292e

    })


    it('Deve apresentar o nome do usuário cadastrado, em coluna usuário.', () => { })


    it('Deve apresentar o e-mail do usuário cadastrado, em coluna usuário.', () => { })


    it('Deve apresentar o perfil do usuário cadastrado, em coluna usuário.', () => { })


    it('Deve ser possível usar a paginação para visualizar resultados.', () => { })


    it('Deve ser possível selecionar a quantidade de resultados que são apresentados em tela.', () => { })


    it('Deve buscar por usuários cadastrados usando o campo de pesquisa.', () => { })


    it('Deve verificar os tipos de perfis disponíveis para cadastro.', () => { })


    it('Deve verificar a quantidade mínima de caracteres aceitos no campo "Nome".', () => {
        // Campo deve aceitar minimo 2 caracteres, ex: "Eu"
<<<<<<< HEAD
        acessarCadastroUsuario()

        cy.getVisible(nomeUsuario)
            .type(letraUnica)
=======
        cy.acessarCadastroUsuario();

        cy.getElementAndClick(criaNovoUsuario);

        cy.getVisible(nomeUsuario)
            .type(dadosParametros.Cadastro.letraUnica)
>>>>>>> 7e26ae0ed00df99f6fe0236388fd5d6c2090292e
            .blur();

        cy.getVisible('.help-block.has-error')
            .should('contain', 'Valor inválido!');

        cy.getVisible(nomeUsuario)
            .clear()
<<<<<<< HEAD
            .type(nome)
=======
            .type(dadosParametros.Cadastro.nome)
>>>>>>> 7e26ae0ed00df99f6fe0236388fd5d6c2090292e
            .blur();

        cy.get('#name-error')
            .should('have.class', 'help-block has-error valid');
<<<<<<< HEAD
    })


    it('Deve verificar a obrigatoriedade de preenchimento do campo "Nome".', () => {
        acessarCadastroUsuario()

        cy.verificarObrigatoriedadeCampo(nomeUsuario);

    })


    it('Deve verificar a obrigatoriedade de preenchimento do campo "Data de nascimento".', () => {
        acessarCadastroUsuario()

        cy.verificarObrigatoriedadeCampo(nomeUsuario);
    })


    it('Deve validar se o campo "Data de nascimento" aceita somente números.', () => {
        acessarCadastroUsuario()

        cy.getVisible(dataNascimentoUsuario)
            .should('have.attr', 'type', 'date');
    })


    it('Deve verificar a obrigatoriedade de preenchimento do campo "N° CPF/CNPJ".', () => {
        acessarCadastroUsuario()

        cy.verificarObrigatoriedadeCampo(cpfCnpjUsuario);
    })


    it('Deve verificar se o campo "N° CPF/CNPJ" está preenchido com um valor de CPF válido.', () => {
        acessarCadastroUsuario()

        cy.getVisible(cpfCnpjUsuario)
            .clear()
            .type(cpfAleatorio)
            .should('have.attr', 'aria-invalid', 'true');

    })


    it('Deve verificar se o campo "N° CPF/CNPJ" está preenchido com um valor de CNPJ válido.', () => {
        acessarCadastroUsuario()

        cy.getVisible(cpfCnpjUsuario)
            .clear()
            .type(cnpjAleatorio)
=======
    });


    it('Deve verificar a obrigatoriedade de preenchimento do campo "Nome".', () => {
        cy.acessarCadastroUsuario();

        cy.getElementAndClick(criaNovoUsuario);

        cy.verificarObrigatoriedadeCampo(nomeUsuario);

    });


    it('Deve validar se o campo "Data de nascimento" aceita somente números.', () => {
        cy.acessarCadastroUsuario();

        cy.getElementAndClick(criaNovoUsuario);

        cy.getVisible(dataNascimentoUsuario)
            .should('have.attr', 'type', 'date');
    });


    it('Deve verificar a obrigatoriedade de preenchimento do campo "N° CPF/CNPJ".', () => {
        cy.acessarCadastroUsuario();

        cy.getElementAndClick(criaNovoUsuario);

        cy.verificarObrigatoriedadeCampo(cpfCnpjUsuario);
    });


    it.only('Deve verificar se o campo "N° CPF/CNPJ" está preenchido com um valor de CPF válido.', () => {
        cy.acessarCadastroUsuario();

        cy.getElementAndClick(criaNovoUsuario);

        cy.getVisible(cpfCnpjUsuario)
            .clear()
            .type(dadosParametros.Cadastro.cpf)
            .should('have.attr', 'aria-invalid', 'true');

    }); 


    it('Deve verificar se o campo "N° CPF/CNPJ" está preenchido com um valor de CNPJ válido.', () => {
        cy.acessarCadastroUsuario()

        cy.getVisible(cpfCnpjUsuario)
            .clear()
            .type(dadosParametros.Cadastro.cnpj)
>>>>>>> 7e26ae0ed00df99f6fe0236388fd5d6c2090292e
            .should('have.attr', 'aria-invalid', 'true');
    })


    it('Deve verificar a obrigatoriedade de preenchimento do campo "Telefone/Celular".', () => {
<<<<<<< HEAD
        acessarCadastroUsuario()
=======
        cy.acessarCadastroUsuario()
>>>>>>> 7e26ae0ed00df99f6fe0236388fd5d6c2090292e

        cy.verificarObrigatoriedadeCampo(telefoneUsuario);
    })


    it('Deve verificar se o campo "Telefone/Celular" contém máscara de preenchimento.', () => {
<<<<<<< HEAD
        acessarCadastroUsuario()

        cy.getVisible(telefoneUsuario)
            .clear()
            .type(telefoneIncompleto)
            .should('have.attr', 'aria-invalid', 'true')
            .clear()
            .type(telefoneAleatorio)
=======
        cy.acessarCadastroUsuario()

        cy.getVisible(telefoneUsuario)
            .clear()
            .type(dadosParametros.Cadastro.telefone.slice(0, -3))
            .should('have.attr', 'aria-invalid', 'true')
            .clear()
            .type(dadosParametros.Cadastro.telefone)
>>>>>>> 7e26ae0ed00df99f6fe0236388fd5d6c2090292e


    })


    it('Deve verificar se o campo "Telefone/Celular" tem validação para números iguais.', () => {
<<<<<<< HEAD
        acessarCadastroUsuario()
=======
        cy.acessarCadastroUsuario()
>>>>>>> 7e26ae0ed00df99f6fe0236388fd5d6c2090292e

        cy.getVisible(telefoneUsuario)
            .clear()
            .type('11111111111')
            .should('have.value', '(11) 11111-1111')
    })


    it('Deve verificar se o campo "Telefone/Celular" tem validação para preenchimento com número "0".', () => {
<<<<<<< HEAD
        acessarCadastroUsuario()
=======
        cy.acessarCadastroUsuario()
>>>>>>> 7e26ae0ed00df99f6fe0236388fd5d6c2090292e

        cy.getVisible(telefoneUsuario)
            .clear()
            .type('0000000000')
            .should('have.value', '(00) 0000-0000')
    })


    it('Deve verificar se o campo "Telefone/Celular" tem validação para preenchimento com número "9".', () => {
<<<<<<< HEAD
        acessarCadastroUsuario()
=======
        cy.acessarCadastroUsuario()
>>>>>>> 7e26ae0ed00df99f6fe0236388fd5d6c2090292e

        cy.getVisible(telefoneUsuario)
            .clear()
            .type('99999999999')
            .should('have.value', '(99) 99999-9999')
    })


    it('Deve verificar a obrigatoriedade de preenchimento do campo "E-mail".', () => {
<<<<<<< HEAD
        acessarCadastroUsuario()
=======
        cy.acessarCadastroUsuario()
>>>>>>> 7e26ae0ed00df99f6fe0236388fd5d6c2090292e

        cy.verificarObrigatoriedadeCampo(emailUsuario);
    })


    it('Deve verificar se há validação após o "@", no campo "E-mail".', () => {
<<<<<<< HEAD
        acessarCadastroUsuario()

        cy.get(emailUsuario)
            .type(email)
=======
        cy.acessarCadastroUsuario()

        cy.get(emailUsuario)
            .type(dadosParametros.Autenticacao.email)
>>>>>>> 7e26ae0ed00df99f6fe0236388fd5d6c2090292e
            .should('have.attr', 'aria-invalid', 'true');


    })

    it('Deve verificar a obrigatoriedade de preenchimento e tipo do campo "Senha".', () => {
<<<<<<< HEAD
        acessarCadastroUsuario()
=======
        cy.acessarCadastroUsuario()
>>>>>>> 7e26ae0ed00df99f6fe0236388fd5d6c2090292e

        cy.verificarObrigatoriedadeCampo(senhaUsuario)

        cy.getVisible(senhaUsuario)
            .should('have.attr', 'type', 'password');
    })


    it('Deve verificar o tamanho mínimo do campo "Senha".', () => {
<<<<<<< HEAD
        acessarCadastroUsuario()
=======
        cy.acessarCadastroUsuario()
>>>>>>> 7e26ae0ed00df99f6fe0236388fd5d6c2090292e

        cy.getVisible(senhaUsuario)
            .should('have.attr', 'data-rule-minlength')

        cy.getVisible(senhaUsuario)
            .invoke('attr', 'data-rule-minlength')
            .then((minlengthValue) => {
                cy.log(`Valor da propriedade data-rule-minlength: ${minlengthValue}`);
            });
    })


    it('Deve verificar o tamanho máximo do campo "Senha".', () => {
<<<<<<< HEAD
        acessarCadastroUsuario()

        cy.getVisible(senhaUsuario)
            .type(senhaGigante)
=======
        cy.acessarCadastroUsuario()

        cy.getVisible(senhaUsuario)
            .type(dadosParametros.Autenticacao.senhaGigante)
>>>>>>> 7e26ae0ed00df99f6fe0236388fd5d6c2090292e
    })


    it('Deve verificar o tamanho mínimo do campo "Confirmar Senha".', () => {
<<<<<<< HEAD
        acessarCadastroUsuario()
=======
        cy.acessarCadastroUsuario()
>>>>>>> 7e26ae0ed00df99f6fe0236388fd5d6c2090292e

        cy.getVisible(confirmarSenhaUsuario)
            .should('have.attr', 'data-rule-minlength')

        cy.getVisible(confirmarSenhaUsuario)
            .invoke('attr', 'data-rule-minlength')
            .then((minlengthValue) => {
                cy.log(`Valor da propriedade data-rule-minlength: ${minlengthValue}`);
            });
    })


    it('Deve verificar o tamanho máximo do campo "Confirmar Senha".', () => {
<<<<<<< HEAD
        acessarCadastroUsuario()

        cy.getVisible(confirmarSenhaUsuario)
            .type(senhaGigante)
=======
        cy.acessarCadastroUsuario()

        cy.getVisible(confirmarSenhaUsuario)
            .type(dadosParametros.Autenticacao.senhaGigante)
>>>>>>> 7e26ae0ed00df99f6fe0236388fd5d6c2090292e
    })


    it('Deve verificar se o conteúdo de "Senha" e "Confirmar Senha" é igual.', () => {
<<<<<<< HEAD
        acessarCadastroUsuario()

        cy.getVisible(senhaUsuario)
            .type(senhaGigante)
            .should('have.value', senhaGigante);

        cy.getVisible(confirmarSenhaUsuario)
            .type(senhaGigante)
            .should('have.value', senhaGigante);
=======
        cy.acessarCadastroUsuario()

        cy.getVisible(senhaUsuario)
            .type(dadosParametros.Autenticacao.senhaGigante)
            .should('have.value', dadosParametros.Autenticacao.senhaGigante);

        cy.getVisible(confirmarSenhaUsuario)
            .type(dadosParametros.Autenticacao.senhaGigante)
            .should('have.value', dadosParametros.Autenticacao.senhaGigante);
>>>>>>> 7e26ae0ed00df99f6fe0236388fd5d6c2090292e

        cy.getVisible(senhaUsuario)
            .invoke('val')
            .then((senhaDigitada) => {
                cy.getVisible(confirmarSenhaUsuario)
                    .invoke('val')
                    .should('eq', senhaDigitada);
            });
    })


    it('Deve verificar se o botão de opção está alinhado com a label de "Perfil de usuário".', () => {
<<<<<<< HEAD
        acessarCadastroUsuario()
=======
        cy.acessarCadastroUsuario()
>>>>>>> 7e26ae0ed00df99f6fe0236388fd5d6c2090292e

        cy.get('.form-check')  // Seletor que captura o elemento pai das opções
            .each((formCheck, index) => {
                // Captura o input do rádio e a label da opção
                const inputRadio = cy.wrap(formCheck).find('.icheck-me');
                const labelOption = cy.wrap(formCheck).find('.form-check-label');

                // Obtém as coordenadas do input do rádio
                inputRadio.invoke('offset').then((radioOffset) => {
                    // Obtém as coordenadas da label da opção
                    labelOption.invoke('offset').then((labelOffset) => {
                        // Verifica se as coordenadas estão próximas, considerando uma tolerância
                        const tolerancia = 5; // Tolerância em pixels
                        expect(Math.abs(radioOffset.top - labelOffset.top)).to.be.lessThan(tolerancia);
                        expect(Math.abs(radioOffset.left - labelOffset.left)).to.be.lessThan(tolerancia);
                        expect(radioOffset.top).to.be.closeTo(labelOffset.top, tolerancia);
                    });
                });
            })
    })

    it('Deve verificar a obrigatoriedade de preenchimento do campo "Setor".', () => {
<<<<<<< HEAD
        acessarCadastroUsuario()
=======
        cy.acessarCadastroUsuario()
>>>>>>> 7e26ae0ed00df99f6fe0236388fd5d6c2090292e

        cy.getVisible(setorUsuario)
            .click()

        cy.get(opcaoSetorUsuario)
            .eq(0)
            .invoke('attr', 'style', 'display: block')

        cy.get(opcaoSelectSetorUsuario)
            .invoke('removeAttr', 'style')
            .then(() => {
                cy.getVisible('#cost_center_id')
                    .should('have.attr', 'aria-required', 'true');
            });
    })


    it('Deve verificar a obrigatoriedade de preenchimento do campo "Limite de Aprovação".', () => {
<<<<<<< HEAD
        acessarCadastroUsuario()
=======
        cy.acessarCadastroUsuario()
>>>>>>> 7e26ae0ed00df99f6fe0236388fd5d6c2090292e

        cy.verificarObrigatoriedadeCampo(limiteAprovacaoUsuario);
    })


    it('Deve verificar a possibilidade de inserção de letras no campo "Limite de Aprovação".', () => {
<<<<<<< HEAD
        acessarCadastroUsuario()

        cy.get(limiteAprovacaoUsuario)
            .type(nome)
=======
        cy.acessarCadastroUsuario()

        cy.get(limiteAprovacaoUsuario)
            .type(dadosParametros.Cadastro.nome)
>>>>>>> 7e26ae0ed00df99f6fe0236388fd5d6c2090292e
            .should('have.value', '');

    })


    it('Deve verificar a possibilidade de inserção de valores negativos no campo "Limite de Aprovação".', () => {
<<<<<<< HEAD
        acessarCadastroUsuario()
=======
        cy.acessarCadastroUsuario()
>>>>>>> 7e26ae0ed00df99f6fe0236388fd5d6c2090292e

        cy.get(limiteAprovacaoUsuario)
            .type('-')

        cy.get('#form-register > div.user-information > div:nth-child(4) > div.col-sm-2 > div')
            .should('have.class', 'form-group has-error');
    })












<<<<<<< HEAD
    it.only('Deve ser possível criar usuário de perfil "padrão", "Autorizado para solicitar".', () => {
        
        cy.inserirNome(nomeUsuario,nome)

        
        inserirDataNascimentoUsuario(dataNascimentoUsuario);

       
        cy.inserirCpf(cpfCnpjUsuario,cpfAleatorio)

        
        cy.inserirTelefone(telefoneUsuario,telefoneAleatorio)

        
        cy.inserirEmail(emailUsuario,emailCompleto)


        cy.inserirSenha(senhaUsuario,senha)

        
        cy.inserirSenha(confirmarSenhaUsuario,senha)
=======
    it('Deve ser possível criar usuário de perfil "padrão", "Autorizado para solicitar".', () => {

        cy.inserirNome(nomeUsuario, dadosParametros.Cadastro.nome)


        cy.inserirDataNascimento(dataNascimentoUsuario);


        cy.inserirCpf(cpfCnpjUsuario, dadosParametros.Cadastro.cpf)


        cy.inserirTelefone(telefoneUsuario, dadosParametros.Cadastro.telefone)


        cy.inserirEmail(emailUsuario, dadosParametros.Autenticacao.email)


        cy.inserirSenha(senhaUsuario, dadosParametros.Autenticacao.senha)


        cy.inserirSenha(confirmarSenhaUsuario, dadosParametros.Autenticacao.senha)
>>>>>>> 7e26ae0ed00df99f6fe0236388fd5d6c2090292e


        cy.selecionarPerfil(dadosParametros.enums.Perfil.Administrador);


        cy.selecionarAutorizacaoParaSolicitar(dadosParametros.enums.OpcaoAutorizacao.Autorizado);


<<<<<<< HEAD
        cy.inserirSetorUsuario(setorUsuario,opcaoSetorUsuario,opcaoSelectSetorUsuario,opcaoSelecionadaSetorUsuario);


        cy.inserirUsuarioAprovador(usuarioAprovador,opcaoUsuarioAprovador);


        cy.inserirLimiteAprovacao('175',limiteAprovacaoUsuario)
=======
        cy.inserirSetorUsuario(setorUsuario, opcaoSetorUsuario, opcaoSelectSetorUsuario, opcaoSelecionadaSetorUsuario);


        cy.inserirUsuarioAprovador(usuarioAprovador, opcaoUsuarioAprovador);


        cy.inserirLimiteAprovacao('175', limiteAprovacaoUsuario)
>>>>>>> 7e26ae0ed00df99f6fe0236388fd5d6c2090292e


        cy.inserirCentroCustoPermitido(selecionarTodosCentroCustoPermitidoUsuario)


        cy.getVisible(salvarCadastroUsuario)
            .click()
<<<<<<< HEAD


=======
>>>>>>> 7e26ae0ed00df99f6fe0236388fd5d6c2090292e
    })

    it('Deve ser possível criar usuário de perfil "Administrador", "Não Autorizado para solicitar".', () => { })


    it('Deve ser possível criar usuário de perfil "Padrão", "Autorizado para solicitar".', () => { })

    it('Deve ser possível criar usuário de perfil "Padrão", "Não Autorizado para solicitar".', () => { })

    it('Deve ser possível criar usuário de perfil "Padrão", "Não Autorizado para solicitar" e "Sem limite de aprovação".', () => { })


    it('Deve ser possível criar usuário de perfil "Suprimentos HKM", "Autorizado para solicitar".', () => { })

    it('Deve ser possível criar usuário de perfil "Suprimentos HKM", "Não Autorizado para solicitar".', () => { })


    it('Deve ser possível criar usuário de perfil "Suprimentos HKM", "Autorizado para solicitar".', () => { })

    it('Deve ser possível criar usuário de perfil "Suprimentos HKM", "Não   Autorizado para solicitar".', () => { })

    it('Deve ser possível criar usuário de perfil "Padrão" com senha maior que 255 caracteres.', () => { })

    it('Deve retornar mensagem de erro ao tentar cadastrar usuário com e-mail já cadastrado.', () => { })

    it('Deve retornar mensagem de erro ao tentar cadastrar usuário com Cpf já cadastrado.', () => { })

    it('Deve retornar mensagem de erro ao tentar cadastrar usuário com Cnpj já cadastrado.', () => { })


})