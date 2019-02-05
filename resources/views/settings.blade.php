@extends('layouts.argon')

@section('content')
    <div class="row">
        <div class="col-xl-10 mx-auto">
            <div class="card bg-secondary shadow">
                <div class="card-header bg-white border-0">
                    <div class="row align-items-center">
                        <div class="col-8">
                            <h3 class="mb-0">Authorise with SIMS</h3>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    @include('partials.errors.errors')
                    @admin
                    <div class="mb-4">
                        <h6 class="heading-small text-muted mb-3">Sync data with Sims</h6>
                        <div class="pl-lg-4">
                            <label class="form-control-label mb-3">
                                Authorise this app with your schools SIMS -
                                <a class="text-primary" data-toggle="modal" data-target="#syncHelp">Confused?</a>
                            </label>
                            <div class="row ml-0 mb-3">
                                @tokenExists
                                    <button data-toggle="popover" data-placement="right" data-trigger="hover" data-content="Looks like you have already authorised this app to fetch the latest data from SIMS." class="text-white btn btn-primary mr-2" disabled>Authorise</button>
                                @else
                                    <a href="{{route('authorise-assembly')}}" class="text-white btn btn-primary mr-2">
                                        Authorise
                                    </a>
                                @endtokenExists
                            </div>
                            <label class="form-control-label mb-3">
                                Sync your SIMS data by choosing the options below.
                            </label>
                            <div class="row ml-0">
                                @tokenExists
                                    <a :disabled="loading" v-on:click="loading = true" href="{{route('syncStudents')}}" class="text-white btn btn-primary mr-2">
                                        <i  v-if="loading" class="fas fa-2x fa-spinner fa-spin"></i>
                                        <span v-else>Sync Students</span>
                                    </a>
                                    <a :disabled="loadingStaff" v-on:click="loadingStaff = true" href="{{route('syncStaff')}}" class="text-white btn btn-primary ml-2">
                                        <i  v-if="loadingStaff" class="fas fa-2x fa-spinner fa-spin"></i>
                                        <span v-else>Sync Staff</span>
                                    </a>
                                @else
                                    <button data-toggle="popover" data-placement="right" data-trigger="hover" data-content="Please authorise the app with your SIMS first by clicking Authorise." class="text-white btn btn-primary mr-2" disabled>Sync Students</button>
                                    <button data-toggle="popover" data-placement="right" data-trigger="hover" data-content="Please authorise the app with your SIMS first by clicking Authorise." class="text-white btn btn-primary mr-2" disabled>Sync Staff</button>
                                @endtokenExists
                            </div>
                        </div>
                    </div>
                    @endadmin
                    @can('create', App\Tag::class)
                        <div class="mb-4">
                            <h6 class="heading-small text-muted mb-3">Create Tags</h6>
                            <div class="pl-lg-4">
                                <form action="{{ route('tags.store') }}" method="POST">
                                    @csrf
                                    <input data-toggle="popover" data-trigger="focus" data-content="Provide a unique tag name. The tag must be no more than 30 characters in length." required maxlength="30" type="text" name="tag" class="form-control" placeholder="Enter a tag name">
                                    <button type="submit" class="d-none"></button>
                                </form>
                            </div>
                        </div>
                    @endcan
                    @can(['create','update','delete'], App\User::class)
                        <div class="mb-4">
                            <h6 class="heading-small text-muted mb-3">Export/Import Staff</h6>
                            <div class="pl-lg-4">
                                <form method="POST" action="{{ route('staff.import') }}" enctype="multipart/form-data">
                                    @csrf
                                    <label class="form-control-label mb-3">
                                        <a class="text-primary" href="{{ route('staff.export') }}">Export Staff</a>
                                    </label>
                                    <div style="font-size: 14px" class="custom-file form-control-alternative">
                                        <input name="import" type="file" class="custom-file-input form-control form-control-alternative">
                                        <label class="custom-file-label border-0">Select</label>
                                        <button class="btn btn-primary mt-2" type="submit">Submit</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    @endcan
                </div>
            </div>
        </div>
    </div>
@endsection
