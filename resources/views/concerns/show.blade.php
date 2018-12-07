@extends('layouts.argon')

@section('content')

    <!-- Sidebar -->
    @include('partials.sidebar')

    <!-- Main content -->
    <div class="main-content">
        @include('partials.navbar')
        @include('partials.header-blank')

        <div class="container-fluid mt--7">
            <div class="row">
                <div class="col-xl-12">
                    @component('partials.cards.card')
                        @slot('title') Concern #{{ $concern->id }} - {{ $concern->title }} @endslot
                        @slot('body')
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-xl-4">
                                        <h3>Date Reported</h3>
                                        <p>{{ $concern->reported_at }}</p>
                                    </div>
                                    <div class="col-xl-4">
                                        <h3>Student</h3>
                                        <p>
                                            @foreach($concern->students as $student)
                                                {{ $student->forename }} {{ $student->surname }} (Year {{ $student->year_group }})<br>
                                            @endforeach
                                        </p>
                                    </div>
                                    <div class="col-xl-4">
                                        <h3>Reported By</h3>
                                        <p>{{ $concern->user->name }}</p>
                                    </div>
                                </div>
                            </div>
                        @endslot
                    @endcomponent
                    @component('partials.cards.card')
                        @slot('title') Comments @endslot
                        @slot('body')
                            <table class="table">
                                @forelse($concern->comments as $comment)
                                    <tr>
                                        <td>{{ $comment->created_at }}</td>
                                        <td>{{ $comment->comment }}</td>
                                    </tr>
                                @empty
                                    <p>There are no comments for this concern.</p>
                                @endforelse
                            </table>
                        @endslot
                    @endcomponent
                </div>
            </div>
            @include('partials.footer')
        </div>
    </div>

@endsection