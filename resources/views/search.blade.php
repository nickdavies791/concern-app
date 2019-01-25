@extends('layouts.argon')

@section('content')
    <div class="row">
        <div class="col-xl-10 mx-auto">
            <div class="card bg-secondary shadow">
                <div class="card-header bg-white border-0">
                    <div class="row align-items-center">
                        <div class="col-8">
                            <h3 class="mb-0">Search Results</h3>
                        </div>
                        <div class="col-4 text-right">
                            <a class="btn btn-sm btn-primary text-white">{{ $results->count() }} results</a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    @foreach($results->groupByType() as $type => $modelResults)
                       <h2>{{ ucfirst($type) }}</h2>
                       
                       @foreach($modelResults as $result)
                           <ul class="pl-0">
                                <a href="{{ $result->url }}">{{ $result->title }}</a>
                           </ul>
                       @endforeach
                    @endforeach
                </div>
            </div>
        </div>
    </div>
@endsection
