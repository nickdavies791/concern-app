@extends('layouts.argon')

@section('content')
    <div class="row">
        <div class="col-xl-10 mx-auto">
            <div class="card bg-secondary shadow">
                <div class="card-header bg-white border-0">
                    <div class="row align-items-center">
                        <div class="col-8">
                            <h3 class="mb-0">Documents</h3>
                        </div>
                        <div class="col-4 text-right">
                            <a class="btn btn-sm btn-primary text-white">Documents</a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <h6 class="heading-small text-muted mb-4">
                        My Documents
                        <span class="float-right">
                            <a href="{{ route('documents.create') }}" class="btn btn-sm btn-primary text-white">New Document</a>
                        </span>
                    </h6>
                    <div class="pl-lg-4">
                        <document-table></document-table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
