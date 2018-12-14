@extends('layouts.argon')

@section('content')
    <div class="row">
        <div class="col-xl-12">
            @component('partials.cards.card')
                @slot('title') Concern #{{ $concern->id }} - {{ $concern->title }} @endslot
                @slot('body')
                    <div class="card-body">
                        <div class="row">
                            <div class="col-xl-3">
                                <h3>Date of Concern</h3>
                                <small>{{ $concern->concern_date }}</small>
                            </div>
                            <div class="col-xl-3">
                                <h3>Date Reported</h3>
                                <small>{{ $concern->reported_at }}</small>
                            </div>
                            <div class="col-xl-3">
                                <h3>Students</h3>
                                <p>
                                    @foreach($concern->students as $student)
                                        <small>{{ $student->forename }} {{ $student->surname }} (Year {{ $student->year_group }})</small>
                                    @endforeach
                                </p>
                            </div>
                            <div class="col-xl-3">
                                <h3>Reported By</h3>
                                <small>{{ $concern->user->name }}</small>
                            </div>
                        </div>
                    </div>
                @endslot
            @endcomponent
        </div>
    </div>
    <div class="row mt-3">
        <div class="col-xl-12">
            @component('partials.cards.card')
                @slot('title') Comments @endslot
                @slot('body')
                    <div class="card-body">


                        <ul class="comments">
                            @forelse($concern->comments as $comment)
                                <li>
                                    <h4>{{ $comment->user->name }} on {{ $comment->posted_at }}</h4>
                                    <small>{{ $comment->body }}</small><br>
                                    <small>{{ $comment->action_taken }}</small>
                                </li>
                            @empty
                                <li>There are no comments for this concern.</li>
                            @endforelse
                        </ul>


                    </div>
                @endslot
            @endcomponent
        </div>
    </div>

@endsection