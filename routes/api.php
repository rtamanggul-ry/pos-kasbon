<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\BarangController;
use App\Http\Controllers\Api\BarangMasukController;
use App\Http\Controllers\Api\KasbonController;
use App\Http\Controllers\Api\LaporanController;
use App\Http\Controllers\Api\PelangganController;
use App\Http\Controllers\Api\PembayaranKasbonController;
use App\Http\Controllers\Api\TransaksiController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    Route::apiResource('barang', BarangController::class);
    Route::apiResource('pelanggan', PelangganController::class);

    // Barang Masuk
    Route::apiResource('barang-masuk', BarangMasukController::class)->except(['update']);

    // Transaksi
    Route::apiResource('transaksi', TransaksiController::class)->only(['index', 'store', 'show']);

    // Kasbon & Pembayaran
    Route::apiResource('kasbon', KasbonController::class)->only(['index', 'show']);
    Route::get('kasbon/{kasbon}/pembayaran', [PembayaranKasbonController::class, 'index']);
    Route::post('kasbon/{kasbon}/pembayaran', [PembayaranKasbonController::class, 'store']);

    // Laporan
    Route::get('laporan/hari-ini', [LaporanController::class, 'hariIni']);
    Route::apiResource('laporan', LaporanController::class)->only(['index', 'show']);
});
