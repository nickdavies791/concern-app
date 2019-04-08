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
                                <div style="font-size: 14px" class="custom-file form-control-alternative">
                                    <input name="attachment" type="file" class="custom-file-input form-control form-control-alternative">
                                    <label class="custom-file-label border-0">Select</label>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary btn-lg">Save File</button>
                        </form>
                    </div>
                @endslot
            @endcomponent
        </div>
    </div>
@endsection
