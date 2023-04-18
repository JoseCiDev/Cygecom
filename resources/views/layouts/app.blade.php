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
	<link rel="stylesheet" href="css/bootstrap.min.css">
	<!-- jQuery UI -->
	<link rel="stylesheet" href="css/plugins/jquery-ui/jquery-ui.min.css">
	<!-- PageGuide -->
	<link rel="stylesheet" href="css/plugins/pageguide/pageguide.css">
	<!-- Fullcalendar -->
	<link rel="stylesheet" href="css/plugins/fullcalendar/fullcalendar.css">
	<link rel="stylesheet" href="css/plugins/fullcalendar/fullcalendar.print.css" media="print">
	<!-- chosen -->
	<link rel="stylesheet" href="css/plugins/chosen/chosen.css">
	<!-- select2 -->
	<link rel="stylesheet" href="css/plugins/select2/select2.css">
	<!-- icheck -->
	<link rel="stylesheet" href="css/plugins/icheck/all.css">
	<!-- Theme CSS -->
	<link rel="stylesheet" href="css/style.css">
	<!-- Color CSS -->
	<link rel="stylesheet" href="css/themes.css">

	<!-- jQuery -->
	<script src="js/jquery.min.js"></script>


	<!-- Nice Scroll -->
	<script src="js/plugins/nicescroll/jquery.nicescroll.min.js"></script>
	<!-- jQuery UI -->
	<script src="js/plugins/jquery-ui/jquery-ui.js"></script>
	<!-- Touch enable for jquery UI -->
	<script src="js/plugins/touch-punch/jquery.touch-punch.min.js"></script>
	<!-- slimScroll -->
	<script src="js/plugins/slimscroll/jquery.slimscroll.min.js"></script>
	<!-- Bootstrap -->
	<script src="js/bootstrap.min.js"></script>
	<!-- vmap -->
	<script src="js/plugins/vmap/jquery.vmap.min.js"></script>
	<script src="js/plugins/vmap/jquery.vmap.world.js"></script>
	<script src="js/plugins/vmap/jquery.vmap.sampledata.js"></script>
	<!-- Bootbox -->
	<script src="js/plugins/bootbox/jquery.bootbox.js"></script>
	<!-- Flot -->
	<script src="js/plugins/flot/jquery.flot.min.js"></script>
	<script src="js/plugins/flot/jquery.flot.bar.order.min.js"></script>
	<script src="js/plugins/flot/jquery.flot.pie.min.js"></script>
	<script src="js/plugins/flot/jquery.flot.resize.min.js"></script>
	<!-- imagesLoaded -->
	<script src="js/plugins/imagesLoaded/jquery.imagesloaded.min.js"></script>
	<!-- PageGuide -->
	<script src="js/plugins/pageguide/jquery.pageguide.js"></script>
	<!-- FullCalendar -->
	<script src="js/plugins/fullcalendar/moment.min.js"></script>
	<script src="js/plugins/fullcalendar/fullcalendar.min.js"></script>
	<!-- Chosen -->
	<script src="js/plugins/chosen/chosen.jquery.min.js"></script>
	<!-- select2 -->
	<script src="js/plugins/select2/select2.min.js"></script>
	<!-- icheck -->
	<script src="js/plugins/icheck/jquery.icheck.min.js"></script>

	<!-- Theme framework -->
	<script src="js/eakroko.min.js"></script>
	<!-- Theme scripts -->
	<script src="js/application.min.js"></script>
	<!-- Just for demonstration -->
	<script src="js/demonstration.min.js"></script>

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
	<link rel="apple-touch-icon-precomposed" href="img/apple-touch-icon-precomposed.png" />

    <link rel="stylesheet" href="{{asset('css/main.css')}}">
