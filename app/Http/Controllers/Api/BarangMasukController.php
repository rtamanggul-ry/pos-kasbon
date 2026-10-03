<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\BarangMasuk;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BarangMasukController extends Controller
{
    use ApiResponse;

    public function index()
    {
        $barangMasuks = BarangMasuk::with('barang')->latest()->get();

        return $this->successResponse('Data restok berhasil diambil', $barangMasuks);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'id_barang' => 'required|exists:barangs,id',
            'tanggal_masuk' => 'required|date',
            'jumlah_masuk' => 'required|integer|min:1',
        ]);

        $barangMasuk = DB::transaction(function () use ($validated) {
            $barangMasuk = BarangMasuk::create($validated);
            $barangMasuk->barang()->increment('stok', $validated['jumlah_masuk']);

            return $barangMasuk->load('barang');
        });

        return $this->successResponse('Restok barang berhasil dicatat', $barangMasuk, 201);
    }

    public function show(BarangMasuk $barangMasuk)
    {
        return $this->successResponse('Detail restok berhasil diambil', $barangMasuk->load('barang'));
    }

    public function destroy(BarangMasuk $barangMasuk)
    {
        DB::transaction(function () use ($barangMasuk) {
            $barangMasuk->barang()->decrement('stok', $barangMasuk->jumlah_masuk);
            $barangMasuk->delete();
        });

        return $this->successResponse('Data restok berhasil dihapus');
    }
}
