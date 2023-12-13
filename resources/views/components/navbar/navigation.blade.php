<div id="active-menu-shadow"></div>
<div id="navigation">

    <div class="user">
        <div class="dropdown">
            <button class="btn btn-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                <img src="{{ asset('img/gecom/gecom_usuario.svg') }}" alt="" width="25" style="border-radius: 100%">
                {{ auth()->user()->person->name }}
            </button>
            <ul class="dropdown-menu">
                <li>
                    <a data-cy="route-profile" class="dropdown-item" href="{{ route('users.edit', ['user' => auth()->user()]) }}">Configurações da conta</a>
                </li>
                <li>
                    <a data-cy="btn-logout" class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault();document.getElementById('logout-form').submit();">
                        Sair
                    </a>
                    <form id="logout-form" data-cy="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">@csrf</form>
                </li>
            </ul>
        </div>
    </div>

    <span id="menu-hambuguer-icon"> <i class="fa-solid fa-bars"></i> </span>
    <div class='main-nav'>
        <span id="menu-hambuguer-icon-closer" style="display: none"> <i class="fa-solid fa-arrow-left-long"></i> </span>

        @if (Gate::any(['get.users.index', 'get.suppliers.index']))
            <div class="dropdown">
                <button class="btn btn-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                    Cadastros
                </button>
                <ul class="dropdown-menu">
                    @can('get.users.index')
                        <li> <a href="{{ route('users.index') }}" data-cy="dropdown-cadastros-usuarios">Usuários</a> </li>
                    @endcan
                    @can('get.suppliers.index')
                        <li> <a href="{{ route('suppliers.index') }}" data-cy="dropdown-cadastros-fornecedores">Fornecedores</a> </li>
                    @endcan
                </ul>
            </div>
        @endif

        @if (Gate::any(['get.requests.dashboard', 'get.requests.index.own', 'get.requests.index']))
            <div class="dropdown">
                <button class="btn btn-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                    Solicitações
                </button>
                <ul class="dropdown-menu">
                    @can('get.requests.dashboard')
                        <li><a href="{{ route('requests.dashboard') }}" data-cy="dropdown-solicitacoes-novas">Nova solicitação</a></li>
                    @endcan
                    @can('get.requests.index.own')
                        <li><a href="{{ route('requests.index.own') }}" data-cy="dropdown-solicitacoes-minhas">Minhas solicitações</a></li>
                    @endcan
                    @can('get.requests.index')
                        <li><a href="{{ route('requests.index') }}" data-cy="dropdown-solicitacoes-gerais">Solicitações gerais</a></li>
                    @endcan
                </ul>
            </div>
        @endif

        @if (Gate::any(['get.supplies.product.index', 'get.supplies.service.index', 'get.supplies.contract.index']))
            <div class="dropdown">
                <button class="btn btn-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                    Suprimentos
                </button>
                <ul class="dropdown-menu">
                    @can('get.supplies.index')
                        <li><a href="{{ route('supplies.index') }}" data-cy="dropdown-suprimentos-dashboard">Dashboard</a></li>
                    @endcan
                    @can('get.supplies.product.index')
                        <li><a href="{{ route('supplies.product.index') }}" data-cy="dropdown-suprimentos-produtos">Produtos</a></li>
                    @endcan
                    @can('get.supplies.service.index')
                        <li><a href="{{ route('supplies.service.index') }}" data-cy="dropdown-suprimentos-servicos-pontuais">Serviços pontuais</a></li>
                    @endcan
                    @can('get.supplies.contract.index')
                        <li><a href="{{ route('supplies.contract.index') }}" data-cy="dropdown-suprimentos-servicos-recorrentes">Serviços recorrentes</a></li>
                    @endcan
                </ul>
            </div>
        @endif

        @if (Gate::any(['get.reports.index']))
            <div class="dropdown">
                <button class="btn btn-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                    Relatórios
                </button>
                <ul class="dropdown-menu">
                    @can('get.reports.index')
                        <li> <a href="{{ route('reports.index') }}">Relatórios de solicitações</a> </li>
                    @endcan
                </ul>
            </div>
        @endif

        @if (Gate::any(['get.profile.create', 'profile.index']))
            <div class="dropdown">
                <button class="btn btn-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                    Autorizações
                </button>
                <ul class="dropdown-menu">
                    @can('get.profile.index')
                        <li> <a href="{{ route('profile.index') }}">Lista de perfis</a> </li>
                    @endcan
                    @can('get.profile.create')
                        <li> <a href="{{ route('profile.create') }}">Criação de perfis</a> </li>
                    @endcan
                </ul>
            </div>
        @endif

    </div>

    <a data-cy="logo-gecom" href="/" id="brand"></a>
</div>

@push('scripts')
    <script type="module" src="{{ asset('js/navbar/mobile.js') }}"></script>
@endpush
