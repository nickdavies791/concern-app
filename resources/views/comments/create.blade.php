@extends('layouts.argon')

@section('content')

    <div class="row">
        <div class="col-xl-10 mx-auto">
            @component('partials.cards.card')
                @slot('title') Concern {{ Request::get('id') }} - Add Comment @endslot
                @slot('body')
                    <div class="card-body">
                        @include('partials.errors.errors')
                        <form method="POST" action="{{ route('comments.store') }}">
                            @csrf
                            <input name="concern" type="hidden" value="{{ Request::get('id') }}">
                            <div class="form-group">
                                <label>Comment</label>
                                <textarea name="body" class="form-control"></textarea>
                            </div>
                            <div class="form-group">
                                <a href="#" class="text-primary" data-toggle="modal" data-target="#body-map">Include a Body Map</a>
                                <input type="hidden" id="url" name="image" value="">
                            </div>
                            <div class="form-group">
                                <label>Action Taken</label>
                                <textarea name="action_taken" class="form-control"></textarea>
                            </div>
                            <button type="submit" class="btn btn-primary btn-lg">Save Comment</button>
                        </form>
                    </div>
                @endslot
            @endcomponent
        </div>
    </div>

@endsection
