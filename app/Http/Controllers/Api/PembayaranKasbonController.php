<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Kasbon;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PembayaranKasbonController extends Controller
{
    use ApiResponse;

    public function index(Kasbon $kasbon)
    {
        return $this->successResponse(
            'Riwayat pembayaran kasbon berhasil diambil',
            $kasbon->pembayaranKasbons()->latest()->get()
        );
    }

    public function store(Request $request, Kasbon $kasbon)
    {
        if ($kasbon->status === 'Lunas') {
            return $this->errorResponse('Kasbon ini sudah lunas', 400);
        }

        $validated = $request->validate([
            'nominal_bayar' => "required|integer|min:1|max:{$kasbon->sisa_tagihan}",
        ]);

        $pembayaran = DB::transaction(function () use ($validated, $kasbon) {
            $pembayaran = $kasbon->pembayaranKasbons()->create([
                'tanggal_bayar' => now()->toDateString(),
                'nominal_bayar' => $validated['nominal_bayar'],
            ]);

            $kasbon->decrement('sisa_tagihan', $validated['nominal_bayar']);

            if ($kasbon->sisa_tagihan == 0) {
                $kasbon->update(['status' => 'Lunas']);
            }

            return $pembayaran;
        });

        return $this->successResponse('Pembayaran kasbon berhasil dicatat', $pembayaran, 201);
    }
}
