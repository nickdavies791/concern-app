@extends('layouts.argon')

@section('content')
    <div class="row">
        <div class="col-xl-10 mx-auto">
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
                    <h6 class="heading-small text-muted">Add a new policy</h6>
                    @include('partials.errors.errors')
                    <div class="pl-lg-4 mt-3">
                        <form action="{{url('policies')}}" method="post" enctype="multipart/form-data">
                            {{ csrf_field() }}
                            <div class="row">
                                <div class="col-md-12">
                                    <label class="form-control-label mb-3">
                                        Policy name
                                    </label>
                                    <div class="form-group">
                                        <input required autocomplete="off" name="name" type="text" class="form-control form-control-alternative" placeholder="Policy name">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <label class="form-control-label mb-3">
                                        Who's allowed access?
                                        <a class="text-primary" data-toggle="modal" data-target="#groupHelp">Confused?</a>
                                    </label>
                                    <div class="form-group">
                                        <group-select></group-select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-control-label mb-3">
                                            Choose your policy
                                        </label>
                                        <div style="font-size: 14px" class="custom-file form-control-alternative">
                                            <input name="file_path" type="file" class="custom-file-input form-control form-control-alternative">
                                            <label class="custom-file-label border-0" for="customFile">Select</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 mx-auto text-center">
                                    <button type="submit" class="btn btn-primary">Upload</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
