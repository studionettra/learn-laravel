<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\TransOrder;
use App\Models\TransOrderDetail;
use App\Models\TypeOfService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;

class TransOrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Penjelasan: Mengambil semua data transaksi pesanan beserta relasi customer-nya
        $orders = TransOrder::with('customer')->orderBy('id', 'desc')->get();
        $title = "Laundry Order Transaction";
        $text = "Are you sure you want to delete this order?";
        confirmDelete("Delete Order", $text);
        
        return view('transaction.index', compact('orders', 'title'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $title = "Create New Order";
        $customers = Customer::orderBy('customer_name', 'asc')->get();
        $services = TypeOfService::orderBy('service_name', 'asc')->get();
        
        // Penjelasan: Kita membuat string array dari data services untuk mempermudah render dropdown di JS dinamis
        return view('transaction.create', compact('title', 'customers', 'services'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validasi form utama
        $request->validate([
            'id_customer' => 'required|exists:customer,id',
            'order_date' => 'required|date',
            'order_end_date' => 'nullable|date',
            'service_id' => 'required|array',
            'service_id.*' => 'required|exists:type_of_service,id',
            'qty' => 'required|array',
            'qty.*' => 'required|numeric|min:1',
        ]);

        DB::beginTransaction();
        try {
            // Penjelasan: Membuat nomor nota / order_code secara otomatis
            // Format: ORD-YYYYMMDD-XXXX (contoh: ORD-20260628-0001)
            $datePrefix = date('Ymd');
            $lastOrder = TransOrder::whereDate('created_at', date('Y-m-d'))->latest()->first();
            
            if ($lastOrder) {
                // Ambil 4 digit terakhir dan tambahkan 1
                $lastNumber = (int) substr($lastOrder->order_code, -4);
                $newNumber = str_pad($lastNumber + 1, 4, '0', STR_PAD_LEFT);
            } else {
                $newNumber = '0001';
            }
            $orderCode = 'ORD-' . $datePrefix . '-' . $newNumber;

            // Hitung Grand Total dari input rincian layanan
            $grandTotal = 0;
            $detailsData = [];
            
            // Loop data array layanan dari form
            foreach ($request->service_id as $key => $serviceId) {
                $qty = $request->qty[$key];
                $service = TypeOfService::find($serviceId);
                $subtotal = $service->price * $qty;
                
                $detailsData[] = [
                    'id_service' => $serviceId,
                    'qty' => $qty,
                    'subtotal' => $subtotal,
                    'notes' => $request->notes[$key] ?? null
                ];
                
                $grandTotal += $subtotal;
            }

            // Penjelasan: Menyimpan ke tabel trans_order (Header)
            // order_pay dan order_change dibiarkan null sesuai kesepakatan karena ini baru membuat order
            $order = TransOrder::create([
                'id_customer' => $request->id_customer,
                'order_code' => $orderCode,
                'order_date' => $request->order_date,
                'order_end_date' => $request->order_end_date,
                'order_status' => 0, // 0 = baru
                'order_pay' => null,
                'order_change' => null,
                'total' => $grandTotal
            ]);

            // Penjelasan: Menyimpan ke tabel trans_order_detail (Detail)
            foreach ($detailsData as $detail) {
                TransOrderDetail::create([
                    'id_order' => $order->id,
                    'id_service' => $detail['id_service'],
                    'qty' => $detail['qty'],
                    'subtotal' => $detail['subtotal'],
                    'notes' => $detail['notes']
                ]);
            }

            DB::commit();
            Alert::success('Success!!', 'Laundry Order Was Created Successfully');
            return redirect()->to('transaction');
        } catch (\Throwable $th) {
            DB::rollBack();
            Alert::error('Fail!!', 'An error occurred while saving the order. ' . $th->getMessage());
            return back()->withInput();
        }
    }

    public function show(string $id)
    {
        $title = "Detail Order";
        $order = TransOrder::with(['customer', 'details.service'])->findOrFail($id);
        
        return view('transaction.show', compact('title', 'order'));
    }

    /**
     * Print the specified resource receipt.
     */
    public function print(string $id)
    {
        $title = "Cetak Nota Order";
        $order = TransOrder::with(['customer', 'details.service'])->findOrFail($id);
        
        return view('transaction.print', compact('title', 'order'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        // Dalam konteks laundry, order yang sudah berjalan biasanya tidak diedit secara master-detail
        // Kecuali hanya untuk update status. (Untuk update status nantinya ada di fitur Pickup)
        // Jadi kita bisa nonaktifkan fungsi edit order atau membatasi perbaikannya.
        Alert::warning('Warning', 'Edit feature is disabled for active orders.');
        return redirect()->to('transaction');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $order = TransOrder::find($id);
        if ($order) {
            $order->delete();
            Alert::success('Success!', 'Order Has Been Deleted');
        }
        return redirect()->to('transaction');
    }
}
