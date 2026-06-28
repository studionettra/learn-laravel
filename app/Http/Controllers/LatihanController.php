<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use function Laravel\Prompts\title;

class LatihanController extends Controller
{
    public function index()
    {
        return view('latihan');
    }

    public function tambah()
    {
        $jumlahTambah = 0;
        $title = 'Penjumlahan';
        return view('tambah', compact('jumlahTambah', 'title'));
    }

    public function kurang()
    {
        $jumlahKurang = 0;
        $title = 'Pengurangan';
        return view('kurang', compact('jumlahKurang', 'title'));
    }

    public function kali()
    {
        $jumlahKali = 0;
        $title = 'Perkalian';
        return view('kali', compact('jumlahKali', 'title'));
    }

    public function bagi()
    {
        $jumlahBagi = 0;
        $title = 'Pembagian';
        return view('bagi', compact('jumlahBagi', 'title'));
    }

    public function actionTambah(Request $request)
    {
        $angka1 = $request->angka_1;
        $angka2 = $request->input('angka_2');

        $jumlahTambah = $angka1 + $angka2;
        return view('tambah', compact('jumlahTambah'));
        // return $jumlah;
    }

    public function actionKurang(Request $request)
    {
        $angka1 = $request->angka_1;
        $angka2 = $request->input('angka_2');

        $jumlahKurang = $angka1 - $angka2;
        return view('kurang', compact('jumlahKurang'));
        // return $jumlah;
    }

    public function actionKali(Request $request)
    {
        $angka1 = $request->angka_1;
        $angka2 = $request->input('angka_2');

        $jumlahKali = $angka1 * $angka2;
        return view('kali', compact('jumlahKali'));
        // return $jumlah;
    }

    public function actionBagi(Request $request)
    {
        $angka1 = $request->angka_1;
        $angka2 = $request->input('angka_2');

        $jumlahBagi = $angka1 / $angka2;
        return view('bagi', compact('jumlahBagi'));
        // return $jumlah;
    }
}
