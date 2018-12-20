@extends('layouts.argon')

@section('content')
    <div class="row">
        <div class="col-xl-12 mx-auto">
            <div class="card bg-secondary shadow">
                <div class="card-header bg-white border-0">
                    <div class="row align-items-center">
                        <div class="col-8">
                            <h3 class="mb-0">Policies</h3>
                        </div>
                        <div class="col-4 text-right">
                            <a class="btn btn-sm btn-primary text-white">Policies</a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <h6 class="heading-small text-muted mb-4">
                        My Policies
                        <span class="float-right">
                            <a href="{{route('policies.create')}}" class="btn btn-sm btn-primary text-white">New Policy</a>
                        </span>
                    </h6>
                    <div class="pl-lg-4">
                        <policy-table></policy-table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
