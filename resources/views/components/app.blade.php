<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Favicon -->
    <link rel="shortcut icon" href="{{ asset('img/gecom/favicon.png') }}" />

    <link rel="stylesheet" href="{{ asset('css/main.css') }}">

    <!-- jQuery -->
    <script src="{{ asset('js/jquery.min.js') }}"></script>
    <!-- Bootstrap -->
    <script src="{{ asset('js/bootstrap.min.js') }}"></script>
    <!-- Bootbox -->
    <script src="{{ asset('js/plugins/bootbox/jquery.bootbox.js') }}"></script>
    <!-- select2 -->
    <script src="{{ asset('js/plugins/select2/select2.min.js') }}"></script>
    <!-- Validation -->
    <script src="{{ asset('js/plugins/validation/jquery.validate.min.js') }}"></script>
    <script src="{{ asset('js/plugins/validation/additional-methods.min.js') }}"></script>
    <!-- MOMENT JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.4/moment-with-locales.min.js"
    integrity="sha512-42PE0rd+wZ2hNXftlM78BSehIGzezNeQuzihiBCvUEB3CVxHvsShF86wBWwQORNxNINlBPuq7rG4WWhNiTVHFg=="
    crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <!-- IMask -->
    <script src="https://unpkg.com/imask"></script>
    <!-- New DataTables -->
    <script src="{{ asset('js/plugins/momentjs/jquery.moment.min.js') }}"></script>
    <script src="{{ asset('js/plugins/momentjs/moment-range.min.js') }}"></script>
    <script src="{{ asset('js/plugins/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.9.3/html2pdf.bundle.min.js"></script>

    <script src="{{ asset('js/plugins/form/jquery.form.min.js') }}"></script>

    <script src="{{asset('js/main.js')}}"></script>



    @stack('styles')
    @stack('scripts')
</head>

<body>
    @php
        $currentProfile = auth()->user()->profile->name;
    @endphp

    <div id="app">
        {{-- NAVBAR --}}
        <div id="navigation">
            <x-navbar.logo />
            <ul class='main-nav'>
                <x-navbar.menu-item route="home" title="INÍCIO" />

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
            </ul>
            <x-navbar.user />
        </div>

        @if (!App::isProduction())
            @php
                $stringFromFile = file('../.git/HEAD', FILE_USE_INCLUDE_PATH);
                $firstLine = $stringFromFile[0];
                $explodedString = explode('/', $firstLine, 3);
                $branchName = $explodedString[2];
            @endphp

            <div class="env" style="background-color: rgb(251, 52, 52);">
                <h3 style="text-align: center; margin: 0px; color: rgb(40, 40, 40); padding:2px">
                    {{ App::environment() }}: {{ $branchName }}
                <h3>
            </div>
        @endif

        <div id="main">
            <div class="container-fluid">
                <x-breadcrumb />
                <x-alert />
                {{ $slot }}
            </div>
        </div>
    </div>

    {{ $scripts ?? null }}
</body>

</html>
