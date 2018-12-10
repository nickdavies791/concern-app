<table class="table align-items-center table-flush">
    <thead class="thead-light">
    <tr>
        <th scope="col">Identifier</th>
        <th scope="col">Concern Summary</th>
        <th scope="col">Reported on</th>
    </tr>
    </thead>
    <tbody>
    @foreach($concerns as $concern)
        <tr>
            <td>{{ $concern->id }}</td>
            <td>{{ $concern->title }}</td>
            <td>{{ $concern->reported_at }}</td>
        </tr>
    @endforeach
    </tbody>
</table>