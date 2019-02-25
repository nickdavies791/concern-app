@extends('layouts.argon')

@section('content')
    <div class="row">
        <div class="col-xl-6">
           <div class="card card-profile shadow">
                <div class="row justify-content-center">
                    <div class="col-lg-3 order-lg-2">
                        <div class="card-profile-image">
                            <a href="#">
                                <img src="{{ route('storage', ['folder' => 'students', 'filename' => $student->mis_id.'.jpg']) }}" class="rounded-circle">
                            </a>
                        </div>
                    </div>
                </div>
                <div class="card-header text-center border-0 pt-8 pt-md-4 pb-0 pb-md-4">
                    <div class="d-flex justify-content-start">
                        <a href="#" class="btn btn-sm btn-primary mr-4">Year {{ $student->year_group }}</a>
                    </div>
                </div>
                <div class="card-body pt-0 pt-md-4">
                    <div class="row">
                        <div class="col">
                            <div class="text-center  mt-md-5">
                                <h3>
                                    {{ $student->full_name }}<span class="font-weight-light">, Year {{ $student->year_group }}</span>
                                </h3>
                                @if($student->sen_category)
                                    <p>SEN Category: {{ $student->sen_category }}</p>
                                @endif
                                @if($student->ever_in_care)
                                    <p><span data-toggle="popover" data-trigger="hover" data-placement="right" data-content="Indicates whether a student is either currently 'looked after' or has been in the past">Ever in care:</span> {{ $student->ever_in_care ? 'Yes' : 'No' }}</p>
                                @endif
                                @if($student->siblings)
                                    @foreach($student->siblings as $sibling)
                                        <a class="d-block" href="{{ route('students.show', ['id' => $sibling->id]) }}">{{ $sibling->full_name }} - Year {{ $sibling->year_group }}</a>
                                    @endforeach
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-6">
            @component('partials.cards.card-chart')
                @slot('title') Attendance {{ $student->attendance->start_date }} - {{ $student->attendance->end_date }} @endslot
                @slot('body')
                    <chart type="pie" :datasets="{{ $attendance }}"></chart>
                @endslot
            @endcomponent
         </div>
    </div>
    <div class="row">
        <div class="col-xl-6">
            @component('partials.cards.card')
                @slot('title') Exclusions @endslot
                @slot('body')
                    <table class="table align-items-center table-flush table-responsive">
                        <thead class="thead-light">
                            <th>Exclusion Type</th>
                            <th>Reason Given</th>
                            <th>Start Date</th>
                            <th>End Date</th>
                            <th>Exclusion Length</th>
                        </thead>
                        <tbody>
                            @foreach($student->exclusions as $exclusion)
                                <tr>
                                    <td>{{ $exclusion->type }}</td>
                                    <td>{{ $exclusion->reason }}</td>
                                    <td>{{ $exclusion->start_date }}</td>
                                    <td>{{ $exclusion->end_date }}</td>
                                    <td>{{ $exclusion->length }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @endslot
            @endcomponent
        </div>
        <div class="col-xl-6">
            @component('partials.cards.card')
                @slot('title') Concerns @endslot
                @slot('body')
                    <table class="table align-items-center table-flush table-responsive">
                        <thead class="thead-light">
                        <tr>
                            <th scope="col">Summary</th>
                            <th scope="col">Tagged</th>
                            <th scope="col">Logged by</th>
                            <th scope="col">Logged on</th>
                            <th scope="col">Resolved</th>
                            <th scope="col">Groups</th>
                        </tr>
                        </thead>
                        <tbody>
                            @foreach ($student->concerns as $concern)
                                <tr>
                                    <td>
                                        <a href="{{ route("concerns.show", ['id' => $concern->id]) }}">
                                            {{ $concern->type }}
                                        </a>
                                    </td>
                                    <td>
                                        @foreach($concern->tags as $tag)
                                            <span class="badge badge-pill badge-primary">{{ $tag->name }}</span><br />
                                        @endforeach
                                    </td>
                                    <td>{{ $concern->user->name }}</td>
                                    <td>{{ $concern->created_at }}</td>
                                    <td>{{ $concern->resolved_on ? $concern->resolved_on->diffForHumans() : '-' }}</td>
                                    <td>
                                        @foreach($concern->groups as $group)
                                            <button disabled class="btn btn-sm btn-danger">
                                                {{ $group->name }}
                                            </button>
                                        @endforeach
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @endslot
            @endcomponent
        </div>
    </div>
@endsection