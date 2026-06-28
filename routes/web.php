<?php

use App\Http\Controllers\LoginController;
use Illuminate\Support\Facades\Route;

//Login
Route::get('/', [LoginController::class, 'index'])->name('login');

//app
Route::post('action-login', [LoginController::class, 'actionLogin'])->name('action-login');
Route::post('action-out', [LoginController::class, 'actionLogout'])->name('action-logout');

Route::middleware(['auth', 'nochace'])->group(function () {
    // Semua yang login bisa akses dashboard
    Route::get('dashboard', function () {
        return view('dashboard.index');
    });
    
    // Group Administrator & Pimpinan
    Route::middleware(['checklevel:Administrator,Pimpinan'])->group(function () {
        Route::get('report', [\App\Http\Controllers\ReportController::class, 'index'])->name('report.index');
        Route::get('report/print', [\App\Http\Controllers\ReportController::class, 'print'])->name('report.print');
    });

    // Group Administrator saja
    Route::middleware(['checklevel:Administrator'])->group(function () {
        Route::resource('user', \App\Http\Controllers\UserController::class);
        Route::resource('level', \App\Http\Controllers\LevelController::class);
    });

    // Group Administrator & Operator
    Route::middleware(['checklevel:Administrator,Operator'])->group(function () {
        Route::get('transaction/{id}/print', [\App\Http\Controllers\TransOrderController::class, 'print'])->name('transaction.print');
        Route::resource('customer', \App\Http\Controllers\CustomerController::class);
        Route::resource('service', \App\Http\Controllers\TypeOfServiceController::class);
        Route::resource('transaction', \App\Http\Controllers\TransOrderController::class);
        Route::resource('pickup', \App\Http\Controllers\TransLaundryPickupController::class);
    });
});
