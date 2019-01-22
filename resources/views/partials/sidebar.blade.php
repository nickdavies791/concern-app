<!-- Sidenav -->
<nav class="navbar navbar-vertical fixed-left navbar-expand-md navbar-light bg-white" id="sidenav-main">
    <div class="container-fluid">
        <!-- Toggler -->
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#sidenav-collapse-main" aria-controls="sidenav-main" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <!-- Brand -->
        <a class="navbar-brand pt-0" href="{{ route('home') }}">
            <img src="{{ asset('images/clpt-logo.svg') }}" class="navbar-brand-img" alt="...">
        </a>
        <!-- Collapse -->
        <div class="collapse navbar-collapse" id="sidenav-collapse-main">
            <!-- Collapse header -->
            <div class="navbar-collapse-header d-md-none">
                <div class="row">
                    <div class="col-6 collapse-brand">
                        <a href="{{ route('home') }}">
                            <img src="{{ asset('images/clpt-logo.svg') }}">
                        </a>
                    </div>
                    <div class="col-6 collapse-close">
                        <button type="button" class="navbar-toggler" data-toggle="collapse" data-target="#sidenav-collapse-main" aria-controls="sidenav-main" aria-expanded="false" aria-label="Toggle sidenav">
                            <span></span>
                            <span></span>
                        </button>
                    </div>
                </div>
            </div>
            <!-- Form -->
            <form class="mt-4 mb-3 d-md-none">
                <div class="input-group input-group-rounded input-group-merge">
                    <input type="search" class="form-control form-control-rounded form-control-prepended" placeholder="Search" aria-label="Search">
                    <div class="input-group-prepend">
                        <div class="input-group-text">
                            <span class="fa fa-search"></span>
                        </div>
                    </div>
                </div>
            </form>
            <h6 class="navbar-heading text-muted">Home</h6>
            <!-- Navigation -->
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('home') }}">
                        <i class="ni ni-tv-2 text-primary"></i> Dashboard
                    </a>
                </li>
            </ul>
            <ul class="navbar-nav mb-md-3">
                @can('view-all', App\Concern::class)
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('concerns.index') }}">
                            <i class="ni ni-single-copy-04 text-primary"></i> View All Concerns
                        </a>
                    </li>
                @endcan
                @can('view-own', App\Concern::class)
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('user.concerns') }}">
                            <i class="ni ni-circle-08 text-primary"></i> View My Concerns
                        </a>
                    </li>
                @endcan
                @can('create', App\Concern::class)
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('concerns.create') }}">
                            <i class="ni ni-collection text-primary"></i> Report a Concern
                        </a>
                    </li>
                @endcan
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('policies.index') }}">
                        <i class="ni ni-paper-diploma text-primary"></i> Policies
                    </a>
                </li>
                @admin
                    <li class="nav-item">
                        <a class="nav-link" href="{{route('settings')}}">
                            <i class="ni ni-settings text-primary"></i> Settings
                        </a>
                    </li>
                @endadmin
            </ul>
            @can('view-all', App\Concern::class)
                <!-- Divider -->
                <hr class="my-3">
                <!-- Heading -->
                <h6 class="navbar-heading text-muted">Reports</h6>
                <!-- Navigation -->
                <ul class="navbar-nav mb-md-3">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('reports.index') }}">
                            <i class="ni ni-chart-pie-35 text-red"></i> View Reports
                        </a>
                    </li>
                </ul>
            @endcan

            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="mt-3 btn btn-outline-primary btn-block">Sign out</button>
            </form>

        </div>
    </div>
</nav>
