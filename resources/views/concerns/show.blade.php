@extends('layouts.argon')

@section('content')
    <div class="container-fluid">
        @component('partials.cards.card')
            @slot('title') {{ $concern->type }} @endslot
            @slot('body')
                <div class="card-body">
                    <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" id="pills-details-tab" data-toggle="pill" href="#pills-details" role="tab" aria-controls="pills-details" aria-selected="true">Concern Details</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="pills-attachments-tab" data-toggle="pill" href="#pills-attachments" role="tab" aria-controls="pills-attachments" aria-selected="false">Attachments</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="pills-students-tab" data-toggle="pill" href="#pills-students" role="tab" aria-controls="pills-students" aria-selected="false">Students Involved</a>
                        </li>
                    </ul>
                    <div class="tab-content pt-3" id="pills-tabContent">
                        <div class="tab-pane fade show active" id="pills-details" role="tabpanel" aria-labelledby="pills-details-tab">
                            <h4>Logged by {{ $concern->user->name }}</h4>
                            <p>{{ $concern->body }}</p>
                            <div class="mt-3">
                                @forelse($concern->tags as $tag)
                                    <span class="badge badge-pill badge-success">{{ $tag->name }}</span>
                                @empty
                                @endforelse
                            </div>
                        </div>
                        <div class="tab-pane fade" id="pills-attachments" role="tabpanel" aria-labelledby="pills-attachments-tab">
                            <p><a class="btn btn-sm btn-primary" href="{{ route('attachments.create', ['concern' => $concern->id]) }}">+ Add Files</a></p>
                            <ul class="list-unstyled">
                                <table class="table table-bordered">
                                    <thead class="thead-light">
                                        <tr>
                                            <th>Attachment Name</th>
                                            <th>File Type</th>
                                            <th>Upload Date</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($attachments as $attachment)
                                            <tr>
                                                <td>
                                                    <a target="_blank" href="{{ asset('/storage/' . $attachment->id . '/' . $attachment->file_name) }}">{{ $attachment->file_name }}</a>
                                                </td>
                                                <td>
                                                    {{ $attachment->mime_type }}
                                                </td>
                                                <td>
                                                    {{ $attachment->created_at }}
                                                </td>
                                            </tr>
                                        @empty
                                            <p>No attachments for this concern.</p>
                                        @endforelse
                                    </tbody>
                                </table>

                            </ul>
                        </div>
                        <div class="tab-pane fade" id="pills-students" role="tabpanel" aria-labelledby="pills-students-tab">
                            @foreach($concern->students as $student)
                                <table class="table table-bordered mb-3">
                                    <thead class="thead-light">
                                        <tr>
                                            <th colspan="5">{{ $student->fullname }}</th>
                                        </tr>
                                        <tr>
                                            <th>Photo</th>
                                            <th>Admission Number</th>
                                            <th>UPN</th>
                                            <th>Year Group</th>
                                            <th>Birth Date</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>
                                                <a href="{{ route('students.show', ['id' => $student->student_id]) }}">
                                                    <img height="100px" src="{{ asset('/storage/students/'.$student->mis_id.'.jpg') }}">
                                                </a>
                                            </td>
                                            <td>{{ $student->admission_number }}</td>
                                            <td>{{ $student->upn }}</td>
                                            <td>{{ $student->year_group }}</td>
                                            <td>{{ $student->birth_date }}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            @endforeach
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    @can('update', App\Concern::class)
                        <a class="btn btn-sm btn-warning" href="{{ route('concerns.edit', ['id' => $concern->id]) }}">Edit</a>
                    @endcan
                </div>
            @endslot
        @endcomponent
        @forelse($concern->comments as $comment)
            <div class="card shadow mb-3">
                <div class="card-body">
                    {{ $comment->body }}
                </div>
                <div class="card-footer">
                    <small>{{ $comment->posted_at }} by {{ $comment->user->name }}</small>
                </div>
            </div>
        @empty
        @endforelse
        <div class="card shadow mb-3">
            <div class="card-body">
                <a href="{{ route('comments.create', ['id' => $concern->id]) }}">+ Add Comment</a>
            </div>
        </div>
    </div>
@endsection
