<!doctype html>
<html lang="pt-br">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

	<!-- Bootstrap -->
	<link rel="stylesheet" href="{{asset('css/bootstrap.min.css')}}">
	<!-- jQuery UI -->
	<link rel="stylesheet" href="{{asset('css/plugins/jquery-ui/jquery-ui.min.css')}}">
	<!-- dataTables -->
	<link rel="stylesheet" href="{{asset('css/plugins/datatable/TableTools.css')}}">
	<!-- PageGuide -->
	<link rel="stylesheet" href="{{asset('css/plugins/pageguide/pageguide.css')}}">
	<!-- Fullcalendar -->
	<link rel="stylesheet" href="{{asset('css/plugins/fullcalendar/fullcalendar.css')}}">
	<link rel="stylesheet" href="{{asset('css/plugins/fullcalendar/fullcalendar.print.css')}}" media="print">
	<!-- chosen -->
	<link rel="stylesheet" href="{{asset('css/plugins/chosen/chosen.css')}}">
	<!-- select2 -->
	<link rel="stylesheet" href="{{asset('css/plugins/select2/select2.css')}}">
	<!-- icheck -->
	<link rel="stylesheet" href="{{asset('css/plugins/icheck/all.css')}}">
	<!-- Theme CSS -->
	<link rel="stylesheet" href="{{asset('css/style.css')}}">
	<!-- Color CSS -->
	<link rel="stylesheet" href="{{asset('css/themes.css')}}">

	<link rel="{{asset('apple-touch-icon-precomposed')}}" href="{{asset('img/apple-touch-icon-precomposed.png')}}" />

    <link rel="stylesheet" href="{{asset('css/main.css')}}">

	<!-- jQuery -->
	<script src="{{asset('js/jquery.min.js')}}"></script>


	<!-- Nice Scroll -->
	{{-- <script src="js/plugins/nicescroll/jquery.nicescroll.min.js"></script> --}}
	<!-- jQuery UI -->
	<script src="{{asset('js/plugins/jquery-ui/jquery-ui.js')}}"></script>
	<!-- Touch enable for jquery UI -->
	<script src="{{asset('js/plugins/touch-punch/jquery.touch-punch.min.js')}}"></script>
	<!-- slimScroll -->
	<script src="{{asset('js/plugins/slimscroll/jquery.slimscroll.min.js')}}"></script>
	<!-- Bootstrap -->
	<script src="{{asset('js/bootstrap.min.js')}}"></script>
	<!-- vmap -->
	<script src="{{asset('js/plugins/vmap/jquery.vmap.min.js')}}"></script>
	<script src="{{asset('js/plugins/vmap/jquery.vmap.world.js')}}"></script>
	<script src="{{asset('js/plugins/vmap/jquery.vmap.sampledata.js')}}"></script>
	<!-- Bootbox -->
	<script src="{{asset('js/plugins/bootbox/jquery.bootbox.js')}}"></script>
	<!-- Flot -->
	<script src="{{asset('js/plugins/flot/jquery.flot.min.js')}}"></script>
	<script src="{{asset('js/plugins/flot/jquery.flot.bar.order.min.js')}}"></script>
	<script src="{{asset('js/plugins/flot/jquery.flot.pie.min.js')}}"></script>
	<script src="{{asset('js/plugins/flot/jquery.flot.resize.min.js')}}"></script>
	<!-- imagesLoaded -->
	<script src="{{asset('js/plugins/imagesLoaded/jquery.imagesloaded.min.js')}}"></script>
	<!-- PageGuide -->
	<script src="{{asset('js/plugins/pageguide/jquery.pageguide.js')}}"></script>
	<!-- FullCalendar -->
	<script src="{{asset('js/plugins/fullcalendar/moment.min.js')}}"></script>
	<script src="{{asset('js/plugins/fullcalendar/fullcalendar.min.js')}}"></script>
	<!-- Chosen -->
	<script src="{{asset('js/plugins/chosen/chosen.jquery.min.js')}}"></script>
	<!-- select2 -->
	<script src="{{asset('js/plugins/select2/select2.min.js')}}"></script>
	<!-- icheck -->
	<script src="{{asset('js/plugins/icheck/jquery.icheck.min.js')}}"></script>

	<!-- Theme framework -->
	<script src="{{asset('js/eakroko.min.js')}}"></script>
	<!-- Theme scripts -->
	<script src="{{asset('js/application.min.js')}}"></script>
	<!-- Just for demonstration -->
	<script src="{{asset('js/demonstration.min.js')}}"></script>

	<!--[if lte IE 9]>
		<script src="js/plugins/placeholder/jquery.placeholder.min.js"></script>
		<script>
			$(document).ready(function() {
				$('input, textarea').placeholder();
			});
		</script>
		<![endif]-->

	<!-- Favicon -->
	<link rel="shortcut icon" href="{{asset('img/favicon.ico')}}" />
	<!-- Apple devices Homescreen icon -->

	<!-- New DataTables -->
	<script src="{{asset('js/plugins/momentjs/jquery.moment.min.js')}}"></script>
	<script src="{{asset('js/plugins/momentjs/moment-range.min.js')}}"></script>
	<script src="{{asset('js/plugins/datatables/jquery.dataTables.min.js')}}"></script>
	<script src="{{asset('js/plugins/datatables/extensions/dataTables.tableTools.min.js')}}"></script>
	<script src="{{asset('js/plugins/datatables/extensions/dataTables.colReorder.min.js')}}"></script>
	<script src="{{asset('js/plugins/datatables/extensions/dataTables.colVis.min.js')}}"></script>
	<script src="{{asset('js/plugins/datatables/extensions/dataTables.scroller.min.js')}}"></script>
</head>

<body>
    <div id="app">
			{{-- NAVBAR --}}
			<div id="navigation">
				<div class="container-fluid">
					<x-navbar.logo/>
					<ul class='main-nav'>
						<x-navbar.menu-item route="home" title="Dashboard"/>
						@if (auth()->user()->profile->profile_name === 'admin')

							<x-navbar.menu-item route="users" title="Usuários"/>

						@endif

						<x-navbar.menu-item-dropdown route="home" title="Req. Compras"/>
						<x-navbar.menu-item-dropdown route="home" title="Cotações"/>

						@if (auth()->user()->profile->profile_name === 'admin')

							<x-navbar.menu-item-dropdown route="home" title="Ordens de Compra"/>
							<x-navbar.menu-item-dropdown route="home" title="Integração Sênior"/>

						@endif
					</ul>
					<x-navbar.user>
						<x-navbar.notification/>
					</x-navbar.user>
				</div>
			</div>

            <div id="main-content-container">
                <div id="main">
                    <div class="container">
                        <div class="page-header">
                            {{ $title }}
                        </div>
						
						<x-alert/>

                        {{ $slot }}

                    </div>
                </div>
            </div>
		</div>
    </div>
</body>

</html>
