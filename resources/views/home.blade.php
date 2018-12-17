@extends('layouts.argon')

@section('content')
    @include('partials.alerts.alert-success')
    <div class="row">
        <div class="col-xl-8">
        @component('partials.cards.card')
            @slot('title') Latest Unresolved Concerns @endslot
            @slot('body')
                    @include('concerns.partials.latest_unresolved')
                @endslot
            @endcomponent
        </div>
        <div class="col-xl-4">
            @component('partials.cards.card')
                @slot('title') Actions @endslot
                @slot('body')
                    <div class="card-body">
                        <a href="{{ route('concerns.create') }}" class="btn btn-lg btn-danger">Report a Concern</a>
                        <a href="{{ route('comments.create') }}" class="btn btn-lg btn-primary">Update a Concern</a>
                    </div>
                @endslot
            @endcomponent
        </div>
    </div>
@endsection
