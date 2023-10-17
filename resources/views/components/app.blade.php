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

    @vite([
        'resources/css/app.css',
        'resources/js/app.js',

        'node_modules/bootstrap/dist/js/bootstrap.min.js', // Bootstrap v3.2.0 - incompatível com ES6
        'node_modules/select2/select2.js', // select2 v3.5.1 - incompatível com ES6

        'public/js/plugins/validation/jquery.validate.min.js', // v1.13.1
        'public/js/plugins/validation/additional-methods.min.js' // v1.13.1,
    ])

    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.9.3/html2pdf.bundle.min.js"></script>

    @stack('styles')
</head>

<body>
    <div id="app">
        <x-navbar.navigation/>
        <x-navbar.environment-info/>

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
