<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" ></script>
    <script src="{{ asset('js/argon.min.js') }}" ></script>
    <script src="{{ asset('vendor/sweetalert/sweetalert.all.js') }}" ></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="https://fonts.gstatic.com">
      <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet">
      <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css" integrity="sha384-B4dIYHKNBt8Bc12p+WXckhzcICo0wtJAoU8YZTY5qE0Id1GSseTk6S+L3BlXeVIU" crossorigin="anonymous">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('fonts/nucleo/nucleo.css') }}" rel="stylesheet">
</head>
<body>
    <div id="app">
        <main class="app-wrapper">
            @yield('content')
        </main>
    </div>
    @include('sweetalert::alert')
    @include('partials.modals.sync-help')
    @include('partials.modals.body-map')
    <script defer="defer" src="{{ asset('js/body-map.js') }}"></script>
</body>
</html>
