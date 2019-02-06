@extends('layouts.argon')

@section('content')
    <div class="row">
        <div class="col-xl-6">
            <div class="chart chart-light">
                <chart type="bar" :data="{{ $totalConcernsByTag }}"></chart>
            </div>
        </div>
    </div>
@endsection
