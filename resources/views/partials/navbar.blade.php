<!-- Top navbar -->
<nav class="navbar navbar-top navbar-expand-md navbar-dark" id="navbar-main">
    <div class="container-fluid d-flex justify-content-between align-items-start mt-2">
        <div class="">
            <a class="h4 mb-0 text-white text-uppercase" href="{{ route('home') }}">Dashboard</a>
        </div>
        <form method="POST" action="{{ route('search') }}" class="navbar-search navbar-search-dark form-inline mr-3 d-none d-md-flex ml-lg-auto">
            @csrf
            <div class="form-group mb-0">
                <div class="input-group input-group-alternative">
                    <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fas fa-search"></i></span>
                    </div>
                    <input class="form-control" name="query" placeholder="Search" type="text" required>
                </div>
            </div>
        </form>
    </div>
</nav>
