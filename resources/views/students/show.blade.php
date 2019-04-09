@extends('layouts.argon')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-7">
                @component('partials.cards.card')
                    @slot('title') {{ $student->full_name }}, Year {{ $student->year_group }} @endslot
                    @slot('body')
                        <div class="card-body">
                            <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active" id="pills-details-tab" data-toggle="pill" href="#pills-details" role="tab" aria-controls="pills-details" aria-selected="true">Student Details</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="pills-concerns-tab" data-toggle="pill" href="#pills-concerns" role="tab" aria-controls="pills-concerns" aria-selected="false">Concerns</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="pills-exclusions-tab" data-toggle="pill" href="#pills-exclusions" role="tab" aria-controls="pills-exclusions" aria-selected="false">Exclusions</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="pills-siblings-tab" data-toggle="pill" href="#pills-siblings" role="tab" aria-controls="pills-siblings" aria-selected="false">Siblings</a>
                                </li>
                            </ul>
                            <div class="tab-content" id="pills-tabContent">
                                <div class="tab-pane fade show active table-responsive" id="pills-details" role="tabpanel" aria-labelledby="pills-details-tab">
                                    <table class="table table-bordered">
                                        <tr>
                                            <td rowspan="5" width="150">
                                                <img src="{{ asset('/storage/students/'.$student->mis_id.'.jpg') }}">
                                            </td>
                                            <th>Admission Number</th>
                                            <td>{{ $student->admission_number }}</td>
                                        </tr>
                                        <tr>
                                            <th>UPN</th>
                                            <td>{{ $student->upn }}</td>
                                        </tr>
                                        <tr>
                                            <th>Year Group</th>
                                            <td>Year {{ $student->year_group }}</td>
                                        </tr>
                                        <tr>
                                            <th>Date of Birth</th>
                                            <td>{{ $student->birth_date }}</td>
                                        </tr>
                                        @if($student->ever_in_care)
                                            <tr>
                                                <th>Ever in care</th>
                                                <td>{{ $student->ever_in_care }}</td>
                                            </tr>
                                        @endif
                                        @if($student->sen_category)
                                            <tr>
                                                <th>SEN Category</th>
                                                <td>{{ $student->sen_category }}</td>
                                            </tr>
                                        @endif
                                    </table>
                                </div>
                                <div class="tab-pane fade table-responsive" id="pills-concerns" role="tabpanel" aria-labelledby="pills-concerns-tab">
                                    @if($student->concerns->count() > 0)
                                        <table class="table table-bordered mb-3">
                                            <thead class="thead-light">
                                            <tr>
                                                <th scope="col">Summary</th>
                                                <th scope="col">Tagged</th>
                                                <th scope="col">Reported by</th>
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
                                                        <td>{{ $concern->user->name }} on {{ $concern->created_at }}</td>
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
                                    @else
                                        <p>No concerns reported for this student.</p>
                                    @endif
                                </div>
                                <div class="tab-pane fade table-responsive" id="pills-exclusions" role="tabpanel" aria-labelledby="pills-exclusions-tab">
                                    @if($student->exclusions->count() > 0)
                                        <table class="table table-bordered mb-3">
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
                                    @else
                                        <p>No exclusions for this student.</p>
                                    @endif
                                </div>
                                <div class="tab-pane fade table-responsive" id="pills-siblings" role="tabpanel" aria-labelledby="pills-siblings-tab">
                                @if($student->siblings)
                                    @foreach($student->siblings as $sibling)
                                        <a class="d-block" href="{{ route('students.show', ['id' => $sibling->id]) }}">{{ $sibling->full_name }} - Year {{ $sibling->year_group }}</a>
                                    @endforeach
                                @endif
                                </div>
                            </div>
                        </div>
                    @endslot
                @endcomponent
            </div>
            <div class="col-md-5">
                @component('partials.cards.card-chart')
                    @slot('title') Attendance {{ $student->attendance->start_date }} - {{ $student->attendance->end_date }} @endslot
                    @slot('body')
                        <div class="card-body">
                            <chart type="pie" :datasets="{{ $attendance }}"></chart>
                        </div>
                    @endslot
                @endcomponent
            </div>
        </div>
    </div>
@endsection