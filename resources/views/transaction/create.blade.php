@extends('layouts.app')
@section('title', 'Create New Laundry Order')

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">{{ $title ?? '' }}</h3>
        </div>
        <div class="card-body">
            <form action="{{ route('transaction.store') }}" method="POST" id="orderForm">
                @csrf
                
                <h5 class="mb-3">Informasi Pesanan</h5>
                <div class="row mb-4">
                    <div class="col-md-6 mb-3">
                        <label for="">Customer *</label>
                        <select name="id_customer" class="form-control" required>
                            <option value="">Pilih Customer</option>
                            @foreach ($customers as $customer)
                                <option value="{{ $customer->id }}">{{ $customer->customer_name }} - {{ $customer->phone }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3 mb-3">
                        <label for="">Tanggal Order *</label>
                        <input type="date" class="form-control" name="order_date" required value="{{ date('Y-m-d') }}">
                    </div>
                    <div class="col-md-3 mb-3">
                        <label for="">Estimasi Selesai</label>
                        <input type="date" class="form-control" name="order_end_date">
                    </div>
                </div>

                <h5 class="mb-3">Rincian Layanan</h5>
                <div class="table-responsive">
                    <table class="table table-bordered" id="serviceTable">
                        <thead class="bg-light">
                            <tr>
                                <th>Layanan *</th>
                                <th width="15%">Harga (Rp)</th>
                                <th width="15%">Qty / Berat *</th>
                                <th width="20%">Subtotal (Rp)</th>
                                <th>Catatan</th>
                                <th width="5%">Aksi</th>
                            </tr>
                        </thead>
                        <tbody id="serviceTableBody">
                            <!-- Baris dinamis akan disisipkan di sini oleh JS -->
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="6">
                                    <button type="button" class="btn btn-sm btn-success" id="btnTambahLayanan">
                                        <i class="bi bi-plus-circle"></i> Tambah Layanan
                                    </button>
                                </td>
                            </tr>
                            <tr>
                                <th colspan="3" class="text-end h5">Grand Total</th>
                                <th colspan="3" class="h5">
                                    Rp <span id="grandTotalDisplay">0</span>
                                </th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
                
                <div class="mt-4">
                    <button class="btn btn-primary" type="submit">Buat Pesanan</button>
                    <a href="{{ route('transaction.index') }}" class="btn btn-secondary">Batal</a>
                </div>
            </form>
        </div>
    </div>

    <!-- Data Services dalam format JSON untuk digunakan oleh Vanilla JS -->
    <script>
        // Penjelasan: Mengkonversi koleksi services dari PHP ke JSON object agar bisa dibaca oleh Javascript Murni
        const servicesData = @json($services);
        
        document.addEventListener('DOMContentLoaded', function() {
            const tableBody = document.getElementById('serviceTableBody');
            const btnTambahLayanan = document.getElementById('btnTambahLayanan');
            const grandTotalDisplay = document.getElementById('grandTotalDisplay');

            // Penjelasan: Fungsi untuk menambah baris layanan baru secara dinamis (tanpa jQuery)
            function addServiceRow() {
                const tr = document.createElement('tr');
                
                // Membuat struktur opsi dropdown dari data JSON
                let optionsHtml = '<option value="">Pilih Layanan</option>';
                servicesData.forEach(service => {
                    optionsHtml += `<option value="${service.id}" data-price="${service.price}">${service.service_name}</option>`;
                });

                // Memasukkan template HTML ke dalam baris tabel
                tr.innerHTML = `
                    <td>
                        <select name="service_id[]" class="form-control service-select" required>
                            ${optionsHtml}
                        </select>
                    </td>
                    <td>
                        <input type="text" class="form-control price-input bg-light" readonly value="0">
                    </td>
                    <td>
                        <input type="number" name="qty[]" class="form-control qty-input" min="1" value="1" required>
                    </td>
                    <td>
                        <input type="text" class="form-control subtotal-input bg-light" readonly value="0">
                    </td>
                    <td>
                        <input type="text" name="notes[]" class="form-control" placeholder="Catatan (Opsional)">
                    </td>
                    <td>
                        <button type="button" class="btn btn-danger btn-sm btn-remove-row"><i class="bi bi-trash"></i></button>
                    </td>
                `;
                
                tableBody.appendChild(tr);
                bindRowEvents(tr);
            }

            // Penjelasan: Mengikat event listener (seperti onchange / oninput) pada elemen-elemen di baris baru
            function bindRowEvents(row) {
                const serviceSelect = row.querySelector('.service-select');
                const qtyInput = row.querySelector('.qty-input');
                const btnRemove = row.querySelector('.btn-remove-row');
                
                // Saat layanan dipilih, ambil harga dari atribut 'data-price' dan hitung subtotal
                serviceSelect.addEventListener('change', function() {
                    const selectedOption = this.options[this.selectedIndex];
                    const price = selectedOption.getAttribute('data-price') || 0;
                    
                    row.querySelector('.price-input').value = formatRupiah(price);
                    calculateSubtotal(row);
                });

                // Saat qty diubah/diketik, langsung hitung ulang subtotal
                qtyInput.addEventListener('input', function() {
                    calculateSubtotal(row);
                });

                // Hapus baris dari tabel
                btnRemove.addEventListener('click', function() {
                    row.remove();
                    calculateGrandTotal();
                });
            }

            // Penjelasan: Rumus menghitung subtotal per baris
            function calculateSubtotal(row) {
                const serviceSelect = row.querySelector('.service-select');
                const selectedOption = serviceSelect.options[serviceSelect.selectedIndex];
                const price = selectedOption ? parseFloat(selectedOption.getAttribute('data-price') || 0) : 0;
                
                const qty = parseFloat(row.querySelector('.qty-input').value || 0);
                const subtotal = price * qty;
                
                row.querySelector('.subtotal-input').value = formatRupiah(subtotal);
                calculateGrandTotal();
            }

            // Penjelasan: Menjumlahkan seluruh subtotal di tabel menjadi Grand Total
            function calculateGrandTotal() {
                let grandTotal = 0;
                const subtotals = document.querySelectorAll('.subtotal-input');
                
                subtotals.forEach(input => {
                    // Hilangkan titik sebelum konversi ke angka karena format indonesia
                    const val = input.value.replace(/\./g, '');
                    grandTotal += parseFloat(val || 0);
                });
                
                grandTotalDisplay.innerText = formatRupiah(grandTotal);
            }

            // Format angka ke format Rupiah standar (contoh: 15.000)
            function formatRupiah(angka) {
                return new Intl.NumberFormat('id-ID', { maximumFractionDigits: 0 }).format(angka);
            }

            // Jalankan fungsi tambah baris saat tombol Tambah Layanan diklik
            btnTambahLayanan.addEventListener('click', addServiceRow);

            // Munculkan 1 baris layanan kosong secara default saat halaman dimuat
            addServiceRow();
        });
    </script>
@endsection
