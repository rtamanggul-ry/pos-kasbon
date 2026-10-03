<?php

namespace App\Models;

use Database\Factories\BarangFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable(['nama_barang', 'harga_modal', 'harga_jual', 'stok'])]
class Barang extends Model
{
    public function barangMasuks(): HasMany
    {
        return $this->hasMany(BarangMasuk::class, 'id_barang');
    }

    public function detailTransaksis(): HasMany
    {
        return $this->hasMany(DetailTransaksi::class, 'id_barang');
    }

    /** @use HasFactory<BarangFactory> */
    use HasFactory;
}
