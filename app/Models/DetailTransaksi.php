<?php

namespace App\Models;

use Database\Factories\DetailTransaksiFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable(['id_transaksi', 'id_barang', 'kuantitas', 'harga_satuan', 'sub_total'])]
class DetailTransaksi extends Model
{
    public function transaksi(): BelongsTo
    {
        return $this->belongsTo(Transaksi::class, 'id_transaksi');
    }

    public function barang(): BelongsTo
    {
        return $this->belongsTo(Barang::class, 'id_barang');
    }

    /** @use HasFactory<DetailTransaksiFactory> */
    use HasFactory;
}
