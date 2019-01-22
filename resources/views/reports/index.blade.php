@extends('layouts.argon')

{!! $concernsByMonthBreakdown->script() !!}
{!! $totalConcernsByTag->script() !!}

@section('content')
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
