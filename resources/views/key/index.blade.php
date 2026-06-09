@extends('layouts.app')
@section('tittle', 'Key Management')
@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-tittle">
                {{ $title ?? '' }}
            </h3>
            <div class="card-body">
                <div class="mb-3" align="right">
                    <a href="{{ route('key.create') }}" class="btn btn-primary">Create New Key</a>
                </div>
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($keys as $index => $key)
                            <tr>
                                <td>{{ $index += 1 }}</td>
                                <td> {{ $key->name ?? '' }}</td>
                                <td>{{ $key->email }}</td>
                                <td>
                                    <a href="{{ route('key.edit', $key->id) }}" class="btn btn-success icon">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <form action="{{ route('key.destroy', $key->id) }}" method="POST" class="d-inline"
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
