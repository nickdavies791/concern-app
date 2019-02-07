@extends('layouts.argon')
@section('content')
    <div class="row">
        <div class="col-xl-10 mx-auto">
            @component('partials.cards.card')
                @slot('title') Reports @endslot
                @slot('body')
                    <p></p>
                @endslot
            @endcomponent
        </div>
    </div>
@endsection
