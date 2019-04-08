@extends('layouts.argon')

@section('content')

    <div class="row">
        <div class="col-xl-12">
            @component('partials.cards.card')
                @slot('title') Upload an Attachment @endslot
                @slot('body')
                    <div class="card-body">
                        @include('partials.errors.errors')
                        <form method="POST" enctype="multipart/form-data" action="{{ route('attachments.store', ['concern' => $concern]) }}">
                            @csrf
                            <div class="form-group">
                                <label>Add Supporting Files</label>
                                <div class="input-group mb-3">
                                    <div class="custom-file">
                                        <input name="files[]" type="file" multiple class="custom-file-input" id="inputGroupFile02">
                                        <label class="custom-file-label" for="inputGroupFile02">Choose files</label>
                                    </div>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary btn-lg">Save Files</button>
                        </form>
                    </div>
                @endslot
            @endcomponent
        </div>
    </div>
@endsection
