<!-- Top navbar -->
<nav class="navbar navbar-top navbar-expand-md navbar-dark" id="navbar-main">
    <div class="container-fluid d-flex justify-content-between align-items-start mt-2">
        <div class="">
            <a class="h4 mb-0 text-white text-uppercase" href="{{ route('home') }}">Dashboard</a>
        </div>
        @include('partials.search')
    </div>
</nav>
