@extends('layouts.argon')

@section('content')
    <div class="row">
        <div class="col-xl-6">
            @component('partials.cards.card-chart')
                @slot('title') Total Concerns By Tag @endslot
                @slot('body')
                    <chart type="horizontalBar" :datasets="{{ $totalConcernsByTag }}"></chart>
                @endslot
            @endcomponent
        </div>
        <div class="col-xl-6">
            @component('partials.cards.card-chart')
                @slot('title') Concerns By Month Breakdown @endslot
                @slot('body')
                    <chart type="line" :datasets="{{ $concernsThisYear }}"></chart>
                @endslot
            @endcomponent
        </div>
    </div>
@endsection
