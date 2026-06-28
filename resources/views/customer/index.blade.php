@extends('layouts.app')
@section('title', 'Customer Management')
@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">
                {{ $title ?? '' }}
            </h3>
            <div class="card-tools mb-3" align="right">
                <a href="{{ route('customer.create') }}" class="btn btn-primary">Create New Customer</a>
            </div>
        </div>
        <div class="card-body">
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Name</th>
                        <th>Phone</th>
                        <th>Address</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($customers as $index => $customer)
                        <tr>
                            <td>{{ $index += 1 }}</td>
                            <td>{{ $customer->customer_name }}</td>
                            <td>{{ $customer->phone }}</td>
                            <td>{{ $customer->address }}</td>
                            <td>
                                <a href="{{ route('customer.edit', $customer->id) }}" class="btn btn-success icon">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <a href="{{ route('customer.destroy', $customer->id) }}" class="btn btn-danger"
                                    data-confirm-delete="true">Delete</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
