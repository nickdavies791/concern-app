@extends('layouts.argon')

@section('content')

    <div class="row">
        <div class="col-xl-12">
            @component('partials.cards.card')
                @slot('title') Create a Concern @endslot
                @slot('body')
                    <div class="card-body">
                        @include('partials.errors.errors')
                        <form method="POST" action="{{ route('concerns.store') }}">
                            @csrf
                            <div class="form-group">
                                <label>Concern Summary</label>
                                <input type="text" name="title" class="form-control" placeholder="Provide a brief summary">
                            </div>
                            <div class="form-group">
                                <label>Find a Student</label>
                                <select name="student" class="form-control">
                                    @foreach($students as $student)
                                        <option value="{{ $student->id }}">{{ $student->forename . ' ' . $student->surname }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <a href="#" class="text-primary" data-toggle="modal" data-target="#body-map">Include a Body Map</a>
                                <input type="hidden" id="url" name="url" value="">
                            </div>
                            <div class="form-group">
                                <label>Notify Group</label>
                                <select name="group" class="form-control">
                                    @foreach($groups as $group)
                                        <option value="{{ $group->id }}">{{ $group->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <button type="submit" class="btn btn-primary btn-lg">Save Concern</button>
                        </form>
                    </div>
                @endslot
            @endcomponent
        </div>
    </div>
@endsection
