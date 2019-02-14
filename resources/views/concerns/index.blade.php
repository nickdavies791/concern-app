@extends('layouts.argon')

@section('content')

    <div class="row">
        <div class="col-xl-10 mx-auto">
            @component('partials.cards.card')
                @slot('title') Concerns @endslot
                @slot('body')
                    <table class="table align-items-center table-flush">
                        <thead class="thead-light">
                        <tr>
                            <th scope="col">Summary</th>
                            <th scope="col">Tagged</th>
                            <th scope="col">Students</th>
                            <th scope="col">Logged by</th>
                            <th scope="col">Logged on</th>
                            <th scope="col">Groups</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($concerns as $concern)
                            <tr>
                                <td>
                                    <a href="{{ route('concerns.show', ['concern' => $concern->id]) }}">{{ $concern->type }}</a>
                                </td>
                                <td>
                                    @foreach($concern->tags as $tag)
                                        <span class="badge badge-pill badge-primary">{{ $tag->name }}</span>
                                    @endforeach
                                </td>
                                <td>
                                    @foreach($concern->students as $student)
                                        {{ $student->forename }} {{ $student->surname }} (Year {{ $student->year_group }})<br/>
                                    @endforeach
                                </td>
                                <td>
                                    {{ $concern->user->name }}
                                </td>
                                <td>
                                    {{ $concern->created_at }}
                                </td>
                                <td>
                                    @foreach($concern->groups as $group)
                                        <button disabled class="btn btn-sm btn-danger">
                                            {{ $group->name }}
                                        </button>
                                    @endforeach
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
