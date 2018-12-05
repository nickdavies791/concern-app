@extends('layouts.argon')

@section('content')

    <!-- Sidebar -->
    @include('partials.sidebar')

    <!-- Main content -->
    <div class="main-content">
        @include('partials.navbar')
        @include('partials.header')
        <div class="container-fluid mt--7">
            <div class="row">
                <div class="col-xl-4">
                    @component('partials.cards.card')
                        @slot('title') Student List @endslot
                        @slot('body')
                            <div class="card-body">
                                <p>Students here...</p>
                            </div>
                        @endslot
                    @endcomponent
                </div>
                <div class="col-xl-8">
                    @component('partials.cards.card')
                        @slot('title') Latest Concerns @endslot
                        @slot('body')
                            @include('partials.tables')
                        @endslot
                    @endcomponent
                </div>
            </div>
            @include('partials.footer')
        </div>
    </div>

@endsection