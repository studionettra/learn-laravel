<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LatihanController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('latihan', [LatihanController::class, 'index']);
Route::get('tambah', [LatihanController::class, 'tambah'])-> name('tambah');
Route::get('kurang', [LatihanController::class, 'kurang'])-> name('kurang');
Route::get('kali', [LatihanController::class, 'kali'])-> name('kali');
Route::get('bagi', [LatihanController::class, 'bagi'])-> name('bagi');

Route::post('action-tambah',[LatihanController::class, 'actionTambah'])->name('action-tambah');
Route::post('action-kurang',[LatihanController::class, 'actionKurang'])->name('action-kurang');
Route::post('action-kali',[LatihanController::class, 'actionKali'])->name('action-kali');
Route::post('action-bagi',[LatihanController::class, 'actionBagi'])->name('action-bagi');

// Router::get('latihan', [App\Http\Controllers\LatihanController::class, 'index']);
