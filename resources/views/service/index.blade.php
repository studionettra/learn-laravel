@extends('layouts.app')
@section('title', 'Service Type Management')
@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">
                {{ $title ?? '' }}
            </h3>
            <div class="card-tools mb-3" align="right">
                <a href="{{ route('service.create') }}" class="btn btn-primary">Create New Service</a>
            </div>
        </div>
        <div class="card-body">
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Service Name</th>
                        <th>Price (Rp)</th>
                        <th>Description</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($services as $index => $service)
                        <tr>
                            <td>{{ $index += 1 }}</td>
                            <td>{{ $service->service_name }}</td>
                            <td>Rp {{ number_format($service->price, 0, ',', '.') }}</td>
                            <td>{{ $service->description ?? '-' }}</td>
                            <td>
                                <a href="{{ route('service.edit', $service->id) }}" class="btn btn-success icon">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <a href="{{ route('service.destroy', $service->id) }}" class="btn btn-danger"
                                    data-confirm-delete="true">Delete</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
