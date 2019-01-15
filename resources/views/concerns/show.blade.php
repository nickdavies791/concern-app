@extends('layouts.argon')

@section('content')
    <div class="row">
        <div class="col-xl-8">
            @component('partials.cards.card')
                @slot('title')
                    #{{ $concern->id }} - {{ $concern->title }}
                    <div class="float-right text-muted">
                        <button disabled class="btn btn-sm {{$concern->resolved_on ? 'btn-success' : 'btn-danger'}}">
                            {{$concern->resolved_on ? 'RESOLVED' : 'UNRESOLVED'}}
                        </button>
                        <a href="{{ route('concerns.edit', ['id' => $concern->id]) }}" class="btn btn-sm btn-primary">
                            Edit
                        </a>
                    </div>
                    <small class="d-block text-muted">{{$concern->concern_date}}</small>
                @endslot
                @slot('body')
                    <div class="card-body">
                        <div class="row">
                            <div class="col-xl-9">
                                <div class="mb-3">
                                    <h3 class="mb-0">Concern Details</h3>
                                    <small class="text-muted d-block mb-2">
                                        Occurred on -
                                        {{ $concern->concern_date }}
                                    </small>
                                    <small>{{ $concern->body }}</small>
                                </div>

                            </div>
                            <div class="col-xl-3">
                                <div class="mb-3">
                                    <h3 class="mb-2">Groups Notified</h3>
                                    <div class="d-flex align-items-center flex-wrap">
                                        @forelse ($concern->groups as $group)
                                            <button disabled class="btn btn-sm btn-primary mr-2 mb-1">
                                                {{$group->name}}
                                            </button>
                                        @empty
                                            <small>No groups notified.</small>
                                        @endforelse
                                    </div>

                                </div>
                                <h3>Students Involved</h3>
                                <ul class="list-unstyled">
                                    @foreach($concern->students as $student)
                                        <li>
                                            <small>
                                                <a href="{{route("students.show", ['id' => $student->student_id])}}">
                                                    {{ $student->forename }} {{ $student->surname }} (Year {{ $student->year_group }})
                                                </a>
                                            </small>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                @endslot
            @endcomponent
        </div>
        <div class="col-xl-4">
            @component('partials.cards.card')
                @slot('title')Attachments @endslot
                @slot('body')
                    <ul class="list-group list-group-flush">
                        @foreach($concern->attachments as $attachment)
                            <li class="list-group-item d-flex align-items-center justify-content-between">
                                <small>
                                    <a target="_blank" href="{{ asset('storage/'.$attachment->file_name) }}">
                                        {{ $attachment->file_name }}
                                    </a>
                                </small>
                                <small class="text-muted">
                                    {{$attachment->created_at->diffForHumans()}}
                                </small>
                            </li>
                        @endforeach
                    </ul>
                @endslot
            @endcomponent
        </div>
    </div>
    <div class="row mt-4">
        <div class="col-xl-12">
            <h2 class="">Comments -
                <button class="btn btn-sm btn-primary">New comment</button>
            </h2>
            <ul class="comments mt-3">
                @forelse($concern->comments as $comment)
                    <li class="bg-white shadow mb-3">
                        <h4>{{ $comment->user->name }} on {{ $comment->posted_at }}</h4>
                        <small>{{ $comment->body }}</small><br>
                        <small>{{ $comment->action_taken }}</small>
                    </li>
                    <li class="bg-white shadow mb-2">
                        <h4>{{ $comment->user->name }} on {{ $comment->posted_at }}</h4>
                        <small>{{ $comment->body }}</small><br>
                        <small>{{ $comment->action_taken }}</small>
                    </li>
                @empty
                    <li class="bg-white shadow mb-3 text-center">There are no comments for this concern.</li>
                @endforelse
            </ul>
        </div>
    </div>

@endsection
