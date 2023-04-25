<!doctype html>
<html lang="pt-br">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

	<link rel="stylesheet" href="{{ asset('css/main.css') }}">

	<!-- Bootstrap -->
	<link rel="stylesheet" href="{{asset('css/bootstrap.min.css')}}">
	<!-- jQuery UI -->
	<link rel="stylesheet" href="{{asset('css/plugins/jquery-ui/jquery-ui.min.css')}}">
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
	{{-- <link rel="shortcut icon" href="img/favicon.ico" /> --}}
	<!-- Apple devices Homescreen icon -->
	<link rel="{{asset('apple-touch-icon-precomposed')}}" href="img/apple-touch-icon-precomposed.png" />

    <link rel="stylesheet" href="{{asset('css/main.css')}}">
</head>
<body>
    <div id="app">
			<div id="navigation">
				<div class="container-fluid">
					<a href="/" id="brand">GECOM</a>
					<ul class='main-nav'>
						<li>
							<a href="">
								<span>Dashboard</span>
							</a>
						</li>
						@if (auth()->user()->profile->profile_name === 'admin')
							<li>
								<a href="{{ route('register') }}">
									<span>Usuários</span>
								</a>
							</li>
						@endif
						<li>
							<a href="#" data-toggle="dropdown" class='dropdown-toggle'>
								<span>Req. Compras</span>
								<span class="caret"></span>
							</a>
							<ul class="dropdown-menu">
								<li>
									<a href=""> --- </a>
								</li>
							</ul>
						</li>
						<li>
							<a href="#" data-toggle="dropdown" class='dropdown-toggle'>
								<span>Cotações</span>
								<span class="caret"></span>
							</a>
							<ul class="dropdown-menu">
								<li>
									<a href=""> --- </a>
								</li>
							</ul>
						</li>
						@if (auth()->user()->profile->profile_name === 'admin')
						<li>
							<a href="#" data-toggle="dropdown" class='dropdown-toggle'>
								<span>Ordens de Compra</span>
								<span class="caret"></span>
							</a>
							<ul class="dropdown-menu">
								<li>
									<a href=""> --- </a>
								</li>
							</ul>
						</li>
						<li>
							<a href="#" data-toggle="dropdown" class='dropdown-toggle'>
								<span>Integração Sênior</span>
								<span class="caret"></span>
							</a>
							<ul class="dropdown-menu">
								<li>
									<a href=""> --- </a>
								</li>
							</ul>
						</li>
					@endif
					</ul>
					<div class="user">
						<ul class="icon-nav">
							<li class='dropdown'>
								<a href="#" class='dropdown-toggle' data-toggle="dropdown">
									<i class="fa fa-bell"></i>
									<span class="label label-lightred">4</span>
								</a>
								<ul class="dropdown-menu pull-right message-ul">
									<li>
										<a href="#">
											Notificação Número 1
										</a>
									</li>
									<li>
										<a href="#">
											Notificação Número 2
										</a>
									</li>
									<li>
										<a href="components-messages.html" class='more-messages'>Todas as notificações
											<i class="fa fa-arrow-right"></i>
										</a>
									</li>
								</ul>
							</li>
						</ul>
						<div class="dropdown">
							<a href="#" class='dropdown-toggle' data-toggle="dropdown"> 
								{{ auth()->user()->person->name }} |
								Perfil: {{ auth()->user()->profile->profile_name }}
								<img src="img/demo/default-user.png" alt="" width="30"> 
							</a>
							<ul class="dropdown-menu pull-right">
								<li>
									<a href="#">Configurações da conta</a>
								</li>
								<li>
									<a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault();document.getElementById('logout-form').submit();">
									 	{{ __('Sair') }}
								 	</a>
								 <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">@csrf</form>
								</li>
							</ul>
						</div>
					</div>
				</div>
			</div>
			<div id="main-content-container">
				<div id="main">
					<div class="container">
						<div class="page-header">
							<div>
								<h1 class="pull-left">@yield('title') </h1>
							</div>
						</div>
						<main class="py-4">
							@yield('content')
						</main>
					</div>
				</div>
			</div>
		</div>
    </div>
</body>

</html>
