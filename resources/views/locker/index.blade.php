@extends('layouts.app')
@section('tittle', 'Locker Management')
@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-tittle">
                {{ $title ?? '' }}
            </h3>
            <div class="card-body">
                <div class="mb-3" align="right">
                    <a href="{{ route('locker.create') }}" class="btn btn-primary">Create</a>
                </div>
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Locker Code</th>
                            <th>Batch</th>
                            <th>Major</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($lockers as $index => $locker)
                            <tr>
                                <td>{{ $index += 1 }}</td>
                                <td> {{ $locker->locker_name ?? '' }}</td>
                                <td>{{ $locker->batch }}</td>
                                <td>{{ $locker->major_name }}</td>
                                <td>
                                    @if ($locker->status == 'Available')
                                        <span class="badge text-white bg-primary">{{ $locker->status }}</span>
                                    @elseif ($locker->status == 'Unavailable')
                                        <span class="badge text-white bg-secondary">{{ $locker->status }}</span>
                                    @elseif ($locker->status == 'Damaged')
                                        <span class="badge text-white bg-warning">{{ $locker->status }}</span>
                                    @elseif ($locker->status == 'Missing')
                                        <span class="badge text-white bg-danger">{{ $locker->status }}</span>
                                    @endif
                                </td>
                                <td>
                                    <a href="{{ route('locker.edit', $locker->id) }}" class="btn btn-success icon">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <a href="{{ route('locker.destroy', $locker->id) }}" class="btn btn-danger"
                                        data-confirm-delete="true">Delete</a>

                                    {{--  <form action="{{ route('locker.destroy', $locker->id) }}" method="POST"
                                        class="d-inline" data-confirm-delete="true">
                                        @csrf
                                        @method('DELETE')

                                        <button class="btn btn-danger">
                                            <i class="bi bi-trash-fill"></i>
                                        </button>

                                    </form>  --}}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
