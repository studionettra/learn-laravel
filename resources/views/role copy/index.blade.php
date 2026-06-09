@extends('layouts.app')
@section('tittle', 'Student Management')
@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-tittle">
                {{ $title ?? '' }}
            </h3>
            <div class="card-body">
                <div class="mb-3" align="right">
                    <a href="{{ route('student.create') }}" class="btn btn-primary">Create New Student</a>
                </div>
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Major</th>
                            <th>Name</th>
                            <th>Phone</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($students as $index => $student)
                            <tr>
                                <td>{{ $index += 1 }}</td>
                                <td> {{ $student->major->name ?? '' }}</td>
                                <td> {{ $student->name ?? '' }}</td>
                                <td> {{ $student->phone ?? '' }}</td>

                                <td>
                                    <a href="{{ route('role.edit', $student->id) }}" class="btn btn-success icon">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <form action="{{ route('role.destroy', $student->id) }}" method="POST" class="d-inline"
                                        data-confirm-delete="true">
                                        @csrf
                                        @method('DELETE')

                                        <button class="btn btn-danger">
                                            <i class="bi bi-trash-fill"></i>
                                        </button>

                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
