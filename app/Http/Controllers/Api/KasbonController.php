<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Kasbon;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;

class KasbonController extends Controller
{
    use ApiResponse;

    public function index(Request $request)
    {
        $query = Kasbon::with(['pelanggan', 'transaksi']);

        if ($request->has('status')) {
            $query->where('status', $request->status);
        }

        return $this->successResponse('Data kasbon berhasil diambil', $query->latest()->get());
    }

    public function show(Kasbon $kasbon)
    {
        return $this->successResponse(
            'Detail kasbon berhasil diambil',
            $kasbon->load(['pelanggan', 'transaksi', 'pembayaranKasbons'])
        );
    }
}
