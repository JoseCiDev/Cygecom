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

    <script>
        $(() => {
            // required style
            $('[data-rule-required]').each(function () {
                const $label = $('label[for="' + $(this).attr('id') + '"]');
                $label.append('<sup style="color:red">*</sup>');
            });
        });
    </script>

    <!-- IMask -->
    <script src="https://unpkg.com/imask"></script>
    <script>
        $.fn.imask = function(options) {
            return this.each(function() {
                const element = this;
                new IMask(element, options);
            });
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
</head>

<body>
    <div id="app">
        {{-- NAVBAR --}}
        <div id="navigation">
            <div class="container-fluid">
                <x-navbar.logo />
                <ul class='main-nav'>
                    <x-navbar.menu-item route="home" title="DASHBOARD" />

                    @if (auth()->user()->profile->isAdmin)
                        <li>
                            <a href="#" data-toggle="dropdown" class='dropdown-toggle'>
                                <span>CADASTROS</span>
                                <span class="caret"></span>
                            </a>
                            <ul class="dropdown-menu">
                                <li>
                                    <a href="{{ route('users') }}">Usuários</a>
                                </li>
                                <li>
                                    <a href="{{ route('suppliers') }}">Fornecedores</a>
                                </li>
                                <li>
                                    <a href="{{ route('products') }}">Produtos</a>
                                </li>
                            </ul>
                        </li>
                    @endif
                    <li>
                        <a href="#" data-toggle="dropdown" class='dropdown-toggle'>
                            <span>SOLICITAÇÕES</span>
                            <span class="caret"></span>
                        </a>
                        <ul class="dropdown-menu">
                            <li><a href="{{ route('requests.own') }}">Minhas Solicitações</a></li>
                            @if (auth()->user()->profile->isAdmin)
                                <li><a href="{{ route('requests') }}">Solicitações Gerais</a></li>
                            @endif
                        </ul>
                    </li>

                    <li>
                        <a href="#" data-toggle="dropdown" class='dropdown-toggle'>
                            <span>COTAÇÕES</span>
                            <span class="caret"></span>
                        </a>
                        <ul class="dropdown-menu">
                            <li>
                                <a href="{{ route('quotations') }}">Minhas Cotações</a>
                            </li>
                            <li>
                                <a href="{{ route('quotations') }}">Cotações Gerais</a>
                            </li>
                        </ul>
                    </li>

                    @if (auth()->user()->profile->isAdmin)
                        <x-navbar.menu-item route="home" title="INTEGRAÇÃO SÊNIOR" />
                    @endif
                </ul>
                <x-navbar.user>
                    <x-navbar.notification />
                </x-navbar.user>
            </div>
        </div>

        <div id="main-content-container">
            <div id="main">
                <div class="container">
                    <div class="page-header">
                        {{ $title }}
                    </div>
                    <x-breadcrumb />
                    <x-alert />
                    {{ $slot }}
                </div>
            </div>
        </div>
    </div>
    </div>

    <script>
        $(() => {
            // datatable language
            $('#DataTables_Table_0').DataTable({
                "language": {
                    "lengthMenu": "Mostrar _MENU_ registros",
                    "zeroRecords": "Nenhum registro encontrado",
                    "info": "Mostrando página _PAGE_ de _PAGES_",
                    "infoEmpty": "Nenhum registro disponível",
                    "infoFiltered": "(filtrado de _MAX_ registros no total)",
                    "search": "Buscar:",
                    "paginate": {
                        "first": "Primeiro",
                        "last": "Último",
                        "next": "Próximo",
                        "previous": "Anterior"
                    }
                },
                "destroy": true
            });

            // autocomplete off
            $("form").attr('autocomplete', 'off');
        })
    </script>
</body>

</html>
