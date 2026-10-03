<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Barang;
use App\Models\Kasbon;
use App\Models\Transaksi;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TransaksiController extends Controller
{
    use ApiResponse;

    public function index()
    {
        $transaksis = Transaksi::with(['pelanggan', 'detailTransaksis.barang'])->latest()->get();

        return $this->successResponse('Data transaksi berhasil diambil', $transaksis);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'metode_pembayaran' => 'required|in:Tunai,Kredit',
            'id_pelanggan' => 'required_if:metode_pembayaran,Kredit|nullable|exists:pelanggans,id',
            'items' => 'required|array|min:1',
            'items.*.id_barang' => 'required|exists:barangs,id',
            'items.*.kuantitas' => 'required|integer|min:1',
        ]);

        $transaksi = DB::transaction(function () use ($validated) {
            $totalHarga = 0;
            $detailItems = [];

            foreach ($validated['items'] as $item) {
                $barang = Barang::findOrFail($item['id_barang']);

                if ($barang->stok < $item['kuantitas']) {
                    abort(422, "Stok {$barang->nama_barang} tidak mencukupi. Tersisa: {$barang->stok}");
                }

                $subTotal = $barang->harga_jual * $item['kuantitas'];
                $totalHarga += $subTotal;

                $detailItems[] = [
                    'id_barang' => $barang->id,
                    'kuantitas' => $item['kuantitas'],
                    'harga_satuan' => $barang->harga_jual,
                    'sub_total' => $subTotal,
                ];

                $barang->decrement('stok', $item['kuantitas']);
            }

            $transaksi = Transaksi::create([
                'tanggal' => now()->toDateString(),
                'total_harga' => $totalHarga,
                'metode_pembayaran' => $validated['metode_pembayaran'],
                'id_pelanggan' => $validated['id_pelanggan'] ?? null,
            ]);

            $transaksi->detailTransaksis()->createMany($detailItems);

            if ($validated['metode_pembayaran'] === 'Kredit') {
                Kasbon::create([
                    'id_pelanggan' => $validated['id_pelanggan'],
                    'id_transaksi' => $transaksi->id,
                    'total_utang' => $totalHarga,
                    'sisa_tagihan' => $totalHarga,
                    'status' => 'Belum Lunas',
                ]);
            }

            return $transaksi->load(['pelanggan', 'detailTransaksis.barang', 'kasbon']);
        });

        return $this->successResponse('Transaksi berhasil dibuat', $transaksi, 201);
    }

    public function show(Transaksi $transaksi)
    {
        return $this->successResponse(
            'Detail transaksi berhasil diambil',
            $transaksi->load(['pelanggan', 'detailTransaksis.barang', 'kasbon'])
        );
    }
}
