@extends('layouts.argon')

@section('content')
    <div class="row">
        <div class="col-lg-8">
            <div class="card shadow">
                <div class="card-header bg-transparent">
                    <div class="row align-items-center">
                        <div class="col">
                            <h2 class="mb-0">{{$student->forename . ' ' . $student->surname}}</h2>
                        </div>
                    </div>
                </div>

                <table class="table align-items-center table-flush">
                    <thead class="thead-light">
                    <tr>
                        <th scope="col">Summary</th>
                        <th scope="col">Logged by</th>
                        <th scope="col">Logged on</th>
                        <th scope="col">Resolved</th>
                    </tr>
                    </thead>
                    <tbody>
                        @foreach ($student->concerns as $concern)
                            <tr>
                                <td>
                                    <a href="{{route("concerns.show", ['id' => $concern->id])}}">
                                        {{$concern->title}}
                                    </a>
                                </td>
                                <td>{{$concern->user->name}}</td>
                                <td>{{$concern->created_at->format('jS F Y')}}</td>
                                <td>{{$concern->resolved_on ? $concern->resolved_on->diffForHumans() : '-' }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="card card-profile shadow">
                <div class="row justify-content-center">
                    <div class="col-lg-3 order-lg-2">
                        <div class="card-profile-image">
                            <a href="#">
                                <img src="/images/student-icon.svg" class="rounded-circle">
                            </a>
                        </div>
                    </div>
                </div>
                <div class="card-header text-center border-0 pt-8 pt-md-4 pb-0 pb-md-4">
                    <div class="d-flex justify-content-start">
                        <a href="#" class="btn btn-sm btn-primary mr-4">Year {{$student->year_group}}</a>
                    </div>
                </div>
                <div class="card-body pt-0 pt-md-4">
                    <div class="row">
                        <div class="col">
                            <div class="text-center  mt-md-5">
                                <h3>
                                    {{$student->forename . ' ' . $student->surname}}<span class="font-weight-light">, Year {{$student->year_group}}</span>
                                </h3>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>


@endsection