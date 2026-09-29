<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Pelanggan;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;

class PelangganController extends Controller
{
    use ApiResponse;

    public function index()
    {
        $pelanggans = Pelanggan::all();

        return $this->successResponse('Data pelanggan berhasil diambil', $pelanggans);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_pelanggan' => 'required|string|max:255',
            'no_hp' => 'nullable|string|max:20',
        ]);

        $pelanggan = Pelanggan::create($validated);

        return $this->successResponse('Pelanggan berhasil ditambahkan', $pelanggan, 201);
    }

    public function show(Pelanggan $pelanggan)
    {
        return $this->successResponse('Data pelanggan berhasil diambil', $pelanggan);
    }

    public function update(Request $request, Pelanggan $pelanggan)
    {
        $validated = $request->validate([
            'nama_pelanggan' => 'sometimes|required|string|max:255',
            'no_hp' => 'nullable|string|max:20',
        ]);

        $pelanggan->update($validated);

        return $this->successResponse('Pelanggan berhasil diperbarui', $pelanggan);
    }

    public function destroy(Pelanggan $pelanggan)
    {
        $pelanggan->delete();

        return $this->successResponse('Pelanggan berhasil dihapus');
    }
}
