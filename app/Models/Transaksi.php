<?php

namespace App\Models;

use Database\Factories\TransaksiFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

#[Fillable(['tanggal', 'total_harga', 'metode_pembayaran', 'id_pelanggan'])]
class Transaksi extends Model
{
    public function pelanggan(): BelongsTo
    {
        return $this->belongsTo(Pelanggan::class, 'id_pelanggan');
    }

    public function detailTransaksis(): HasMany
    {
        return $this->hasMany(DetailTransaksi::class, 'id_transaksi');
    }

    public function kasbon(): HasOne
    {
        return $this->hasOne(Kasbon::class, 'id_transaksi');
    }

    /** @use HasFactory<TransaksiFactory> */
    use HasFactory;
}
