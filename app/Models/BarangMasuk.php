<?php

namespace App\Models;

use Database\Factories\BarangMasukFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable(['id_barang', 'tanggal_masuk', 'jumlah_masuk'])]
class BarangMasuk extends Model
{
    public function barang(): BelongsTo
    {
        return $this->belongsTo(Barang::class, 'id_barang');
    }

    /** @use HasFactory<BarangMasukFactory> */
    use HasFactory;
}
