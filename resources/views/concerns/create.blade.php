@extends('layouts.argon')

@section('content')

    <div class="row">
        <div class="col-xl-10 mx-auto">
            @component('partials.cards.card')
                @slot('title') Create a Concern @endslot
                @slot('body')
                    <div class="card-body">
                        @include('partials.errors.errors')
                        <form method="POST" action="{{ route('concerns.store') }}">
                            @csrf
                            <div class="form-group">
                                <label>Find a Student</label>
                                <student-select></student-select>
                            </div>
                            <div class="form-group">
                                <label>Concern Summary</label>
                                <input type="text" name="title" class="form-control" placeholder="Provide a brief summary">
                            </div>
                            <div class="form-group">
                                <label>Details</label>
                                <textarea name="body" class="form-control" placeholder="Include the details of the concern"></textarea>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Date of Concern</label>
                                        <datetime type="datetime" v-model="datetime" name="concern_date" input-id="concern_date" input-class="form-control" placeholder="Provide a date"></datetime>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Assign a tag</label>
                                        <tag-select></tag-select>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <a href="#" class="text-primary" data-toggle="modal" data-target="#body-map">Include a Body Map</a>
                                <input type="hidden" id="url" name="image" value="">
                            </div>
                            <div class="form-group">
                                <label>Notify Group(s)</label>
                                <group-select></group-select>
                            </div>
                            <button type="submit" class="btn btn-primary btn-lg">Save Concern</button>
                        </form>
                    </div>
                @endslot
            @endcomponent
        </div>
    </div>
@endsection
