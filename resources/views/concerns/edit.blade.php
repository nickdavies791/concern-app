@extends('layouts.argon')

@section('content')

    <div class="row">
        <div class="col-xl-12">
            @component('partials.cards.card')
                @slot('title') Edit Concern @endslot
                @slot('body')
                    <div class="card-body">
                        @include('partials.errors.errors')
                        <form method="POST" action="{{ route('concerns.update', ['id' => $concern->id]) }}">
                            @csrf
                            @method('PATCH')
                            <div class="form-group">
                                <label>Concern Summary</label>
                                <input value="{{ $concern->title }}" type="text" name="title" class="form-control" placeholder="Provide a brief summary">
                            </div>
                            <div class="form-group">
                                <label>Details</label>
                                <textarea name="body" class="form-control" placeholder="Include the details of the concern">{{ $concern->body }}</textarea>
                            </div>
                            <button type="submit" class="btn btn-primary btn-lg">Save Concern</button>
                        </form>
                    </div>
                @endslot
            @endcomponent
        </div>
    </div>
@endsection
