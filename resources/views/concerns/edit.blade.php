@extends('layouts.argon')

@section('content')

    <div class="row">
        <div class="col-xl-12">
            @component('partials.cards.card')
                @slot('title') Edit Concern @endslot
                @slot('body')
                    <div class="card-body">
                        @include('partials.errors.errors')
                    </div>
                @endslot
            @endcomponent
        </div>
    </div>
@endsection
