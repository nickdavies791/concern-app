@extends('layouts.argon')

@section('content')
    @section('content')

        <!-- Sidebar -->
        @include('partials.sidebar')

        <!-- Main content -->
        <div id="test" class="main-content">
            @include('partials.navbar')
            @include('partials.header')
            <div class="container-fluid mt--7">
                <div class="row">
                    <div class="col-xl-10 mx-auto">
                        <div class="card bg-secondary shadow">
                            <div class="card-header bg-white border-0">
                                <div class="row align-items-center">
                                    <div class="col-8">
                                        <h3 class="mb-0">Settings Page</h3>
                                    </div>
                                    <div class="col-4 text-right">
                                        <a class="btn btn-sm btn-primary text-white">Settings</a>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                @if(auth()->user()->role_id === 3)
                                    <h6 class="heading-small text-muted mb-4">Sync data with Sims</h6>
                                    <div class="pl-lg-4">
                                        <label class="form-control-label mb-3">
                                            Authorise this app with your schools SIMS -
                                            <a class="text-primary" data-toggle="modal" data-target="#syncHelp">Confused?</a>
                                        </label>
                                        <div class="row ml-0 mb-3">
                                            <a href="{{route('authorise-assembly')}}" class="text-white btn btn-success mr-2">
                                                Authorise
                                            </a>
                                        </div>
                                        <label class="form-control-label mb-3">
                                            Here you can sync your student and staff data with you schools SIMS
                                        </label>
                                        <div class="row ml-0">
                                            <a :disabled="loading" v-on:click="loading = true" href="{{route('syncStudents')}}" class="text-white btn btn-default mr-2">
                                                <i  v-if="loading" class="fas fa-2x fa-spinner fa-spin"></i>
                                                <span v-else>Sync Students</span>
                                            </a>
                                            <a :disabled="loadingStaff" v-on:click="loadingStaff = true" href="{{route('syncStaff')}}" class="text-white btn btn-primary ml-2">
                                                <i  v-if="loadingStaff" class="fas fa-2x fa-spinner fa-spin"></i>
                                                <span v-else>Sync Staff</span>
                                            </a>
                                        </div>
                                    </div>
                                    <hr class="my-4">
                                @endif
                                <h6 class="heading-small text-muted mb-4">My Policies</h6>
                                <div class="pl-lg-4">
                                    <table class="table align-items-center table-flush">
                                        <thead class="thead-light">
                                            <tr>
                                                <th scope="col">Policy Name</th>
                                                <th scope="col">Read</th>
                                                <th scope="col">Read on</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <th scope="row">
                                                    Safeguarding Policy
                                                </th>
                                                <td>
                                                    <button disabled type="button" class="btn btn-sm btn-success">Read</button>
                                                </td>
                                                <td>
                                                    Tuesday 11th December 2018
                                                </td>
                                            </tr>
                                            <tr>
                                                <th scope="row">
                                                    LAC Policy
                                                </th>
                                                <td>
                                                    <button disabled type="button" class="btn btn-sm btn-danger">Unread</button>
                                                </td>
                                                <td>
                                                    -
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @include('partials.footer')
            </div>
        </div>

    @endsection
@endsection
