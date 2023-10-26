@php
    $currentProfile = auth()->user()->profile->name;
@endphp

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
                    <a data-cy="route-profile" class="dropdown-item" href="{{ route('profile') }}">Configurações da conta</a>
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

    <span id="menu-hambuguer-icon" > <i class="fa-solid fa-bars"></i> </span>
    <div class='main-nav'>
        <span id="menu-hambuguer-icon-closer" style="display: none"> <i class="fa-solid fa-arrow-left-long"></i> </span>

        @if ($currentProfile === 'admin' || $currentProfile === 'gestor_usuarios' || $currentProfile === 'gestor_fornecedores')
            <div class="dropdown">
                <button class="btn btn-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                    Cadastros
                </button>
                <ul class="dropdown-menu">
                    @if ($currentProfile === 'admin' || $currentProfile === 'gestor_usuarios')
                        <li>
                            <a href="{{ route('users') }}" data-cy="dropdown-cadastros-usuarios">Usuários</a>
                        </li>
                    @endif
                    @if ($currentProfile === 'admin' || $currentProfile === 'gestor_fornecedores')
                        <li>
                            <a href="{{ route('suppliers') }}" data-cy="dropdown-cadastros-fornecedores">Fornecedores</a>
                        </li>
                    @endif
                </ul>
            </div>
        @endif

        <div class="dropdown">
            <button class="btn btn-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                Solicitações
            </button>
            <ul class="dropdown-menu">
                <li><a href="{{ route('request.links') }}" data-cy="dropdown-solicitacoes-novas">Nova solicitação</a></li>
                <li><a href="{{ route('requests.own') }}" data-cy="dropdown-solicitacoes-minhas">Minhas solicitações</a></li>
                @if ($currentProfile === 'admin')
                    <li><a href="{{ route('requests') }}" data-cy="dropdown-solicitacoes-gerais">Solicitações gerais</a></li>
                @endif
            </ul>
        </div>

        @if ($currentProfile === 'admin' || $currentProfile === 'suprimentos_inp' || $currentProfile === 'suprimentos_hkm')
            <div class="dropdown">
                <button class="btn btn-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                    Suprimentos
                </button>
                <ul class="dropdown-menu">
                    <li><a href="{{ route('supplies.index') }}" data-cy="dropdown-suprimentos-dashboard">Dashboard</a></li>
                    @if ($currentProfile === 'admin')
                        <li><a href="{{ route('supplies.product') }}" data-cy="dropdown-suprimentos-produtos">Produtos</a></li>
                        <li><a href="{{ route('supplies.service') }}" data-cy="dropdown-suprimentos-servicos">Serviços</a></li>
                        <li><a href="{{ route('supplies.contract') }}" data-cy="dropdown-suprimentos-contratos">Contratos</a></li>
                    @endif
                </ul>
            </div>
        @endif

        <div class="dropdown">
            <button class="btn btn-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                Relatórios
            </button>
            <ul class="dropdown-menu">
                <li> <a href="{{ route('reports.index.view') }}">Relatórios de solicitações</a> </li>
            </ul>
        </div>

    </div>

    <a data-cy="logo-gecom" href="/" id="brand"></a>
</div>

@push('scripts')
    <script type="module" src="{{asset('js/navbar/mobile.js')}}"></script>
@endpush
