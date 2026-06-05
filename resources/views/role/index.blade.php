@extends('layouts.app')
@section('tittle', 'Role Management')
@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-tittle">
                {{ $title ?? '' }}
            </h3>
            <div class="card-body">
                <div class="mb-3" align="right">
                    <a href="{{ route('role.create') }}" class="btn btn-primary">Create New Role</a>
                </div>
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Name</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($roles as $index => $role)
                            <tr>
                                <td>{{ $index += 1 }}</td>
                                <td> {{ $role->name ?? '' }}</td>
                                <td>

                                    @if ($role->is_active == 1)
                                        <span class="badge text-white bg-primary">Active</span>
                                    @else
                                        <span class="badge text-white bg-danger">In Active</span>
                                    @endif
                                </td>
                                <td>
                                    <a href="{{ route('role.edit', $role->id) }}" class="btn btn-success icon">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <form action="{{ route('role.destroy', $role->id) }}" method="POST" class="d-inline"
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
