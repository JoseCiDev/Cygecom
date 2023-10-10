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

    <!-- Bootstrap -->
    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
    <!-- select2 -->
    <link rel="stylesheet" href="{{ asset('css/plugins/select2/select2.css') }}">
    <!-- jQuery UI -->
    <link rel="stylesheet" href="{{ asset('css/plugins/jquery-ui/jquery-ui.min.css') }}">
    <!-- Theme CSS -->
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">

    <link rel="stylesheet" href="{{ asset('css/main.css') }}">
    <link rel="stylesheet" href="{{ asset('css/supplies.css') }}">
    <link rel="stylesheet" href="{{ asset('css/modal-supplies.css') }}">
    <link rel="stylesheet" href="{{ asset('css/bootbox.custom.css') }}">
    <link rel="stylesheet" href="{{ asset('css/custom-modal-dialog.css') }}">
    <link rel="stylesheet" href="{{ asset('css/custom-breadcrumb.css') }}">
    <link rel="stylesheet" href="{{ asset('css/purchase-request/product-suggestion-autocomplete.css') }}">
    <link rel="stylesheet" href="{{ asset('css/purchase-request/log.css') }}">
    <link rel="stylesheet" href="{{ asset('css/purchase-request/request-dashboard.css') }}">
    <link rel="stylesheet" href="{{ asset('css/supplies/form-status-filter.css') }}">
    <link rel="stylesheet" href="{{ asset('css/supplies/category-column-tags.css') }}">
    <link rel="stylesheet" href="{{ asset('css/supplies/dashboard.css') }}">
    <link rel="stylesheet" href="{{ asset('css/supplies/details.css') }}">

    <!-- jQuery -->
    <script src="{{ asset('js/jquery.min.js') }}"></script>
    <!-- Bootstrap -->
    <script src="{{ asset('js/bootstrap.min.js') }}"></script>
    <!-- jQuery UI -->
    <script src="{{ asset('js/plugins/jquery-ui/jquery-ui.js') }}"></script>
    <!-- Bootbox -->
    <script src="{{ asset('js/plugins/bootbox/jquery.bootbox.js') }}"></script>
    <script src="{{ asset('js/plugins/form/jquery.form.min.js') }}"></script>

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

    <script>
         $.fn.imask = function(options) {
            const maskedElements = this.map((_, input) => new IMask(input, options)).toArray();

            if (maskedElements.length === 1) {
                return maskedElements[0];
            }

            return maskedElements;
        }

        // adiciona required style em elemento jquery e torna required pra validacao
        $.fn.makeRequired = function() {
            this.filter(function() {
                return $(this).closest('.form-group').find('label').first().find('sup').length === 0;
            }).each(function() {
                const $label = $(this).closest('.form-group').find('label').first();
                $label.append('<sup style="color:red">*</sup>');
                $(this).data('rule-required', true);
            });

            return $(this);
        }

        $.fn.removeRequired = function() {
            this.each(function() {
                const $sup = $(this).closest('.form-group').find('label').first().find('sup');
                $sup.remove();
                $(this).data('rule-required', false);
            });

            return $(this);
        }

        $(() => {
            // required style
            $('[data-rule-required]').each(function() {
                const $label = $(this).closest('.form-group').find('label').first();
                $label.append('<sup style="color:red">*</sup>');
            });

            $(".select2-me").select2();

            // autocomplete off
            $("form").attr('autocomplete', 'off');

            $('.dataTable').each((_, table) => $(table).DataTable({
                language: {
                    lengthMenu: "Mostrar _MENU_ registros",
                    zeroRecords: "Nenhum registro encontrado",
                    info: "Mostrando página _PAGE_ de _PAGES_",
                    infoEmpty: "Nenhum registro disponível",
                    infoFiltered: "(filtrado de _MAX_ registros no total)",
                    search: "Buscar:",
                    paginate: {
                        first: "Primeiro",
                        last: "Último",
                        next: "Próximo",
                        previous: "Anterior"
                    }
                },
                destroy: true
            }));

            $('.form-validate').each(function () {
                const id = $(this).attr('id');
                $("#" + id).validate({
                    ignore: ".no-validation",
                    errorElement: 'span',
                    errorClass: 'help-block has-error',
                    errorPlacement: (error, element) => {
                        const $elementParent = element.parent();

                        if (element.siblings('.input-group-addon').length > 0) {
                            $elementParent.after(error);
                            return;
                        }

                        const elementType = element.attr('type');
                        const radioCheckbox = ['radio', 'checkbox'];
                        const elementTypeIsRadioOrCheckbox = radioCheckbox.includes(elementType);

                        if (elementTypeIsRadioOrCheckbox) {
                            element.closest('.form-group').find('fieldset').first().after(error);
                            return;
                        }

                        if (element.prop('tagName').toLowerCase() === 'select') {
                            element.before(error);
                            return;
                        }

                        if (element.prop('type') === 'hidden' && error.text().length) {
                            element[0].parentElement.scrollIntoView({block: 'center'});
                            return;
                        }

                        element.after(error);
                    },
                    highlight: (label) => $(label).closest('.form-group').removeClass('has-error has-success').addClass('has-error'),
                    success: (label) => label.addClass('valid').closest('.form-group').removeClass('has-error has-success'),
                    onkeyup: (element) => $(element).valid(),
                    onfocusout: (element) => $(element).valid(),
                    rules: {
                        password: {
                            minlength: 8
                        },
                        password_confirmation: {
                            minlength: 8,
                            equalTo: '#password'
                        }
                    },
                });
            });
        });
    </script>
</head>

<body>
    @php
        $currentProfile = auth()->user()->profile->name;
    @endphp
    <div id="app">
        {{-- NAVBAR --}}
        <div id="navigation">
            <div class="container-fluid">
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
