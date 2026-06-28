@extends('layouts.app')
@section('title', 'Create New Pickup')

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">{{ $title ?? '' }}</h3>
        </div>
        <div class="card-body">
            <form action="{{ route('pickup.store') }}" method="POST" id="pickupForm">
                @csrf
                
                <div class="row mb-4">
                    <div class="col-md-6 mb-3">
                        <label for="">Pilih Order / Nomor Nota *</label>
                        <select name="id_order" id="id_order" class="form-control" required>
                            <option value="">-- Pilih Pesanan (Baru) --</option>
                            @foreach ($orders as $order)
                                <!-- Penjelasan: Atribut data-total disisipkan agar bisa dibaca JS untuk kalkulasi kembalian -->
                                <option value="{{ $order->id }}" data-total="{{ $order->total }}">
                                    {{ $order->order_code }} - {{ $order->customer->customer_name ?? 'Unknown' }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="">Tanggal Pengambilan *</label>
                        <input type="date" class="form-control" name="pickup_date" required value="{{ date('Y-m-d') }}">
                    </div>
                </div>

                <div class="row mb-4">
                    <div class="col-md-4 mb-3">
                        <label for="">Total Tagihan (Rp)</label>
                        <input type="text" class="form-control bg-light" id="total_display" readonly value="0">
                    </div>
                    <div class="col-md-4 mb-3">
                        <label for="">Uang Bayar (Rp) *</label>
                        <input type="number" name="order_pay" id="order_pay" class="form-control" min="0" required placeholder="0">
                    </div>
                    <div class="col-md-4 mb-3">
                        <label for="">Kembalian (Rp)</label>
                        <!-- Penjelasan: Kolom kembalian bersifat readonly karena dihitung otomatis oleh Javascript -->
                        <input type="text" class="form-control bg-light text-danger fw-bold" id="order_change_display" readonly value="0">
                    </div>
                </div>

                <div class="mb-4">
                    <label for="">Catatan (Opsional)</label>
                    <textarea name="notes" class="form-control" rows="3" placeholder="Catatan pengambilan..."></textarea>
                </div>
                
                <div class="mt-4">
                    <button class="btn btn-primary" type="submit" id="btnSubmit">Proses Pengambilan</button>
                    <a href="{{ route('pickup.index') }}" class="btn btn-secondary">Batal</a>
                </div>
            </form>
        </div>
    </div>

    <!-- Skrip Kalkulator Kembalian Otomatis -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const selectOrder = document.getElementById('id_order');
            const totalDisplay = document.getElementById('total_display');
            const inputPay = document.getElementById('order_pay');
            const changeDisplay = document.getElementById('order_change_display');
            const btnSubmit = document.getElementById('btnSubmit');
            
            let currentTotal = 0; // Menyimpan tagihan murni (angka)

            // Penjelasan: Fungsi format Rupiah untuk tampilan
            function formatRupiah(angka) {
                return new Intl.NumberFormat('id-ID', { maximumFractionDigits: 0 }).format(angka);
            }

            // Penjelasan: Event ketika Nota / Order dipilih
            selectOrder.addEventListener('change', function() {
                const selectedOption = this.options[this.selectedIndex];
                
                // Ambil nilai 'data-total' dari option HTML
                currentTotal = selectedOption.value ? parseFloat(selectedOption.getAttribute('data-total') || 0) : 0;
                
                // Tampilkan total ke layar
                totalDisplay.value = formatRupiah(currentTotal);
                
                // Set nilai minimum pada input pembayaran agar kasir tak bisa input kurang
                inputPay.min = currentTotal;
                
                // Hitung ulang jika sudah ada angka yang diketik
                calculateChange();
            });

            // Penjelasan: Event ketika kasir mengetik uang pembayaran
            inputPay.addEventListener('input', function() {
                calculateChange();
            });

            // Penjelasan: Rumus perhitungan kembalian
            function calculateChange() {
                const payAmount = parseFloat(inputPay.value || 0);
                const change = payAmount - currentTotal;
                
                if (change < 0) {
                    changeDisplay.value = 'Uang Kurang!';
                    btnSubmit.disabled = true; // Kunci tombol submit jika uang kurang
                } else {
                    changeDisplay.value = formatRupiah(change);
                    btnSubmit.disabled = false; // Buka tombol submit jika uang pas/lebih
                }
            }
        });
    </script>
@endsection
