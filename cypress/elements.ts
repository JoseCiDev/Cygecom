interface Elements<T = string> {

    Compartilhado: {
        logout: T;
        opcoesMenu: T;
        menuReduzido: T;
        breadcumbHome: T;
        breadcumbUsuario: T;
        mostraQuantidadeRegistros: T;
        BuscaUsuarioCadastrado: T;
        proximaPagina: T;
        paginaAnterior: T;
    };

    Login: {
        tituloLogin: T;
        email: T;
        senha: T;
        entrar: T;
        msgDadosIncorretosLogin: T;
    };

    CustomCommands: {

    },

    Inicio: {
        perfilUsuario: T;
        inicioMenu: T;
        logoGecom: T;
        telaInicio: T;
    },

    Cadastro: {
        cadastroMenu: T;
        cadastroMenuReduzido: T;
        cadastroUsuarioSubMenu: T;
        criaNovoUsuario: T;
        nomeUsuario: T;
        dataNascimentoUsuario: T;
        cpfCnpjUsuario: T;
        telefoneUsuario: T;
        emailUsuario: T;
        senhaUsuario: T;
        confirmarSenhaUsuario: T;
        setorUsuario: T;
        opcaoSetorUsuario: T;
        opcaoSelectSetorUsuario: T;
        opcaoSelecionadaSetorUsuario: T;
        usuarioAprovador: T;
        opcaoUsuarioAprovador: T;
        limiteAprovacaoUsuario: T;
        centroCustoPermitidoUsuario: T;
        selecionarTodosCentroCustoPermitidoUsuario: T;
        limparCentroCustoPermitidoUsuario: T;
        salvarCadastroUsuario: T;
        cancelarCadastroUsuario: T;
        cadastroFornecedorSubMenu: T;
        mensagemObrigatoriedadeNome: T;
        mensagemObrigatoriedadeCpfCnpj: T;
        mensagemObrigatoriedadeTelefone: T;
    },

    Solicitacao: {
        solicitacaoMenu: T;
        novaSolicitacaoSubMenu: T;
        minhaSolicitacaoSubMenu: T;
        solicitacaoGeralSubMenu: T;
    },

    Suprimento: {
        suprimentoMenu: T;
        dashboardSubMenu: T;
        produtoSubMenu: T;
        servicoSubMenu: T;
        contratoSubMenu: T;
    },
}



export const elements: Elements = {

    Compartilhado: {
        logout: '[data-cy="btn-logout"]',
        opcoesMenu: 'ul.main-nav li',
        menuReduzido: '.toggle-mobile',
        breadcumbHome: '[data-cy="breadcrumb-0"]',
        breadcumbUsuario: '[data-cy="breadcrumb-1"]',
        mostraQuantidadeRegistros: 'select',
        BuscaUsuarioCadastrado: 'label > input',
        proximaPagina: '#DataTables_Table_0_next',
        paginaAnterior: '#DataTables_Table_0_previous',
    },

    Login: {
        tituloLogin: '.login-logo',
        email: '[data-cy="email"]',
        senha: '[data-cy="password"]',
        entrar: '[data-cy="btn-login-entrar"]',
        msgDadosIncorretosLogin: 'body > div > div > div > div > div > h5 > strong',
    },

    CustomCommands: {

    },

    Inicio: {
        perfilUsuario: '[data-cy="profile-dropdown"]',
        inicioMenu: '[data-cy="route-home"]',
        logoGecom: '[data-cy="logo-gecom"]',
        telaInicio: '#main',
    },

    Cadastro: {
        cadastroMenu: '[data-cy="dropdown-cadastros"]',
        cadastroMenuReduzido: '.mobile-nav > :nth-child(2) > [href="#"]',
        cadastroUsuarioSubMenu: '[data-cy="dropdown-cadastros-usuarios"]',
        criaNovoUsuario: '[data-cy="btn-novo-usuario"]',
        nomeUsuario: '[data-cy="name"]',
        dataNascimentoUsuario: '[data-cy="birthdate"]',
        cpfCnpjUsuario: '[data-cy="cpf_cnpj"]',
        telefoneUsuario: '[data-cy="number"]',
        emailUsuario: '[data-cy="email"]',
        senhaUsuario: '[data-cy="password"]',
        confirmarSenhaUsuario: '[data-cy="password-confirm"]',
        setorUsuario: '#cost_center_id_chosen > .chosen-single',
        opcaoSetorUsuario: 'select#cost_center_id.chosen-select.form-control>',
        opcaoSelectSetorUsuario: 'select#cost_center_id.chosen-select.form-control',
        opcaoSelecionadaSetorUsuario: 'ul.chosen-results li.active-result:nth-child(2)',
        usuarioAprovador: '#approver_user_id_chosen > a',
        opcaoUsuarioAprovador: 'ul.chosen-results li.active-result',
        limiteAprovacaoUsuario: '[data-cy="format-approve-limit"]',
        centroCustoPermitidoUsuario: '.chosen-choices',
        selecionarTodosCentroCustoPermitidoUsuario: '[data-cy="btn-select-all-cost-centers"]',
        limparCentroCustoPermitidoUsuario: '[data-cy="btn-clear-cost-centers"]',
        salvarCadastroUsuario: '[data-cy="btn-submit-salvar"]',
        cancelarCadastroUsuario: '[data-cy="btn-cancelar"]',
        cadastroFornecedorSubMenu: '[data-cy="dropdown-cadastros-fornecedores"]',
        mensagemObrigatoriedadeNome: '#name-error',
        mensagemObrigatoriedadeCpfCnpj: '#cpf_cnpj-error',
        mensagemObrigatoriedadeTelefone: '#number-error',
    },

    Solicitacao: {
        solicitacaoMenu: '[data-cy="dropdown-solicitacoes"]',
        novaSolicitacaoSubMenu: '[data-cy="dropdown-solicitacoes-novas"]',
        minhaSolicitacaoSubMenu: '[data-cy="dropdown-solicitacoes-minhas"]',
        solicitacaoGeralSubMenu: '[data-cy="dropdown-solicitacoes-minhas"]',
    },

    Suprimento: {
        suprimentoMenu: '[data-cy="dropdown-suprimentos"]',
        dashboardSubMenu: '[data-cy="dropdown-suprimentos-dashboard"]',
        produtoSubMenu: '[data-cy="dropdown-suprimentos-produtos"]',
        servicoSubMenu: '[data-cy="dropdown-suprimentos-servicos"]',
        contratoSubMenu: '[data-cy="dropdown-suprimentos-contratos"]',
    },


}
