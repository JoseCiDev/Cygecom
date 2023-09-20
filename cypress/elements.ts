export const ELEMENTS = {
    logout: '[data-cy="btn-logout"]',
    opcoesMenu:'ul.main-nav li',
    menuReduzido:'.toggle-mobile',
    // LOGIN
    tituloLogin: 'body > div.wrapper > h1',
    email: '[data-cy="email"]',
    senha: '[data-cy="password"]',
    entrar: '[data-cy="btn-login-entrar"]',
    msgDadosIncorretosLogin: 'body > div > div > div > div > div > h5 > strong',

    // INICIO
    perfilUsuario: '[data-cy="profile-dropdown"]',
    inicioMenu: '[data-cy="route-home"]',
    logoGecom: '[data-cy="logo-gecom"]',
    telaInicio:'#main',


    // CADASTROS
    // Usuarios
    cadastroMenu: '[data-cy="dropdown-cadastros"]',
    cadastroMenuReduzido:'.mobile-nav > :nth-child(2) > [href="#"]',
    cadastroUsuarioSubMenu: '[data-cy="dropdown-cadastros-usuarios"]',
    breadcumbHome:'[data-cy="breadcrumb-0"]',
    breadcumbUsuario:'[data-cy="breadcrumb-1"]',
    mostraQuantidadeRegistros:'select',
    BuscaUsuarioCadastrado:'label > input',
    proximaPagina:'#DataTables_Table_0_next',
    paginaAnterior:'#DataTables_Table_0_previous',
    criaNovoUsuario:'[data-cy="btn-novo-usuario"]',
    nomeUsuario:'[data-cy="name"]',
    dataNascimentoUsuario:'[data-cy="birthdate"]',
    cpfCnpjUsuario:'[data-cy="cpf_cnpj"]',
    telefoneUsuario:'[data-cy="number"]',
    emailUsuario:'[data-cy="email"]',
    senhaUsuario:'[data-cy="password"]',
    confirmarSenhaUsuario:'[data-cy="password-confirm"]',
    
    //autorizacao para solicitar
    setorUsuario:'#cost_center_id_chosen > .chosen-single',
    opcaoSetorUsuario:'select#cost_center_id.chosen-select.form-control>',
    opcaoSelectSetorUsuario:'select#cost_center_id.chosen-select.form-control',
    opcaoSelecionadaSetorUsuario:'ul.chosen-results li.active-result:nth-child(2)',
    usuarioAprovador:'#approver_user_id_chosen > a',
    opcaoUsuarioAprovador:'ul.chosen-results li.active-result',
    limiteAprovacaoUsuario:'[data-cy="format-approve-limit"]',
    centroCustoPermitidoUsuario:'.chosen-choices',
    selecionarTodosCentroCustoPermitidoUsuario:'[data-cy="btn-select-all-cost-centers"]',
    limparCentroCustoPermitidoUsuario:'[data-cy="btn-clear-cost-centers"]',
    salvarCadastroUsuario:'[data-cy="btn-submit-salvar"]',
    cancelarCadastroUsuario:'[data-cy="btn-cancelar"]',
    // Fornecedores
    cadastroFornecedorSubMenu: '[data-cy="dropdown-cadastros-fornecedores"]',
    

    // SOLICITACOES
    solicitacaoMenu: '[data-cy="dropdown-solicitacoes"]',
    // Nova Solicitacao
    novaSolicitacaoSubMenu: '[data-cy="dropdown-solicitacoes-novas"]',
    // Minhas solicitações
    minhaSolicitacaoSubMenu: '[data-cy="dropdown-solicitacoes-minhas"]',
    // Solicitações Gerais
    solicitacaoGeralSubMenu: '[data-cy="dropdown-solicitacoes-minhas"]',

    // SUPRIMENTOS
    suprimentoMenu: '[data-cy="dropdown-suprimentos"]',
    // Dashboard
    dashboardSubMenu: '[data-cy="dropdown-suprimentos-dashboard"]',
    // Produtos
    produtoSubMenu: '[data-cy="dropdown-suprimentos-produtos"]',
    // Servicos
    servicoSubMenu: '[data-cy="dropdown-suprimentos-servicos"]',
    // Contratos
    contratoSubMenu:'[data-cy="dropdown-suprimentos-contratos"]',

}