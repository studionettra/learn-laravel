@extends('layouts.app')
@section('title', 'Laundry Order Transaction')
@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">
                {{ $title ?? '' }}
            </h3>
            <div class="card-tools mb-3" align="right">
                <a href="{{ route('transaction.create') }}" class="btn btn-primary">Create New Order</a>
            </div>
        </div>
        <div class="card-body">
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Order Code</th>
                        <th>Customer</th>
                        <th>Date</th>
                        <th>Total (Rp)</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($orders as $index => $order)
                        <tr>
                            <td>{{ $index += 1 }}</td>
                            <td>{{ $order->order_code }}</td>
                            <td>{{ $order->customer->customer_name ?? 'Unknown' }}</td>
                            <td>{{ \Carbon\Carbon::parse($order->order_date)->format('d M Y') }}</td>
                            <td>Rp {{ number_format($order->total, 0, ',', '.') }}</td>
                            <td>
                                @if ($order->order_status == 0)
                                    <span class="badge bg-warning text-dark">Baru</span>
                                @elseif ($order->order_status == 1)
                                    <span class="badge bg-success">Sudah Diambil</span>
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('transaction.show', $order->id) }}" class="btn btn-info icon text-white" title="View Detail">
                                    <i class="bi bi-eye"></i>
                                </a>
                                <a href="{{ route('transaction.destroy', $order->id) }}" class="btn btn-danger icon"
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
