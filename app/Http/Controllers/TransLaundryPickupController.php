<?php

namespace App\Http\Controllers;

use App\Models\TransLaundryPickup;
use App\Models\TransOrder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;

class TransLaundryPickupController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Penjelasan: Mengambil seluruh riwayat pengambilan beserta relasi order dan customer
        $pickups = TransLaundryPickup::with(['order', 'customer'])->orderBy('id', 'desc')->get();
        $title = "Laundry Pickup History";
        $text = "Are you sure you want to delete this pickup record?";
        confirmDelete("Delete Pickup", $text);

        return view('pickup.index', compact('pickups', 'title'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $title = "Create New Pickup";
        
        // Penjelasan: Hanya mengambil order yang statusnya 0 (Baru / Belum Diambil)
        $orders = TransOrder::with('customer')
            ->where('order_status', 0)
            ->orderBy('id', 'desc')
            ->get();
            
        return view('pickup.create', compact('title', 'orders'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'id_order' => 'required|exists:trans_order,id',
            'pickup_date' => 'required|date',
            'order_pay' => 'required|numeric|min:0',
            'notes' => 'nullable|string'
        ]);

        DB::beginTransaction();
        try {
            // Ambil data order
            $order = TransOrder::findOrFail($request->id_order);
            
            // Hitung kembalian
            // Kembalian = Uang Bayar - Grand Total
            $change = $request->order_pay - $order->total;
            
            if ($change < 0) {
                // Jika uang kurang, batalkan proses
                Alert::error('Fail!!', 'Uang pembayaran kurang dari total tagihan!');
                return back()->withInput();
            }

            // Tahap 1: Update status dan pembayaran di tabel trans_order
            $order->update([
                'order_status' => 1, // 1 = Sudah Diambil
                'order_pay' => $request->order_pay,
                'order_change' => $change
            ]);

            // Tahap 2: Catat riwayat pengambilan di tabel trans_laundry_pickup
            TransLaundryPickup::create([
                'id_order' => $order->id,
                'id_customer' => $order->id_customer,
                'pickup_date' => $request->pickup_date,
                'notes' => $request->notes
            ]);

            DB::commit();
            Alert::success('Success!!', 'Laundry Pickup Was Processed Successfully');
            return redirect()->to('pickup');
            
        } catch (\Throwable $th) {
            DB::rollBack();
            Alert::error('Fail!!', 'An error occurred while saving the pickup. ' . $th->getMessage());
            return back()->withInput();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        // Fitur show detail pickup
        $title = "Detail Pickup";
        $pickup = TransLaundryPickup::with(['order.details.service', 'customer'])->findOrFail($id);
        
        return view('pickup.show', compact('title', 'pickup'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        Alert::warning('Warning', 'Edit feature is disabled for pickup records.');
        return redirect()->to('pickup');
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
        $pickup = TransLaundryPickup::find($id);
        if ($pickup) {
            // Opsional: kembalikan status order ke 0? 
            // Tergantung kebutuhan bisnis, untuk saat ini kita biarkan status order 1 atau ubah jadi 0.
            // Anggap saja jika pickup dihapus, order kembali jadi 0
            $order = TransOrder::find($pickup->id_order);
            if($order){
                $order->update([
                    'order_status' => 0,
                    'order_pay' => null,
                    'order_change' => null
                ]);
            }
            $pickup->delete();
            Alert::success('Success!', 'Pickup Record Has Been Deleted & Order Status Reverted');
        }
        return redirect()->to('pickup');
    }
}
