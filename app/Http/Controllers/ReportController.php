<?php

namespace App\Http\Controllers;

use App\Models\TransOrder;
use Illuminate\Http\Request;
use Carbon\Carbon;

class ReportController extends Controller
{
    /**
     * Display the report filter and results.
     */
    public function index(Request $request)
    {
        $title = "Laporan Pendapatan Laundry";
        
        // Penjelasan: Mengatur default filter tanggal (mulai awal bulan ini sampai hari ini)
        $startDate = $request->start_date ?? Carbon::now()->startOfMonth()->format('Y-m-d');
        $endDate = $request->end_date ?? Carbon::now()->format('Y-m-d');

        // Penjelasan: Mengambil data order berdasarkan rentang tanggal
        $orders = TransOrder::with('customer')
            ->whereBetween('order_date', [$startDate, $endDate])
            ->orderBy('order_date', 'asc')
            ->get();

        // Penjelasan: Menghitung total keseluruhan pendapatan
        $totalRevenue = $orders->sum('total');

        return view('report.index', compact('title', 'orders', 'startDate', 'endDate', 'totalRevenue'));
    }

    /**
     * Display a clean print view for the report.
     */
    public function print(Request $request)
    {
        $title = "Cetak Laporan Pendapatan";
        
        $startDate = $request->start_date ?? Carbon::now()->startOfMonth()->format('Y-m-d');
        $endDate = $request->end_date ?? Carbon::now()->format('Y-m-d');

        $orders = TransOrder::with('customer')
            ->whereBetween('order_date', [$startDate, $endDate])
            ->orderBy('order_date', 'asc')
            ->get();

        $totalRevenue = $orders->sum('total');

        return view('report.print', compact('title', 'orders', 'startDate', 'endDate', 'totalRevenue'));
    }
}
