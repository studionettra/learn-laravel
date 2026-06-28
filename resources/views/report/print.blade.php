<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Cetak Laporan' }}</title>
    <!-- Kita pakai bootstrap dari CDN untuk pencetakan murni agar rapi -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #fff;
            color: #000;
        }

        .kop-surat {
            border-bottom: 3px solid #000;
            padding-bottom: 10px;
            margin-bottom: 20px;
        }

        @media print {
            @page {
                size: A4 portrait;
                margin: 1cm;
            }
            body {
                -webkit-print-color-adjust: exact; /* Memaksa warna tercetak */
                print-color-adjust: exact;
            }
            .table-bordered, .table-bordered th, .table-bordered td {
                border: 1px solid #000 !important; /* Memaksa garis tabel tercetak tajam */
            }
            .no-print {
                display: none !important;
            }
        }
    </style>
</head>

<body>
    <div class="container mt-4">

        <div class="kop-surat text-center">
            <h2 class="mb-1"><strong>LAUNDRY PPKD JP</strong></h2>
            <p class="mb-0">Jl. Karet Pasar Baru Barat No. 31, RT.13/RW.4, RW.4, Karet Tengsin, Kecamatan Tanah Abang,
                Jakarta Pusat, Daerah Khusus Ibukota Jakarta 10220</p>
            <p>Telp: 0812-1817-8150</p>
        </div>

        <div class="text-center mb-4">
            <h4><u>{{ strtoupper($title) }}</u></h4>
            <p>Periode: {{ \Carbon\Carbon::parse($startDate)->format('d M Y') }} -
                {{ \Carbon\Carbon::parse($endDate)->format('d M Y') }}</p>
        </div>

        <table class="table table-bordered border-dark">
            <thead>
                <tr class="text-center">
                    <th>No</th>
                    <th>Tanggal</th>
                    <th>Nomor Nota</th>
                    <th>Nama Pelanggan</th>
                    <th>Status</th>
                    <th>Total (Rp)</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($orders as $index => $order)
                    <tr>
                        <td class="text-center">{{ $index + 1 }}</td>
                        <td>{{ \Carbon\Carbon::parse($order->order_date)->format('d M Y') }}</td>
                        <td>{{ $order->order_code }}</td>
                        <td>{{ $order->customer->customer_name ?? '-' }}</td>
                        <td class="text-center">
                            {{ $order->order_status == 1 ? 'Sudah Diambil' : 'Baru' }}
                        </td>
                        <td class="text-end">{{ number_format($order->total, 0, ',', '.') }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center">Tidak ada transaksi</td>
                    </tr>
                @endforelse
            </tbody>
            <tfoot>
                <tr>
                    <th colspan="5" class="text-end">TOTAL PENDAPATAN</th>
                    <th class="text-end">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</th>
                </tr>
            </tfoot>
        </table>

        <div class="row mt-5">
            <div class="col-8"></div>
            <div class="col-4 text-center">
                <p>Jakarta, {{ \Carbon\Carbon::now()->format('d M Y') }}</p>
                <br><br><br>
                <p><strong><u>Pimpinan / Admin</u></strong></p>
            </div>
        </div>

    </div>

    <!-- Penjelasan: Script untuk otomatis membuka dialog Print ketika halaman selesai dimuat -->
    <script>
        window.onload = function() {
            window.print();
        }
    </script>
</body>

</html>
