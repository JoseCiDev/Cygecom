@php
    $currentProfile = auth()->user()->profile->name;
@endphp

@push('styles')
    <style>
        #brand,
        .user,
        .main-nav->li{
            width: 120px
        }
    </style>
@endpush

<div id="navigation">
    <a data-cy="logo-gecom" href="/" id="brand"></a>
    <ul class='main-nav'>
        <li>
            <a data-cy="route-home" href=" {{ route('home') }} ">
                <span> INÍCIO </span>
            </a>
        </li>

        @if ($currentProfile === 'admin' || $currentProfile === 'gestor_usuarios' || $currentProfile === 'gestor_fornecedores')
            <li>
                <a href="#" data-toggle="dropdown" class='dropdown-toggle' data-cy="dropdown-cadastros">
                    <span>CADASTROS</span>
                    <span class="caret"></span>
                </a>
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
            </li>
        @endif

        <li>
            <a href="#" data-toggle="dropdown" class='dropdown-toggle'
                data-cy="dropdown-solicitacoes">
                <span>SOLICITAÇÕES</span>
                <span class="caret"></span>
            </a>
            <ul class="dropdown-menu">
                <li><a href="{{ route('request.links') }}" data-cy="dropdown-solicitacoes-novas">Nova solicitação</a></li>
                <li><a href="{{ route('requests.own') }}" data-cy="dropdown-solicitacoes-minhas">Minhas solicitações</a></li>
                @if ($currentProfile === 'admin')
                    <li><a href="{{ route('requests') }}" data-cy="dropdown-solicitacoes-gerais">Solicitações gerais</a></li>
                @endif
            </ul>
        </li>

        @if ($currentProfile === 'admin' || $currentProfile === 'suprimentos_inp' || $currentProfile === 'suprimentos_hkm')
            <li>
                <a href="#" data-toggle="dropdown" class='dropdown-toggle'
                    data-cy="dropdown-suprimentos">
                    <span>SUPRIMENTOS</span>
                    <span class="caret"></span>
                </a>
                <ul class="dropdown-menu">
                    <li><a href="{{ route('supplies.index') }}" data-cy="dropdown-suprimentos-dashboard">Dashboard</a></li>
                    @if ($currentProfile === 'admin')
                        <li><a href="{{ route('supplies.product') }}" data-cy="dropdown-suprimentos-produtos">Produtos</a></li>
                        <li><a href="{{ route('supplies.service') }}" data-cy="dropdown-suprimentos-servicos">Serviços</a></li>
                        <li><a href="{{ route('supplies.contract') }}" data-cy="dropdown-suprimentos-contratos">Contratos</a></li>
                    @endif
                </ul>
            </li>
        @endif

        <li>
            <a href="#" data-toggle="dropdown" class='dropdown-toggle' data-cy="dropdown-suprimentos">
                <span>RELATÓRIOS</span>
                <span class="caret"></span>
            </a>
            <ul class="dropdown-menu">
                <li> <a href="{{ route('reports.index.view') }}">Relatórios de solicitações</a> </li>
            </ul>
        </li>

    </ul>
    <div class="user">
        <div class="dropdown">
            <a href="#" class='dropdown-toggle regular-text' data-toggle="dropdown" data-cy="profile-dropdown" style="display: flex; align-items:center; gap: 5px">
                <img src="{{ asset('img/gecom/gecom_usuario.svg') }}" alt="" width="25" style="border-radius: 100%">
                {{ auth()->user()->person->name }}
            </a>
            <ul class="dropdown-menu pull-right">
                <li>
                    <a data-cy="route-profile" href="{{ route('profile') }}">Configurações da conta</a>
                </li>
                <li>
                    <a data-cy="btn-logout" class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault();document.getElementById('logout-form').submit();">
                         {{ __('Sair') }}
                     </a>
                    <form id="logout-form" data-cy="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">@csrf</form>
                </li>
            </ul>
        </div>
    </div>
</div>
