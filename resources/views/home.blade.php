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
    @else
    <div class="row">
        <div class="col-xl-8">
            @component('partials.cards.card')
                @slot('title') School Details @endslot
                @slot('body')
                    <div class="card-body">
                        <table class="table align-items-center table-flush">
                            <tbody>
                                <tr>
                                    <th>Headteacher</th>
                                    <td>{{ $school->headteacher }}</td>
                                </tr>
                                <tr>
                                    <th>School</th>
                                    <td>{{ $school->name }}</td>
                                </tr>
                                <tr>
                                    <th>URN</th>
                                    <td>{{ $school->urn }}</td>
                                </tr>
                                <tr>
                                    <th>Address</th>
                                    <td>{{ $school->street }}, {{ $school->town }}, {{ $school->postcode }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                @endslot
            @endcomponent
        </div>
        <div class="col-xl-4">
            @component('partials.cards.card')
                @slot('title') Actions @endslot
                @slot('body')
                    <div class="card-body">
                        @can('create', App\Concern::class)
                            <a href="{{ route('concerns.create') }}" class="btn btn-icon btn-3 btn-danger" type="button">
                                <span class="btn-inner--icon"><i class="ni ni-chat-round"></i></span>
                                <span class="btn-inner--text">Report a Concern</span>
                            </a>
                        @endcan
                        <a href="{{ route('documents.index') }}" class="btn btn-icon btn-3 btn-primary" type="button">
                            <span class="btn-inner--icon"><i class="ni ni-books"></i></span>
                            <span class="btn-inner--text">View Policies</span>
                        </a>
                    </div>
                @endslot
            @endcomponent
        </div>
    </div>
    @endadminOrSafeguarding
@endsection
