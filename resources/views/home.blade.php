@extends('layouts.argon')

@section('content')
    @adminOrSafeguarding
    <div class="row">
        <div class="col-xl-6">
            @component('partials.cards.card-chart')
                @slot('title') Total # Concerns By Tag @endslot
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
    @endadminOrSafeguarding
    @staff
    <div class="row">
        <div class="col-xl-8">
            @component('partials.cards.card')
                @slot('title') School Details @endslot
                @slot('body')
                    <div class="card-body">
                        <p>School info here...</p>
                    </div>
                @endslot
            @endcomponent
        </div>
        <div class="col-xl-4">
            @component('partials.cards.card')
                @slot('title') Actions @endslot
                @slot('body')
                    <div class="card-body">
                        <a href="{{ route('concerns.create') }}" class="btn btn-icon btn-3 btn-danger" type="button">
                            <span class="btn-inner--icon"><i class="ni ni-chat-round"></i></span>
                            <span class="btn-inner--text">Report a Concern</span>
                        </a>
                        <a href="{{ route('documents.index') }}" class="btn btn-icon btn-3 btn-primary" type="button">
                            <span class="btn-inner--icon"><i class="ni ni-books"></i></span>
                            <span class="btn-inner--text">View Policies</span>
                        </a>
                    </div>
                @endslot
            @endcomponent
        </div>
    </div>
    @endstaff
@endsection
