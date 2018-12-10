@extends('layouts.argon')

@section('content')

    <!-- Sidebar -->
    @include('partials.sidebar')

    <!-- Main content -->
    <div class="main-content">
        @include('partials.navbar')
        @include('partials.header-blank')

        <div class="container-fluid mt--7">
            <div class="row">
                <div class="col-xl-12">
                    @component('partials.cards.card')
                        @slot('title') Concerns @endslot
                        @slot('body')
                            <table class="table align-items-center table-flush">
                                <thead class="thead-light">
                                <tr>
                                    <th scope="col">Identifier</th>
                                    <th scope="col">Summary</th>
                                    <th scope="col">Students</th>
                                    <th scope="col">Reported on</th>
                                    <th scope="col">Reported by</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($concerns as $concern)
                                    <tr>
                                        <td>
                                            {{ $concern->id }}
                                        </td>
                                        <td>
                                            <a href="{{ route('concerns.show', ['concern' => $concern->id]) }}">{{ $concern->title }}</a>
                                        </td>
                                        <td>
                                            @foreach($concern->students as $student)
                                                {{ $student->forename }} {{ $student->surname }} (Year {{ $student->year_group }})<br/>
                                            @endforeach
                                        </td>
                                        <td>
                                            {{ $concern->reported_at }}
                                        </td>
                                        <td>
                                            {{ $concern->user->name }}
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                            <div class="mx-3 ml-auto">
                                {{ $concerns->links() }}
                            </div>
                        @endslot
                    @endcomponent
                </div>
            </div>
            @include('partials.footer')
        </div>
    </div>

@endsection