</head>
<body>
    <div id="app">
        <div>
			<div id="navigation">
				<div class="container-fluid">
					<a href="#" id="brand">GECOM</a>
					<a href="#" class="toggle-nav" rel="tooltip" data-placement="bottom" title="Toggle navigation">
						<i class="fa fa-bars"></i>
					</a>
					<ul class='main-nav'>
						<li>
							<a href="index-2.html">
								<span>Painel</span>
							</a>
						</li>
						@if (auth()->user()->profile->profile_name === 'admin')
							<li>
								<a href="#" data-toggle="dropdown" class='dropdown-toggle'>
									<span>Cadastro</span>
									<span class="caret"></span>
								</a>
								<ul class="dropdown-menu">
									<li>
										<a href="{{ route('register') }}">Registrar usuário</a>
									</li>
								</ul>
							</li>
						@endif
					</ul>
					<div class="user">
						<ul class="icon-nav">
							<li class='dropdown'>
								<a href="#" class='dropdown-toggle' data-toggle="dropdown">
									<i class="fa fa-envelope"></i>
									<span class="label label-lightred">4</span>
								</a>
								<ul class="dropdown-menu pull-right message-ul">
									<li>
										<a href="#">
											<img src="img/demo/user-1.jpg" alt="">
											<div class="details">
												<div class="name">Jane Doe</div>
												<div class="message">
													Lorem ipsum Commodo quis nisi ...
												</div>
											</div>
										</a>
									</li>
									<li>
										<a href="#">
											<img src="img/demo/user-2.jpg" alt="">
											<div class="details">
												<div class="name">John Doe</div>
												<div class="message">
													Ut ad laboris est anim ut ...
												</div>
											</div>
											<div class="count">
												<i class="fa fa-comment"></i>
												<span>3</span>
											</div>
										</a>
									</li>
									<li>
										<a href="#">
											<img src="img/demo/user-3.jpg" alt="">
											<div class="details">
												<div class="name">Bob Doe</div>
												<div class="message">
													Excepteur Duis magna dolor!
												</div>
											</div>
										</a>
									</li>
									<li>
										<a href="components-messages.html" class='more-messages'>Go to Message center
											<i class="fa fa-arrow-right"></i>
										</a>
									</li>
								</ul>
							</li>
		
							<li class="dropdown sett">
								<a href="#" class='dropdown-toggle' data-toggle="dropdown">
									<i class="fa fa-cog"></i>
								</a>
								<ul class="dropdown-menu pull-right theme-settings">
									<li>
										<span>Layout-width</span>
										<div class="version-toggle">
											<a href="#" class='set-fixed'>Fixed</a>
											<a href="#" class="active set-fluid">Fluid</a>
										</div>
									</li>
									<li>
										<span>Topbar</span>
										<div class="topbar-toggle">
											<a href="#" class='set-topbar-fixed'>Fixed</a>
											<a href="#" class="active set-topbar-default">Default</a>
										</div>
									</li>
									<li>
										<span>Sidebar</span>
										<div class="sidebar-toggle">
											<a href="#" class='set-sidebar-fixed'>Fixed</a>
											<a href="#" class="active set-sidebar-default">Default</a>
										</div>
									</li>
								</ul>
							</li>
						</ul>
						<div class="dropdown">
							<a href="#" class='dropdown-toggle' data-toggle="dropdown"> 
								{{ auth()->user()->person->name }} |
								Perfil: {{ auth()->user()->profile->profile_name }}
								<img src="img/demo/user-avatar.jpg" alt="">
							</a>
							<ul class="dropdown-menu pull-right">
								<li>
									<a href="more-userprofile.html">Edit profile</a>
								</li>
								<li>
									<a href="#">Account settings</a>
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
			<div class="container-fluid" id="content">
				<div id="left">
					<form action="http://www.eakroko.de/flat/search-results.html" method="GET" class='search-form'>
						<div class="search-pane">
							<input type="text" name="search" placeholder="Search here...">
							<button type="submit">
								<i class="fa fa-search"></i>
							</button>
						</div>
					</form>
					<div class="subnav">
						<div class="subnav-title">
							<a href="#" class='toggle-subnav'>
								<i class="fa fa-angle-down"></i>
								<span>Content</span>
							</a>
						</div>
						<ul class="subnav-menu">
							<li class='dropdown'>
								<a href="#" data-toggle="dropdown">Articles</a>
								<ul class="dropdown-menu">
									<li>
										<a href="#">Action #1</a>
									</li>
									<li>
										<a href="#">Antoher Link</a>
									</li>
									<li class='dropdown-submenu'>
										<a href="#" data-toggle="dropdown" class='dropdown-toggle'>Go to level 3</a>
										<ul class="dropdown-menu">
											<li>
												<a href="#">This is level 3</a>
											</li>
											<li>
												<a href="#">Unlimited levels</a>
											</li>
											<li>
												<a href="#">Easy to use</a>
											</li>
										</ul>
									</li>
								</ul>
							</li>
							<li>
								<a href="#">News</a>
							</li>
							<li>
								<a href="#">Pages</a>
							</li>
							<li>
								<a href="#">Comments</a>
							</li>
						</ul>
					</div>
					<div class="subnav">
						<div class="subnav-title">
							<a href="#" class='toggle-subnav'>
								<i class="fa fa-angle-down"></i>
								<span>Plugins</span>
							</a>
						</div>
						<ul class="subnav-menu">
							<li>
								<a href="#">Cache manager</a>
							</li>
							<li class='dropdown'>
								<a href="#" data-toggle="dropdown">Import manager</a>
								<ul class="dropdown-menu">
									<li>
										<a href="#">Action #1</a>
									</li>
									<li>
										<a href="#">Antoher Link</a>
									</li>
									<li class='dropdown-submenu'>
										<a href="#" data-toggle="dropdown" class='dropdown-toggle'>Go to level 3</a>
										<ul class="dropdown-menu">
											<li>
												<a href="#">This is level 3</a>
											</li>
											<li>
												<a href="#">Unlimited levels</a>
											</li>
											<li>
												<a href="#">Easy to use</a>
											</li>
										</ul>
									</li>
								</ul>
							</li>
							<li>
								<a href="#">Contact form generator</a>
							</li>
							<li>
								<a href="#">SEO optimization</a>
							</li>
						</ul>
					</div>
					<div class="subnav">
						<div class="subnav-title">
							<a href="#" class='toggle-subnav'>
								<i class="fa fa-angle-down"></i>
								<span>Settings</span>
							</a>
						</div>
						<ul class="subnav-menu">
							<li>
								<a href="#">Theme settings</a>
							</li>
							<li class='dropdown'>
								<a href="#" data-toggle="dropdown">Page settings</a>
								<ul class="dropdown-menu">
									<li>
										<a href="#">Action #1</a>
									</li>
									<li>
										<a href="#">Antoher Link</a>
									</li>
									<li class='dropdown-submenu'>
										<a href="#" data-toggle="dropdown" class='dropdown-toggle'>Go to level 3</a>
										<ul class="dropdown-menu">
											<li>
												<a href="#">This is level 3</a>
											</li>
											<li>
												<a href="#">Unlimited levels</a>
											</li>
											<li>
												<a href="#">Easy to use</a>
											</li>
										</ul>
									</li>
								</ul>
							</li>
							<li>
								<a href="#">Security settings</a>
							</li>
						</ul>
					</div>
					<div class="subnav subnav-hidden">
						<div class="subnav-title">
							<a href="#" class='toggle-subnav'>
								<i class="fa fa-angle-right"></i>
								<span>Default hidden</span>
							</a>
						</div>
						<ul class="subnav-menu">
							<li>
								<a href="#">Menu</a>
							</li>
							<li class='dropdown'>
								<a href="#" data-toggle="dropdown">With submenu</a>
								<ul class="dropdown-menu">
									<li>
										<a href="#">Action #1</a>
									</li>
									<li>
										<a href="#">Antoher Link</a>
									</li>
									<li class='dropdown-submenu'>
										<a href="#" data-toggle="dropdown" class='dropdown-toggle'>More stuff</a>
										<ul class="dropdown-menu">
											<li>
												<a href="#">This is level 3</a>
											</li>
											<li>
												<a href="#">Easy to use</a>
											</li>
										</ul>
									</li>
								</ul>
							</li>
							<li>
								<a href="#">Security settings</a>
							</li>
						</ul>
					</div>
				</div>
				<div id="main">
					<div class="container-fluid">
						{{-- <div class="breadcrumbs">
							<ul>
								<li>
									<a href="">Home</a>
									<i class="fa fa-angle-right"></i>
								</li>
								<li>
									<a href="">Components</a>
									<i class="fa fa-angle-right"></i>
								</li>
								<li>
									<a href="">Bootstrap elements</a>
								</li>
							</ul>
							<div class="close-bread">
								<a href="#">
									<i class="fa fa-times"></i>
								</a>
							</div>
						</div> --}}
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
