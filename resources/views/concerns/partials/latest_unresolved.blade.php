<table class="table align-items-center table-flush">
    <thead class="thead-light">
    <tr>
        <th scope="col">Concern Summary</th>
        <th scope="col">Reported on</th>
        <th scope="col">Reported by</th>
    </tr>
    </thead>
    <tbody>
    @foreach($concerns as $concern)
        <tr>
            <td><a href="{{ route('concerns.show', ['id' => $concern->id]) }}">{{ $concern->title }}</a></td>
            <td>{{ $concern->created_at }}</td>
            <td>{{ $concern->user->name }}</td>
        </tr>
    @endforeach
    </tbody>
</table>
