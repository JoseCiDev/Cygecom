<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
	<!-- Apple devices fullscreen -->
	<meta name="apple-mobile-web-app-capable" content="yes" />
	<!-- Apple devices fullscreen -->
	<meta names="apple-mobile-web-app-status-bar-style" content="black-translucent" />

	<title>GECOM - Login</title>

	<!-- Bootstrap -->
	<link rel="stylesheet" href="css/bootstrap.min.css">
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
	<!-- Validation -->
	<script src="js/plugins/validation/jquery.validate.min.js"></script>
	<script src="js/plugins/validation/additional-methods.min.js"></script>
	<!-- icheck -->
	<script src="js/plugins/icheck/jquery.icheck.min.js"></script>
	<!-- Bootstrap -->
	<script src="js/bootstrap.min.js"></script>
	<script src="js/eakroko.js"></script>

	<!--[if lte IE 9]>
		<script src="js/plugins/placeholder/jquery.placeholder.min.js"></script>
		<script>
			$(document).ready(function() {
				$('input, textarea').placeholder();
			});
		</script>
	<![endif]-->

	<!-- Favicon -->
	<link rel="shortcut icon" href="{{asset('img/gecom/favicon.png')}}" />
	<!-- Apple devices Homescreen icon -->
	{{-- <link rel="apple-touch-icon-precomposed" href="img/apple-touch-icon-precomposed.png" /> --}}

</head>

<style>
	.login .wrapper {
		width: 360px;
	}
	.login-logo{
		margin-bottom: 20px;
		width: 75%;
	}
	#login-form{
		box-sizing: border-box;
		background-color: #FFFFFF;
		border-radius: 4px;
		padding: 10px;
		width: 100%;
	}

	#login-form #btn-login-entrar.btn{
		width: 100%;
		border-radius: 4px!important;
		background-color: #333333;
	}
	#login-form #btn-login-entrar.btn:hover{
		background-color: #cccccc
	}

	.login .wrapper .logo-essentia {
		display:flex;
		justify-content:center;
		margin-top: 60px
	}

</style>

<body class='login theme-grey'>
	<div class="wrapper">
		<img class="login-logo" src="{{asset('img/gecom/logo-login.svg')}}" alt="login-logo-essentia-group">
		<x-alert/>
		<form method="POST" action="{{ route('login') }}" id="login-form">
			@csrf
			<div class="form-group">
				<div class="email controls">
					<input type="email" name='email' data-cy="email" placeholder="Email" class='form-control' @error('email') is-invalid @enderror name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
				</div>
			</div>
			<div class="form-group">
				<div class="pw controls">
					<input type="password" name="password" data-cy="password" placeholder="Senha" class='form-control' @error('password') is-invalid @enderror name="password" required autocomplete="current-password">
				</div>
			</div>
			<div class="submit" style="padding-bottom: 10px;">
				<input type="submit" data-cy="btn-login-entrar" id="btn-login-entrar" value="Entrar" class='btn btn-large btn-primary'>
			</div>
		</form>
        <div class="logo-essentia">
            <img class="essentia-group" src="{{asset('img/gecom/essentia-group.svg')}}" alt="">
        </div>
	</div>
</body>
