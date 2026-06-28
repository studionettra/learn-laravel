@extends('layouts.app')
@section('title', 'Detail Order')

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">{{ $title ?? '' }} - {{ $order->order_code }}</h3>
        </div>
        <div class="card-body">
            <div class="row mb-4">
                <div class="col-md-6">
                    <h5>Informasi Pelanggan</h5>
                    <table class="table table-borderless table-sm">
                        <tr>
                            <td width="150">Nama</td>
                            <td>: {{ $order->customer->customer_name ?? '-' }}</td>
                        </tr>
                        <tr>
                            <td>No. Telepon</td>
                            <td>: {{ $order->customer->phone ?? '-' }}</td>
                        </tr>
                        <tr>
                            <td>Alamat</td>
                            <td>: {{ $order->customer->address ?? '-' }}</td>
                        </tr>
                    </table>
                </div>
                <div class="col-md-6">
                    <h5>Informasi Pesanan</h5>
                    <table class="table table-borderless table-sm">
                        <tr>
                            <td width="150">Tanggal Masuk</td>
                            <td>: {{ \Carbon\Carbon::parse($order->order_date)->format('d M Y') }}</td>
                        </tr>
                        <tr>
                            <td>Tanggal Selesai</td>
                            <td>: {{ $order->order_end_date ? \Carbon\Carbon::parse($order->order_end_date)->format('d M Y') : '-' }}</td>
                        </tr>
                        <tr>
                            <td>Status</td>
                            <td>: 
                                @if ($order->order_status == 0)
                                    <span class="badge bg-warning text-dark">Baru</span>
                                @elseif ($order->order_status == 1)
                                    <span class="badge bg-success">Sudah Diambil</span>
                                @endif
                            </td>
                        </tr>
                    </table>
                </div>
            </div>

            <h5>Rincian Layanan</h5>
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Layanan</th>
                        <th>Harga</th>
                        <th>Qty / Berat</th>
                        <th>Subtotal</th>
                        <th>Catatan</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($order->details as $index => $detail)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $detail->service->service_name ?? 'Layanan dihapus' }}</td>
                            <td>Rp {{ number_format($detail->service->price ?? 0, 0, ',', '.') }}</td>
                            <td>{{ $detail->qty }}</td>
                            <td>Rp {{ number_format($detail->subtotal, 0, ',', '.') }}</td>
                            <td>{{ $detail->notes ?? '-' }}</td>
                        </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <th colspan="4" class="text-end">Grand Total</th>
                        <th colspan="2">Rp {{ number_format($order->total, 0, ',', '.') }}</th>
                    </tr>
                    @if($order->order_pay)
                    <tr>
                        <th colspan="4" class="text-end">Dibayar</th>
                        <th colspan="2">Rp {{ number_format($order->order_pay, 0, ',', '.') }}</th>
                    </tr>
                    <tr>
                        <th colspan="4" class="text-end">Kembalian</th>
                        <th colspan="2">Rp {{ number_format($order->order_change, 0, ',', '.') }}</th>
                    </tr>
                    @endif
                </tfoot>
            </table>

            <div class="mt-4">
                <a href="{{ route('transaction.index') }}" class="btn btn-secondary">Kembali</a>
                <a href="{{ route('transaction.print', $order->id) }}" target="_blank" class="btn btn-primary">Cetak Nota</a>
            </div>
        </div>
    </div>
@endsection
