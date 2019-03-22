@extends('layouts.argon')

@section('content')
<div class="row">
    <div class="col-xl-10 col-lg-12 mx-auto">
        <div class="card bg-secondary shadow">
            <div class="card-header bg-transparent border-0">
                <h2 class="mb-0">Import Concern Tags</h2>
            </div>
            <div class="card-body col-10 mx-auto">
                <div class="mb-4">
                    <p class="mb-2 font-weight-bold">
                        Tags are categories that can be associated with concerns. For example, a concern may have a tag
                        called 'Cyber-bullying'
                        which signifies the concern is related to cyber-bullying. Importing these tags will make it
                        easier for staff to categorise
                        concerns appropriately.
                    </p>
                    <p class="mb-2 font-weight-bold">
                        To import tags, first download the template, this contains the fields required to import tags
                        successfully into this app.
                        Fill out these fields and re-upload the document to the form below and click submit.
                    </p>
                </div>
                <a class="btn btn-sm btn-primary mb-3" href="#">Download
                    template</a>
                <form method="POST" action="{{ route('tag.import') }}" enctype="multipart/form-data">
                    @csrf
                    <div style="font-size: 14px" class="custom-file form-control-alternative">
                        <input name="tag-import" type="file" class="custom-file-input form-control form-control-alternative">
                        <label class="custom-file-label border-0">Select</label>
                    </div>
                    <div class="col-xl-12 text-center">
                        <button class="btn btn-primary mt-2" type="submit">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection 