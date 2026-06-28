@extends('layouts.app')
@section('title', 'Laporan Pendapatan Laundry')

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">{{ $title ?? '' }}</h3>
        </div>
        <div class="card-body">
            
            <!-- Penjelasan: Form Filter Berdasarkan Tanggal -->
            <form action="{{ route('report.index') }}" method="GET" class="mb-4">
                <div class="row align-items-end">
                    <div class="col-md-3 mb-3">
                        <label for="">Tanggal Awal</label>
                        <input type="date" name="start_date" class="form-control" value="{{ $startDate }}" required>
                    </div>
                    <div class="col-md-3 mb-3">
                        <label for="">Tanggal Akhir</label>
                        <input type="date" name="end_date" class="form-control" value="{{ $endDate }}" required>
                    </div>
                    <div class="col-md-4 mb-3">
                        <button type="submit" class="btn btn-primary me-2">Tampilkan</button>
                        
                        <!-- Penjelasan: Tombol Cetak membuka tab baru, mengirim parameter tanggal yang sedang aktif -->
                        <a href="{{ route('report.print', ['start_date' => $startDate, 'end_date' => $endDate]) }}" target="_blank" class="btn btn-success">
                            <i class="bi bi-printer"></i> Cetak Laporan
                        </a>
                    </div>
                </div>
            </form>

            <!-- Penjelasan: Tabel Hasil Laporan -->
            <div class="table-responsive">
                <table class="table table-bordered table-striped">
                    <thead class="bg-light">
                        <tr>
                            <th>No</th>
                            <th>Tanggal</th>
                            <th>Nomor Nota</th>
                            <th>Nama Pelanggan</th>
                            <th>Status</th>
                            <th>Total Tagihan (Rp)</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($orders as $index => $order)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ \Carbon\Carbon::parse($order->order_date)->format('d M Y') }}</td>
                                <td>{{ $order->order_code }}</td>
                                <td>{{ $order->customer->customer_name ?? '-' }}</td>
                                <td>
                                    @if ($order->order_status == 0)
                                        <span class="badge bg-warning text-dark">Baru</span>
                                    @elseif ($order->order_status == 1)
                                        <span class="badge bg-success">Sudah Diambil</span>
                                    @endif
                                </td>
                                <td>Rp {{ number_format($order->total, 0, ',', '.') }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center text-muted">Tidak ada transaksi pada rentang tanggal ini.</td>
                            </tr>
                        @endforelse
                    </tbody>
                    <tfoot>
                        <tr>
                            <th colspan="5" class="text-end h5">Total Pendapatan:</th>
                            <th class="h5">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</th>
                        </tr>
                    </tfoot>
                </table>
            </div>

        </div>
    </div>
@endsection
