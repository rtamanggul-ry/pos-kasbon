<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Barang;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;

class BarangController extends Controller
{
    use ApiResponse;

    public function index()
    {
        $barangs = Barang::all();

        return $this->successResponse('Data barang berhasil diambil', $barangs);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_barang' => 'required|string|max:255',
            'harga_modal' => 'required|integer',
            'harga_jual' => 'required|integer',
            'stok' => 'integer',
        ]);

        $barang = Barang::create($validated);

        return $this->successResponse('Barang berhasil ditambahkan', $barang, 201);
    }

    public function show(Barang $barang)
    {
        return $this->successResponse('Data barang berhasil diambil', $barang);
    }

    public function update(Request $request, Barang $barang)
    {
        $validated = $request->validate([
            'nama_barang' => 'sometimes|required|string|max:255',
            'harga_modal' => 'sometimes|required|integer',
            'harga_jual' => 'sometimes|required|integer',
            'stok' => 'sometimes|integer',
        ]);

        $barang->update($validated);

        return $this->successResponse('Barang berhasil diperbarui', $barang);
    }

    public function destroy(Barang $barang)
    {
        $barang->delete();

        return $this->successResponse('Barang berhasil dihapus');
    }
}
