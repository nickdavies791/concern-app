@extends('layouts.argon')

@section('content')

    <div class="row">
        <div class="col-xl-10 mx-auto">
            @component('partials.cards.card')
                @slot('title') Concerns Shared With Me @endslot
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

@endsection
