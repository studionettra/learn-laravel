@extends('layouts.app')
@section('title', 'Laundry Pickup History')
@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">
                {{ $title ?? '' }}
            </h3>
            <div class="card-tools mb-3" align="right">
                <a href="{{ route('pickup.create') }}" class="btn btn-primary">Create New Pickup</a>
            </div>
        </div>
        <div class="card-body">
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Order Code</th>
                        <th>Customer</th>
                        <th>Pickup Date</th>
                        <th>Total Tagihan</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($pickups as $index => $pickup)
                        <tr>
                            <td>{{ $index += 1 }}</td>
                            <td>{{ $pickup->order->order_code ?? '-' }}</td>
                            <td>{{ $pickup->customer->customer_name ?? 'Unknown' }}</td>
                            <td>{{ \Carbon\Carbon::parse($pickup->pickup_date)->format('d M Y') }}</td>
                            <td>Rp {{ number_format($pickup->order->total ?? 0, 0, ',', '.') }}</td>
                            <td>
                                <a href="{{ route('pickup.destroy', $pickup->id) }}" class="btn btn-danger icon"
                                    data-confirm-delete="true" title="Delete">
                                    <i class="bi bi-trash"></i>
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
