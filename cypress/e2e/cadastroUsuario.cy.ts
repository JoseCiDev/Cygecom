/// <reference types="cypress" />
import * as faker from '@faker-js/faker';
import * as fakerBr from 'faker-br';
import { elements as el } from '../elements';
import { dadosParametros } from '../dadosParametros';


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
    ,

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




    beforeEach(function () {

        cy.login(dadosParametros.env.EMAILGESTORUSUARIO, dadosParametros.env.SENHAGESTORUSUARIO);

        acessarCadastroUsuario()
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



    it('Deve ser possível navegar pelos breadcumbs.', () => {

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
        acessarCadastroUsuario()

        cy.getVisible(nomeUsuario)
            .type(letraUnica)
            .blur();

        cy.getVisible('.help-block.has-error')
            .should('contain', 'Valor inválido!');

        cy.getVisible(nomeUsuario)
            .clear()
            .type(nome)
            .blur();

        cy.get('#name-error')
            .should('have.class', 'help-block has-error valid');
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
            .should('have.attr', 'aria-invalid', 'true');
    })


    it('Deve verificar a obrigatoriedade de preenchimento do campo "Telefone/Celular".', () => {
        acessarCadastroUsuario()

        cy.verificarObrigatoriedadeCampo(telefoneUsuario);
    })


    it('Deve verificar se o campo "Telefone/Celular" contém máscara de preenchimento.', () => {
        acessarCadastroUsuario()

        cy.getVisible(telefoneUsuario)
            .clear()
            .type(telefoneIncompleto)
            .should('have.attr', 'aria-invalid', 'true')
            .clear()
            .type(telefoneAleatorio)


    })


    it('Deve verificar se o campo "Telefone/Celular" tem validação para números iguais.', () => {
        acessarCadastroUsuario()

        cy.getVisible(telefoneUsuario)
            .clear()
            .type('11111111111')
            .should('have.value', '(11) 11111-1111')
    })


    it('Deve verificar se o campo "Telefone/Celular" tem validação para preenchimento com número "0".', () => {
        acessarCadastroUsuario()

        cy.getVisible(telefoneUsuario)
            .clear()
            .type('0000000000')
            .should('have.value', '(00) 0000-0000')
    })


    it('Deve verificar se o campo "Telefone/Celular" tem validação para preenchimento com número "9".', () => {
        acessarCadastroUsuario()

        cy.getVisible(telefoneUsuario)
            .clear()
            .type('99999999999')
            .should('have.value', '(99) 99999-9999')
    })


    it('Deve verificar a obrigatoriedade de preenchimento do campo "E-mail".', () => {
        acessarCadastroUsuario()

        cy.verificarObrigatoriedadeCampo(emailUsuario);
    })


    it('Deve verificar se há validação após o "@", no campo "E-mail".', () => {
        acessarCadastroUsuario()

        cy.get(emailUsuario)
            .type(email)
            .should('have.attr', 'aria-invalid', 'true');


    })

    it('Deve verificar a obrigatoriedade de preenchimento e tipo do campo "Senha".', () => {
        acessarCadastroUsuario()

        cy.verificarObrigatoriedadeCampo(senhaUsuario)

        cy.getVisible(senhaUsuario)
            .should('have.attr', 'type', 'password');
    })


    it('Deve verificar o tamanho mínimo do campo "Senha".', () => {
        acessarCadastroUsuario()

        cy.getVisible(senhaUsuario)
            .should('have.attr', 'data-rule-minlength')

        cy.getVisible(senhaUsuario)
            .invoke('attr', 'data-rule-minlength')
            .then((minlengthValue) => {
                cy.log(`Valor da propriedade data-rule-minlength: ${minlengthValue}`);
            });
    })


    it('Deve verificar o tamanho máximo do campo "Senha".', () => {
        acessarCadastroUsuario()

        cy.getVisible(senhaUsuario)
            .type(senhaGigante)
    })


    it('Deve verificar o tamanho mínimo do campo "Confirmar Senha".', () => {
        acessarCadastroUsuario()

        cy.getVisible(confirmarSenhaUsuario)
            .should('have.attr', 'data-rule-minlength')

        cy.getVisible(confirmarSenhaUsuario)
            .invoke('attr', 'data-rule-minlength')
            .then((minlengthValue) => {
                cy.log(`Valor da propriedade data-rule-minlength: ${minlengthValue}`);
            });
    })


    it('Deve verificar o tamanho máximo do campo "Confirmar Senha".', () => {
        acessarCadastroUsuario()

        cy.getVisible(confirmarSenhaUsuario)
            .type(senhaGigante)
    })


    it('Deve verificar se o conteúdo de "Senha" e "Confirmar Senha" é igual.', () => {
        acessarCadastroUsuario()

        cy.getVisible(senhaUsuario)
            .type(senhaGigante)
            .should('have.value', senhaGigante);

        cy.getVisible(confirmarSenhaUsuario)
            .type(senhaGigante)
            .should('have.value', senhaGigante);

        cy.getVisible(senhaUsuario)
            .invoke('val')
            .then((senhaDigitada) => {
                cy.getVisible(confirmarSenhaUsuario)
                    .invoke('val')
                    .should('eq', senhaDigitada);
            });
    })


    it('Deve verificar se o botão de opção está alinhado com a label de "Perfil de usuário".', () => {
        acessarCadastroUsuario()

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
        acessarCadastroUsuario()

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
        acessarCadastroUsuario()

        cy.verificarObrigatoriedadeCampo(limiteAprovacaoUsuario);
    })


    it('Deve verificar a possibilidade de inserção de letras no campo "Limite de Aprovação".', () => {
        acessarCadastroUsuario()

        cy.get(limiteAprovacaoUsuario)
            .type(nome)
            .should('have.value', '');

    })


    it('Deve verificar a possibilidade de inserção de valores negativos no campo "Limite de Aprovação".', () => {
        acessarCadastroUsuario()

        cy.get(limiteAprovacaoUsuario)
            .type('-')

        cy.get('#form-register > div.user-information > div:nth-child(4) > div.col-sm-2 > div')
            .should('have.class', 'form-group has-error');
    })












    it.only('Deve ser possível criar usuário de perfil "padrão", "Autorizado para solicitar".', () => {
        
        cy.inserirNome(nomeUsuario,nome)

        
        inserirDataNascimentoUsuario(dataNascimentoUsuario);

       
        cy.inserirCpf(cpfCnpjUsuario,cpfAleatorio)

        
        cy.inserirTelefone(telefoneUsuario,telefoneAleatorio)

        
        cy.inserirEmail(emailUsuario,emailCompleto)


        cy.inserirSenha(senhaUsuario,senha)

        
        cy.inserirSenha(confirmarSenhaUsuario,senha)


        cy.selecionarPerfil(dadosParametros.enums.Perfil.Administrador);


        cy.selecionarAutorizacaoParaSolicitar(dadosParametros.enums.OpcaoAutorizacao.Autorizado);


        cy.inserirSetorUsuario(setorUsuario,opcaoSetorUsuario,opcaoSelectSetorUsuario,opcaoSelecionadaSetorUsuario);


        cy.inserirUsuarioAprovador(usuarioAprovador,opcaoUsuarioAprovador);


        cy.inserirLimiteAprovacao('175',limiteAprovacaoUsuario)


        cy.inserirCentroCustoPermitido(selecionarTodosCentroCustoPermitidoUsuario)


        cy.getVisible(salvarCadastroUsuario)
            .click()


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