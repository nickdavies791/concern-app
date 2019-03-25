@extends('layouts.argon')

@section('content')
    <div class="row">
        <div class="col-xl-8">
            @component('partials.cards.card')
                @slot('title')
                    {{ $concern->type }}
                    <div class="float-right text-muted">
                        <button disabled class="btn btn-sm {{ $concern->resolved_on ? 'btn-success' : 'btn-danger' }}">
                            {{ $concern->resolved_on ? 'RESOLVED' : 'UNRESOLVED' }}
                        </button>
                        @can('update', $concern)
                            <a href="{{ route('concerns.edit', ['id' => $concern->id]) }}" class="btn btn-sm btn-primary">
                                Edit
                            </a>
                        @endcan
                        @can('delete', $concern)
                            <form class="d-inline" method="POST" action="{{ route('concerns.delete', ['id' => $concern->id]) }}">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-sm btn-primary">Delete</button>
                            </form>
                        @endcan
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
                                <h3>Tagged As</h3>
                                <ul class="list-unstyled">
                                    <div class="d-flex align-items-center flex-wrap">
                                        @forelse ($concern->tags as $tag)
                                            <button disabled class="btn btn-sm btn-primary mr-2 mb-1">
                                                {{ $tag->name }}
                                            </button>
                                        @empty
                                            <small>No tags added.</small>
                                        @endforelse
                                    </div>
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
                <a href="{{ route('comments.create', ['id' => $concern->id]) }}" class="btn btn-sm btn-primary">New Comment</a>
            </h2>
            <ul class="comments mt-3">
                @forelse($concern->comments as $comment)
                    <li class="bg-white shadow mb-3">
                        <div class="mb-3 float-right">
                            @can('update', $comment)
                                <a href="{{ route('comments.edit', ['id' => $comment->id]) }}" class="btn btn-sm btn-primary">
                                    Edit
                                </a>
                            @endcan
                            @can('delete', $comment)
                                <form class="d-inline" method="POST" action="{{ route('comments.delete', ['id' => $comment->id]) }}">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-primary">Delete</button>
                                </form>
                            @endcan
                        </div>
                        <h4>{{ $comment->user->name }} on {{ $comment->posted_at }}</h4>
                        <small>{{ $comment->body }}</small><br>
                    </li>
                @empty
                    <li class="bg-white shadow mb-3 text-center">There are no comments for this concern.</li>
                @endforelse
            </ul>
        </div>
    </div>

@endsection
