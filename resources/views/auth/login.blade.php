<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />

	<title>GECOM - Login</title>

    <!-- Favicon -->
	<link rel="shortcut icon" href="{{asset('img/gecom/favicon.png')}}" />

	<!-- Bootstrap -->
	<link rel="stylesheet" href="css/bootstrap.min.css">
	<!-- Theme CSS -->
	<link rel="stylesheet" href="css/style.css">
	<!-- Bootstrap -->
	<script src="js/bootstrap.min.js"></script>
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
