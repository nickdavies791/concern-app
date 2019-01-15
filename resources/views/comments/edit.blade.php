@extends('layouts.argon')

@section('content')

    <div class="row">
        <div class="col-xl-12">
            @component('partials.cards.card')
                @slot('title') Edit Comment @endslot
                @slot('body')
                    <div class="card-body">
                        @include('partials.errors.errors')
                        <form method="POST" action="{{ route('comments.update', ['id' => $comment->id]) }}">
                            @csrf
                            @method('PATCH')
                            <input type="hidden" value="{{ $comment->concern_id }}" name="concern">
                            <div class="form-group">
                                <label>Comment</label>
                                <textarea name="body" class="form-control">{{ $comment->body }}</textarea>
                            </div>
                            <div class="form-group">
                                <label>Action Taken</label>
                                <textarea name="action_taken" class="form-control">{{ $comment->action_taken }}</textarea>
                            </div>
                            <button type="submit" class="btn btn-primary btn-lg">Save Comment</button>
                        </form>
                    </div>
                @endslot
            @endcomponent
        </div>
    </div>

@endsection
