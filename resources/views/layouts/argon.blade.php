<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    @routes

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" ></script>
    <script src="{{ asset('js/argon.min.js') }}"></script>
    <script src="{{ asset('js/Chart.min.js') }}"></script>
    <script src="{{ asset('vendor/sweetalert/sweetalert.all.js') }}" ></script>
    <script src="https://unpkg.com/popper.js@1.14.6/dist/umd/popper.js"></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css" integrity="sha384-B4dIYHKNBt8Bc12p+WXckhzcICo0wtJAoU8YZTY5qE0Id1GSseTk6S+L3BlXeVIU" crossorigin="anonymous">

    <!-- Styles -->
    <link rel="stylesheet" href="https://unpkg.com/vue-multiselect@2.1.0/dist/vue-multiselect.min.css">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('fonts/nucleo/nucleo.css') }}" rel="stylesheet">
</head>
<body>
    <div id="app">
        <main class="app-wrapper">
        <!-- Sidebar -->
        @include('partials.sidebar')

        <!-- Main content -->
            <div class="main-content">
                @include('partials.navbar')
                @include('partials.header')
                <div class="container-fluid mt--7">
                    @component('partials.alerts.alert-success')
                        <strong>Success!</strong> {{ session('alert.success') }}
                    @endcomponent
                    @component('partials.alerts.alert-warning')
                        <strong>Note: </strong> {{ session('alert.warning') }}
                    @endcomponent
                    @component('partials.alerts.alert-danger')
                        <strong>Error!</strong> {{ session('alert.danger') }}
                    @endcomponent
                    @yield('content')
                    @include('partials.footer')
                </div>
            </div>
        </main>
    </div>
    @include('sweetalert::alert')
    @include('partials.modals.sync-help')
    @include('partials.modals.group-help')
    @include('partials.modals.body-map')
    @include('partials.modals.protection')
    <script defer="defer" src="{{ asset('js/body-map.js') }}"></script>
    <script>
        $(function () {
            $('[data-toggle="popover"]').popover()
        });
    </script>
</body>
</html>
