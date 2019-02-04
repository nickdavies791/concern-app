@extends('layouts.argon')

@section('content')
    @push('charts')
        {!! $concernsByMonthBreakdown->script() !!}
        {!! $totalConcernsByTag->script() !!}
    @endpush
    <div class="row">
        <div class="col-xl-8">
            @component('partials.cards.card-chart')
                @slot('title') Concerns by Month Breakdown @endslot
                @slot('body')
                    <div class="p-3">
                        {!! $concernsByMonthBreakdown->container() !!}
                    </div>
                @endslot
            @endcomponent
            @component('partials.cards.card')
                @slot('title') Latest Unresolved Concerns @endslot
                @slot('body')
                    @include('concerns.partials.latest_unresolved')
                @endslot
            @endcomponent
        </div>
        <div class="col-xl-4">
            @component('partials.cards.card-chart')
                @slot('title') Total Concerns By Tag @endslot
                @slot('body')
                    <div class="p-3">
                        {!! $totalConcernsByTag->container() !!}
                    </div>
                @endslot
            @endcomponent
        </div>
    </div>
@endsection
