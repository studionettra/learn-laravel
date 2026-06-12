@extends('layouts.app')
@section('title', 'Instructor Management')
@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-tittle">
                {{ $title ?? '' }}
            </h3>
            <div class="card-body">
                <div class="mb-3" align="right">
                    <a href="{{ route('instructor.create') }}" class="btn btn-primary">Create New Instructor</a>
                </div>
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Major</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($instructors as $index => $instructor)
                            <tr>
                                <td>{{ $index += 1 }}</td>
                                <td> {{ $instructor->major->name ?? '' }}</td>
                                <td> {{ $instructor->name ?? '' }}</td>
                                <td> {{ $instructor->user->email ?? '' }}</td>
                                <td> {{ $instructor->phone ?? '' }}</td>

                                <td>
                                    <a href="{{ route('instructor.edit', $instructor->id) }}" class="btn btn-success icon">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <a href="{{ route('instructor.destroy', $instructor->id) }}" class="btn btn-danger"
                                        data-confirm-delete="true">Delete</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
