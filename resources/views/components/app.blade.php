<!doctype html>
<html lang="pt-br">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Bootstrap -->
    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
    <!-- jQuery UI -->
    <link rel="stylesheet" href="{{ asset('css/plugins/jquery-ui/jquery-ui.min.css') }}">
    <!-- dataTables -->
    <link rel="stylesheet" href="{{ asset('css/plugins/datatable/TableTools.css') }}">
    <!-- PageGuide -->
    <link rel="stylesheet" href="{{ asset('css/plugins/pageguide/pageguide.css') }}">
    <!-- Fullcalendar -->
    <link rel="stylesheet" href="{{ asset('css/plugins/fullcalendar/fullcalendar.css') }}">
    <link rel="stylesheet" href="{{ asset('css/plugins/fullcalendar/fullcalendar.print.css') }}" media="print">
    <!-- chosen -->
    <link rel="stylesheet" href="{{ asset('css/plugins/chosen/chosen.css') }}">
    <!-- select2 -->
    <link rel="stylesheet" href="{{ asset('css/plugins/select2/select2.css') }}">
    <!-- icheck -->
    <link rel="stylesheet" href="{{ asset('css/plugins/icheck/all.css') }}">
    <!-- Theme CSS -->
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <!-- Color CSS -->
    <link rel="stylesheet" href="{{ asset('css/themes.css') }}">

    <link rel="{{ asset('apple-touch-icon-precomposed') }}"
        href="{{ asset('img/apple-touch-icon-precomposed.png') }}" />

    <link rel="stylesheet" href="{{ asset('css/main.css') }}">
    <link rel="stylesheet" href="{{ asset('css/supplies.css') }}">
    <link rel="stylesheet" href="{{ asset('css/modal-supplies.css') }}">
    <link rel="stylesheet" href="{{ asset('css/bootbox.custom.css') }}">
    <link rel="stylesheet" href="{{ asset('css/custom-modal-dialog.css') }}">

    <!-- jQuery -->
    <script src="{{ asset('js/jquery.min.js') }}"></script>

    <!-- Masked inputs -->
    <script src="{{ asset('js/plugins/maskedinput/jquery.maskedinput.min.js') }}"></script>
    <!-- jQuery UI -->
    <script src="{{ asset('js/plugins/jquery-ui/jquery-ui.js') }}"></script>
    <!-- Touch enable for jquery UI -->
    <script src="{{ asset('js/plugins/touch-punch/jquery.touch-punch.min.js') }}"></script>
    <!-- slimScroll -->
    <script src="{{ asset('js/plugins/slimscroll/jquery.slimscroll.min.js') }}"></script>
    <!-- Bootstrap -->
    <script src="{{ asset('js/bootstrap.min.js') }}"></script>
    <!-- vmap -->
    <script src="{{ asset('js/plugins/vmap/jquery.vmap.min.js') }}"></script>
    <script src="{{ asset('js/plugins/vmap/jquery.vmap.world.js') }}"></script>
    <script src="{{ asset('js/plugins/vmap/jquery.vmap.sampledata.js') }}"></script>
    <!-- Bootbox -->
    <script src="{{ asset('js/plugins/bootbox/jquery.bootbox.js') }}"></script>
    <!-- Bootbox -->
    <script src="{{ asset('js/plugins/form/jquery.form.min.js') }}"></script>
    <!-- Flot -->
    <script src="{{ asset('js/plugins/flot/jquery.flot.min.js') }}"></script>
    <script src="{{ asset('js/plugins/flot/jquery.flot.bar.order.min.js') }}"></script>
    <script src="{{ asset('js/plugins/flot/jquery.flot.pie.min.js') }}"></script>
    <script src="{{ asset('js/plugins/flot/jquery.flot.resize.min.js') }}"></script>
    <!-- imagesLoaded -->
    <script src="{{ asset('js/plugins/imagesLoaded/jquery.imagesloaded.min.js') }}"></script>
    <!-- PageGuide -->
    <script src="{{ asset('js/plugins/pageguide/jquery.pageguide.js') }}"></script>
    <!-- FullCalendar -->
    <script src="{{ asset('js/plugins/fullcalendar/moment.min.js') }}"></script>
    <script src="{{ asset('js/plugins/fullcalendar/fullcalendar.min.js') }}"></script>
    <!-- Chosen -->
    <script src="{{ asset('js/plugins/chosen/chosen.jquery.min.js') }}"></script>
    <!-- select2 -->
    <script src="{{ asset('js/plugins/select2/select2.min.js') }}"></script>
    <!-- multi select -->
    <link rel="stylesheet" href="{{ asset('css/plugins/multiselect/multi-select.css') }}">
    <!-- icheck -->
    <script src="{{ asset('js/plugins/icheck/jquery.icheck.min.js') }}"></script>

    <!-- MultiSelect -->
    <script src="{{ asset('js/plugins/multiselect/jquery.multi-select.js') }}"></script>

    <!-- Theme framework -->
    <script src="{{ asset('js/eakroko.min.js') }}"></script>
    <!-- Theme scripts -->
    <script src="{{ asset('js/application.min.js') }}"></script>
    <!-- Just for demonstration -->
    <script src="{{ asset('js/demonstration.min.js') }}"></script>

    <!-- Favicon -->
    <link rel="shortcut icon" href="{{ asset('img/favicon.ico') }}" />
    <!-- Apple devices Homescreen icon -->

    <!-- Validation -->
    <script src="{{ asset('js/plugins/validation/jquery.validate.min.js') }}"></script>
    <script src="{{ asset('js/plugins/validation/additional-methods.min.js') }}"></script>

    <!-- MOMENT JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.4/moment-with-locales.min.js"
        integrity="sha512-42PE0rd+wZ2hNXftlM78BSehIGzezNeQuzihiBCvUEB3CVxHvsShF86wBWwQORNxNINlBPuq7rG4WWhNiTVHFg=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <script>
        $(() => {
            // required style
            $('[data-rule-required]').each(function() {
                const $label = $(this).closest('.form-group').find('label').first();
                $label.append('<sup style="color:red">*</sup>');
            });
        });
    </script>

    <!-- IMask -->
    <script src="https://unpkg.com/imask"></script>
    <script>
        $.fn.imask = function(options) {
            const maskedElements = this.map((_, input) => new IMask(input, options)).toArray();

            if (maskedElements.length === 1) {
                return maskedElements[0];
            }

            return maskedElements;
        }
    </script>

    <!-- New DataTables -->
    <script src="{{ asset('js/plugins/momentjs/jquery.moment.min.js') }}"></script>
    <script src="{{ asset('js/plugins/momentjs/moment-range.min.js') }}"></script>
    <script src="{{ asset('js/plugins/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('js/plugins/datatables/extensions/dataTables.tableTools.min.js') }}"></script>
    <script src="{{ asset('js/plugins/datatables/extensions/dataTables.colReorder.min.js') }}"></script>
    <script src="{{ asset('js/plugins/datatables/extensions/dataTables.colVis.min.js') }}"></script>
    <script src="{{ asset('js/plugins/datatables/extensions/dataTables.scroller.min.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.9.3/html2pdf.bundle.min.js"></script>

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

                    @if ($currentProfile === 'admin')
                        <li>
                            <a href="#" data-toggle="dropdown" class='dropdown-toggle' data-cy="dropdown-cadastros">
                                <span>CADASTROS</span>
                                <span class="caret"></span>
                            </a>
                            <ul class="dropdown-menu">
                                <li>
                                    <a href="{{ route('users') }}" data-cy="dropdown-cadastros-usuarios">Usuários</a>
                                </li>
                                <li>
                                    <a href="{{ route('suppliers') }}" data-cy="dropdown-cadastros-fornecedores">Fornecedores</a>
                                </li>
                            </ul>
                        </li>
                    @endif
                    <li>
                        <a href="#" data-toggle="dropdown" class='dropdown-toggle' data-cy="dropdown-solicitacoes">
                            <span>SOLICITAÇÕES</span>
                            <span class="caret"></span>
                        </a>
                        <ul class="dropdown-menu">
                            <li><a href="{{ route('request.links') }}" data-cy="dropdown-solicitacoes-novas">Nova Solicitação</a></li>
                            <li><a href="{{ route('requests.own') }}" data-cy="dropdown-solicitacoes-minhas">Minhas Solicitações</a></li>
                            @if ($currentProfile === 'admin')
                                <li><a href="{{ route('requests') }}" data-cy="dropdown-solicitacoes-gerais">Solicitações Gerais</a></li>
                            @endif
                        </ul>
                    </li>
                    @if ($currentProfile === 'admin' || $currentProfile === 'suprimentos_inp' || $currentProfile === 'suprimentos_hkm')
                        <li>
                            <a href="#" data-toggle="dropdown" class='dropdown-toggle' data-cy="dropdown-suprimentos">
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
                <x-navbar.user/>
            </div>
        </div>

        <div id="main">
            <div class="container-fluid">
                <div class="page-header">
                    {{ $title ?? null }}
                </div>
                <x-breadcrumb />
                <x-alert />
                {{ $slot }}
            </div>
        </div>
    </div>

    <script>
        $(() => {
            // datatable language
            $('#DataTables_Table_0').DataTable({
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
            });

            // autocomplete off
            $("form").attr('autocomplete', 'off');
        })
    </script>
</body>

</html>
