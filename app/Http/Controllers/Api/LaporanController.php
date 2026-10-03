<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\BarangMasuk;
use App\Models\Kasbon;
use App\Models\Laporan;
use App\Models\PembayaranKasbon;
use App\Models\Transaksi;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;

class LaporanController extends Controller
{
    use ApiResponse;

    public function index(Request $request)
    {
        $query = Laporan::query();

        if ($request->has('tanggal_mulai') && $request->has('tanggal_selesai')) {
            $query->whereBetween('tanggal_laporan', [$request->tanggal_mulai, $request->tanggal_selesai]);
        }

        return $this->successResponse('Data laporan berhasil diambil', $query->latest('tanggal_laporan')->get());
    }

    public function hariIni()
    {
        $hariIni = now()->toDateString();

        $totalPendapatanTunai = Transaksi::whereDate('tanggal', $hariIni)
            ->where('metode_pembayaran', 'Tunai')
            ->sum('total_harga');

        $totalKasbonBaru = Kasbon::whereHas('transaksi', function ($query) use ($hariIni) {
            $query->whereDate('tanggal', $hariIni);
        })
            ->sum('total_utang');

        $totalPembayaranKasbon = PembayaranKasbon::whereDate('tanggal_bayar', $hariIni)
            ->sum('nominal_bayar');

        // Untuk total pengeluaran restok, kita harus mengkalikan jumlah_masuk dengan harga_modal barang
        $totalPengeluaranRestok = BarangMasuk::with('barang')
            ->whereDate('tanggal_masuk', $hariIni)
            ->get()
            ->sum(function ($restok) {
                return $restok->jumlah_masuk * $restok->barang->harga_modal;
            });

        $laporan = Laporan::updateOrCreate(
            ['tanggal_laporan' => $hariIni],
            [
                'total_pendapatan_tunai' => $totalPendapatanTunai,
                'total_kasbon_baru' => $totalKasbonBaru,
                'total_pembayaran_kasbon' => $totalPembayaranKasbon,
                'total_pengeluaran_restok' => $totalPengeluaranRestok,
            ]
        );

        return $this->successResponse('Laporan hari ini berhasil digenerate', $laporan);
    }

    public function show(Laporan $laporan)
    {
        return $this->successResponse('Detail laporan berhasil diambil', $laporan);
    }
}
