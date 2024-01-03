<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests">
   
    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Favicon -->
    <link rel="shortcut icon" href="{{ asset('img/gecom/favicon.png') }}" />

    @vite([
        'resources/css/app.css',
        'resources/js/app.js',
    ])

    @stack('styles')
</head>

<body>
    <div id="app">
        <x-navbar.navigation/>
        <x-navbar.environment-info/>
        <x-modals.alert/>

        <div id="main">
            <div class="container-fluid">
                <x-breadcrumb />
                <x-alert />
                {{ $slot }}
            </div>
        </div>
    </div>

    @stack('scripts')
</body>

</html>
